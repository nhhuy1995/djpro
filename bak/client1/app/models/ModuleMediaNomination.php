<?php
class ModuleMediaNomination extends \Phalcon\Mvc\Collection
{
    public function getSource()
    {
        return "modulemedianomination";
    }

    private $date;
    private $mid;
    private $nomination;
    private $type;

    function setDate($date) { $this->date = $date; }
    function getDate() { return $this->date; }
    function setMid($mid) { $this->mid = $mid; }
    function getMid() { return $this->mid; }
    function setNomination($nomination) { $this->nomination = $nomination; }
    function getNomination() { return $this->nomination; }
    function setType($type) { $this->type = $type; }
    function getType() { return $this->type; }
}
?>