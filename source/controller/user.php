<?php

if(!defined('BLOG')) {
	exit('Access Denied');
}

$doarr=array('reg','login','check','logout');

if(!in_array($do,$doarr)){
	$do='reg';
}


switch($do){
	case 'reg':
		if($_B['uid']){//若是已登录的
			if(strpos($_B['referer'],'user') && strpos($_B['referer'],'reg')){
				bheader('location: '.$_B['siteurl']);
			}
			bheader('location: '.$_B['referer']);
		}
		$regbtn=$_GET['regbtn'];
		if($_B['ajax'] && $regbtn){
			$status=1;
			$data='';

			$username=trim($_GET['username']);
			$email=trim($_GET['email']);
			$pwd=trim($_GET['pwd']);
			$pwd2=trim($_GET['pwd2']);
			$autologin=trim($_GET['autologin']);
			
			if($pwd!=$pwd2){
				$status=2;
				$data['msg']='两次输入的密码不一致';
				$data['id']='pwd2';
			}
			if($status==1 && !check_username($username)){
				$status=2;
				$data['msg']='昵称包含敏感字符';
				$data['id']='username';
			}
			if($status==1 && !check_email($email)){
				$status=2;
				$data['msg']='Email 格式不对';
				$data['id']='email';
			}
			if($status==1 && J::t('users')->find_by_field('username',$username)){
				$status=2;
				$data['msg']='该昵称已被注册';
				$data['id']='username';
			}
			if($status==1 && J::t('users')->find_by_field('email',$email)){
				$status=2;
				$data['msg']='该 Email 已被注册';
				$data['id']='email';
			}
			if($status==1){//开始注册
				$salt=random(6);
				$md5pwd=md5($pwd);
				$realpwd=md5($md5pwd.$salt);
				$insert=array(
					'username' => $username,
					'password' => $realpwd,
					'email' => $email,
					'groupid' => 10,
					'regip' => $_B['clientip'],
					'regdate' => TIMESTAMP,
					'lastloginip' => $_B['clientip'],
					'lastlogintime' => TIMESTAMP,
					'salt' => $salt,
				);
				$uid=J::t('users')->register($insert);
				if($uid > 0){
					$insert['uid']=$uid;
					$cookietime=86400;
					if($autologin){
						$cookietime=2952000;
					}
					setloginstatus($insert,$cookietime);
					$data['msg']='注册成功';
				}else{
					$status=2;
					$data['msg']='注册失败，请刷新重试';
					$data['id']='error';
				}
			}
			jsonOutput($status,$data);
		}
		break;
	case 'login':
		if($_B['uid']){//若是已登录的
			jsonOutput(1);
		}
		if($_B['ajax'] && $_GET['loginbtn']){
			$username=trim($_GET['username']);
			$pwd=trim($_GET['pwd']);
			$autologin=trim($_GET['autologin']);
			if($username=='' || $pwd==''){
				jsonOutput(2,'用户名或密码不能为空');
			}
			//失败次数 登录错误在十分钟内 且大于等于5次
			if($failed=J::t('loginfailed')->fetch_ip($_B['clientip'])){
				if((TIMESTAMP - $failed['lastupdate']) < 600 && $failed['count']>=5){
					jsonOutput(2,'错误次数太多，请 10 分钟后再试';);
				}
			}
			if($uinfo=J::t('users')->login($username)){
				$pwd=md5(md5($pwd).$uinfo['salt']);
				if($uinfo['password'] != $pwd){
					if($failed){
						J::t('loginfailed')->update_by_pk(array('count'=>$failed['count']+1,'lastupdate'=>TIMESTAMP),$failed['ip']);
					}else{
						$insert=array(
							'ip'=>$_B['clientip'],
							'count'=>1,
							'lastupdate'=>TIMESTAMP,
						);
						J::t('loginfailed')->insert($insert);
					}
					jsonOutput(2,'用户名或密码错误');
				}else{
					$cookietime=86400;
					if($autologin){
						$cookietime=2952000;
					}
					setloginstatus($uinfo,$cookietime);
					jsonOutput(1);
				}
			}else{
				jsonOutput(2,'用户名或密码错误');
			}
			
		}
		break;
	case 'check':
		$status=1;
		$data='';
		if(empty($_GET['type']) || empty($_GET['data']) || !in_array(trim($_GET['type']),array('username','email'))){
			
		}else{
			$func=$_GET['type']=='username' ? 'check_username' : 'check_email';
			if(!$func($_GET['data'])){
				$status=2;
				$data['msg']= $_GET['type']=='username' ? '昵称包含敏感字符' :  'Email 格式不对';
			}
			if($status==1 && (J::t('users')->find_by_field($_GET['type'],$_GET['data']))){
				$status=2;
				$data['msg']=$_GET['type']=='username' ? '该昵称已被注册' :  '该 Email 已被注册';
			}
			$data['type']=$_GET['type'];
		}
		$data['val']=$_GET['data'];
		jsonOutput($status,$data);
		break;
	case 'logout':
		foreach($_B['cookie'] as $k => $v) {
			bsetcookie($k);
		}
		$_B['uid']= 0;
		$_B['username']= '';
		$_B['groupid']= '';
		$_B['user']= array();
		bheader('location: '.$_B['referer']);
		break;
}




$limit=10;
$start=$_B['page'] * $limit;

//$articles=J::t('article')->fetch_all($start,$limit);

include display('user_reg');
?>