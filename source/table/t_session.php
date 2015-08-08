<?php

if(!defined('BLOG')) {
	exit('Access Denied');
}

class t_session {

	public function __construct() {

		$this->_table = 'session';
		$this->_pk    = 'sid';
	}

	
}

?>