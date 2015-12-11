<?php


if(!defined('BLOG')) {
	exit('Access Denied');
}

class jam_error
{
	public static function exception_error($exception) {
		global $_B;
		$msg='code : '.$exception->getCode().'<br>message : '.$exception->getMessage();
		$msg.='<br><br><div>SQL : '.$exception->getSql().'</div>';
		
		$debug_trace=$exception->getTrace();
		krsort($debug_trace);
		foreach($debug_trace as $k=>$error){
			$fun=$error['function'];
			if($error['class']){
				$fun=$error['class'].$error['type'].$error['function'];
			}
			$extend.='<span style="width:500px;">file: '.$error['file'].'</span>';
			$extend.='<span style="width:100px;">line: '.$error['line'].'</span>';
			$extend.='<span>function: '.$fun.'</span><br>';
		}
		//错误日志
		$file = BLOG_ROOT.'/data/log/dberror_'.date('Ymd',TIMESTAMP).'.log';
		if($fp = @fopen($file, 'a+')){
			$logmsg=date('Ymd-H:i:s').' [-] '.$_B['uid'].' [-] '.$_B['clientip'].' [-] '.$exception->getCode().' [-] '.$exception->getMessage().PHP_EOL;
			@fwrite($fp, $logmsg);
		}
		if($_B['ajax'] && $exception->getSql()){
			jsonOutput(2,$exception->getSql());
		}
		self::system_error($msg,'db',$extend);
	}

	public static function system_error($msg,$type='',$extend='') {

		echo <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>系统错误 Error</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="ROBOTS" content="NOINDEX,NOFOLLOW,NOARCHIVE" />
	<style type="text/css">
	.alert {
	  padding: 15px;
	  margin-bottom: 20px;
	  border: 1px solid transparent;
	  border-radius: 4px;
	}
	.alert-danger {
	  color: #a94442;
	  background-color: #f2dede;
	  border-color: #ebccd1;
	}
	.alert-warning{
	  color: #a94442;
	  background-color: #fcf8e3;
	  border-color: #ebccd1;
	}
	.alert-danger div{
	  font-weight:bold;
	  padding:5px 5px;
	  color: #fff;
	  background-color:#FF6464
	}
	.alert-warning span{
	  display:inline-block;
	}
	</style>
</head>
<body>
<div id="container">
<h2>系统错误 Error</h2>
	<div class='alert alert-danger'>$msg</div>
EOT;
if($extend){
	echo "<div class='alert alert-warning'>$extend</div>";
}
echo <<<EOT
</body>
</html>
EOT;
		exit();
	}

}