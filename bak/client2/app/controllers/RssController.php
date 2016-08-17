<?php
namespace DjClient\Controller;

use DjClient\Library\Helper;
use DjClient\Library\Makelink;
use DjClient\Models\Artist;
use DjClient\Models\Category;
use DjClient\Models\Album;
use DjClient\Models\Media;
use DjClient\Models\Tags;
use DjClient\Models\Topic;
use DjClient\Models\Users;
use Phalcon\Mvc\View;

class RssController extends ControllerBase {

    private $_headerName;

    protected function afterExecuteRoute() {
        if (!$this->_headerName)
            $this->_headerName = 'Dj.pro.vn';
        $this->response->setHeader('Content-Type', 'text/xml, charset=utf-8');
        $this->view->setVars(array(
            'domainUri'  =>  DOMAIN,
            'headerName' => $this->_headerName,
            'sitename' => $this->config->application->site
        ));
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }

    public function topicAction() {
        $limit = 1000;
        $p = $this->dispatcher->getParam('page');
        $p = ($p < 1) ? 1: $p;
        $skip = ($p - 1) * $limit;
        $criteria = array(
            'condition' => array(
                'type' => 'topic',
                'status' => 1
            ),
            'skip' => $skip,
            'limit' => $limit,
            'sort' => array(
                'datecreate' => -1
            )
        );

        $listTopic = Album::findAndReturnArray($criteria);
        foreach ($listTopic  as $elem) {
            $elem['priavatar'] =  Helper::checkAvatar($elem['usercreate'],$elem['priavatar']);
            $elem['link'] = DOMAIN . Makelink::link_view_article_playlist_music($elem['name'], $elem['_id']);
            $elem['publish_date'] = date('d-m-Y', $elem['datecreate']);
            $listTopicItem[] = $elem;
        }

        $this->_headerName   = 'Chủ đề mới';
        $this->view->setVar('listTopicItem', $listTopicItem);
    }

    public function articleAction() {
        $limit = 1000;
        $p = $this->dispatcher->getParam('page');
        $p = ($p < 1) ? 1: $p;
        $skip = ($p - 1) * $limit;

        $type = $this->dispatcher->getParam('type');
        $criteria = array(
            'condition' => array(
                'status' => 1,
                'type' => $type
            ),
            'skip' => $skip,
            'limit' => $limit,
            'sort' => array(
                'datecreate' => -1
            )
        );
        if ($type == 'images') {
            $fcMakelink = "link_view_article";
            $this->_headerName =  'Ảnh mới';
        }
        if ($type == 'news') {
            $fcMakelink = "link_view_article";
            $this->_headerName =  'Tin tức mới';
        }
        if ($type == 'audio') {
            $fcMakelink = "link_view_article_music";
            $this->_headerName =  'Nonstop mới';
        }
        if ($type == 'video') {
            $fcMakelink = "link_view_article_video";
            $this->_headerName = 'Video mới';
        }

        $listMedia = Media::findAndReturnArray($criteria);
        foreach ($listMedia  as $elem) {
            $elem['priavatar'] =  Helper::checkAvatar($elem['usercreate'],$elem['priavatar']);
            $elem['link'] = DOMAIN . Makelink::$fcMakelink($elem['name'], $elem['_id']);
            $elem['publish_date'] = date('d-m-Y', $elem['datecreate']);
            $listMediaItem[] = $elem;
        }
        $this->view->setVar('listMediaItem', $listMediaItem);
    }

    public function albumAction() {
        $limit = 1000;
        $p = $this->dispatcher->getParam('page');
        $p = ($p < 1) ? 1: $p;
        $skip = ($p - 1) * $limit;
        $criteria = array(
            'condition' => array(
                'status' => 1,
                'type' => 'album'
            ),
            'skip' => $skip,
            'limit' => $limit,
            'sort' => array(
                'datecreate' => -1
            )
        );

        $albums = Album::findAndReturnArray($criteria);
        $listAlbums = [];
        foreach ($albums  as $album) {
            $album['priavatar'] =  Helper::checkAvatar($album['usercreate'],$album['priavatar']);
            $album['link'] = DOMAIN . Makelink::link_view_article_playlist_music($album['name'], $album['_id']);
            $album['publish_date'] = date('d-m-Y', $album['datecreate']);
            $listAlbums[] = $album;
        }

        $this->_headerName = 'Album mới';
        $this->view->setVar('listAlbums', $listAlbums);
    }

