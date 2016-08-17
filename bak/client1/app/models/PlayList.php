<?php
class PlayList extends \Phalcon\Mvc\Collection
{
    public function getSource()
    {
        return "playlist";
    }

    public $modifydate;
    public $datecreate;
    public $usercreate;
    public $name;
    public $moretitle;
    public $namenoneutf;
    public $key;
    public $song;
    public $priavatar;
    public $avatar;
    public $view;
    public $replay;
    public $spamflag;
    public $liked;
    public $download;
    public $gift;
    public $status;

    function setModifydate($modifydate) { $this->modifydate = $modifydate; }
    function getModifydate() { return $this->modifydate; }
    function setDatecreate($datecreate) { $this->datecreate = $datecreate; }
    function getDatecreate() { return $this->datecreate; }
    function setUsercreate($usercreate) { $this->usercreate = $usercreate; }
    function getUsercreate() { return $this->usercreate; }
    function setName($name) { $this->name = $name; }
    function getName() { return $this->name; }
    function setMoretitle($moretitle) { $this->moretitle = $moretitle; }
    function getMoretitle() { return $this->moretitle; }
    function setNamenoneutf($namenoneutf) { $this->namenoneutf = $namenoneutf; }
    function getNamenoneutf() { return $this->namenoneutf; }
    function setKey($key) { $this->key = $key; }
    function getKey() { return $this->key; }
    function setSong($song) { $this->song = $song; }
    function getSong() { return $this->song; }
    function setPriavatar($priavatar) { $this->priavatar = $priavatar; }
    function getPriavatar() { return $this->priavatar; }
    function setAvatar($avatar) { $this->avatar = $avatar; }
    function getAvatar() { return $this->avatar; }
    function setView($view) { $this->view = $view; }
    function getView() { return $this->view; }
    function setReplay($replay) { $this->replay = $replay; }
    function getReplay() { return $this->replay; }
    function setSpamflag($spamflag) { $this->spamflag = $spamflag; }
    function getSpamflag() { return $this->spamflag; }
    function setLiked($liked) { $this->liked = $liked; }
    function getLiked() { return $this->liked; }
    function setDownload($download) { $this->download = $download; }
    function getDownload() { return $this->download; }
    function setGift($gift) { $this->gift = $gift; }
    function getGift() { return $this->gift; }
    function setStatus($status) { $this->status = $status; }
    function getStatus() { return $this->status; }

}
?>