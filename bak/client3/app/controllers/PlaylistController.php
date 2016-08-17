<?php
namespace DjClient\Controller;

use DjClient\Library\Helper;
use DjClient\Library\Makelink;
use DjClient\Models\Album;
use DjClient\Models\Artist;
use DjClient\Models\Category;
use DjClient\Models\Comment;
use DjClient\Models\Media;
use DjClient\Models\Notify;
use DjClient\Models\Settings;
use DjClient\Models\Tags;
use DjClient\Models\Users;
use DjClient\Services\RankingArticle;

class PlaylistController extends ControllerBase
{
    public static $TYPE_SELECTIVE_PLAYLIST = 'selective_playlist';

    public function indexAction()
    {

        $limit = 8;
        $listPlaylist = Album::ListAlbumByMultiConditions(self::$TYPE_PLAYLIST, $limit, 1);
        //list playlist selective
        $listIdPlaylist = Settings::getElementByKey(self::$TYPE_SELECTIVE_PLAYLIST);
        $listPlaylistSelectvie = Helper::resortarray(Album::ListAlbumByMultiConditions(self::$TYPE_PLAYLIST, $limit, 1, $listIdPlaylist), $listIdPlaylist, "_id");
        $this->view->listplaylist = $listPlaylist;
        $this->view->listplselective = $listPlaylistSelectvie;
        $this->view->header = Helper::setHeader('Playlist','','');
    }

