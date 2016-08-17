<?php
class Singer extends \Phalcon\Mvc\Collection
{
    public function getSource()
    {
        return "singer";
    }
    public $avatar;
    public $category;
    public $companycert;
    public $country;
    public $datecreate;
    public $dob;
    public $fullname;
    public $key;
    public $name;
    public $namenoneutf;
    public $priavatar;
    public $profile;
    public $status;
    public $type;
    public $usercreate;
    public $usermodify;

    function setAvatar($avatar) { $this->avatar = $avatar; }
    function getAvatar() { return $this->avatar; }
    function setCategory($category) { $this->category = $category; }
    function getCategory() { return $this->category; }
    function setCompanycert($companycert) { $this->companycert = $companycert; }
    function getCompanycert() { return $this->companycert; }
    function setCountry($country) { $this->country = $country; }
    function getCountry() { return $this->country; }
    function setDatecreate($datecreate) { $this->datecreate = $datecreate; }
    function getDatecreate() { return $this->datecreate; }
    function setDob($dob) { $this->dob = $dob; }
    function getDob() { return $this->dob; }
    function setFullname($fullname) { $this->fullname = $fullname; }
    function getFullname() { return $this->fullname; }
    function setKey($key) { $this->key = $key; }
    function getKey() { return $this->key; }
    function setName($name) { $this->name = $name; }
    function getName() { return $this->name; }
    function setNamenoneutf($namenoneutf) { $this->namenoneutf = $namenoneutf; }
    function getNamenoneutf() { return $this->namenoneutf; }
    function setPriavatar($priavatar) { $this->priavatar = $priavatar; }
    function getPriavatar() { return $this->priavatar; }
    function setProfile($profile) { $this->profile = $profile; }
    function getProfile() { return $this->profile; }
    function setStatus($status) { $this->status = $status; }
    function getStatus() { return $this->status; }
    function setType($type) { $this->type = $type; }
    function getType() { return $this->type; }
    function setUsercreate($usercreate) { $this->usercreate = $usercreate; }
    function getUsercreate() { return $this->usercreate; }
    function setUsermodify($usermodify) { $this->usermodify = $usermodify; }
    function getUsermodify() { return $this->usermodify; }
}
?>