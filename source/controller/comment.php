<?php

if(!defined('BLOG')) {
	exit('Access Denied');
}

$do=!empty($_GET['do']) ? $_GET['do'] : '';

$doarr=array('add','get','zan');
if(!in_array($do,$doarr)){
	jsonOutput(2,'不允许的操作');
}

if($do=='add'){
	checkLogin();
	if($_B['ajax']){
		require_once libfile('article');
		$aid = $_GET['aid'] ? $_GET['aid'] : '';
		if(!is_numeric($aid) || $aid<=0){
			jsonOutput(2,'数据错误，请刷新重试');
		}
		$rcid = $_GET['rcid'] ? $_GET['rcid'] : '';
		//若是回复
		if(is_numeric($rcid) && $rcid>0){
			$rinfo=J::t('comment')->find_by_pk($rcid,'authorid,author');
			if($rinfo){
				$insert['rcid']=$rcid;
				$insert['ruid']=$rinfo['authorid'];
				$insert['username']=$rinfo['author'];
			}
		}
		$content = $_GET['content'] ? commentubb($_GET['content']) : '';
		if($content==''){
			jsonOutput(2,'评论内容不能为空');
		}

		$insert['aid']=$aid;
		$insert['authorid']=$_B['uid'];
		$insert['author']=$_B['username'];
		$insert['content']=$content;
		$insert['dateline']=TIMESTAMP;
		
		$cid=J::t('comment')->insert($insert);
		if($cid){
			require_once libfile('article');
			$insert['content']=ubb2html($insert['content']);
			$insert['cid']=$cid;
			$insert['formattime']='刚刚';
			$insert['time']=btime(TIMESTAMP);
			$insert['avatar']=IMGDIR.'jam.png';
			
			$comlist[0]=$insert;
			$data=display('_comment',0,true,array('comlist'=>$comlist));
			jsonOutput(1,$data);
		}else{
			$data='添加失败';
			jsonOutput(2,'添加失败');
		}
	}else{
		jsonOutput(2,'不允许的操作');
	}
}elseif($do=='get'){
	if(!$_B['ajax']){
		jsonOutput(2,'不允许的操作');
	}
	if(!is_numeric($_B['page'])){
		jsonOutput(2,'数据出错，请刷新重试');
	}
	if(!is_numeric($_GET['aid']) || $_GET['aid']<=0){
		jsonOutput(2,'数据出错，请刷新重试');
	}
	$aid=$_GET['aid'];
	$comlimit=30;
	$start=($_B['page']-1) * $comlimit;
	$comlist=J::t('comment')->fetch_list('*',"classify='article' AND aid=$aid AND `status`=1",$start,$comlimit);
	$next='';
	if($comlist){
		require_once libfile('article');
		foreach($comlist as $k=>$v){
			$comlist[$k]['formattime']=btime($v['dateline'],1);
			$comlist[$k]['time']=btime($v['dateline']);
			$comlist[$k]['avatar']=IMGDIR.'jam.png';
			$comlist[$k]['content']=ubb2html($v['content']);
		}
		if(count($comlist)>=$comlimit){
			$next='index.php?m=comment&do=get&aid='.$aid.'&page='.($_B['page']+1);
		}
	}
	$data['content']=display('_comment',0,true,array('comlist'=>$comlist));
	$data['next']=$next;
	jsonOutput(1,$data);
}elseif($do=='zan'){
	if(!$_B['ajax']){
		jsonOutput(2,'不允许的操作');
	}
	if(!is_numeric($_GET['cid']) || $_GET['cid']<=0){
		jsonOutput(2,'数据出错，请刷新重试');
	}
	
	jsonOutput(1,-1);
}