<?php

if(!defined('BLOG')) {
	exit('Access Denied');
}


$do=!empty($_GET['do']) ? $_GET['do'] : '';

$doarr=array('article-new');
if(!in_array($do,$doarr)){
	jsonOutput(2,'不允许的操作');
}

$upload=new class_upload();

switch($do){
	case 'article-new':
		if(!$_B['uid']){
			jsonOutput(2,'login');
		}
		$upload->init($_FILES['file'],'article','data/attachment');
		$file=&$upload->file;
		
		if(!$file['isimage']){
			jsonOutput(2,'请上传图片附件  0027');
		}
		if($file['size'] > 2097152){//2M
			jsonOutput(2,'请上传小余 2M 的图片  0032');
		}
		$upload->save($file['tmp_name'],$file['target']);
		$errorcode=$upload->error();
		if($errorcode<0){
			$data=$upload->errormsg();
			@unlink($file['target']);
			jsonOutput(2,$data);
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
			$data=$image->errormsg($status);
			@unlink($file['target']);
			jsonOutput(2,$data);
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
			@unlink($file['target']);
			jsonOutput(2,'上传失败  0071');
		}

		$data['url']=$_B['siteurl'].$file['imgurl'].'.thumb.jpg';
		$data['aid']=$aid;
		jsonOutput(1,$data);
		break;
	case 'view':

	case 'new':
}


?>