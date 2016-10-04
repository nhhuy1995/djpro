<?php
namespace DjClient\Library;

use DjClient\Models\Users;
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

    public static function getAvatarUserDefault()
    {
        return '/web/images/avatar_default_user.png';
    }

    public static function getAvatarVideoDefault()
    {
        return '/web/images/avatar_video_default.jpg';
    }

    public static function getAvatarDefault()
    {
        return '/web/images/avatar_default.jpg';
    }

    public static function getBannerDefault()
    {
        return '/web/images/banner_default.jpg';
    }

    public static function GenerateUrl($name, $id, $type)
    {
        $id_category_video = 1443429549;
        $id_category_nhacsan = 1443797999;
        if ($type == 'video') {
            if ($id == $id_category_video) $link = '/video.html';
            else $link = Makelink::link_view_category_video($name, $id);
        } else if ($type == 'album')
            $link = '/album.html';
        else if ($type == 'playlist')
            $link = '/playlist-chon-loc.html';
        else if ($type == 'audio') {
            if ($id == $id_category_nhacsan) $link = '/nhac-san.html';
            else $link = Makelink::link_view_category_music($name, $id);
        }
        return $link;

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
            } else $str .= $key . '=' . $val . '&';
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

    public static function ListCategoryStatic()
    {
        $data = array(
            1 => array('title' => "Bài hát", 'link' => 'bai-hat.html'),
            2 => array('title' => "Video", 'link' => 'video.html'),
            3 => array('title' => "Album", 'link' => 'album.html'),
            4 => array('title' => "Playlist", 'link' => 'playlist.html'),
            5 => array('title' => "Chủ đề", 'link' => 'chu-de.html'),
            6 => array('title' => "Tin tức", 'link' => 'tin-tuc.html'),
            7 => array('title' => "Ảnh", 'link' => 'anh.html'),
            8 => array('title' => "Nghệ sỹ", 'link' => 'nghe-sy.html'),
        );
        return $data;
    }

    public static $_artist_type = array(
        "dj", "producer", "singer", "composer"
    );

    public static function getAllArtistTypes()
    {
        return array_combine(
            static::$_artist_type,
            array("DJ", "Nhà sản xuất", "Ca sỹ", "Nhạc sỹ")
        );
    }

    public static function setHeader($title, $desc, $image, $lyrics = null,$keyword = null)
    {
        $actual_link = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $data = array(
//            'url' => DOMAIN . $url,
            'url' => $actual_link,
            'title' => $title,
            'desc' => str_replace('"','&quot;',$desc),
            'images' => DOMAIN . $image,
            'lyric' => str_replace('"','&quot;',strip_tags($lyrics)),
            'keyword' => $keyword,
        );
        return $data;
    }

    public static function checkAvatar($usercreate_id, $priavatar)
    {
        $avatarDefault = "/web/images/alb-hqh4.jpg";
        if (empty($priavatar) || !isset($priavatar)) {
            $userinfo = Users::findById($usercreate_id);
            if (empty($userinfo->priavatar) || !isset($userinfo->priavatar)) {
                $avatar = $avatarDefault;
            } else $avatar = $userinfo->priavatar;
        } else $avatar = $priavatar;
        return $avatar;
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

    /*public static function randomString($length = 6)
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
    }*/
    public static function RandomString($length = 10)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
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
    public static function clean_string($string) {
        $s = trim($string);
        $s = iconv("UTF-8", "UTF-8//IGNORE", $s); // drop all non utf-8 characters

        // this is some bad utf-8 byte sequence that makes mysql complain - control and formatting i think
        $s = preg_replace('/(?>[\x00-\x1F]|\xC2[\x80-\x9F]|\xE2[\x80-\x8F]{2}|\xE2\x80[\xA4-\xA8]|\xE2\x81[\x9F-\xAF])/', ' ', $s);

        $s = preg_replace('/\s+/', ' ', $s); // reduce all multiple whitespace to a single space

        return $s;
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

    public static function CheckExtention($mediaurl)
    {
        if (strpos($mediaurl, 'youtube.com') !== false) $exten = 'youtube';
        else if (strpos($mediaurl, 'soundcloud.com') !== false) $exten = 'soundcloud';
        else if (strpos($mediaurl, 'zippyshare.com') !== false) $exten = 'zippyshare';
        else if (strpos($mediaurl, 'tunescoop.com') !== false) $exten = 'tunescoop';
        else $exten = 'other';
        return $exten;
    }

    public static function jsonResponse($response)
    {
        if (!is_array($response)) return;
        header("Content-Type:application/json;charset=utf-8");
        die(json_encode($response));
    }

    public static function contains($needle, $haystack)
    {
        return strpos($haystack, $needle) !== false;
        /* if(preg_match("/\b($haystack)\b/", $needle)){
             return true;
         }
         else {
             return false;
         }*/
    }

    public static function Numberformat($number)
    {
        return number_format($number, 0, ',', '.');
    }

    public static function ListExpletives()
    {
        $string = "/(nghedi.tk)|(.tk)|(\")|(< \")|(\" >)|(<\")|(\">)|(.vn)|(`)|(nghedi)|(NGHEDI)|(NgheDi)|(tk)|(Tk)|(TK)|(.TK)|(http)|(www)|(lin)|(lìn)|(htt)|(ww)|(Refresh)|(địt)|(Địt)|(ĐỊT)|(đéo)|(Đéo)|(ĐÉO)|(lồn)|(Lồn)|(LỒN)|(L0N)|(L0n)|(l0n)|(lôn)|(lon`)|(llon)|(lô`n)|(lo`n)|(cặc)|(Cặc)|(CẶC)|(dái)|(Dái)|(DÁI)|(chó)|(Chó)|(CHÓ)|(Cứt)|(cứt)|(CỨT)|(ỉa)|(Ỉa)|(đái)|(Đái)|(ỈA)|(.com)|(.org)|(.biz)|(dkm)|(đkm)|(ĐKM)|(dit)|(lon)|(Lon)|(lyn)|(LON)|(DIT)|(D J . K e n h 7 4 . C o m)|(. C o m)|(DIT)|(cut)|(Cut)|(tom9z)|(369)|(4444)|(888)|(DM)|(loz)|(djt)|(đjt)|(bán)|(sim)|(sjm)|(TOPDJVN.Com)|(TOPDJVN)|(09)|(con mẹ)|(mẹ mày)/";
        return $string;
    }

    public static function CheckStringExpletives($string, $stringReplace = '***')
    {
        $partern = Helper::ListExpletives();
        return preg_replace($partern, $stringReplace, $string);
    }

    public static function get_time_ago($time_stamp)
    {
        $time_difference = strtotime('now') - $time_stamp;

        if ($time_difference >= 60 * 60 * 24 * 365.242199) {
            /*
             * 60 seconds/minute * 60 minutes/hour * 24 hours/day * 365.242199 days/year
             * This means that the time difference is 1 year or more
             */
            return static::get_time_ago_string($time_stamp, 60 * 60 * 24 * 365.242199, 'Năm');
        } elseif ($time_difference >= 60 * 60 * 24 * 30.4368499) {
            /*
             * 60 seconds/minute * 60 minutes/hour * 24 hours/day * 30.4368499 days/month
             * This means that the time difference is 1 month or more
             */
            return static::get_time_ago_string($time_stamp, 60 * 60 * 24 * 30.4368499, 'Tháng');
        } elseif ($time_difference >= 60 * 60 * 24 * 7) {
            /*
             * 60 seconds/minute * 60 minutes/hour * 24 hours/day * 7 days/week
             * This means that the time difference is 1 week or more
             */
            return static::get_time_ago_string($time_stamp, 60 * 60 * 24 * 7, 'Tuần');
        } elseif ($time_difference >= 60 * 60 * 24) {
            /*
             * 60 seconds/minute * 60 minutes/hour * 24 hours/day
             * This means that the time difference is 1 day or more
             */
            return static::get_time_ago_string($time_stamp, 60 * 60 * 24, 'Ngày');
        } elseif ($time_difference >= 60 * 60) {
            /*
             * 60 seconds/minute * 60 minutes/hour
             * This means that the time difference is 1 hour or more
             */
            return static::get_time_ago_string($time_stamp, 60 * 60, 'Giờ');
        } else {
            /*
             * 60 seconds/minute
             * This means that the time difference is a matter of minutes
             */
            return static::get_time_ago_string($time_stamp, 60, 'Phút');
        }
    }

    public static function get_time_ago_string($time_stamp, $divisor, $time_unit)
    {
        $time_difference = strtotime("now") - $time_stamp;
        $time_units = floor($time_difference / $divisor);

        settype($time_units, 'string');

        if ($time_units === '0') {
            return '1 ' . $time_unit . ' trước';
//            return 'less than 1 ' . $time_unit . ' ago';
        } elseif ($time_units === '1') {
            return '1 ' . $time_unit . ' trước';
//            return '1 ' . $time_unit . ' ago';
        } else {
            /*
             * More than "1" $time_unit. This is the "plural" message.
             */
            // TODO: This pluralizes the time unit, which is done by adding "s" at the end; this will not work for i18n!
            return $time_units . ' ' . $time_unit . ' trước';
//            return $time_units . ' ' . $time_unit . 's ago';
        }
    }

    public static function urlResponse($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public static function processUrl($url, $apCode)
    {
        $url = $url . '?access_token=' . $apCode;
        return static::urlResponse($url);
    }

    public function genlinkConfirmGoogle()
    {

        $client_id = $this->config->google->clientid;
        $client_secret = $this->config->google->clientsecret;
        $redirect_uri = 'http://dj.pro.vn/user/callbackgoogle';
        $client = new \Google_Client();
        $client->setClientId($client_id);
        $client->setClientSecret($client_secret);
        $client->setRedirectUri($redirect_uri);
        $client->addScope("email");
        $client->addScope("profile");
        $authUrl = $client->createAuthUrl(); // link confirm google
        return $authUrl;
    }
}

?>