<?php
namespace DjCms\Library;

use Phalcon\Mvc\User\Component;

class Module extends Component
{
    public static function Permission()
    {
        $permission["loginsystem"] = array("name" => "Đăng nhập hệ thống");
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
        $permission["reportspam"] = array("name" => "Feedback", "child" => array(
            array("name" => "Xem danh sách", "key" => "view"),
//            array("name" => "Thêm mới", "key" => "add"),
//            array("name" => "Sửa", "key" => "update"),
            array("name" => "Xóa", "key" => "delete")
        ));
//        $permission["bxh"] = array("name" => "Bảng xếp hạng", "child" => array(
//                array("name" => "Xem danh sách", "key" => "view"),
//                array("name" => "Thêm mới", "key" => "add"),
//                array("name" => "Sửa", "key" => "update"),
//                array("name" => "Xóa", "key" => "delete")
//        ));
        return $permission;
    }

    public static function Sidebar()
    {
        $sidebar[] = array("name" => "Home", "icon" => "md md-home", "key" => "index", "controller" => "/index/index");
//        $sidebar[] = array("name" => "Trận đấu", "icon" => "md md-schedule", "key" => "match", "controller" => "/match/index");
        $sidebar[] = array("name" => "Media", "icon" => "md md-receipt", "key" => "media", "controller" => "/media/index");
        $sidebar[] = array("name" => "Nhạc yêu cầu", "icon" => "md md-receipt", "key" => "mediarequire", "controller" => "/mediarequire/index");
        $sidebar[] = array("name" => "Album - Playlist - Topic", "icon" => "md md-slideshow", "key" => "video", "controller" => "/album/index");
        $sidebar[] = array("name" => "Artist", "icon" => "md md-star-outline", "key" => "artist", "controller" => "/artist/index");
//        $sidebar[] = array("name" => "Chủ đề", "icon" => "md md-account-balance", "key" => "topic", "controller" => "/topic/index");
        $sidebar[] = array("name" => "Chuyên mục", "icon" => "md md-folder", "key" => "category", "controller" => "/category/index");
        $sidebar[] = array("name" => "Comment", "icon" => "md md-comment", "key" => "comment", "controller" => "/comment/index");
        $sidebar[] = array("name" => "Tag", "icon" => "md md-turned-in", "key" => "tag", "controller" => "/tag/index");
        $sidebar[] = array("name" => "Feedback", "icon" => "md md-warning", "key" => "reportspam", "controller" => "/reportspam/index");
//        $sidebar[] = array("name" => "Mở rộng", "icon" => "md md-now-widgets", "key" => "teamball,league,star", "controller" => "javascript:void(0)", "child" => array(
//            array("name" => "Đội bóng", "key" => "teamball", "controller" => "/teamball/index"),
//            array("name" => "Giải đấu", "key" => "league", "controller" => "/league/index"),
//            array("name" => "Cầu thủ", "key" => "star", "controller" => "/star/index"),
//            array("name" => "Bảng xếp hạng", "key" => "bxh", "controller" => "/bxh/index"),
//            array("name" => "Tốp ghi bàn", "key" => "topscorer", "controller" => "/topscorer/index"),
//        ));
        $sidebar[] = array("name" => "Cấu hình hiển thị", "icon" => "md md-view-list", "key" => "viewconfig,livescorehome", "controller" => "javascript:void(0)", "child" => array(
//            array("name" => "Chuyên mục trang chủ", "key" => "categoryhome", "controller" => "/viewcomponent/categoryhome"),
            array("name" => "Danh sách Menu", "key" => "listmenuindex", "controller" => "/viewcomponent/listmenuindex"),
            array("name" => "Slideshow", "key" => "slideshow", "controller" => "/viewcomponent/slideshow"),
            array("name" => "Tác phẩm chọn lọc", "key" => "selectivearticle", "controller" => "/viewcomponent/selectivearticle")
//            array("name" => "Trận đấu trang chủ", "key" => "livescorehome", "controller" => "/livescorehome/index"),
        ));
        $sidebar[] = array("name" => "Hệ thống", "icon" => "md md-settings-applications", "key" => "role,user", "controller" => "javascript:void(0)", "child" => array(
            array("name" => "Nhóm quyền", "key" => "role", "controller" => "/role/index"),
            array("name" => "Users", "key" => "user", "controller" => "/users/index")
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