<?php
namespace DjClient\Controller;

use DjClient\Library\Helper;
use DjClient\Library\Makelink;
use DjClient\Models\Album;
use DjClient\Models\Artist;
use DjClient\Models\Media;
use DjClient\Models\RankingMonth;
use DjClient\Models\RankingWeek;
use DjClient\Services\RankingArticle;

class RankingController extends ControllerBase
{
    const REDIS_PREFIX_KEY = "dj_top_rank_";
    private static $TYPE_RANKING = "ranking";
    private static $TYPE_TOP100 = "top100";
    private static $TYPE_DE_CU = "topdecu";
    /*
     *@description: page bxh audio
     */
    public function indexAction()
    {

        $type = $this->request->get('t');
        if (isset($type)) {
            if ($type == static::$TYPE_VIDEO) $action = 'bxhvideo';
            else $action = 'bxhalbum';
            $this->dispatcher->forward(
                array('controller' => 'ranking',
                    'action' => $action,
                ));
        }
        $listAudio = $this->getTopRankArticleByWeek(array(
            "redisKey" => self::getRedisKey("audio", "view", "week"),
            "type" => "audio",
            "action" => "view",
            "collection" => "Media",
            "limit" => 10
        ));
        $this->breadCrumbs->addItem(array(),static::$TYPE_RANKING);
        $this->view->setVars(array(
            "listAudio" => $listAudio,
        ));
        $this->view->header = Helper::setHeader('Bảng xếp hạng','', '');

    }

    /*
         *@description: page bxh video
         */
    public function bxhvideoAction()
    {
        $listVideo = $this->getTopRankArticleByWeek(array(
            "redisKey" => self::getRedisKey("video", "view", "week"),
            "type" => "video",
            "action" => "view",
            "collection" => "Media",
            "limit" => 10
        ));
        $this->view->setVars(array(
            "listVideo" => $listVideo,
        ));
        $this->breadCrumbs->addItem(array(),static::$TYPE_RANKING);
        $this->view->header = Helper::setHeader('Bảng xếp hạng','', '');
    }

    /*
        *@description: page bxh album
        */
    public function bxhalbumAction()
    {
        $type = $this->request->get('t');
        $listAlbum = $this->getTopRankArticleByWeek(array(
            "redisKey" => self::getRedisKey($type, "view", "week"),
            "type" => $type,
            "action" => "view",
            "collection" => "Album",
            "limit" => 10
        ));
        $this->breadCrumbs->addItem(array(),static::$TYPE_RANKING);
        $this->view->setVars(array(
            "listAlbum" => $listAlbum,
        ));
        $this->view->header = Helper::setHeader('Bảng xếp hạng','', '');
    }

    /*
     *@description: page nomination audio
     */
    public function nominationAction()
    {
        $type = $this->request->get('t');
        if (isset($type)) {
            if ($type == static::$TYPE_VIDEO) $action = 'nominationvideo';
            else $action = 'nominationalbum';
            $this->dispatcher->forward(
                array('controller' => 'ranking',
                    'action' => $action,
                ));
        }
        $this->breadCrumbs->addItem(array(),static::$TYPE_DE_CU);
        $listAudio = $this->getTopRankArticleByWeek(array(
            "redisKey" => self::getRedisKey("audio", "nomination", "week"),
            "type" => "audio",
            "action" => "nomination",
            "collection" => "Media",
            "limit" => 10
        ));
        $this->view->setVars(array(
            "listAudio" => $listAudio,
        ));
        $this->view->header = Helper::setHeader('TOP đề cử bởi thành viên','', '');
    }

    /*
        *@description: page nomination video
        */
    public function nominationvideoAction()
    {

        $listVideo = $this->getTopRankArticleByWeek(array(
            "redisKey" => self::getRedisKey("video", "nomination", "week"),
            "type" => "video",
            "action" => "nomination",
            "collection" => "Media",
            "limit" => 10
        ));
        $this->view->setVars(array(
            "listVideo" => $listVideo,
        ));
        $this->breadCrumbs->addItem(array(),static::$TYPE_DE_CU);
        $this->view->header = Helper::setHeader('TOP đề cử bởi thành viên','', '');
    }


    /*
    *@description: page nomination album
    */
    public function nominationalbumAction()
    {
        $type = $this->request->get('t');
        $listAlbum = $this->getTopRankArticleByWeek(array(
            "redisKey" => self::getRedisKey($type, "nomination", "week"),
            "type" => $type,
            "action" => "nomination",
            "collection" => "Album",
            "limit" => 10
        ));
        $this->view->setVars(array(
            "listAlbum" => $listAlbum,
        ));
        $this->breadCrumbs->addItem(array(),static::$TYPE_DE_CU);
        $this->view->header = Helper::setHeader('TOP đề cử bởi thành viên','', '');
    }


    /*
     *@description: page top100 audio
    */
    public function top100Action()
    {
        $type = $this->request->get('t');
        if (isset($type)) {
            if ($type == static::$TYPE_VIDEO) $action = 'top100video';
            else $action = 'top100album';
            $this->dispatcher->forward(
                array('controller' => 'ranking',
                    'action' => $action,
                ));
        }
        $listAudio = $this->getTopRankArticleByMonth(array(
            "redisKey" => self::getRedisKey("audio", "view", "month"),
            "type" => "audio",
            "action" => "view",
            "collection" => "Media",
            "limit" => 100
        ));
        $this->view->setVars(array(
            "listAudio" => $listAudio,
        ));
        $this->breadCrumbs->addItem(array(),static::$TYPE_TOP100);
        $this->view->header = Helper::setHeader('TOP 100','', '');
    }

