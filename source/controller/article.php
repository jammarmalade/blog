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
			$articles[$k]['content']=strip_ubb($v['content']);
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

		$navtitle=$_B['setting']['blog']['blogName'].' - 列表';
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

		$navtitle=$article['subject'].' - '.$article['author'];
		break;
	case 'new':
		if($_B['ajax'] && $_GET['type']=='new'){
			$return['status']=1;
			$return['data']='';
			if(!$_B['uid']){
				$return['status']=2;
				$return['data']='login';
				jsonOutput($return);
			}
			$subject=$_GET['subject'];
			$content=$_GET['content'];

			if($subject=='' || $content==''){
				$return['status']=2;
				$return['data']='标题或内容不能为空';
				jsonOutput($return);
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
				$return['data']=$_B['siteurl'].'index.php?m=article&do=view&id='.$aid;
			}else{
				if(!$aid){
					$return['status']=2;
					$return['data']='添加失败';
				}else{
					$return['data']='添加成功';
				}
			}

			jsonOutput($return);
		}
		if(!$_B['uid']){
			shownotice('请先登录',array('referer'=>$_B['referer']));
		}
		$navtitle=$_B['setting']['blog']['blogName'].' - 写文章';
		$defaultcontent='';
		break;
	case 'update':
		if($_B['ajax'] && $_GET['type']=='update'){
			
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

		$navtitle='编辑文章 - '.$article['subject'];

		$aidattach = $article['image'] ? $article['aid'] : 0;
		$defaultcontent=ubb2html($article['content'],$aidattach,'update');
		$do='new';
		break;
}



include display('article_'.$do);
?>