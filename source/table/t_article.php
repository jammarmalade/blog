<?php

if(!defined('BLOG')) {
	exit('Access Denied');
}

class t_article extends class_table{

	public function __construct() {

		$this->_table = 'article';
		$this->_pk    = 'aid';
		parent::__construct();
	}

	function fetch_list($type,$condition='',$start=0,$limit=0,$order='') {
		$field='*';
		if($type=='list'){
			$field='aid,typeid,`subject`,authorid,author,`like`,views,comments,image,dateline,`from`';
		}
		return $this->fetch_all($field,$condition,$start,$limit,$order);
	}
	
	function fetch_count(){
		return DB::result_first('SELECT count(*) FROM %t',array($this->_table));
	}
}

?>