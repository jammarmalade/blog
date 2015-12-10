<?php

if(!defined('BLOG')) {
	exit('Access Denied');
}

class t_tagid_aid {

	public function __construct() {

		$this->_table = 'tagid_aid';
		$this->_pk    = 'id';
	}
	
	function insert($data){
		return DB::insert($this->_table,$data,true);
	}
	//检查关系是否存在
	function relationExists($tagid,$aid){
		return DB::fetch_first('SELECT * FROM %t WHERE tagid=%d AND aid=%d',array($this->_table,$tagid,$aid));
	}

}

?>