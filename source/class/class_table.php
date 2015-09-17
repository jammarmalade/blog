<?php


class class_table {
	
	public function __construct() {

	}
	
	function find_by_pk($id,$field='*'){
		return DB::fetch_first('SELECT %i FROM %t WHERE %i=%s',array($field,$this->_table,$this->_pk,$id));
	}

	function find_by_field($field,$val){
		return DB::fetch_first('SELECT * FROM %t WHERE %i=%s',array($this->_table,$field,$val));
	}
	
	function insert($data,$return_id = true){
		return DB::insert($this->_table,$data,$return_id);
	}

	function update($data,$condition){
		return DB::update($this->_table,$data,$condition);
	}

	function fetch_all($field='*',$condition='',$start=0,$limit=0,$order=''){
		if(!$field){
			$field='*';
		}
		if($condition){
			$condition='WHERE '.$condition;
		}
		$strLimit='';
		if($start>=0 && $limit>0){
			$strLimit='LIMIT '.$start.','.$limit;
		}
		$strOrder='';
		if($order){
			$strOrder='ORDER BY '.$order;
		}
//		$sql="SELECT $field FROM %t $condition $strOrder $strLimit";
//		echo $sql;
		return DB::fetch_all("SELECT $field FROM %t $condition $strOrder $strLimit",array($this->_table));
	}
}