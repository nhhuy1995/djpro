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
use DjCms\Library\Makelink;
use DjCms\Models\Artist;
use DjCms\Models\ReportSpam;
use DjCms\Models\YoutubeVideo;
use DjCms\Models\Category;
use DjCms\Models\Media;
use DjCms\Models\Tag;
use DjCms\Models\Users;
use DjCms\Service\SendWorkload;

class MediaController extends ControllerBase
{
    public function indexAction()
    {
        $p = $_GET['p'];
        $keyword = $_GET['q'];
        $type = $_GET['type'];
        $catid = $_GET['catid'];
        $status = $_GET['status'];
        if ($p <= 1) $p = 1;
        $limit = 20;
        $cp = ($p - 1) * $limit;
        #Query
        $query = array();
        $queryname = array('$text' => array('$search' => "\"$keyword\""));
        $queryid = array('_id' => $keyword);
        $querycategory = array('category' => $catid);
        $querytype = array('type' => $type);
        $querystatus = array('status' => intval($status));
        ## Filter
        if (!empty($keyword)) {
            $query['$or'][] = $queryname;
            $query['$or'][] = $queryid;
        }
        if (!empty($catid))
            $query['$and'][] = $querycategory;
        if (!empty($status))
            $query['$and'][] = $querystatus;
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

        $listmedia = Media::findAndReturnArray($paramsQuery);
        try {
            foreach ($listmedia as $key => $item) {
                if ($item['type'] == 'audio') $listmedia[$key]['link'] = DOMAIN.Makelink::link_view_article_music($item['name'], $item['_id']);
                else if ($item['type'] == 'video') $listmedia[$key]['link'] = DOMAIN.Makelink::link_view_article_video($item['name'], $item['_id']);
                else $listmedia[$key]['link'] = DOMAIN.Makelink::link_view_article($item['name'], $item['_id']);
                $userid = $item['usercreate'];
                $userInfo = Users::findById($userid);
                if(isset($userInfo) && !empty($userInfo)){
                    $listmedia[$key]['usercreate'] = $userInfo->username;
                    $listmedia[$key]['user_link'] = DOMAIN.Makelink::link_view_member($userInfo->username,$userInfo->getId());
                }
                $catids = $item['category'];
                if (!empty($catids) && isset($catids)) {
                    foreach ($catids as $elem) if ($listCategory[$elem]) $catName[] = $listCategory[$elem]['name'];
                    $listmedia[$key]['categoryname'] = $catName;
                }
                unset($catids, $catName, $userid);
                // if (!empty($listmedia[$key]['priavatar']))
                //     $listmedia[$key]['priavatar'] = $this->getRealPathImage($listmedia[$key]['priavatar']);
            }
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
        $count = Media::count(array($query));
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
        $o = (array)Media::findById($id);
        ##warning media
        if (isset($id)) {
            $media_Warning = ReportSpam::count(array(
                'conditions' => array('atid' => $o['_id'], 'type' => $o['type'])
            ));
            $o['spamflag'] = $media_Warning;
        }

        $o['note'] = Helper::br2nl($o['note']);
        // $o['priavatar'] = $this->getRealPathImage($o['priavatar']);
        if (!is_array($o['tags']) || !count($o['tags']))
            $o['tags'] = array();
        if (!is_array($o['artist']) || !count($o['artist']))
            $o['artist'] = array();
        $criteria = array(
            "condition" => array("_id" => array('$in' => $o['tags'])),
            "fields" => array("name", "_id")
        );

        $listTagCr = Tag::findAndReturnArray($criteria);
        $listTagCr = Helper::resortarray($listTagCr, $o['tags'], '_id');
        $listArtistCr = Artist::findAndReturnArray(array(
            "condition" => array('_id' => array('$in' => $o['artist'])),
        ));
        $listArtistCr = Helper::resortarray($listArtistCr, $o['artist'], '_id');
        $o['tags'] = $listTagCr;
        $o['artist'] = $listArtistCr;
        $this->view->object = $o;
        $this->view->liststatus = Helper::getListStatus();
        $this->view->categoryview = Category::recursive_to_html(array('type' => array('$in' => array('video', 'audio', 'media', 'images', 'news'))), "category[]", $o['category']);
        $this->view->backlink = Helper::cpagerparm("tact,id,status", "/media/index");
    }

    public function formprocessAction()
    {
        if ($this->request->isPost()) {
            $id = $this->request->getPost('id');
            $uinfo = (array)$this->session->get("uinfo");
            ##Process
            $postvalue = Helper::post_to_array("name,description,category,mediaurl,content,type,status,view,like,replay,spamflag,artist,ishot,priavatar,is_convert_quality,gen_priavatar");
            $postvalueVid = Helper::post_to_array("link_video_1080,link_video_720,link_video_480,link_video_360,link_video_240,link_video_144");
            $postvalueAud = Helper::post_to_array("media_link_320k,media_link_128k,media_link_64k");
            $postvalue = $postvalue + $postvalueVid + $postvalueAud;
            $postvalue['view'] = intval($postvalue['view']);
            $postvalue['like'] = intval($postvalue['like']);
            $postvalue['replay'] = intval($postvalue['replay']);
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
                if ($postvalue['status'] == '1') $newStatus = Artist::$_STATUS_ACTIVE;
                else $newStatus = Artist::$_STATUS_WAIT;
                $postvalue['artist'] = Artist::standardListArtist($postvalue['artist'], $uinfo['_id'], $newStatus);
            }
            if (!empty($id)) {
                $curInfo = Media::findById($id);
                if ($curInfo->mediaurl != $postvalue['mediaurl'])
                    $postvalue['is_convert_quality'] = '';
            } else {
                $postvalue['_id'] = strval(strtotime("now"));
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
                    if ($this->_isFromStreamServer($postvalue['mediaurl']) && empty($postvalue['is_convert_quality'])) {
                        // $mediaUrl = $this->_getMediaLocalpath($postvalue['mediaurl']);
                        $mediaUrl = $postvalue['mediaurl'];
                        $jobClient = new SendWorkload();
                        $jobClient->pushVideoToYoutube(array(
                            "media_url" => $postvalue['mediaurl'],
                            "title" => $postvalue['name'],
                            "mid" => (!empty($id)) ? $id : $postvalue['_id'],
                            "user_id" => $uinfo['_id']
                        ));
                        $postvalue['is_convert_quality'] = 1;
                    }

                }
                // $postvalue['duration'] = $duration;
            }

            #Avatar + Status
            $priavatar = $this->post_file_to_array($postvalue['type']);
            if (empty($priavatar))
                $priavatar = $this->request->getPost('gen_priavatar');

            if ($priavatar != null) {
                $postvalue['priavatar'] = $priavatar;
                // $postvalue['priavatar'] = $this->getShortenPathImage($postvalue['priavatar']);
            }

            if (empty($priavatar_small))
                $priavatar_small = $this->request->getPost('priavatar_small');

            if ($priavatar_small != null) {
                $postvalue['priavatar_small'] = $priavatar_small;
                // $postvalue['priavatar_small'] = $this->getShortenPathImage($postvalue['priavatar_small']);
            }

            if (empty($postvalue['is_convert_quality']) && defined('HAS_RABBIT_MQ')) {
                if ($this->_isFromStreamServer($postvalue['mediaurl']) && $postvalue['type'] === "audio") {
                    // $mediaUrl = $this->_getMediaLocalpath($postvalue['mediaurl']);
                    $mediaUrl = $postvalue['mediaurl'];
                    $artistNames = array();
                    if (empty($postvalue['artist']))
                        $postvalue['artist'] = array();
                    $artistCl = Artist::findAndReturnArray(array(
                        "condition" => array(
                            '_id' => array('$in' => $postvalue['artist'])
                        )
                    ));
                    foreach ($artistCl as $key => $value) {
                        $artistNames[] = $value['username'];
                    }
                    $jobClient = new SendWorkload();
                    $jobClient->pushMediaToConvert(array(
                        "title" => $postvalue['name'],
                        "media_url" => $mediaUrl,
                        "mid" => (!empty($id)) ? $id : $postvalue['_id'],
                        "artist" => implode(";", $artistNames)
                    ));
                }
                $postvalue['is_convert_quality'] = 1;
            }

            if ($id <= 0) {
                $postvalue['datecreate'] = intval(strtotime("now"));
                $postvalue['usercreate'] = $uinfo['_id'];
                Media::insertDocument($postvalue);
                $this->flash->success($this->getLanguage()->insert_success);
            } else {
                Media::updateDocument(array('_id' => $id), array('$set' => $postvalue, '$push' => array("usermodify" => array("uid" => $uinfo['_id'], "datecreate" => intval(strtotime("now"))))));
                $this->flash->success($this->getLanguage()->update_success);
            }

            $redirect = $this->request->getPost("redirect");
            if (!$redirect) $redirect = "media/index?type=" . $postvalue['type'];
            return $this->response->redirect(ltrim($redirect, "/"));
        } else $redirect = "media/index";
        return $this->response->redirect(ltrim($redirect, "/"));
    }

    public function deleteAction()
    {

        $id = $this->request->get('id');
        if (is_array($id)) { // delete in
            $id = array_map("strval", $id);
            Media::updateDocument(array('_id' => array('$in' => $id)), array('$set' => array('status' => 2)), array('multiple' => true));
        } else  Media::updateDocument(array('_id' => "$id"), array('$set' => array('status' => 2)));
        $this->flash->success($this->getLanguage()->delete_success);
        $redirect = Helper::cpagerparm("tact,id,status", "/media/index");
        if (!$redirect) $redirect = '/media/index';
        return $this->response->redirect(ltrim($redirect, '/'));
    }

    protected function _isLocalMediaUrl($mediaUrl)
    {
        return preg_match('/^(\/web\/uploads\/)/', $mediaUrl);
    }

    protected function _isFromStreamServer($mediaUrl)
    {
        return preg_match('/^(http:\/\/s1\.download\.stream\.djscdn\.com\/media)/', $mediaUrl);
    }

}