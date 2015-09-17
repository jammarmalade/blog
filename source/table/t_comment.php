<?php

if(!defined('BLOG')) {
	exit('Access Denied');
}

class t_comment extends class_table{

	public function __construct() {

		$this->_table = 'comment';
		$this->_pk    = 'cid';
		parent::__construct();
	}

	function fetch_list($type,$condition='',$start=0,$limit=0,$order='') {
		$field='*';
		if($type=='list'){
			$field='';
		}
		return $this->fetch_all($field,$condition,$start,$limit,$order);
	}
	
	
}

?>