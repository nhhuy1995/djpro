<?php
namespace DjClient\Controller;

use DjClient\Library\Helper;
use DjClient\Library\Makelink;
use DjClient\Models\Album;
use DjClient\Models\Category;
use DjClient\Models\Media;
use DjClient\Models\RankingWeek;
use DjClient\Models\Settings;
use DjClient\Models\Topic;
use DjClient\Models\Users;
use DjClient\Services\Email;
use DjClient\Services\RankingArticle;

class IndexController extends ControllerBase
{
    public static $TYPE_SELECTIVE_AUDIO = 'selective_audio';
    public static $TYPE_SELECTIVE_TOPIC = 'selective_topic';
    public static $TYPE_SELECTIVE_VIDEO = 'selective_video';

    public function indexAction()
    {

        $this->view->listmedia = Media::ListMusicByMultiConditions(self::$TYPE_MUSIC, 10, 1);//list media by datecreate

        $this->view->listMedia_ByView = Media::ListMusicByMultiConditions(self::$TYPE_MUSIC, 10, 2);//list media by view

        $this->view->listPlaylist = Album::ListAlbumByMultiConditions(self::$TYPE_PLAYLIST, 5, 1); //List playlist

        $this->view->listAlbum = Album::ListAlbumByMultiConditions(self::$TYPE_ALBUM, 4, 1);//List album
        //audio selective
        $listIdAudio = Settings::getElementByKey(self::$TYPE_SELECTIVE_AUDIO);
        $this->view->list_SelectiveAudio = Helper::resortarray(Media::ListMusicByMultiConditions(self::$TYPE_MUSIC, 10, 1, $listIdAudio), $listIdAudio, "_id");

        //topic selective
        $listIdTopic = Settings::getElementByKey(self::$TYPE_SELECTIVE_TOPIC);
        $this->view->list_SelectiveTopic = Helper::resortarray(Album::ListAlbumByMultiConditions(self::$TYPE_SELECTIVE_TOPIC, 6, 1, $listIdTopic),$listIdTopic,"_id");

        //video selective
        $listIdVideo = Settings::getElementByKey(self::$TYPE_SELECTIVE_VIDEO);
        $this->view->list_SelectiveVideo = Helper::resortarray(Media::ListMusicByMultiConditions(self::$TYPE_VIDEO, 6, 1, $listIdVideo),$listIdVideo,"_id");
        $this->view->class = "mbot-20";
    }
    public function rssAction(){
        $this->view->title = "RSS - Dj.pro.vn";
    }
    public function dieukhoanAction()
    {
        $this->view->title = "Điều khoản thỏa thuận";
    }

    public function banquyenAction()
    {
        $this->view->title = "Chính sách bản quyền";
    }

    public function riengtuAction()
    {
        $this->view->title = "Chính sách riêng tư";
    }

    public function lienheAction()
    {
        $this->view->title = "Liên hệ";
    }

    public function testAction()
    {
        echo mb_strtolower('dj HƯNG');
//        ini_set('display_errors', true);
//        error_reporting(E_ALL);
//        $email = 'nhhuy1995@gmail.com';
//        $info['subject'] = "Test send mail";
//        $info['body'] = "Nội dung của mail";
//        $re = Email::sendMail($email, $info);
//        var_dump($re);
//        die;
//        $listMedia = Media::findAndReturnArray(
//               array("type" => "video")
//                , true
//        );
//        foreach ($listMedia as $key => $value) {
//            if (preg_match('/youtube.com\//', $value['mediaurl'])) {
//                $priavatar = str_replace("<br>", "", $value['priavatar']);
//
////                Media::updateDocument(
////                    array("_id" => $value['_id']),
////                    array('$set' => array(
////                        "priavatar" => $priavatar
////                    ))
////                );
//            }
//        }
//        die;
//        die;
////        $listMediaId = range(0, 3000);
//        $listMedia = Album::findAndReturnArray(
//                array("condition" => array("type" => "album"))
//                , true
//        );
//        $listMediaId = array_keys($listMedia);
//        $years = array(
//                "2013" => range(1, 52),
//                "2014" => range(1, 52),
//                "2015" => range(1, 43)
//        );
//        foreach ($years as $key => $weeks) {
//            foreach ($weeks as $week) {
//                foreach ($listMediaId as $mid) {
//                    $number = rand(1000, 9999);
//                    $this->redisConnect->zAdd("dj_sorted_album_week_".$week."-".$key,  $number, $mid);
//                }
//            }
//        }
//        echo "Success";die;
//        foreach ($listMediaId as $mid) {
//            $value = rand(1, 10);
//            $this->redisConnect->zAdd("dj_sorted_audio_week_40-2015",  $value, $mid);
//        }
//        $time = microtime();
//        echo $time."<br>";
//        var_dump($this->redisConnect->zRevRange($sortedSetName, 0, 40, true));
//        var_dump($this->redisConnect->zRange($sortedSetName, 0, 40, true));
//        $this->redisConnect->multi(\Redis::PIPELINE);
//        $this->redisConnect->zRevRange($sortedSetName, 0, 40, true);
//        $this->redisConnect->zRange($sortedSetName, 0, 40, true);
//        $result = $this->redisConnect->exec();

//        var_dump($result);die;
//        echo microtime() - $time;die;
//        $listMedia = Media::findAndReturnArray(array("type"=>"audio"), true);
//        $listMediaId = array_keys($listMedia);
//        $listAlbum = Album::findAndReturnArray(array("type"=>"album"), true);
//        $listAlbumId = array_keys($listAlbum);
//        $years = array(
//            "2013" => range(1, 52),
//            "2014" => range(1, 52),
//            "2015" => range(1, 30)
//        );
//        ini_set('display_errors', true);
//        error_reporting(E_ALL);
//        foreach ($years as $key => $weeks) {
//            foreach ($weeks as $week) {
//                foreach ($listMediaId as $mid) {
//                    $number = rand(1000, 9999);
//                    $listRankAudio[] = array(
//                        "type" => "music",
//                        "action" => "listen",
//                        "article_id" => $mid,
//                        "number" => $number,
//                        "time_range" => $week."-".$key
//                    );
//                }
//            }
//            RankingWeek::getCollectionInstance()->batchInsert($listRankAudio);
//            unset($listRankAudio);
//        }
//        ini_set('display_errors', true);
//        error_reporting(E_ALL);
//
//        $rankingWeekObj = new RankingWeek();
//        $rankingWeekObj->type = "music";
//        $rankingWeekObj->action = "listen";
//        $rankingWeekObj->time_range = "20-2014";
//        $rankingArticle = new RankingArticle($rankingWeekObj);
//        var_dump($rankingArticle->getListArticleId(true));die;

    }


}

