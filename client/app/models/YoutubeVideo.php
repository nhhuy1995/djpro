<?php
/**
 * Created by PhpStorm.
 * User: hung
 * Date: 31/08/2015
 * Time: 22:18
 */
namespace DjCms\Models;
use DjCms\Library\Helper;
use Phalcon\Mvc\User\Component;

/**
 * Class YoutubeVideo
 * @package DjCms\Model
 * Handle tasks reference to video in youtube
 */
class YoutubeVideo extends Component {

    /**
     * @param $url string Url of Video
     * @return bool|string
     * Return video's duration of given url
     * if Url does not form youtube, return false
     */
    public function getVideoLength($url) {
        preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9]+)/', $url, $match);
        if (count($match) == 2) {
            $id = $match[1];
            $dbConnect = Helper::getConnection();
            $youtubevideoCl = $dbConnect->youtubevideo;
            $criteria = array('video_id' => $id);
            $videoObject = $youtubevideoCl->findOne($criteria);
            if ($videoObject && $videoObject['_id']) return $videoObject['duration'];
            else {
                $duration = $this->getVideoLengthFromYoutube($id);
                $youtubevideoCl->insert(array(
                    "video_id" => $id,
                    "duration" => $duration
                ));
                return $duration;
            }
        } else return false;
    }

    /**
     * @param $id string video's id
     * @return string|int
     * if video is exists return video's duration
     * Otherwise, return 0
     */
    protected function getVideoLengthFromYoutube($id) {
        $apiKey = "AIzaSyB_9oTTFvlxNupfLA8Ee21MzcZbTXKtt-I";
        $mainUrl = "https://www.googleapis.com/youtube/v3/videos?id=";
        $dataFromYt = json_decode(file_get_contents($mainUrl.$id."&key=".$apiKey."&part=contentDetails"));
        if (count($dataFromYt->items)) {
            $itemDetail = $dataFromYt->items[0];
            $contentDetail = $itemDetail->contentDetails;

            // Convert Youtube Time format
            // Ex: PT2H34M25S to 2:34:25
            $start = new \DateTime('@0'); // Unix epoch
            $start->add(new \DateInterval($contentDetail->duration));
            return $start->format('H:i:s');
        } else return 0;
    }
}