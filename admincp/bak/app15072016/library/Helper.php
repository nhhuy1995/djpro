<?php
namespace DjCms\Library;

use Phalcon\Http\Request as HttpRequest;

class Helper
{

    public static function getConnection()
    {
        global $config;
        $host = $config->database->host;
        $username = $config->database->username;
        $password = $config->database->password;
        $database = $config->database->dbname;
        $port = $config->database->port;
        $mgconn = new \MongoClient("mongodb://{$username}:$password@$host:$port");
        return $mgconn->$database;
    }

    public static function encryptpassword($pass)
    {
        return md5(md5($pass));
    }

    public static function post_to_array($param)
    {
        $param = explode(",", $param);
        $arr = array();
        foreach ($param as $item) $arr[$item] = Helper::xss_clean($_POST[$item]);
        return $arr;
    }

    public static function getListType($key = null)
    {
        $data = array(
            'news' => 'Tin tức',
            'video' => 'Video',
            'audio' => 'Bài hát',
            'images' => 'Ảnh',
        );
        if ($key != null) return $data[$key];
        else return $data;
    }

    public static function getListStatus($key = null)
    {
        $data = array(
            1 => 'Đã duyệt',
            3 => 'Chưa duyệt',
            2 => 'Đã xóa',
        );
        if ($key != null) return $data[$key];
        else return $data;
    }

    public static function cpagerparm($para_need_remove, $suffixctr = null)
    {
        $request = new HttpRequest();
        $pa = $request->getQuery();
        $controller = $pa['_url'];
        unset($pa['_url']);
        ##Remove Item
        $s = explode(',', $para_need_remove);
        foreach ($s as $item) unset($pa["$item"]);
        ## Append Querystring
        $str = '';
        foreach ($pa as $key => $val) {
            if (is_array($val)) {
                foreach ($val as $sitem) $hs .= $key . '[]=' . $sitem . '&';
                $str .= $hs;
            } else {
                $str .= $key . '=' . $val . '&';

            }
        }
        if ($suffixctr == null) $link = $controller . "?" . $str;
        else $link = $suffixctr . "?" . $str;
//        $link = rtrim($link, "&");
        return $link;
    }

    public static function paginginfo($rowcount, $limit, $page, $pagelimit = 3)
    {
        if ($page <= 1) $page = 1;
        $totalpage = ceil($rowcount / $limit);
        $startpaging = $page - $pagelimit;
        if ($startpaging <= 1) $startpaging = 1;
        $endpaging = $page + $pagelimit;
        if ($endpaging >= $totalpage) $endpaging = $totalpage;
        if ($endpaging <= $startpaging) $endpaging = $startpaging = 1;
        $paginginfo = array("rowcount" => $rowcount, "rangepage" => range($startpaging, $endpaging), "totalpage" => $totalpage, "page" => $page, "currentlink" => Helper::cpagerparm("p"), "maxpage" => $pagelimit, "limit" => $limit);
        return $paginginfo;
    }

    public static function br2nl($input)
    {
        return preg_replace('/<br(\s+)?\/?>/i', "\n", $input);
    }

    public static function nl2br2($string)
    {
        $string = str_replace(array("\r\n", "\r", "\n"), "<br />", $string);
        return $string;
    }

    public static function xss_clean($data)
    {
        if (is_array($data)) $data = array_map(array(self, "xss_process"), $data);
        else $data = self::xss_process($data);
        return $data;
    }

    private function xss_process($data)
    {
        // Fix &entity\n;
        $data = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

// Remove any attribute starting with "on" or xmlns
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

// Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

// Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

        do {
            // Remove really unwanted tags
            $old_data = $data;
            $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        } while ($old_data !== $data);

// we are done...
        return $data;
    }

    public static function randomString($length = 6)
    {
        $str = "";
//        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
        $characters = array_merge(range('0', '9'), range('0', '9'), range('0', '9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }

    public static function Cleanurl($text)

    {

        $text = str_replace('-', ' ', $text);
        $text = str_replace(' -', ' ', $text);
        $text = str_replace(array('&apos;', '&quot;'), '', $text);

        $text = preg_replace('/[^a-zA-Z0-9_ -,.]/s', '', $text);
        $text = trim($text);

        $stripped = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $text);

        $text = strtolower($stripped);
        $text = str_replace(',', ' ', $text);

        $code_entities_match = array(' ', '--', '&quot;', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '{', '}', '|', ':', '"', '<', '>', '?', '[', ']', '\\', ';', "'", ',', '.', '/', '*', '+', '~', '`', '=');

        $code_entities_replace = array('-', '-', '', '', '', '', '', '', '', '', '', '', '', '-', '-', '', '', '', '', '', '', '', '', '', '', '');

        $text = str_replace($code_entities_match, $code_entities_replace, $text);
        return $text;
    }

    public static function convertToUtf8($str)
    {
        if (!$str) return false;
        $utf8 = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'd' => 'đ|Đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i' => 'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
        foreach ($utf8 as $ascii => $uni) $str = preg_replace("/($uni)/i", $ascii, $str);
        return $str;
    }

    public static function resortarray($data_array, $array_key, $property)
    {
        foreach ($array_key as $key => $val) {
            foreach ($data_array as $item) {
                if ($item["$property"] == $val) {
                    $hdata[] = $item;
                    unset($item);
                }
            }
        }
        return $hdata;
    }
}

?>