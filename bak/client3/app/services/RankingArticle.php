<?php
namespace DjClient\Services;

use DjClient\Models\RankingAbstract;
use Phalcon\Mvc\User\Component;
use Redis as Redis;

class RankingArticle extends Component
{
    const ALLOW_ON_TOP = 1;
    const NOT_ALLOW_ON_TOP = 0;
    const PREFIX_SORTED_SET = "dj_sorted_";
    const WEEK = "week";
    const MONTH = "month";
    const YEAR = "year";

    private $_topRanking;
    private $_previousTopRanking;
    /** @var Redis */
    private $_redisConnect;

    /**
     * @param RankingAbstract $rankOption Ranking option
     */
    function __construct(RankingAbstract $rankOption)
    {
        $this->_rankOption = $rankOption;
        $this->_redisConnect = $this->getDI()->getShared('redisConnect');
    }

    /**
     * @param bool|false $comparePrevious
     * @return array Array of article's id in current top ranking
     *      [
     *          article's id  => [
     *                              view, highest, increase
     *                           ]
     *      ]
     */
    public function getCurrentTopRanking($comparePrevious = false)
    {
        $this->_topRanking = $this->getListArticleId();
        if ($comparePrevious) {
            $this->compareWithPreviousTime();
        }
        return $this->_topRanking;
    }

    /**
     * @desc Compare current with previous top ranking
     */
    public function compareWithPreviousTime()
    {
        $this->_rankOption->addToTimeRange(-1);
        $this->_previousTopRanking = $this->getListArticleId(true);
        if ($this->_previousTopRanking) {
            array_walk(
                $this->_topRanking,
                function (&$value, $key, $option) {
                    $value = array(
                        $option['action'] => $value,
                        "highest" => $option['futureListId'][$key] + 1
                    );
                    if (isset($option['topRank'][$key])) {
                        $value['increase'] = $option['listId'][$key] - $value['highest'] + 1;
                    } else {
                        $value['increase'] = $option['listId'][$key];
                    }
                },
                array(
                    "action" => $this->_rankOption->action,
                    "topRank" => $this->_previousTopRanking,
                    "listId" => array_flip(array_keys($this->_previousTopRanking)),  // Create array with article's id is key and value is index
                    "futureListId" => array_flip(array_keys($this->_topRanking))     // Create array with article's id is key and value is index
                )
            );

            $this->getHighestRankOfArticle();
        } else {
            array_walk(
                $this->_topRanking,
                function (&$value, $key, $action) {
                    $value = array(
                        $action => $value,
                        "highest" => array_search($key, array_keys($this->_topRanking))
                    );
                },
                $this->_rankOption->action
            );
        }
    }

    /**
     * @desc  Get highest rank of article in past
     */
    protected function getHighestRankOfArticle()
    {
        $topRankingInPast[] = $this->_previousTopRanking;
        $indexArticleInPast[] = array_flip(array_keys($this->_previousTopRanking));
        for ($i = 1; $i < 4; $i++) {
            $this->_rankOption->addToTimeRange(-1);
            $rankInPast = $this->getListArticleId();
            if ($rankInPast) {
                $topRankingInPast[] = $rankInPast;
                $indexArticleInPast[] = array_flip(array_keys($rankInPast));
            }
        }
        array_walk(
            $this->_topRanking,
            function (&$value, $key, $option) {
                foreach ($option['ranking'] as $index => $ranking) {
                    if (isset($ranking[$key])) {
                        $rank = $option['indexOfArticle'][$index][$key];
                        if (is_int($rank) && $rank < $value['highest'])
                            $value['highest'] = $rank + 1;
                    }
                }
            },
            array(
                "ranking" => $topRankingInPast,
                "indexOfArticle" => $indexArticleInPast
            )
        );
    }

    /**
     * @return array Array of articles's id in one set
     */
    protected function getListArticleId($debug)
    {
        $rankOption = $this->_rankOption;
        $sortedSetName = self::getSortedSetName(
            $rankOption->action, $rankOption->type,
            $rankOption->periodType, $rankOption->getTimeRange()
        );
        $limit = (int) ($rankOption->limit) * 2;
        if ($limit < 0) $limit = 30;

        return $this->_redisConnect
            ->zRevRange($sortedSetName, 0, $limit, true);
    }

    /**
     * @desc Increase number of action user do with article like view, download, ....
     * @param string $action Type of action
     *        Ex: view, download
     * @param string $articleId Id of article
     * @param string $type Type of article
     */
    public static function increaseActionNumber($action, $articleId, $type)
    {
        /** @var \Redis $redisConnect */
        $weekSetName = self::getSortedSetName($action, $type, self::WEEK);
        $monthSetName = self::getSortedSetName($action, $type, self::MONTH);
        $yearSetName = self::getSortedSetName($action, $type, self::YEAR);

        $redisConnect = \Phalcon\Di::getDefault()->getShared('redisConnect');
        $redisConnect->multi(Redis::PIPELINE);
        $redisConnect->zIncrBy($weekSetName, 1, $articleId);
        $redisConnect->zIncrBy($monthSetName, 1, $articleId);
        $redisConnect->zIncrBy($yearSetName, 1, $articleId);
        $redisConnect->exec();
    }

    /**
     * @param string $action type of action
     * @param string $type type of article
     * @param string $period period of time
     *          [ week | month | year]
     * @param string $specificTime Is specific time period
     *        Ex : "9-2013"
     * @return string sorted set name
     */
    public static function getSortedSetName($action, $type, $period, $specificTime = null)
    {
        $date = new \DateTime();
        $year = $date->format("Y");
        if ($action == "view")
            $prefix = self::PREFIX_SORTED_SET;
        else $prefix = self::PREFIX_SORTED_SET . $action . "_";
        $prefix .= $type . "_" . $period . "_";
        if ($specificTime && strlen($specificTime))
            return $prefix . $specificTime;

        if ($period == self::WEEK) {
            $week = $date->format("W");
            return $prefix . $week . "-" . $year;
        }
        if ($period == self::MONTH) {
            $month = $date->format("m");
            return $prefix . $month . "-" . $year;
        }
        if ($period == self::YEAR)
            return $prefix . $year;
    }

}
