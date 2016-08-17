<?php
namespace DjClient\Models;

/**
 * Class RankingWeek
 * @package DjClient\Models
 */
class RankingWeek extends RankingAbstract
{
    public $periodType = "week";

    public function getTimeRange()
    {
        if (!$this->time_range) {
            $date = new \DateTime();
            $week = $date->format("W");
            $year = $date->format("Y");
            $this->time_range = $week . "-" . $year;
        }
        return $this->time_range;
    }

    public function addToTimeRange($inc)
    {
        if (!$this->time_range) {
            $date = new \DateTime();
            $week = (int)$date->format("W");
            $year = (int)$date->format("Y");
        } else {
            list($week, $year) = explode("-", $this->time_range);
        }
        if ($week == 1) {
            $year--;
            $week = $this->getIsoWeeksInYear($year - 1);
        } else {
            $week--;
            $week = str_pad($week, 2, 0, STR_PAD_LEFT);
        }
        $this->time_range = $week . "-" . $year;
    }

    function getIsoWeeksInYear($year)
    {
        $date = new \DateTime();
        $date->setISODate($year, 53);
        return ($date->format("W") === "53" ? 53 : 52);
    }
}
