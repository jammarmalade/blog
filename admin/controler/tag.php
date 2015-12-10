<?php

if(!defined('BLOG')) {
	exit('Access Denied');
}

$doarr=array('list','add');

if(!in_array($do,$doarr)){
	$do='list';
}

$limit=5;
$start=($_B['page'] - 1) * $limit;
if($do=='list'){
	$count=J::t('tag')->fetch_count();
	$taginfo=J::t('tag')->fetch_all($start,$limit);
	$pagehtml=page($count,$_B['page'],$limit,'admin.php?action=tag&do=list');
}elseif($do=='add'){
	if($_B['ajax']){
		$status=1;
		$data='';
		$tagname=$_GET['tagname'];
		if(J::t('tag')->find_by_tagname($tagname)){
			$status=2;
			$data='已存在该标签';
		}else{
			$insertData = array(
				'tagname'=>$tagname,
				'uid'=>$_B['uid'],
				'username'=>$_B['username'],
				'dateline'=>TIMESTAMP
			);
			$tagid=J::t('tag')->insert($insertData);
			if($tagid>0){
				$data=$tagid;
			}else{
				$status=2;
				$data='插入失败';
			}
		}
		jsonOutput($status,$data);
	}
	exit();
}






//$articles=J::t('article')->fetch_all($start,$limit);


$menu_active[$action]='class="myactive"';
$side_active[$do]='class="myactive"';

include display('header',1);
?>