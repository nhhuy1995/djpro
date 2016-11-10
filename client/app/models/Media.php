<?php
namespace DjClient\Models;

use DjClient\Library\Helper;
use DjClient\Library\Makelink;
use Phalcon\Mvc\Collection;

/**
 * Class Media
 * @package DjCms\Models
 * @author hungln
 * @description Media Collection in Db
 */
class Media extends BaseCollection
{

    public function getSource()
    {
        return "media";
    }

    public function initialize()
    {
        $this->useImplicitObjectIds(false);
    }

    /*
     * @param: $type string
     * @param: $limit int
     * @param: $sort -> if == 1 is sort by datacreate , if == 2 is sort by view
     * @param: $listid array
     */
    public static function ListMusicByMultiConditions($type, $limit, $sort, $listid = null)
    {
        if ($sort == 1) $sort = array('datecreate' => -1);
        else if ($sort == 2) $sort = array('view' => -1);
        if ($listid == null) $cond = array('type' => $type, 'status' => static::$STATUS_ON);
        else $cond = array('_id' => array('$in' => $listid), 'status' => static::$STATUS_ON);
        $listmusic = Media::findAndReturnArray(array(
            'condition' => $cond,
            'sort' => $sort,
            'limit' => $limit,
        ));
        foreach ($listmusic as $key => $value) {
            $usercreate_id = $value['usercreate'];
            $artistid = $value['artist'];
            if ($value['type'] == self::$TYPE_VIDEO) $makelink = Makelink::link_view_article_video($value['name'], $value['_id']);
            if ($value['type'] == self::$TYPE_MUSIC) $makelink = Makelink::link_view_article_music($value['name'], $value['_id']);
            $listmusic[$key]['link'] = $makelink;
            if (!empty($artistid)) $listmusic[$key]['listartist'] = Artist::getArtistByID($artistid);
//            $listmusic[$key]['usercreate'] = Users::getUserInfo($usercreate_id);
            unset($artistid);
        }
        return $listmusic;
    }

    public static function getListMedia_BySearch($keyword, $type, $limit)
    {
        $data = Media::findAndReturnArray(array(
            'condition' => array('$text' => array('$search' => "$keyword"), 'type' => $type, 'status' => static::$STATUS_ON),
            'sort' => array('datecreate', -1),
            'limit' => $limit,
        ));
        foreach ($data as &$item) {
            $artistid = $item['artist'];
            if ($item['type'] == 'audio') $item['link'] = Makelink::link_view_article_music($item['name'], $item['_id']);
            else $item['link'] = Makelink::link_view_article_video($item['name'], $item['_id']);
            $item['username'] = Users::getUserInfo($item['usercreate']);
            if (isset($artistid) || !empty($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
        }
        return $data;
    }
    public static function getListMedia_ByTagsID($tagid,$type,$limit){
        $data = Media::findAndReturnArray(array(
            'condition' => array('tags' => $tagid, 'type' => $type, 'status' => static::$STATUS_ON),
            'sort' => array('datecreate', -1),
            'limit' => $limit,
        ));
        foreach ($data as &$item) {
            $artistid = $item['artist'];
            if ($item['type'] == 'audio') $item['link'] = Makelink::link_view_article_music($item['name'], $item['_id']);
            else if ($item['type'] == 'news') $item['link'] = Makelink::link_view_article($item['name'], $item['_id']);
            else $item['link'] = Makelink::link_view_article_video($item['name'], $item['_id']);
            $item['username'] = Users::getUserInfo($item['usercreate']);
            $item['priavatar'] = Helper::checkAvatar($item['usercreate'],$item['priavatar']);
            if (isset($artistid) || !empty($artistid)) $item['listartist'] = Artist::getArtistByID($artistid);
        }
        return $data;
    }

    public static function getSymLinkMedia($media) {
        $mediaLinksType = array (
            "direct_media_url",
            "link_video_1080","link_video_720",
            "link_video_480","link_video_360",
            "link_video_240","link_video_144",
            "media_link_320k","media_link_128k","media_link_64k"
        );
        foreach ($mediaLinksType as $key => $type) {
            if ($media->$type) {
                $media->$type = Media::_getSymLinkForLink($media->$type);
                if (!$media->direct_media_url)
                    $media->direct_media_url = $media->$type;
            }
        }
        return $media;
    }

    public static function _getSymLinkForLink($mediaLink)
    {
        preg_match('(media/[0-9\/_]+/song)', $mediaLink, $reg_result);
        if ($reg_result) {
            $key_secret = 'DJ_SECRET';
            $prefix_folder = 'media_symb';

            $seperators = array('-', '_', '/');
            $rand_sp = $seperators[array_rand($seperators)];
            $format = join($rand_sp, array('d', 'm', 'Y'));
            $symbolName = $reg_result[0].date($format).$key_secret;
            $symbolLink = $prefix_folder . '/' . md5($symbolName);
            $mediaLink = preg_replace('(media/[0-9\/_]+/song)', $symbolLink, $mediaLink);
            return $mediaLink;
        }

        preg_match('(media/yt_dl/[a-zA-Z0-9-_]+)', $mediaLink, $reg_result);
        if ($reg_result) {
            $key_secret = 'DJ_SECRET';
            $prefix_folder = 'media_symb/yt_dl';

            $seperators = array('-', '_', '/');
            $rand_sp = $seperators[array_rand($seperators)];
            $format = join($rand_sp, array('d', 'm', 'Y'));
            $symbolName = $reg_result[0].date($format).$key_secret;
            $symbolLink = $prefix_folder . '/' . md5($symbolName);
            $mediaLink = preg_replace('(media/yt_dl/[a-zA-Z0-9-_]+)', $symbolLink, $mediaLink);
            return $mediaLink;
        }
    }
}