    public function playlistAction() {
        $limit = 1000;
        $p = $this->dispatcher->getParam('page');
        $p = ($p < 1) ? 1: $p;
        $skip = ($p - 1) * $limit;
        $criteria = array(
            'condition' => array(
                'status' => 1,
                'type' => 'playlist'
            ),
            'skip' => $skip,
            'limit' => $limit,
            'sort' => array(
                'datecreate' => -1
            )
        );

        $playlist = Album::findAndReturnArray($criteria);
        foreach ($playlist  as $elem) {
            $elem['priavatar'] =  Helper::checkAvatar($elem['usercreate'],$elem['priavatar']);
            $elem['link'] = DOMAIN . Makelink::link_view_article_playlist_music($elem['name'], $elem['_id']);
            $elem['publish_date'] = date('d-m-Y', $elem['datecreate']);
            $listPlaylist[] = $elem;
        }

        $this->_headerName = 'Playlist mới';
        $this->view->setVar('listPlaylist', $listPlaylist);
    }
    public function artistAction() {
        $limit = 1000;
        $p = $this->dispatcher->getParam('page');
        $p = ($p < 1) ? 1: $p;
        $skip = ($p - 1) * $limit;
        $criteria = array(
            'condition' => array(
                'status' => 1,
            ),
            'skip' => $skip,
            'limit' => $limit,
            'sort' => array(
                'datecreate' => -1
            )
        );

        $artist = Artist::findAndReturnArray($criteria);
        foreach ($artist  as $elem) {
            $elem['priavatar'] =  Helper::checkAvatar($elem['usercreate'],$elem['priavatar']);
            $elem['link'] = DOMAIN . Makelink::link_view_artist($elem['username'], $elem['_id']);
            $elem['publish_date'] = date('d-m-Y', $elem['datecreate']);
            $listArtist[] = $elem;
        }
        $this->_headerName = 'Nghệ sỹ mới';
        $this->view->setVar('listArtist', $listArtist);
    }
    public function userAction() {
        $limit = 1000;
        $p = $this->dispatcher->getParam('page');
        $p = ($p < 1) ? 1: $p;
        $skip = ($p - 1) * $limit;
        $criteria = array(
            'skip' => $skip,
            'limit' => $limit,
            'sort' => array(
                'datecreate' => -1
            )
        );

        $data = Users::findAndReturnArray($criteria);
        foreach ($data  as $elem) {
            if (empty($elem['priavatar']) || !isset($elem['priavatar'])) $elem['priavatar'] = Helper::getAvatarUserDefault();
            $elem['link'] = DOMAIN . Makelink::link_view_member($elem['username'], $elem['_id']);
            $elem['publish_date'] = date('d-m-Y', $elem['datecreate']);
            $listUser[] = $elem;
        }
        $this->_headerName = 'Thành viên mới';
        $this->view->setVar('listUser', $listUser);
    }
    public function tagsAction() {
        $limit = 1000;
        $p = $this->dispatcher->getParam('page');
        $p = ($p < 1) ? 1: $p;
        $skip = ($p - 1) * $limit;
        $criteria = array(
            'skip' => $skip,
            'limit' => $limit,
            'sort' => array(
                'datecreate' => -1
            )
        );

        $data = Tags::findAndReturnArray($criteria);
        foreach ($data  as $elem) {
            if (empty($elem['priavatar']) || !isset($elem['priavatar'])) $elem['priavatar'] = Helper::getAvatarDefault();
            $elem['link'] = DOMAIN . Makelink::link_view_tags_index($elem['name'], $elem['_id']);
            $elem['publish_date'] = date('d-m-Y', $elem['datecreate']);
            $listTags[] = $elem;
        }
        $this->_headerName = 'Tags mới';
        $this->view->setVar('listTags', $listTags);
    }
}