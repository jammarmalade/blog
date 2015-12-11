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

	function fetch_count($condition=''){
		$wherestr = '';
		if($condition){
			$wherestr = 'WHERE '.$condition;
		}
		return DB::result_first('SELECT count(*) FROM %t '.$wherestr,array($this->_table));
	}
	//获取对应文章的标签
	function fetch_tags($aid){
		return DB::fetch_all("SELECT t.tagid,t.tagname FROM %t t INNER JOIN %t ta ON t.tagid=ta.tagid WHERE ta.aid=%d",array('tag',$this->_table,$aid));
	}

	function delete($tagid,$aid){
		return DB::delete($this->_table,"tagid=$tagid AND aid=$aid");
	}
}

?>