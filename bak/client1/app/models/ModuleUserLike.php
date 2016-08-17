<?php
class ModuleUserLike extends \Phalcon\Mvc\Collection
{
    public function getSource()
    {
        return "moduleuserlike";
    }

    public $date;
    public $uid;
    public $like;

    function setDate($date) { $this->date = $date; }
    function getDate() { return $this->date; }
    function setUid($uid) { $this->uid = $uid; }
    function getUid() { return $this->uid; }
    function setLike($like) { $this->like = $like; }
    function getLike() { return $this->like; }

}
?>