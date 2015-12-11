<?php

if(!defined('BLOG')) {
	exit('Access Denied');
}

class t_article_like extends class_table{

	public function __construct() {

		$this->_table = 'article_like';
		$this->_pk    = 'id';
		parent::__construct();
	}

	function fetch_count($condition=''){
		$wherestr = '';
		if($condition){
			$wherestr = 'WHERE '.$condition;
		}
		return DB::result_first('SELECT count(*) FROM %t '.$wherestr,array($this->_table));
	}
}

?>