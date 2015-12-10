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
		return DB::insert($this->_table,$data,true);
	}

	function fetch_all($start,$limit,$where='',$field='dateline',$sort='DESC') {
		if($where){
			$wherestr="WHERE ".$where;
		}
		return DB::fetch_all("SELECT * FROM %t $wherestr ORDER BY %i $sort ".DB::limit($start, $limit),array($this->_table,$field));
	}
	//搜索查询
	function search_tag($txt){
		$wherestr = 'WHERE tagname LIKE \'%' . strtr($txt, array('%' => '\%', '_' => '\_', '\\' => '\\\\',"'"=>"\'")) . '%\'';
		$sql = "SELECT tagid,tagname FROM pre_".$this->_table." $wherestr ORDER BY CHAR_LENGTH(tagname) LIMIT 10";
		$res = DB::query($sql);
		$return = [];
		while($value = DB::fetch_array($res)) {
			$tmp['id'] =$value['tagid'];
			$tmp['tagname']=$value['tagname'];
			$return[] = $tmp;
		}
		return $return;
	}
}

?>