    public function selectiveAction()
    {
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 12;
        $skip = ($p - 1) * $limit;
        $listIdPlaylist = Settings::getElementByKey(self::$TYPE_SELECTIVE_PLAYLIST);
        $list_SelectivePlaylist = Album::findAndReturnArray(array(
            'fields' => array('name', '_id', 'view', 'usercreate', 'priavatar', 'artist', 'listartist'),
            'condition' => array('_id' => array('$in' => $listIdPlaylist), 'status' => static::$STATUS_ON),
            'sort' => array('datecreate' => -1),
            'skip' => $skip,
            'limit' => $limit,
        ));
        $list_SelectivePlaylist = Helper::resortarray($list_SelectivePlaylist, $listIdPlaylist, "_id");
        foreach ($list_SelectivePlaylist as $item) {
            $artistid = $item['artist'];
            if (isset($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
            $item['link'] = Makelink::link_view_article_playlist_music($item['name'], $item['_id']);
            $data[] = $item;
        }
        $count = Album::findAndReturnArray(array(
            'condition' => array('_id' => array('$in' => $listIdPlaylist), 'status' => static::$STATUS_ON),
        ));
        $this->view->painginfo = Helper::paginginfo(count($count), $limit, $p);
        $this->view->listPlaylist_selective = $data;
        $this->view->header = Helper::setHeader('Playlist chọn lọc','','');
    }

    public function musicAction()
    {
        $uinfo = $this->session->get('uinfo');
        $id = $this->dispatcher->getParam('atId');
        $o = (object)Album::getCollectionInstance()->findAndModify(array('_id' => $id), array('$inc' => array('view' => +1)));
        if (!isset($o->_id)) $this->response->redirect('/error.html');
        $categoryId = $o->category;
        $tagsid = $o->tags;
        if ($categoryId) $listCategory = Category::getCategoryByID(self::$TYPE_PLAYLIST, $categoryId);
        if (isset($tagsid) || !empty($tagsid)) $listtags = Helper::resortarray(Tags::getListTagsByID(self::$TYPE_PLAYLIST, $tagsid), $tagsid, '_id');
        if (isset($o->usercreate) && !empty($o->usercreate)) { // get info of user create
            $usercreateInfo = Users::getUserById($o->usercreate);
            $o->usercreate = $usercreateInfo->username;
            $o->usercreatelink = $usercreateInfo->link;
            $o->usercreate_namerole = $usercreateInfo->namerole;
            $o->is_role = $usercreateInfo->is_role;
        }
        $o->view = isset($o->view) ? Helper::Numberformat($o->view) : 0;
        $o->like = isset($o->like) ? Helper::Numberformat($o->like) : 0;
        $o->dislike = isset($o->dislike) ? Helper::Numberformat($o->dislike) : 0;
        $o->priavatar = Helper::checkAvatar($o->usercreate, $o->priavatar);
        $o->link = Makelink::link_view_article_playlist_music($o->name, $o->_id);
        $listSong = array();
        $data = array();
        $listsongId = array();
        $listsongId = $o->listsong;
        if ($listsongId) {
            $listSong = Media::findAndReturnArray(array(
                'condition' => array('_id' => array('$in' => $listsongId), 'status' => static::$STATUS_ON),
            ));
            foreach ($listSong as $item) {
                $artistid = $item['artist'];
                //check like
                $checklike = Notify::getNotifyByType($uinfo['_id'], $item['_id'], static::$OPTION_TYPE_LIKE);
                $item['checklike'] = isset($checklike->_id) ? 1 : 0;
                //check nominations
                $o_nominations = Notify::getNotifyByType($uinfo['_id'], $item['_id'], static::$OPTION_TYPE_NOMINATIONS);
                $item['nominations'] = isset($o_nominations->_id) ? 1 : 0;
                $item['link'] = Makelink::link_view_article_music($item['name'], $item['_id']);
                if (isset($artistid) || !empty($artistid)) {
                    $listartist = Artist::getArtistByID($artistid);
                    $item['listartist'] = $listartist[0];
                }
                ##check link default
                if (isset($item['media_link_64k'])) $media_url = $item['media_link_64k'];
                else $media_url = $item['media_link_64k'];
                $item["direct_media_url"] = $media_url;
                $data[] = $item;
                unset($artistid);
            }
        }
        ##check đề cử,like,dislike
        if (isset($uinfo)) {
            $o_like = Notify::getNotifyByType($uinfo['_id'], $id, static::$OPTION_TYPE_LIKE);
            $o_dislike = Notify::getNotifyByType($uinfo['_id'], $id, static::$OPTION_TYPE_DISLIKE);
            $o_nominations = Notify::getNotifyByType($uinfo['_id'], $id, static::$OPTION_TYPE_NOMINATIONS);
        }
        $listcomment = Comment::findAndReturnArray(array(
            'condition' => array('atid' => $id, 'parent_id' => "0"),
        ));
        $total_page_comment = ceil(count($listcomment) / 4);
        ##list Audio by view
        $ranking = new RankingController();
        $listmusicbyview = $ranking->getMediaConditions('Media', 'audio', 'month', 5);
        ##total comment
        $total_comment = Comment::count(array(
            'conditions' => array('atid' => $id),
        ));
        $this->view->setVars(array(
            'listartist' => Helper::resortarray(Artist::getArtistByID($o->artist), $o->artist, '_id'),
            'check_like' => $o_like,
            'check_dislike' => $o_dislike,
            'check_nominations' => $o_nominations,
            'currentLink' => str_replace('?','',DOMAIN . Helper::cpagerparm("")),
            'iframe_share_link' => DOMAIN . Makelink::link_view_embed_collection($id),
            'total_page_comment' => $total_page_comment,
            'listmusicbyview' => $listmusicbyview,## list music by view
            'listalbum' => Album::ListAlbumByMultiConditions($o->type, 5, 1),
            'total_comment' => $total_comment,
            'listSong' => $data,
            'listags' => $listtags,
            'listcategory' => $listCategory,
            'object' => $o,
        ));
        $this->view->header = Helper::setHeader($o->name,$o->description,$o->priavatar);
        RankingArticle::increaseActionNumber("view", $o->_id, $o->type);
    }

    public function newAction()
    {
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 12;
        $skip = ($p - 1) * $limit;
        $listAlbum = Album::findAndReturnArray(array(
            'condition' => array('type' => self::$TYPE_PLAYLIST, 'status' => static::$STATUS_ON),
            'skip' => $skip,
            'limit' => $limit,
            'sort' => array('datecreate' => -1),
        ));
        $data = array();
        foreach ($listAlbum as &$item) {
            $artistid = $item['artist'];
            if (isset($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
            $item['link'] = Makelink::link_view_article_playlist_music($item['name'], $item['_id']);
            $data[] = $item;
        }
        $count = $listAlbum = Album::findAndReturnArray(array(
            'condition' => array('type' => self::$TYPE_PLAYLIST, 'status' => static::$STATUS_ON),
        ));
        $this->view->painginfo = Helper::paginginfo(count($count), $limit, $p);
        $this->view->listalbum = $data;
        $this->view->header = Helper::setHeader('Playlist mới nhất','','');
    }

    public function categoryAction()
    {
        $catid = $this->dispatcher->getParam('catId');
        $p = $_GET['p'];
        if ($p <= 1) $p = 1;
        $limit = 12;
        $skip = ($p - 1) * $limit;
        $category = Category::findById($catid);
        if ($category == false) $this->response->redirect('/error.html');
        else {
            $category->link = Makelink::link_view_category_playlist($category->name, $category->getId());
            $cursor = Album::findAndReturnArray(array(
                'condition' => array('category' => $catid, 'status' => static::$STATUS_ON),
                'skip' => $skip,
                'limit' => $limit,
                'sort' => array('datecreate' => -1),
            ));
            $data = array();
            foreach ($cursor as $item) {
                $artistid = $item['artist'];
                if (isset($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
                $item['link'] = Makelink::link_view_article_playlist_music($item['name'], $item['_id']);
                $data[] = $item;
            }
            $count = Album::findAndReturnArray(array(
                'condition' => array('category' => $catid, 'status' => static::$STATUS_ON),
            ));
            $this->view->painginfo = Helper::paginginfo(count($count), $limit, $p);
            $this->view->listalbum = $data;
            $this->view->category = $category;
            $this->view->header = Helper::setHeader($category->name,'','');
        }
    }
}

