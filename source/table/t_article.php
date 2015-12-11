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

	//增加查看次数
	function addViews($aid){
		$cookiekey = 'view-'.$aid;
		if(getcookie($cookiekey)!=$aid){
			DB::query("UPDATE pre_".$this->_table." SET views=`views`+1 WHERE ".$this->_pk.'='.$aid);
			bsetcookie($cookiekey,$aid,300);
		}
		return true;
	}

	function like($aid,$type='add'){
		if($type=='add'){
			$field = '`like`=`like`+1';
		}else{
			$field = '`like`=`like`-1';
		}
		return DB::query("UPDATE pre_".$this->_table." SET $field WHERE ".$this->_pk.'='.$aid);
	}
}

?>