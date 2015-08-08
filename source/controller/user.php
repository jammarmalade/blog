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
			$return['status']=1;
			$return['data']='';

			$username=trim($_GET['username']);
			$email=trim($_GET['email']);
			$pwd=trim($_GET['pwd']);
			$pwd2=trim($_GET['pwd2']);
			$autologin=trim($_GET['autologin']);
			
			if($pwd!=$pwd2){
				$return['status']=2;
				$return['data']['msg']='两次输入的密码不一致';
				$return['data']['id']='pwd2';
			}
			if($return['status']==1 && !check_username($username)){
				$return['status']=2;
				$return['data']['msg']='昵称包含敏感字符';
				$return['data']['id']='username';
			}
			if($return['status']==1 && !check_email($email)){
				$return['status']=2;
				$return['data']['msg']='Email 格式不对';
				$return['data']['id']='email';
			}
			if($return['status']==1 && J::t('users')->find_by_field('username',$username)){
				$return['status']=2;
				$return['data']['msg']='该昵称已被注册';
				$return['data']['id']='username';
			}
			if($return['status']==1 && J::t('users')->find_by_field('email',$email)){
				$return['status']=2;
				$return['data']['msg']='该 Email 已被注册';
				$return['data']['id']='email';
			}
			if($return['status']==1){//开始注册
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
					$return['data']['msg']='注册成功';
				}else{
					$return['status']=2;
					$return['data']['msg']='注册失败，请刷新重试';
					$return['data']['id']='error';
				}
			}
			jsonOutput($return);
		}
		break;
	case 'login':
		$return['status']=1;
		$return['data']='';
		if($_B['uid']){//若是已登录的
			jsonOutput($return);
		}
		if($_B['ajax'] && $_GET['loginbtn']){
			$username=trim($_GET['username']);
			$pwd=trim($_GET['pwd']);
			$autologin=trim($_GET['autologin']);
			if($username=='' || $pwd==''){
				$return['status']=2;
				$return['data']='用户名或密码不能为空';
				jsonOutput($return);
			}
			//失败次数 登录错误在十分钟内 且大于等于5次
			if($failed=J::t('loginfailed')->fetch_ip($_B['clientip'])){
				if((TIMESTAMP - $failed['lastupdate']) < 600 && $failed['count']>=5){
					$return['status']=2;
					$return['data']='错误次数太多，请 10 分钟后再试';
					jsonOutput($return);
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
					$return['status']=2;
					$return['data']='用户名或密码错误';
					jsonOutput($return);
				}else{
					$cookietime=86400;
					if($autologin){
						$cookietime=2952000;
					}
					setloginstatus($uinfo,$cookietime);
					jsonOutput($return);
				}
			}else{
				$return['status']=2;
				$return['data']='用户名或密码错误';
				jsonOutput($return);
			}
			
		}
		break;
	case 'check':
		$return['status']=1;
		$return['data']='';
		if(empty($_GET['type']) || empty($_GET['data']) || !in_array(trim($_GET['type']),array('username','email'))){
			
		}else{
			$func=$_GET['type']=='username' ? 'check_username' : 'check_email';
			if(!$func($_GET['data'])){
				$return['status']=2;
				$return['data']['msg']= $_GET['type']=='username' ? '昵称包含敏感字符' :  'Email 格式不对';
			}
			if($return['status']==1 && (J::t('users')->find_by_field($_GET['type'],$_GET['data']))){
				$return['status']=2;
				$return['data']['msg']=$_GET['type']=='username' ? '该昵称已被注册' :  '该 Email 已被注册';
			}
			$return['data']['type']=$_GET['type'];
		}
		$return['data']['val']=$_GET['data'];
		jsonOutput($return);
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