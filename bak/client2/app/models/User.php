<?php
use Phalcon\Security;
/**
 * 
 * @author hoang
 *
 */
class User extends \Phalcon\Mvc\Collection {
	public function getSource() {
		return "user";
	}
	
	public $username;
	public $name;
	public $email;
	public $password;
	public $dob;
	public $gender;
	public $namenoneutf;
	public $key;
	public $profile;
	public $datecreate;
	public $priavatar;
	public $address;
	public $phone;
	
	function setUsername($username) {
		$this->username = $username;
	}
	function getUsername() {
		return $this->username;
	}
	function setName($name) {
		$this->name = $name;
	}
	function getName() {
		return $this->name;
	}
	function setEmail($email) {
		$this->email = $email;
	}
	function getEmail() {
		return $this->email;
	}
	function setPassword($password) {
		$this->password = $password;
	}
	function getPassword() {
		return $this->password;
	}
	function setDob($dob) {
		$this->dob = $dob;
	}
	function getDob() {
		return $this->dob;
	}
	function setGender($gender) {
		$this->gender = $gender;
	}
	function getGender() {
		return $this->gender;
	}
	function setNamenoneutf($namenoneutf) {
		$this->namenoneutf = $namenoneutf;
	}
	function getNamenoneutf() {
		return $this->namenoneutf;
	}
	function setKey($key) {
		$this->key = $key;
	}
	function getKey() {
		return $this->key;
	}
	function setProfile($profile) {
		$this->profile = $profile;
	}
	function getProfile() {
		return $this->profile;
	}
	function setDatecreate($datecreate) {
		$this->datecreate = $datecreate;
	}
	function getDatecreate() {
		return $this->datecreate;
	}
	function setPriavatar($priavatar) {
		$this->priavatar = $priavatar;
	}
	function getPriavatar() {
		return $this->priavatar;
	}
	function setAddress($address) {
		$this->address = $address;
	}
	function getAddress() {
		return $this->address;
	}
	function setPhone($phone) {
		$this->phone = $phone;
	}
	function getPhone() {
		return $this->phone;
	}
	
	/**
	 * check user login
	 *
	 * @param unknown $params        	
	 */
	public static function login($username, $password) {
		$data = new stdClass;
		if (empty($username) || empty($password)){
			$data->code = 1;
			$data->message = 'Data invalid';
		}
		
		$user = self::findFirst(array(
				"conditions" => array("username" => "{$username}")
		));
		
		if ($user->_id){
			$userPassword = $user->password;
			
			$passwordIsMatch = \Phalcon\Di::getDefault()->get('security')->checkHash($password, $userPassword);
			
			if ($passwordIsMatch == true){
				$data->code = 0;
				$data->message = 'Đăng nhập thành công';
				
				$userData = $user->toArray();
				unset($userData['password']);
				
				\Phalcon\Di::getDefault()->get('session')->set("authentication", true);
				\Phalcon\Di::getDefault()->get('session')->set("userId", $user->_id);
				\Phalcon\Di::getDefault()->get('session')->set("userData", $userData);
			} else {
				$data->code = 3;
				$data->message = 'Mật khẩu không đúng. Vui lòng thử lại';
			}
		} else {
			$data->code = 2;
			$data->message = 'Tài khoản không tồn tại. Vui lòng thử lại';
		}

		return $data;
	}
}
?>