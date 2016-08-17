<?php
namespace DjClient\Services;

use Phalcon\Mvc\User\Component;

class YoutubeDownloader extends Component
{
    public function getLinkDownload($videoLink, $format)
    {
        preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9]+)/', $videoLink, $match);
        if (count($match) == 2) {
            $my_id = $match[1];
            $my_video_info = 'http://www.youtube.com/get_video_info?&video_id='. $my_id.'&asv=3&el=detailpage&hl=en_US'; //video details fix *1
            $my_video_info = $this->_curlGet($my_video_info);
            $title = $url_encoded_fmt_stream_map = $type = $url = '';
            parse_str($my_video_info);
            $avail_formats[] = '';
            $i = 0;
            $ipbits = $ip = $itag = $sig = $quality = '';
            $expire = time();
            if(isset($url_encoded_fmt_stream_map)) {
                /* Now get the url_encoded_fmt_stream_map, and explode on comma */
                $my_formats_array = explode(',', $url_encoded_fmt_stream_map);

                $my_title = $title;
                $cleanedtitle = $this->_clean($title);

                foreach ($my_formats_array as $format) {
                    parse_str($format);
                    $avail_formats[$i]['itag'] = $itag;
                    $avail_formats[$i]['quality'] = $quality;
                    $type = explode(';', $type);
                    $avail_formats[$i]['type'] = $type[0];
                    $avail_formats[$i]['url'] = urldecode($url) . '&signature=' . $sig;
                    parse_str(urldecode($url));
                    $avail_formats[$i]['expires'] = date("G:i:s T", $expire);
                    $avail_formats[$i]['ipbits'] = $ipbits;
                    $avail_formats[$i]['ip'] = $ip;
                    $i++;
                }

                switch ($format) {
                    case "best":
                        /* largest formats first */
                        $target_formats = array('38', '37', '46', '22', '45', '35', '44', '34', '18', '43', '6', '5', '17', '13');
                        break;
                    case "free":
                        /* Here we include WebM but prefer it over FLV */
                        $target_formats = array('38', '46', '37', '45', '22', '44', '35', '43', '34', '18', '6', '5', '17', '13');
                        break;
                    case "ipad":
                        /* here we leave out WebM video and FLV - looking for MP4 */
                        $target_formats = array('37','22','18','17');
                        break;
                    default:
                        /* If they passed in a number use it */
                        if (is_numeric($format)) {
                            $target_formats[] = $format;
                        } else {
                            $target_formats = array('38', '37', '46', '22', '45', '35', '44', '34', '18', '43', '6', '5', '17', '13');
                        }
                        break;
                }
                $best_format = '';
                for ($i=0; $i < count($target_formats); $i++) {
                    for ($j=0; $j < count ($avail_formats); $j++) {
                        if($target_formats[$i] == $avail_formats[$j]['itag']) {
                            //echo '<p>Target format found, it is '. $avail_formats[$j]['itag'] .'</p>';
                            $best_format = $j;
                            break 2;
                        }
                    }
                }
                if( (isset($best_format)) &&
                    (isset($avail_formats[$best_format]['url'])) &&
                    (isset($avail_formats[$best_format]['type']))
                ) {
                    $redirect_url = $avail_formats[$best_format]['url'].'&title='.$cleanedtitle;
                    $content_type = $avail_formats[$best_format]['type'];
                }
                return $redirect_url;
            } else return false;
        }
        else return false;
    }

    protected function _clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return $string;
    }

    protected function _formatBytes($bytes, $precision = 2) {
        $units = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . '' . $units[$pow];
    }

    protected function _curlGet($URL) {
        $ch = curl_init();
        $timeout = 3;
        curl_setopt( $ch , CURLOPT_URL , $URL );
        curl_setopt( $ch , CURLOPT_RETURNTRANSFER , 1 );
        curl_setopt( $ch , CURLOPT_CONNECTTIMEOUT , $timeout );
        /* if you want to force to ipv6, uncomment the following line */
        //curl_setopt( $ch , CURLOPT_IPRESOLVE , 'CURLOPT_IPRESOLVE_V6');
        $tmp = curl_exec( $ch );
        curl_close( $ch );
        return $tmp;
    }
}