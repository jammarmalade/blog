<?php

if(!defined('BLOG')) {
	exit('Access Denied');
}

class t_loginfailed {

	public function __construct() {

		$this->_table = 'loginfailed';
		$this->_pk    = 'ip';
	}

	function fetch_ip($ip) {
		return DB::fetch_first('SELECT * FROM %t WHERE %i=%s',array($this->_table,$this->_pk,$ip));
	}

	function update_by_pk($data,$ip){
		return DB::update($this->_table,$data,$this->_pk."='$ip'");
	}

	function insert($data){
		return DB::insert($this->_table,$data,true);
	}
}

?>