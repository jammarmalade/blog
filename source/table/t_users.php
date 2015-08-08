<?php

if(!defined('BLOG')) {
	exit('Access Denied');
}

class t_users {

	public function __construct() {

		$this->_table = 'users';
		$this->_pk    = 'uid';
	}
	
	function find_by_pk($uid){
		return DB::fetch_first('SELECT * FROM %t WHERE %i=%s',array($this->_table,$this->_pk,$uid));
	}

	function find_by_field($field,$val){
		return DB::fetch_first('SELECT * FROM %t WHERE %i=%s',array($this->_table,$field,$val));
	}
	
	function register($data){
		return DB::insert($this->_table,$data);
	}

	function update_by_pk($data,$uid){
		return DB::update($this->_table,$data,$this->_pk.'='.$uid);
	}
	function login($user){
		if(strlen($user) > 6 && strlen($user) <= 32 && preg_match("/^([A-Za-z0-9\-_.+]+)@([A-Za-z0-9\-]+[.][A-Za-z0-9\-.]+)$/", $user)){
			$field='email';
		}else{
			$field='username';
		}
		return $this->find_by_field($field,$user);
	}
}

?>