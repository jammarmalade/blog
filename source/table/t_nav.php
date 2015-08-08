<?php

if(!defined('BLOG')) {
	exit('Access Denied');
}

class t_nav {

	public function __construct() {

		$this->_table = 'nav';
		$this->_pk    = 'id';
	}

	function find_by_pk($id){
		return DB::fetch_first('SELECT * FROM %t WHERE %i=%s',array($this->_table,$this->_pk,$id));
	}
	function find_by_name($name){
		return DB::fetch_first('SELECT * FROM %t WHERE %i=%s',array($this->_table,$this->_pk,$name));
	}
	function update_by_pk($data,$id){
		return DB::update($this->_table,$data,$this->_pk.'='.$id);
	}
	
	function insert($data){
		return DB::insert($this->_table,$data,true);
	}
	function deletenav($id){
		return DB::delete($this->_table,$this->_pk.'='.$id);
	}
	function fetch_all() {
		return DB::fetch_all("SELECT * FROM %t ",array($this->_table));
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