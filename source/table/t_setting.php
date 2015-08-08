<?php

if(!defined('BLOG')) {
	exit('Access Denied');
}

class t_setting {

	public function __construct() {

		$this->_table = 'setting';
		$this->_pk    = 'sname';
	}

	function fetch_all() {
		return DB::fetch_all("SELECT * FROM %t",array($this->_table),'sname');
	}
	
	function replace($sname,$data) {
		$json_data=json_encode($data);
		$insert=array(
			'sname'	=>$sname,
			'svalue'=>$json_data,
		);
		return DB::insert($this->_table,$insert,false,true);
	}
}

?>