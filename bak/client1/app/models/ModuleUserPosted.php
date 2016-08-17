<?php
class ModuleUserPosted extends \Phalcon\Mvc\Collection
{
    public function getSource()
    {
        return "moduleuserpost";
    }
    
    public $date;
    public $uid;
    public $post;

    function setDate($date) { $this->date = $date; }
    function getDate() { return $this->date; }
    function setUid($uid) { $this->uid = $uid; }
    function getUid() { return $this->uid; }
    function setPost($post) { $this->post = $post; }
    function getPost() { return $this->post; }
}
?>