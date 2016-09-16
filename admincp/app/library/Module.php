<?php
namespace DjCms\Library;

use Phalcon\Mvc\User\Component;

class Module extends Component
{
    public static function Permission()
    {
        $permission["loginsystem"] = array("name" => "Đăng nhập hệ thống");
        $permission["index_view"] = array("name" => "Thống kê");
        $permission["media"] = array("name" => "Media", "child" => array(
            array("name" => "Xem danh sách", "key" => "view"),
            array("name" => "Thêm mới", "key" => "add"),
            array("name" => "Sửa", "key" => "update"),
            array("name" => "Xóa", "key" => "delete")
        ));
        $permission["mediarequire"] = array("name" => "Yêu cầu nhạc", "child" => array(
            array("name" => "Xem danh sách nhạc yêu cầu", "key" => "view"),
            array("name" => "Thêm mới nhạc yêu cầu", "key" => "add"),
            array("name" => "Sửa nhạc yêu cầu", "key" => "update"),
            array("name" => "Xóa nhạc yêu cầu", "key" => "delete")
        ));
        $permission["album"] = array("name" => "Album", "child" => array(
            array("name" => "Xem danh sách", "key" => "view"),
            array("name" => "Xem danh sách chủ đề đặc biệt", "key" => "topicisspecial"),
            array("name" => "Thêm mới", "key" => "add"),
            array("name" => "Sửa", "key" => "update"),
            array("name" => "Xóa", "key" => "delete")
        ));
        $permission["category"] = array("name" => "Chuyên mục", "child" => array(
            array("name" => "Xem danh sách", "key" => "view"),
            array("name" => "Xem danh sách Chủ đề theo chuyên mục", "key" => "article"),
            array("name" => "Xem danh sách Chủ đề đặc biệt", "key" => "categoryspecial"),
            array("name" => "Thêm mới", "key" => "add"),
            array("name" => "Sửa", "key" => "update"),
            array("name" => "Xóa", "key" => "delete")
        ));
        $permission["topic"] = array("name" => "Topic", "child" => array(
            array("name" => "Xem danh sách", "key" => "view"),
            array("name" => "Thêm mới", "key" => "add"),
            array("name" => "Sửa", "key" => "update"),
            array("name" => "Xóa", "key" => "delete")
        ));
        $permission["tag"] = array("name" => "Tag", "child" => array(
            array("name" => "Xem danh sách", "key" => "view"),
            array("name" => "Thêm mới", "key" => "add"),
            array("name" => "Sửa", "key" => "update"),
            array("name" => "Xóa", "key" => "delete")
        ));
        $permission["viewcomponent"] = array("name" => "Cấu hình hiển thị", "child" => array(
            array("name" => "Chuyên mục trang chủ", "key" => "categoryhome"),
            array("name" => "Slideshow", "key" => "slideshow"),
            array("name" => "Main menu", "key" => "mainmenu"),
            array("name" => "Danh sách Menu", "key" => "listmenuindex"),
            array("name" => "Tác phẩm chọn lọc", "key" => "selectivearticle")
        ));
        $permission["role"] = array("name" => "Nhóm quyền", "child" => array(
            array("name" => "Xem danh sách", "key" => "view"),
            array("name" => "Thêm mới", "key" => "add"),
            array("name" => "Sửa", "key" => "update"),
            array("name" => "Xóa", "key" => "delete")
        ));
        $permission["users"] = array("name" => "User", "child" => array(
            array("name" => "Xem danh sách", "key" => "view"),
            array("name" => "Thêm mới", "key" => "add"),
            array("name" => "Sửa", "key" => "update"),
            array("name" => "Xóa", "key" => "delete"),
            array("name" => "Set Role", "key" => "rolegroup")
        ));
        $permission["artist"] = array("name" => "Nghệ sĩ", "child" => array(
            array("name" => "Xem danh sách", "key" => "view"),
            array("name" => "Thêm mới", "key" => "add"),
            array("name" => "Sửa", "key" => "update"),
            array("name" => "Xóa", "key" => "delete")
        ));
        $permission["comment"] = array("name" => "Comment", "child" => array(
            array("name" => "Xem danh sách", "key" => "view"),
            array("name" => "Thêm mới", "key" => "add"),
            array("name" => "Sửa", "key" => "update"),
            array("name" => "Xóa", "key" => "delete")
        ));
        $permission["answer"] = array("name" => "Hỏi đáp", "child" => array(
            array("name" => "Xem danh sách", "key" => "view"),
            array("name" => "Thêm mới", "key" => "add"),
            array("name" => "Sửa", "key" => "update"),
            array("name" => "Xóa", "key" => "delete")
        ));
        $permission["reportspam"] = array("name" => "Feedback", "child" => array(
            array("name" => "Xem danh sách", "key" => "view"),
            array("name" => "Xóa", "key" => "delete")
        ));
        $permission["ads"] = array("name" => "Cấu hình quảng cáo", "child" => array(
            array("name" => "Trang chủ - desktop", "key" => "homepage"),
            array("name" => "Trang chủ - tablet", "key" => "homepagetablet"),
            array("name" => "Trang chủ - mobile", "key" => "homepagemobile"),
            array("name" => "Trang nghe nhạc", "key" => "musicplaypage")
        ));
        return $permission;
    }

