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
		$return['status']=1;
		$return['data']='';
		$tagname=$_GET['tagname'];
		if(J::t('tag')->find_by_tagname($tagname)){
			$return['status']=2;
			$return['data']='已存在该标签';
		}else{
			$tagid=J::t('tag')->insert(array('tagname'=>$tagname,'dateline'=>TIMESTAMP));
			if($tagid>0){
				$return['data']=$tagid;
			}else{
				$return['status']=2;
				$return['data']='插入失败';
			}
		}
		jsonOutput($return);
	}
	exit();
}






//$articles=J::t('article')->fetch_all($start,$limit);


$menu_active[$action]='class="myactive"';
$side_active[$do]='class="myactive"';

include display('header',1);
?>