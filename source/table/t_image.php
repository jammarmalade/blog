<?php

if(!defined('BLOG')) {
	exit('Access Denied');
}

class t_image extends class_table{

	public function __construct() {

		$this->_table = 'image';
		$this->_pk    = 'id';

		parent::__construct();
	}
	
	function fetch_unused($uid){
		return $this->fetch_all('',"uid=$uid");
	}
}

?>