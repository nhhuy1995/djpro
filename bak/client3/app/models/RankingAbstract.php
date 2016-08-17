<?php
namespace DjClient\Models;

abstract class RankingAbstract
{
    public $action;
    public $periodType;
    public $type;
    public $limit;
    protected $time_range;

    abstract public function getTimeRange();

    abstract public function addToTimeRange($inc);

    /**
     * @param string $time Time range
     *        Ex: "09-2015"
     */
    public function setTimeRange($time)
    {
        $this->time_range = $time;
    }

}