<?php

if(!defined('BLOG')) {
	exit('Access Denied');
}

$doarr=array('list','view','new','update');

if(!in_array($do,$doarr)){
	$do='list';
}

$limit=10;
$start=($_B['page'] - 1)* $limit;
require_once libfile('article');

switch($do){
	case 'list':

		$articles=J::t('article')->fetch_list('*','`status`=1',$start,$limit,'dateline DESC');
		foreach($articles as $k=>$v){
			$articles[$k]['content']=cutstr(strip_ubb($v['content']),300);
			$articles[$k]['formattime']=btime($v['dateline'],1);
			$articles[$k]['time']=btime($v['dateline']);
			$articles[$k]['link']='index.php?m=article&do=view&aid='.$v['aid'];
			if($v['image']){
				$imgids[$v['aid']]=$v['image'];
			}
		}
		if($imgids){
			$str_ids=join(',',$imgids);
			$imginfos=J::t('image')->fetch_all('*',"id IN($str_ids)");
			foreach($imginfos as $k=>$v){
				$suff=$v['thumbH'] ? '.thumb.jpg' : '';
				$imgids[$v['aid']]=$_B['siteurl'].$v['path'].$suff;
			}
		}
		$count=J::t('article')->fetch_count();
		$pagehtml=page($count,$_B['page'],$limit,'index.php?m=article&do=list');

		$_B['navtitle']=$_B['setting']['blog']['blogName'].' - 列表';
		break;
	case 'view':
		$aid=$_GET['aid'] ? : 0;
		if(!$aid || !is_numeric($aid)){
			shownotice('该文章不存在',array('referer'=>$_B['referer']));
		}

		$article=J::t('article')->find_by_pk($aid);
		if($article['status']!=1 && !$_B['admin']){
			shownotice('该文章不存在',array('referer'=>$_B['referer']));
		}
		$aidattach = $article['image'] ? $article['aid'] : 0;
		$article['content']=ubb2html($article['content'],$aidattach);
		$article['formattime']=btime($article['dateline'],1);
		$article['time']=btime($article['dateline']);
		//获取评论
		$comlimit=30;
		$comlist=J::t('comment')->fetch_list('*',"classify='article' AND aid=$aid AND `status`=1",0,$comlimit);
		$next=0;
		if($comlist){
			foreach($comlist as $k=>$v){
				$comlist[$k]['formattime']=btime($v['dateline'],1);
				$comlist[$k]['time']=btime($v['dateline']);
				$comlist[$k]['avatar']=IMGDIR.'jam.png';
				$comlist[$k]['content']=ubb2html($v['content']);
			}
			if(count($comlist)>=$comlimit){
				$next=1;
			}
		}

		$_B['navtitle']=$article['subject'].' - '.$article['author'];
		break;
	case 'new':
		if($_B['ajax'] && $_GET['type']=='new'){
			$status=1;
			$data='';
			if(!$_B['uid']){
				jsonOutput(2,'login');
			}
			$subject=$_GET['subject'];
			$content=$_GET['content'];

			if($subject=='' || $content==''){
				jsonOutput(2,'标题或内容不能为空');
			}
			//以后添加审核内容关键词

			$res_content=html2ubb($content,1);
			$image=0;
			if($res_content['image']){
				$tmpimgs=$res_content['image'];
				$image=array_shift($tmpimgs);
			}
			$insert=array(
				'subject'=>$subject,
				'content'=>$res_content['content'],
				'authorid'=>$_B['uid'],
				'author'=>$_B['username'],
				'dateline'=>TIMESTAMP,
				'image'=>$image,
				'views'=>1,
			);
			$aid=J::t('article')->insert($insert);
			if($aid && $image){
				$str_ids=join(',',$res_content['image']);
				J::t('image')->update(array(
					'aid'=>$aid,
					'status'=>1
				),"uid=".$_B['uid']." AND id IN($str_ids)");
				$data=$_B['siteurl'].'index.php?m=article&do=view&id='.$aid;
			}else{
				if(!$aid){
					$status=2;
					$data='添加失败';
				}else{
					$data='添加成功';
				}
			}

			jsonOutput($status,$data);
		}
		checkLogin();
		$_B['navtitle']=$_B['setting']['blog']['blogName'].' - 写文章';
		$defaultcontent='';
		break;
	case 'update':
		if($_B['ajax'] && $_GET['type']=='update'){
			$status=1;
			$data='';
			if(!$_B['uid']){
				jsonOutput(2,'login');
			}
			$aid=$_GET['aid'];
			if(!$aid){
				jsonOutput(2,'没有文章需要修改');
			}
			$subject=$_GET['subject'];
			$content=$_GET['content'];

			if($subject=='' || $content==''){
				jsonOutput(2,'标题或内容不能为空');
			}
			//以后添加审核内容关键词

			$res_content=html2ubb($content,1);
			$image=0;
			if($res_content['image']){
				$tmpimgs=$res_content['image'];
				$image=array_shift($tmpimgs);
			}
			$update=array(
				'subject'=>$subject,
				'content'=>$res_content['content'],
				'lastupdate'=>TIMESTAMP,
				'image'=>$image,
				'views'=>1,
			);
			$res_status=J::t('article')->update($update,"aid=$aid");
			if($res_status && $image){
				$str_ids=join(',',$res_content['image']);
				J::t('image')->update(array(
					'aid'=>$aid,
					'status'=>1
				),"uid=".$_B['uid']." AND id IN($str_ids)");
				$data=$_B['siteurl'].'index.php?m=article&do=view&id='.$aid;
			}else{
				if(!$res_status){
					$status=2;
					$data='修改失败';
				}else{
					$data='修改成功';
				}
			}
			jsonOutput($status,$data);
		}
		
		$aid=$_GET['aid'] ? : 0;
		if(!$aid || !is_numeric($aid)){
			shownotice('该文章不存在',array('referer'=>$_B['referer']));
		}

		$article=J::t('article')->find_by_pk($aid);
		if(!$article){
			shownotice('该文章不存在',array('referer'=>$_B['referer']));
		}
		if($_B['uid']!=$article['authorid'] || ($article['status']!=1 && !$_B['admin'])){
			shownotice('无权编辑该文章',array('referer'=>$_B['referer']));
		}

		$_B['navtitle']='编辑文章 - '.$article['subject'];

		$aidattach = $article['image'] ? $article['aid'] : 0;
		$defaultcontent=ubb2html($article['content'],$aidattach,'update');
		$do='new';
		break;
}



include display('article_'.$do);
?>