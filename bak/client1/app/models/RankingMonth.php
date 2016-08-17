<?php
namespace DjClient\Models;

/**
 * Class RankingMonth
 * @package DjClient\Models
 */
class RankingMonth extends RankingAbstract
{
    public $time_range;
    public $periodType = "month";

    public function getTimeRange()
    {
        if (!$this->time_range) {
            $date = new \DateTime();
            $month = $date->format("m");
            $year = $date->format("Y");
            $this->time_range =  $month . "-" . $year;
        }

        return $this->time_range;
    }

    public function addToTimeRange($inc)
    {
        $date = new \DateTime();
        $month = (int)$date->format("m");
        $year = (int)$date->format("Y");
        if ($month == 1) {
            $year--;
            $month = 12;
        } else {
            $month--;
        }
        $this->time_range = $month . "-" . $year;
    }
}