    public static function Sidebar()
    {
        $sidebar[] = array("name" => "Home", "icon" => "md md-home", "key" => "index", "controller" => "/index/index");
        $sidebar[] = array("name" => "Media", "icon" => "md md-receipt", "key" => "media", "controller" => "/media/index");
        $sidebar[] = array("name" => "Nhạc yêu cầu", "icon" => "md md-receipt", "key" => "mediarequire", "controller" => "/mediarequire/index");
        $sidebar[] = array("name" => "Album - Playlist - Topic", "icon" => "md md-slideshow", "key" => "album", "controller" => "/album/index");
        $sidebar[] = array("name" => "Artist", "icon" => "md md-star-outline", "key" => "artist", "controller" => "/artist/index");
        $sidebar[] = array("name" => "Chuyên mục", "icon" => "md md-folder", "key" => "category", "controller" => "/category/index");
        $sidebar[] = array("name" => "Hỏi đáp", "icon" => "md md-comment", "key" => "category", "controller" => "/answer/index");
        $sidebar[] = array("name" => "Comment", "icon" => "md md-comment", "key" => "comment", "controller" => "/comment/index");
        $sidebar[] = array("name" => "Tag", "icon" => "md md-turned-in", "key" => "tag", "controller" => "/tag/index");
        $sidebar[] = array("name" => "Feedback", "icon" => "md md-warning", "key" => "reportspam", "controller" => "/reportspam/index");
        $sidebar[] = array("name" => "Cấu hình quảng cáo", "icon" => "md md-desktop-mac", "key" => "ads", "controller" => "javascript:void(0)", "child" => array(
            array("name" => "Trang chủ - Desktop", "key" => "ads_homepage", "controller" => "/ads/homepage"),
            array("name" => "Trang chủ - Tablet", "key" => "ads_homepagetablet", "controller" => "/ads/homepagetablet"),
            array("name" => "Trang chủ - Mobile", "key" => "ads_homepagemobile", "controller" => "/ads/homepagemobile"),
            array("name" => "Trang nghe nhạc", "key" => "ads_musicplaypage", "controller" => "/ads/musicplaypage")
        ));
        $sidebar[] = array("name" => "Cấu hình hiển thị", "icon" => "md md-view-list", "key" => "viewcomponent", "controller" => "javascript:void(0)", "child" => array(
            array("name" => "Danh sách Menu", "key" => "viewcomponent_listmenuindex", "controller" => "/viewcomponent/listmenuindex"),
            array("name" => "Slideshow", "key" => "viewcomponent_slideshow", "controller" => "/viewcomponent/slideshow"),
            array("name" => "Tác phẩm chọn lọc", "key" => "viewcomponent_selectivearticle", "controller" => "/viewcomponent/selectivearticle")
        ));
        $sidebar[] = array("name" => "Hệ thống", "icon" => "md md-settings-applications", "key" => "system", "controller" => "javascript:void(0)", "child" => array(
            array("name" => "Nhóm quyền", "key" => "role", "controller" => "/role/index"),
            array("name" => "Users", "key" => "users", "controller" => "/users/index")
        ));
        return $sidebar;
    }

    public function is_accept_permission($key)
    {
        $sessionPermission = $this->session->get('permission');
        if (count($sessionPermission) <= 0) $sessionPermission = array();
        $tmp = explode(",", $key);
        if (count($tmp) > 0) {
            $rs = array_intersect($tmp, $sessionPermission);
            if (count($rs) > 0) return 1;
            else return 0;
        } else {
            if (in_array($key, $sessionPermission)) return 1;
            else return 0;
        }
    }
}

?>