<?php
namespace DjCms\Controller;

use DjCms\Models\Album;
use DjCms\Models\Artist;
use DjCms\Models\Comment;
use DjCms\Models\Media;
use DjCms\Models\MediaRequire;
use DjCms\Models\Tag;
use DjCms\Models\Topic;

class IndexController extends ControllerBase
{
    public static $STATUS_SHOW = 1;
    public static $STATUS_WAIT = 3;
    public static $STATUS_DELETE = 2;
    protected static $TYPE_VIDEO = 'video';
    protected static $TYPE_MUSIC = 'audio';
    protected static $TYPE_ALBUM = 'album';
    protected static $TYPE_TOPIC = 'topic';
    protected static $TYPE_ARTIST = 'artist';
    public static $TYPE_NEWS = 'news';
    public static $TYPE_IMAGES = 'images';
    protected static $TYPE_PLAYLIST = 'playlist';

    public function indexAction()
    {
        $date = date_create(date('Y-m-d'));
        date_sub($date, date_interval_create_from_date_string('30 days'));
        $datetime = strtotime(date_format($date, 'd-m-Y'));
        ##Media
        $media_show = Media::count(array('conditions' => array('type' => static::$TYPE_MUSIC, 'status' => static::$STATUS_SHOW)));
        $media_wait = Media::count(array('conditions' => array('type' => static::$TYPE_MUSIC, 'status' => static::$STATUS_WAIT)));
        $media_delete = Media::count(array(
            'conditions' => array('type' => static::$TYPE_MUSIC, 'status' => static::$STATUS_DELETE, 'datecreate' => array('$gt' => $datetime))
        ));
        $media_require = MediaRequire::count(array('conditions' => array('type' => static::$TYPE_MUSIC)));
        $this->view->media = array(
            'show' => $media_show,
            'wait' => $media_wait,
            'delete' => $media_delete,
            'require' => $media_require
        );

        ##Video
        $video_show = Media::count(array('conditions' => array('type' => static::$TYPE_VIDEO, 'status' => static::$STATUS_SHOW)));
        $video_wait = Media::count(array('conditions' => array('type' => static::$TYPE_VIDEO, 'status' => static::$STATUS_WAIT)));
        $video_delete = Media::count(array(
            'conditions' => array('type' => static::$TYPE_VIDEO, 'status' => static::$STATUS_DELETE, 'datecreate' => array('$gt' => $datetime))
        ));
        $video_require = MediaRequire::count(array('conditions' => array('type' => static::$TYPE_VIDEO)));
        $this->view->video = array(
            'show' => $video_show,
            'wait' => $video_wait,
            'delete' => $video_delete,
            'require' => $video_require
        );

        ##Topic
        $topic_show = Album::count(array('conditions' => array('type' => static::$TYPE_TOPIC, 'status' => static::$STATUS_SHOW)));
        $topic_delete = Album::count(array(
            'conditions' => array('type' => static::$TYPE_TOPIC, 'status' => static::$STATUS_DELETE, 'datecreate' => array('$gt' => $datetime))
        ));
        $this->view->topic = array(
            'show' => $topic_show,
            'delete' => $topic_delete,
        );

        ##Album
        $album_show = Album::count(array('conditions' => array('type' => static::$TYPE_ALBUM, 'status' => static::$STATUS_SHOW)));
        $album_delete = Album::count(array(
            'conditions' => array('type' => static::$TYPE_ALBUM, 'status' => static::$STATUS_DELETE, 'datecreate' => array('$gt' => $datetime))
        ));
        $this->view->album = array(
            'show' => $album_show,
            'delete' => $album_delete,
        );

        ##Playlist
        $playlist_show = Album::count(array('conditions' => array('type' => static::$TYPE_PLAYLIST, 'status' => static::$STATUS_SHOW)));
        $playlist_wait = Album::count(array('conditions' => array('type' => static::$TYPE_PLAYLIST, 'status' => static::$STATUS_WAIT)));
        $playlist_delete = Album::count(array(
            'conditions' => array('type' => static::$TYPE_PLAYLIST, 'status' => static::$STATUS_DELETE, 'datecreate' => array('$gt' => $datetime))
        ));
        $this->view->playlist = array(
            'show' => $playlist_show,
            'wait' => $playlist_wait,
            'delete' => $playlist_delete,
        );

        ##News
        $news_show = Media::count(array('conditions' => array('type' => static::$TYPE_NEWS, 'status' => static::$STATUS_SHOW)));
        $news_delete = Media::count(array(
            'conditions' => array('type' => static::$TYPE_NEWS, 'status' => static::$STATUS_DELETE, 'datecreate' => array('$gt' => $datetime))
        ));
        $this->view->news = array(
            'show' => $news_show,
            'delete' => $news_delete,
        );

        ##Images
        $images_show = Media::count(array('conditions' => array('type' => static::$TYPE_IMAGES, 'status' => static::$STATUS_SHOW)));
        $images_delete = Media::count(array(
            'conditions' => array('type' => static::$TYPE_IMAGES, 'status' => static::$STATUS_DELETE, 'datecreate' => array('$gt' => $datetime))
        ));
        $this->view->images = array(
            'show' => $images_show,
            'delete' => $images_delete,
        );

        ##Artist
        $artist_show = Artist::count(array('conditions' => array('status' => static::$STATUS_SHOW)));
        $artist_wait = Artist::count(array('conditions' => array('status' => static::$STATUS_WAIT)));
        $artist_delete = Artist::count(array(
            'conditions' => array('status' => static::$STATUS_DELETE, 'datecreate' => array('$gt' => $datetime))
        ));
        $this->view->artist = array(
            'show' => $artist_show,
            'wait' => $artist_wait,
            'delete' => $artist_delete,
        );

        ##Tags
        $tags_show = Tag::count(array());
        $this->view->tags = array(
            'show' => $tags_show,
        );

        ##Comment
        $comment_show = Comment::count(array());

        $this->view->comment = array(
            'show' => $comment_show,
        );
    }

}

