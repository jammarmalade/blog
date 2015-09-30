<?php

if(!defined('BLOG')) {
	exit('Access Denied');
}

$doarr=array('blog','nav','seo');

if(!in_array($do,$doarr)){
	$do='blog';
}

if($do=='blog'){
	$new=$_GET['settingnew'];
	if($_GET['admin_status']=='success'){
		$msg='设置成功';
	}
	if($new['blogName']){
		J::t('setting')->replace($do,$new);
		if(!strpos($_B['referer'],'admin_status')){
			$url=$_B['referer'].'admin_status&=success';
		}else{
			$url=$_B['referer'];
		}
		bheader('location: '.$url);
	}
	$blog=$_B['setting']['blog'];
}elseif($do=='nav'){

	if($_B['ajax']){
		$type=$_GET['type'];
		if($type=='update'){
			if(J::t('nav')->find_by_name($_GET['name'])){
				jsonOutput(2,'该导航名称已存在');
			}
			$navstatus=$_GET['status']=='false' ? 0 : 1;
			$update=array(
				'name'=>$_GET['name'],
				'link'=>$_GET['link'],
				'displayorder'=>$_GET['displayorder'],
				'status'=>$navstatus,
			);
			if(!(J::t('nav')->update_by_pk($update,$_GET['id']))){
				$status=2;
				$data='修改失败';
			}else{
				$status=1;
				$data='修改成功';
			}
			jsonOutput($status,$data);
		}elseif($type=='add'){
			if(J::t('nav')->find_by_name($_GET['name'])){
				jsonOutput(2,'该导航名称已存在');
			}
			$navstatus=$_GET['status']=='false' ? 0 : 1;
			$insert=array(
				'pid' =>$_GET['pid'],
				'name'=>$_GET['name'],
				'link'=>$_GET['link'],
				'displayorder'=>$_GET['displayorder'],
				'dateline'=>TIMESTAMP,
				'status'=>$navstatus,
			);
			$id=J::t('nav')->insert($insert);
			if(!$id){
				$status=2;
				$data='插入失败';
			}else{
				$status=1;
				$data=$id;
			}
			jsonOutput($status,$data);
		}elseif($type=='del'){
			$status=1;
			$data='';
			if(!is_numeric($_GET['id']) || $_GET['id'] < 0){
				$status=2;
				$data='删除失败';
			}else{
				if(J::t('nav')->deletenav($_GET['id'])){
					$data='删除成功';
				}else{
					$status=2;
					$data='删除失败';
				}
			}
			jsonOutput($status,$data);

		}elseif($type=='cache'){

			$navinfos=J::t('nav')->fetch_all();
			foreach($navinfos as $k=>$v){
				if($v['pid']==0){
					$pinfos[$v['id']]=$v;
				}else{
					$group[$v['pid']][]=$v;
				}
			}
			foreach(multi_array_sort($pinfos,'displayorder') as $k=>$v){
				$sortpinfos[$v['id']]=$v;
			}
			foreach($group as $k=>$v){
				$sortpinfos[$k]['downnav']=multi_array_sort($v,'displayorder');
			}
			J::t('setting')->replace('nav',$sortpinfos);
			jsonOutput(1);
		}
		exit();
	}else{
		if(empty($_B['setting']['nav'])){
			$navinfos=J::t('nav')->fetch_all();
			foreach($navinfos as $k=>$v){
				if($v['pid']==0){
					$pinfos[$v['id']]=$v;
				}else{
					$group[$v['pid']][]=$v;
				}
			}
			foreach(multi_array_sort($pinfos,'displayorder') as $k=>$v){
				$sortpinfos[$v['id']]=$v;
			}
			foreach($group as $k=>$v){
				$sortpinfos[$k]['downnav']=multi_array_sort($v,'displayorder');
			}
			$nav=$sortpinfos;
		}else{
			$nav=$_B['setting']['nav'];
		}
	}
	

}elseif($do=='seo'){
	
}




$limit=10;
$start=$_B['page'] * $limit;

//$articles=J::t('article')->fetch_all($start,$limit);


$menu_active[$action]='class="myactive"';
$side_active[$do]='class="myactive"';

include display('header',1);
?>