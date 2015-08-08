<?php

if(!defined('BLOG')) {
	exit('Access Denied');
}

class t_tag {

	public function __construct() {

		$this->_table = 'tag';
		$this->_pk    = 'tagid';
	}
	
	function find_by_tagname($tagname){
		return DB::fetch_first('SELECT * FROM %t WHERE tagname=%s',array($this->_table,$tagname));
	}
	
	function fetch_count(){
		return DB::result_first('SELECT count(*) FROM %t',array($this->_table));
	}
	function find_by_pk($tagid){
		return DB::fetch_first('SELECT * FROM %t WHERE %i=%s',array($this->_table,$this->_pk,$tagid));
	}
	
	function insert($data){
		return DB::insert($this->_table,$data);
	}

	function fetch_all($start,$limit,$where='',$field='dateline',$sort='DESC') {
		if($where){
			$wherestr="WHERE ".$where;
		}
		return DB::fetch_all("SELECT * FROM %t $wherestr ORDER BY %i $sort ".DB::limit($start, $limit),array($this->_table,$field));
	}
}

?>