<?php

if(!defined('BLOG')) {
	exit('Access Denied');
}


$do=!empty($_GET['do']) ? $_GET['do'] : '';

$doarr=array('article-new');
if(!in_array($do,$doarr)){
	$return['status']=0;
	$return['data']='不允许的操作';
	jsonOutput($return);
}

$upload=new class_upload();

switch($do){
	case 'article-new':
		if(!$_B['uid']){
			$return['status']=2;
			$return['data']='login';
			jsonOutput($return);
		}
		$return['status']=1;
		$upload->init($_FILES['file'],'article','data/attachment');
		$file=&$upload->file;
		
		if(!$file['isimage']){
			$return['status']=0;
			$return['data']='请上传图片附件  0027';
			jsonOutput($return);
		}
		if($file['size'] > 2097152){//2M
			$return['status']=0;
			$return['data']='请上传小余 2M 的图片  0032';
			jsonOutput($return);
		}
		$upload->save($file['tmp_name'],$file['target']);
		$errorcode=$upload->error();
		if($errorcode<0){
			$return['status']=0;
			$return['data']=$upload->errormsg();
			@unlink($file['target']);
			jsonOutput($return);
		}
		//判断是否开启了exif，并获取照片的exif信息
		$my_exif=array();
		if(extension_loaded('exif') && extension_loaded('mbstring')){
			$my_exif = exif_read_data($file['target'],"EXIF");
		}
		$image=new class_image($file['target']);
		$image->exif=$my_exif;
		$status=$image->Thumb();
		if($status<=0){
			$return['status']=0;
			$return['data']=$image->errormsg($status);
			@unlink($file['target']);
			jsonOutput($return);
		}
		$insert=array(
			'uid'=>$_B['uid'],
			'aid'=>0,
			'path'=>$file['imgurl'],
			'type'=>'article',
			'size'=>$image->imginfo['size'],
			'width'=>$image->imginfo['width'],
			'height'=>$image->imginfo['height'],
			'thumbH'=>$image->imginfo['thumbH'],
			'status'=>0,
			'dateline'=>TIMESTAMP,
		);
		$aid=J::t('image')->insert($insert,true);
		if(!is_numeric($aid) || $aid<=0){
			$return['status']=0;
			$return['data']='上传失败  0071';
			@unlink($file['target']);
			jsonOutput($return);
		}

		$return['status']=1;
		$return['data']['url']=$_B['siteurl'].$file['imgurl'].'.thumb.jpg';
		$return['data']['aid']=$aid;
		jsonOutput($return);
		break;
	case 'view':

	case 'new':
}


?>