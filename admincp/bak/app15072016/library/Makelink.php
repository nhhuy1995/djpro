<?php
namespace DjCms\Library;

use Phalcon\Http\Request as HttpRequest;

class Makelink
{
    public static function link_view_article_music($name, $id)
    {
        $url = Helper::Cleanurl(Helper::convertToUtf8($name));
        return '/' . $url . '-m' . $id . '.html';
    }

    public static function link_view_article_playlist_music($name, $id)
    {
        $url = Helper::Cleanurl(Helper::convertToUtf8($name));
        return '/' . $url . '-plm' . $id . '.html';
    }

    public static function link_view_article_playlist_video($name, $id)
    {
        $url = Helper::Cleanurl(Helper::convertToUtf8($name));
        return '/' . $url . '-plv' . $id . '.html';
    }

    public static function link_view_article_selective_topic($name, $id)
    {
        $url = Helper::Cleanurl(Helper::convertToUtf8($name));
        return '/' . $url . '-sltt' . $id . '.html';
    }

    public static function link_view_article_album($name, $id)
    {
        $url = Helper::Cleanurl(Helper::convertToUtf8($name));
        return '/' . $url . '-ab' . $id . '.html';
    }

    public static function link_view_article_video($name, $id)
    {
        $url = Helper::Cleanurl(Helper::convertToUtf8($name));
        return '/' . $url . '-av' . $id . '.html';
    }

    public static function link_view_category_video($name, $id)
    {
        $url = Helper::Cleanurl(Helper::convertToUtf8($name));
        return '/' . $url . '-cv' . $id . '.html';
    }
    public static function link_view_tags_index($name, $id)
    {
        $url = Helper::Cleanurl(Helper::convertToUtf8($name));
        return '/tags/' . $url . '-ti' . $id . '.html';
    }
    public static function link_view_category_music($name, $id)
    {
        $url = Helper::Cleanurl(Helper::convertToUtf8($name));
        return '/' . $url . '-cm' . $id . '.html';
    }
    public static function link_view_category_playlist($name, $id)
    {
        $url = Helper::Cleanurl(Helper::convertToUtf8($name));
        return '/' . $url . '-cp' . $id . '.html';
    }
    public static function link_view_category_artist($name, $id)
    {
        $url = Helper::Cleanurl(Helper::convertToUtf8($name));
        return '/' . $url . '-ca' . $id . '.html';
    }
    public static function link_view_category_news($name, $id)
    {
        $url = Helper::Cleanurl(Helper::convertToUtf8($name));
        return '/' . $url . '-cn' . $id . '.html';
    }
    public static function link_view_category_images($name, $id)
    {
        $url = Helper::Cleanurl(Helper::convertToUtf8($name));
        return '/' . $url . '-ci' . $id . '.html';
    }
    public static function link_view_article($name, $id)
    {
        $url = Helper::Cleanurl(Helper::convertToUtf8($name));
        return '/' . $url . '-n' . $id . '.html';
    }
}

?>