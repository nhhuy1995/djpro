<?php
class TypeMusic extends \Phalcon\Mvc\Collection
{
    public function getSource()
    {
        return "typemusic";
    }
    public $datecreate;
    public $priavatar;
    public $name;
    public $moretitle;
    public $sort;
    public $pribg;
    public $status;
    public $view;
    public $liked;
    public $replay;
    public $spamflag;
    public $namenoneutf;
    public $key;
    public $usercreate;
    public $modifydate;
    public $download;
    public $gift;

    function setDatecreate($datecreate) { $this->datecreate = $datecreate; }
    function getDatecreate() { return $this->datecreate; }
    function setPriavatar($priavatar) { $this->priavatar = $priavatar; }
    function getPriavatar() { return $this->priavatar; }
    function setName($name) { $this->name = $name; }
    function getName() { return $this->name; }
    function setMoretitle($moretitle) { $this->moretitle = $moretitle; }
    function getMoretitle() { return $this->moretitle; }
    function setSort($sort) { $this->sort = $sort; }
    function getSort() { return $this->sort; }
    function setPribg($pribg) { $this->pribg = $pribg; }
    function getPribg() { return $this->pribg; }
    function setStatus($status) { $this->status = $status; }
    function getStatus() { return $this->status; }
    function setView($view) { $this->view = $view; }
    function getView() { return $this->view; }
    function setLiked($liked) { $this->liked = $liked; }
    function getLiked() { return $this->liked; }
    function setReplay($replay) { $this->replay = $replay; }
    function getReplay() { return $this->replay; }
    function setSpamflag($spamflag) { $this->spamflag = $spamflag; }
    function getSpamflag() { return $this->spamflag; }
    function setNamenoneutf($namenoneutf) { $this->namenoneutf = $namenoneutf; }
    function getNamenoneutf() { return $this->namenoneutf; }
    function setKey($key) { $this->key = $key; }
    function getKey() { return $this->key; }
    function setUsercreate($usercreate) { $this->usercreate = $usercreate; }
    function getUsercreate() { return $this->usercreate; }
    function setModifydate($modifydate) { $this->modifydate = $modifydate; }
    function getModifydate() { return $this->modifydate; }
    function setDownload($download) { $this->download = $download; }
    function getDownload() { return $this->download; }
    function setGift($gift) { $this->gift = $gift; }
    function getGift() { return $this->gift; }

}
?>