    /*
         *@description: page top100 video
        */
    public function top100videoAction()
    {
        $listVideo = $this->getTopRankArticleByMonth(array(
            "redisKey" => self::getRedisKey("audio", "view", "month"),
            "type" => "video",
            "action" => "view",
            "collection" => "Media",
            "limit" => 100
        ));
        $this->view->setVars(array(
            "listVideo" => $listVideo,
        ));
        $this->breadCrumbs->addItem(array(),static::$TYPE_TOP100);
        $this->view->header = Helper::setHeader('TOP 100','', '');
    }

    /*
     *@description: page top100 album
    */
    public function top100albumAction()
    {
        $type = $this->request->get('t');
        $listAlbum = $this->getTopRankArticleByMonth(array(
            "redisKey" => self::getRedisKey($type, "view", "month"),
            "type" => $type,
            "action" => "view",
            "collection" => "Album",
            "limit" => 100
        ));
        $this->breadCrumbs->addItem(array(),static::$TYPE_TOP100);
        $this->view->setVars(array(
            "listAlbum" => $listAlbum,
            "title" => "TOP 100",
        ));

    }
    public function getMediaConditions($collection,$type,$date,$limit){
        $listAudio = $this->getTopRankArticleByWeek(array(
            "redisKey" => self::getRedisKey("$type", "view", "$date"),
            "type" => "$type",
            "action" => "view",
            "collection" => "$collection",
            "limit" => $limit
        ));
        return $listAudio;
    }
    public function getTopRankArticleByWeek($params)
    {
        return $this->getTopRankArticle(new RankingWeek(), $params);
    }

    public function getTopRankArticleByMonth($params)
    {
        return $this->getTopRankArticle(new RankingMonth(), $params);
    }

    /**
     * @desc Get detail of top ranking articles
     * @param array $params Params to query
     *         [
     *              "redisKey" => Redis key
     *              "type" => Article's type
     *              "action" => Action type
     *              "time_range" => Time range [optional]
     *         ]
     * @return array|mixed Top Ranking Article's Detail
     */
    protected function getTopRankArticle($rankOption, $params)
    {
//        $rankOption = new RankingWeek();
//        $listArticleTop = $this->redisConnect->get($params['redisKey']);
//
//        if (!$listArticleTop) {
        $rankOption->type = $params['type'];
        $rankOption->action = $params['action'];
        $rankOption->limit = $params['limit'];
        if ($params['time_range'])
            $rankOption->setTimeRange($params['time_range']);
        $listArticle = $this->processMedia($rankOption, $params['collection']);

        $lastTimeKey = 'last_' . $rankOption->periodType;

        foreach ($listArticle as $key => &$item) {
            $increase = $item['increase'];
            $item[$lastTimeKey] = $key + $increase + 1;
        }
//            $this->redisConnect->set($params['redisKey'], json_encode($listArticle), 600);
//        } else {
//            $listArticle = json_decode($listArticleTop);
//        }

        return $listArticle;
    }

    /**
     * Process media's detail in top ranking
     * @param RankingAbstract $rankOption
     * @param BaseCollection $collection
     * @return array Detail of media after process
     */
    protected function processMedia($rankOption, $collection)
    {
        $rankArticle = new RankingArticle($rankOption);
        $topArticleRanking = $rankArticle->getCurrentTopRanking(true);
        $listMediaId = array();
        foreach ($topArticleRanking as $key => $value) {
            $listMediaId[] = strval($key);
        }
        $criteria = array(
            "condition" => array(
                '_id' => array('$in' => $listMediaId),
                'status' => static::$STATUS_ON
            )
        );
        if ($collection == "Media") {
            $listMedia = Media::findAndReturnArray($criteria);
            //get artist
            foreach ($listMedia as &$item) {
                $artistId = $item['artist'];
                $priavatar = $item['priavatar'];
                if (!isset($priavatar) || empty($priavatar)) $item['priavatar'] = Helper::getAvatarDefault();
                if (isset($artistId) || !empty($artistId)) $item['artist'] = Helper::resortarray(Artist::getArtistByID($artistId), $artistId, '_id');
                if ($item['type'] == 'audio')
                    $item['link'] = Makelink::link_view_article_music($item['name'], $item['_id']);
                else
                    $item['link'] = Makelink::link_view_article_video($item['name'], $item['_id']);
                unset($artistId);
            }
        }
        if ($collection == "Album") {
            $listMedia = Album::findAndReturnArray($criteria);
            foreach ($listMedia as &$item) {
                $artistId = $item['artist'];
                $priavatar = $item['priavatar'];
                if (!isset($priavatar) || empty($priavatar)) $item['priavatar'] = Helper::getAvatarDefault();
                if (isset($artistId) || !empty($artistId)) $item['artist'] = Helper::resortarray(Artist::getArtistByID($artistId), $artistId, '_id');
                $item['link'] = Makelink::link_view_article_playlist_music($item['name'], $item['_id']);
            }
        }

        if ($listMedia) {
            $listMedia = Helper::resortarray($listMedia, $listMediaId, "_id");
            array_walk(
                $listMedia,
                function (&$value, $key, $topArticleRanking) {
                    $value = array_merge($value, $topArticleRanking[intval($value['_id'])]);
                },
                $topArticleRanking
            );
            $listMedia = array_splice($listMedia, 0, $rankOption->limit);
        }
        return $listMedia;
    }

    protected function getRedisKey($articleType, $action, $period)
    {
        return self::REDIS_PREFIX_KEY . $articleType . "_" . $action . "_" . $period;
    }
}

