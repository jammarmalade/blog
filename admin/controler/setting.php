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
			$return['status']=1;
			$return['data']='';
			if(J::t('nav')->find_by_name($_GET['name'])){
				$return['status']=2;
				$return['data']='该导航名称已存在';
				jsonOutput($return);
			}
			$status=$_GET['status']=='false' ? 0 : 1;
			$update=array(
				'name'=>$_GET['name'],
				'link'=>$_GET['link'],
				'displayorder'=>$_GET['displayorder'],
				'status'=>$status,
			);
			if(!(J::t('nav')->update_by_pk($update,$_GET['id']))){
				$return['status']=2;
				$return['data']='修改失败';
			}
			jsonOutput($return);
		}elseif($type=='add'){
			$return['status']=1;
			$return['data']='';
			if(J::t('nav')->find_by_name($_GET['name'])){
				$return['status']=2;
				$return['data']='该导航名称已存在';
				jsonOutput($return);
			}
			$status=$_GET['status']=='false' ? 0 : 1;
			$insert=array(
				'pid' =>$_GET['pid'],
				'name'=>$_GET['name'],
				'link'=>$_GET['link'],
				'displayorder'=>$_GET['displayorder'],
				'dateline'=>TIMESTAMP,
				'status'=>$status,
			);
			$id=J::t('nav')->insert($insert);
			if(!$id){
				$return['status']=2;
				$return['data']='插入失败';
			}else{
				$return['data']=$id;
			}
			jsonOutput($return);
		}elseif($type=='del'){
			$return['status']=1;
			$return['data']='';
			if(!is_numeric($_GET['id']) || $_GET['id'] < 0){
				$return['status']=2;
				$return['data']='删除失败';
			}else{
				if(J::t('nav')->deletenav($_GET['id'])){
					$return['data']='删除成功';
				}else{
					$return['status']=2;
					$return['data']='删除失败';
				}
			}
			jsonOutput($return);

		}elseif($type=='cache'){
			$return['status']=1;
			$return['data']='';

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
			jsonOutput($return);
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