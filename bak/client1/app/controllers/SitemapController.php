<?php
namespace DjClient\Controller;

use DjClient\Library\Helper;
use DjClient\Library\Makelink;
use DjClient\Models\Artist;
use DjClient\Models\Category;
use DjClient\Models\Album;
use DjClient\Models\Media;
use DjClient\Models\Settings;
use DjClient\Models\Tags;
use DjClient\Models\Topic;
use DjClient\Models\Users;
use Phalcon\Mvc\View;

class SitemapController extends ControllerBase {

    protected function afterExecuteRoute() {
        $this->response->setHeader('Content-Type', 'text/xml, charset=utf-8');
        $this->view->setVar('domainUri', DOMAIN);
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }

    public function mainAction() {

    }

    public function categoryAction() {
        /*$criteria = array(
            'sort' => array(
                'datecreate' => -1
            )
        );
        $categories= Category::findAndReturnArray($criteria);
        foreach ($categories  as $category) {
            if ($category['type'] == 'audio') {
                $category['link'] = DOMAIN . Makelink::link_view_category_music($category['name'], $category['_id']);
            }
            if ($category['type'] == 'video') {
                $category['link'] = DOMAIN . Makelink::link_view_category_video($category['name'], $category['_id']);
            }
            if (!empty($category['link'])) {
                $listCategories[] = $category;
            }
        }
        $this->view->setVar('listCategories', $listCategories);*/ 
        $listCategorys = Settings::getElementByKey(self::$TYPE_CATEGORY_HOME);
        $this->view->listCategorys = $listCategorys;
    }

    public function albumAction() {
        $limit = 1000;
        $p = $p = $this->dispatcher->getParam('page');
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
            $listAlbums[] = $album;
        }
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
            $listPlaylist[] = $elem;
        }
        $this->view->setVar('listPlaylist', $listPlaylist);
    }

    public function articleAction() {
        $limit = 1000;
        $p = $p = $this->dispatcher->getParam('page');
        $p = ($p < 1) ? 1: $p;
        $skip = ($p - 1) * $limit;

        $type = $p = $this->dispatcher->getParam('type');
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
        if ($type == 'news' || $type == 'images')
            $fcMakelink = "link_view_article";
        if ($type == 'audio')
            $fcMakelink = "link_view_article_music";
        if ($type == 'video')
            $fcMakelink = "link_view_article_video";

        $listMedia = Media::findAndReturnArray($criteria);
        foreach ($listMedia  as $elem) {
            $elem['link'] = DOMAIN . Makelink::$fcMakelink($elem['name'], $elem['_id']);
            $listMediaItem[] = $elem;
        }
        $this->view->setVar('listMediaItem', $listMediaItem);
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
            $listTopicItem[] = $elem;
        }
        $this->view->setVar('listTopicItem', $listTopicItem);
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
            $listUser[] = $elem;
        }
        $this->view->setVar('listUser', $listUser);
    }
    public function artistAction() {
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

        $data = Artist::findAndReturnArray($criteria);
        foreach ($data  as $elem) {
            $elem['priavatar'] =  Helper::checkAvatar($elem['usercreate'],$elem['priavatar']);
            $elem['link'] = DOMAIN . Makelink::link_view_artist($elem['username'], $elem['_id']);
            $listArtist[] = $elem;
        }
        $this->view->setVar('listArtist', $listArtist);
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
            $elem['link'] = DOMAIN . Makelink::link_view_tags_index($elem['name'], $elem['_id']);
            $listTags[] = $elem;
        }
        $this->view->setVar('listTags', $listTags);
    }
}