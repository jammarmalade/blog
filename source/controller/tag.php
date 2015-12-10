<?php

if(!defined('BLOG')) {
	exit('Access Denied');
}


$do=!empty($_GET['do']) ? $_GET['do'] : '';

$doarr=array('add','search','zan','addRelation');
if(!in_array($do,$doarr)){
	jsonOutput(2,'不允许的操作');
}

if($do=='search'){
	$data = J::t('tag')->search_tag($_GET['q']);
	if(!$data){
		$data[0]['id']=0;
		$data[0]['tagname']=$_GET['q'];
	}
	echo json_encode($data);
	exit();
}elseif($do=='add'){
	$tagname = $_GET['tagname'];
	if(J::t('tag')->find_by_tagname($tagname)){
		$status=2;
		$data='已存在该标签';
	}else{
		$status=1;
		$data=J::t('tag')->insert([
			'tagname'=>$tagname,
			'uid'=>$_B['uid'],
			'username'=>$_B['username'],
			'dateline'=>TIMESTAMP
		]);
	}
	jsonOutput($status,$data);
}elseif($do=='addRelation'){
	$tagid = $_GET['tagid'];
	$aid = $_GET['aid'];
	if(!$tagid || !$aid){
		jsonOutput(2,'缺少参数');
	}
	if(J::t('tagid_aid')->relationExists($tagid,$aid)){
		jsonOutput(2,'已存该标签');
	}else{
		$insertId=J::t('tagid_aid')->insert([
			'tagid'=>$tagid,
			'aid'=>$aid,
			'uid'=>$_B['uid'],
			'username'=>$_B['username'],
			'dateline'=>TIMESTAMP
		]);
		jsonOutput(1,$insertId);
	}

	
}