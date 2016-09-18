<?php
/**
 * Created by PhpStorm.
 * User: hungln6
 * Date: 9/24/2015
 * Time: 9:35 AM
 */
namespace DjCms\Controller;


use DjCms\Library\ArticleDetail\ArticleDetail;
use DjCms\Library\Helper;
use DjCms\Models\Artist;
use DjCms\Models\MediaRequire;
use DjCms\Models\ReportSpam;
use DjCms\Models\YoutubeVideo;
use DjCms\Models\Category;
use DjCms\Models\Media;
use DjCms\Models\Tag;
use DjCms\Models\Users;
use DjCms\Service\SendWorkload;

class MediarequireController extends ControllerBase
{
    public function indexAction()
    {
        $p = $_GET['p'];
        $keyword = $_GET['q'];
        $type = $_GET['type'];
        $catid = $_GET['catid'];
        if ($p <= 1) $p = 1;
        $limit = 20;
        $cp = ($p - 1) * $limit;
        #Query
        $query = array();
        $queryname = array('$text' => array('$search' => "\"$keyword\""));
        $queryid = array('_id' => $keyword);
        $querycategory = array('category' => $catid);
        $querytype = array('type' => $type);
        ## Filter
        if (!empty($keyword)) {
            $query['$or'][] = $queryname;
            $query['$or'][] = $queryid;
        }
        if (!empty($catid))
            $query['$and'][] = $querycategory;
        if (!empty($type))
            $query['$and'][] = $querytype;

        ## bind Data
        $paramsQuery = array(
            "condition" => $query,
            "skip" => $cp,
            "limit" => $limit,
            "sort" => array('_id' => -1),
        );
        $listCategory = Category::findAndReturnArray(array('condition' => array('type' => array('$in' => array('video', 'audio', 'video', 'news', 'images')))), true);
        $listmedia = MediaRequire::findAndReturnArray($paramsQuery);
        try {
            foreach ($listmedia as $key => $item) {
                $userid = $item['usercreate'];
                $userInfo = Users::findById($userid);
                $listmedia[$key]['usercreate'] = $userInfo->username;
                $catids = $item['category'];
                if (!empty($catids)) {
                    foreach ($catids as $elem) if ($listCategory[$elem]) $catName[] = $listCategory[$elem]['name'];
                }
                $listmedia[$key]['categoryname'] = $catName;
                unset($catids, $catName, $userid);
                if (!empty($listmedia[$key]['priavatar']))
                    $listmedia[$key]['priavatar'] = $this->getRealPathImage($listmedia[$key]['priavatar']);
            }
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
        $count = MediaRequire::count(array($query));
        $this->view->listmedia = $listmedia;
        $this->view->listCategory = $listCategory;
        $this->view->listype = Helper::getListType();
        $this->view->liststatus = Helper::getListStatus();
        $this->view->painginfo = Helper::paginginfo($count, $limit, $p);
        $this->view->controllink = array(
            "update" => Helper::cpagerparm("tact,id", "form"),
            "delete" => Helper::cpagerparm("tact,id", "delete")
        );
    }

    public function formAction()
    {
        $id = $this->request->get("id");
        ##News
        $o = (array)MediaRequire::findById($id);
        ##warning media
        if (isset($id)) {
            $media_Warning = ReportSpam::count(array(
                'conditions' => array('atid' => $o['_id'], 'type' => $o['type'])
            ));
            $o['spamflag'] = $media_Warning;
        }
        $o['note'] = Helper::br2nl($o['note']);
        $o['priavatar'] = $this->getRealPathImage($o['priavatar']);
        if (!is_array($o['tags']) || !count($o['tags']))
            $o['tags'] = array();
        if (!is_array($o['artist']) || !count($o['artist']))
            $o['artist'] = array();
        $criteria = array(
            "condition" => array("_id" => array('$in' => $o['tags'])),
            "fields" => array("name", "_id")
        );
        $listTagCr = Tag::findAndReturnArray($criteria);
        $listArtistCr = Artist::findAndReturnArray(array(
            "condition" => array('_id' => array('$in' => $o['artist'])),
        ));
        $listTagCr = Helper::resortarray($listTagCr, $o['tags'], '_id');
        $listArtistCr = Helper::resortarray($listArtistCr, $o['artist'], '_id');

        $o['tags'] = $listTagCr;
        $o['artist'] = $listArtistCr;
        $test = Helper::cpagerparm("tact,id,status", "/mediarequire/index");
//        echo $test;die;
        $this->view->object = $o;
        $this->view->liststatus = Helper::getListStatus();
        $this->view->categoryview = Category::recursive_to_html(array('type' => array('$in' => array('video', 'audio', 'media', 'images', 'news'))), "category[]", $o['category']);
        $this->view->backlink = Helper::cpagerparm("tact,id,status", "/mediarequire/index");
    }

    public function formprocessAction()
    {
        if ($this->request->isPost()) {
            $id = $this->request->getPost('id');
            $uinfo = (array)$this->session->get("uinfo");
            ##Process
            $postvalue = Helper::post_to_array("name,category,mediaurl,content,type,status,view,artist,ishot,priavatar,is_convert_quality");
            $postvalue['view'] = intval($postvalue['view']);
            $postvalue['ishot'] = $postvalue['ishot'] <= 0 ? 0 : 1;
            $postvalue['status'] = intval($postvalue['status']);
            $postvalue['namenonutf'] = strtolower(Helper::convertToUtf8($postvalue['name']));
            $postvalue['direct_media_url'] = ArticleDetail::getMediaUrl($postvalue['mediaurl'], $this->config->application->baseFrontendUri);

            $postvalue['tags'] = $this->request->getPost('tags');

            if (isset($postvalue['tags']) && !empty($postvalue['tags'])) {
                $postvalue['tags'] = Tag::standardListTag($postvalue['tags'], $uinfo['_id']);
            }

            $postvalue['artist'] = $this->request->getPost('artist');
            if (isset($postvalue['artist']) && !empty($postvalue['artist'])) {
                if ($postvalue['status'] == 1)
                    $newStatus = Artist::$_STATUS_ACTIVE;
                else
                    $newStatus = Artist::$_STATUS_WAIT;
                $postvalue['artist'] = Artist::standardListArtist($postvalue['artist'], $uinfo['_id'], $newStatus);
            }

            ## Get duration if type is video to display in web
            if ($postvalue['type'] == "video" && strlen($postvalue['mediaurl'])) {
                $parseUrl = parse_url($postvalue['mediaurl']);
                if ($parseUrl['host'] === "www.youtube.com" || $parseUrl['host'] === "youtube.com") {
                    $urlFirstVideo = $postvalue['mediaurl'];
                    $youtubeApi = new YoutubeVideo();
                    $duration = $youtubeApi->getVideoLength($urlFirstVideo);
                    if (!isset($duration) || !$duration) $duration = 0;
                } else {
                    require_once(__DIR__ . '/../library/getid3/getid3.php');
                    $getID3 = new \getID3();
                    $fileInfo = $getID3->analyze(trim($postvalue['mediaurl'], "//"));
                    $duration = $fileInfo['playtime_string'];
                }
                $postvalue['duration'] = $duration;
            }
            #Avatar + Status
            $priavatar = $this->post_file_to_array($postvalue['type']);
            if ($priavatar != null) $postvalue['priavatar'] = get_client_static_dir() . $priavatar;
            $postvalue['priavatar'] = $this->getShortenPathImage($postvalue['priavatar']);

            if (!empty($id)) {
                $curInfo = MediaRequire::findById($id);
                if ($curInfo->mediaurl != $postvalue['mediaurl'])
                    $postvalue['is_convert_quality'] = '';
            }

            if (empty($postvalue['is_convert_quality']) && defined('HAS_RABBIT_MQ')) {
                if ($this->_isFromStreamServer($postvalue['mediaurl']) && $postvalue['type'] === "audio") {
                    $mediaUrl = $this->_getMediaLocalpath($postvalue['mediaurl']);
                    $jobClient = new SendWorkload();
                    $jobClient->pushMediaToConvert(array(
                        "media_url" => $mediaUrl,
                        "mid" => (!empty($id)) ? $id : $postvalue['_id']
                    ));
                }
                $postvalue['is_convert_quality'] = 1;
            }
            if ($postvalue['status'] == 1) {
                $postvalue['datecreate'] = intval(strtotime("now"));
                $postvalue['usercreate'] = $uinfo['_id'];
                $postvalue['_id'] = strval(strtotime("now"));
                Media::insertDocument($postvalue);
                MediaRequire::deleteDocument(array('_id' => "$id"));
            } else  MediaRequire::updateDocument(array('_id' => $id), array('$set' => $postvalue, '$push' => array("usermodify" => array("uid" => $uinfo['_id'], "datecreate" => intval(strtotime("now"))))));
            $this->flash->success($this->getLanguage()->update_success);

            $redirect = $this->request->getPost("redirect");
            if (!$redirect) $redirect = "mediarequire/index?type=" . $postvalue['type'];
            return $this->response->redirect(ltrim($redirect, "/"));
        } else $redirect = "mediarequire/index";
        return $this->response->redirect(ltrim($redirect, "/"));
    }

    public function deleteAction()
    {

        $id = $this->request->get('id');
        if (is_array($id)) { // delete in
            $id = array_map("strval", $id);
            MediaRequire::deleteDocument(array('_id' => array('$in' => $id)), array('multiple' => true));
        } else  MediaRequire::deleteDocument(array('_id' => "$id"));
        $this->flash->success($this->getLanguage()->delete_success);
        $redirect = Helper::cpagerparm("tact,id,status", "/mediarequire/index");
        if (!$redirect) $redirect = '/mediarequire/index';
        return $this->response->redirect(ltrim($redirect, '/'));
    }

    protected function _isLocalMediaUrl($mediaUrl)
    {
        return preg_match('/^(\/web\/uploads\/)/', $mediaUrl);
    }

    protected function _isFromStreamServer($mediaUrl)
    {
        return preg_match('/^(http:\/\/s2\.download\.stream\.djscdn\.com\/media)/', $mediaUrl);
    }

}