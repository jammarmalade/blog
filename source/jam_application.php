<?php

if(!defined('BLOG')) {
	exit('Access Denied');
}

class jam_application {

	public $b=array();
	public $config=array();
	public $init_webed=false;//防止重复 初始化

	static function &instance() {
		static $obj;
		if(empty($obj)) {
			$obj = new self();
		}
		return $obj;
	}

	function __construct() {
		$this->_init_env();//初始化运行环境
		$this->_init_config();//初始化blog 配置/设置
		$this->_init_input();//初始化输入 get post addslashes
		$this->_init_output();//初始化输出 gzip attackevasive
	}
	function init_web(){
		if(!$this->init_webed) {
			$this->_init_user();//初始化用户
			$this->_init_setting();
		}
		$this->init_webed = true;
	}

	private function _init_env() {
		error_reporting(E_ERROR);
		define('MAGIC_QUOTES_GPC', function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc());// ' " \ NULL 等字符转义 当magic_quotes_gpc=On的时候，函数get_magic_quotes_gpc()就会返回1
		define('GZIP', function_exists('ob_gzhandler'));// ob 缓存压缩输出

		if(function_exists('date_default_timezone_set')) {
			@date_default_timezone_set('Etc/GMT-8');//东八区 北京时间
		}
		define('TIMESTAMP', time());
		if(!defined('BLOG_FUNCTION') && !@include(BLOG_ROOT.'/source/functions.php')) {
			exit('functions.php is missing');
		}
		define('IS_ROBOT', checkrobot());

		global $_B;
		$_B = array(
			'uid' => 0,
			'username' => '',
			'groupid' => 0,
			'timestamp' => TIMESTAMP,
			'clientip' => $this->_get_client_ip(),
			'mobile' => '',
			'agent' => '',
			'admin' => 0,
		);
		checkmobile();

		$_B['PHP_SELF'] = bhtmlspecialchars($this->_get_script_url());
		$_B['basefilename'] = basename($_B['PHP_SELF']);
		$sitepath = substr($_B['PHP_SELF'], 0, strrpos($_B['PHP_SELF'], '/'));
		$_B['siteurl'] = bhtmlspecialchars('http://'.$_SERVER['HTTP_HOST'].$sitepath.'/');
		getReferer();

		$url = parse_url($_B['siteurl']);
		$_B['siteroot'] = isset($url['path']) ? $url['path'] : '';
		$_B['siteport'] = empty($_SERVER['SERVER_PORT']) || $_SERVER['SERVER_PORT'] == '80' ? '' : ':'.$_SERVER['SERVER_PORT'];

		$this->b = & $_B;

	}
	private function _init_config() {
		$_config = array();
		@include BLOG_ROOT.'/config/config.php';
		if(empty($_config)) {
			jam_error::system_error('没有找到配置文件');
		}
		
		$this->config = & $_config;
		$this->b['config'] = & $_config;
		define('IMGDIR', $_config['output']['imagepath']);
		define('JSDIR', 'asset/js');
		define('CSSDIR', 'asset/css');
		define('CACHEDIR', 'data/cache');

		if(substr($_config['cookie']['cookiepath'], 0, 1) != '/') {
			$this->b['config']['cookie']['cookiepath'] = '/'.$this->b['config']['cookie']['cookiepath'];
		}
		$this->b['config']['cookie']['cookiepre'] = $this->b['config']['cookie']['cookiepre'].substr(md5($this->b['config']['cookie']['cookiepath'].'|'.$this->b['config']['cookie']['cookiedomain']), 0, 4).'_';
	}
	private function _init_input() {
		if (isset($_GET['GLOBALS']) || isset($_POST['GLOBALS']) ||  isset($_COOKIE['GLOBALS']) || isset($_FILES['GLOBALS'])) {
			jam_error::system_error('您当前的访问请求当中含有非法字符');
		}

		if(MAGIC_QUOTES_GPC) {
			$_GET = bstripslashes($_GET);
			$_POST = bstripslashes($_POST);
			$_COOKIE = bstripslashes($_COOKIE);
		}

		$prelength = strlen($this->config['cookie']['cookiepre']);
		foreach($_COOKIE as $key => $val) {//cookie 前缀相等说明是本站的cookie
			if(substr($key, 0, $prelength) == $this->config['cookie']['cookiepre']) {
				$this->b['cookie'][substr($key, $prelength)] = $val;
			}
		}

		if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {//合并 get 和 post数据好读取
			$_GET = array_merge($_GET, $_POST);
		}

		if(isset($_GET['page'])) {//若设置页数
			$_GET['page'] = rawurlencode($_GET['page']);
			//rawurlencode 空格是 '%20'，
			//urlencode 空格是 '+'
		}

		foreach($_GET as $k => $v) {
			$this->b[$k] = baddslashes($v);
		}

		$this->b['ajax'] = $_SERVER['REQUEST_METHOD']=='GET' && $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest' || $_SERVER['REQUEST_METHOD']=='POST' ? 1 : 0;
		$this->b['page'] = empty($_GET['page']) ? 1 : max(1, intval($_GET['page']));

	}
	private function _init_output() {
		if($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_SERVER['REQUEST_URI'])) {
			$this->_xss_check();
		}
		
		if($this->config['security']['attackevasive']) {
		//	防止大量访问
		}
		$this->config['output']['gzip']=true;//开启gzip压缩
		if(!empty($_SERVER['HTTP_ACCEPT_ENCODING']) && strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') === false) {
			$this->config['output']['gzip'] = false;//浏览器是否支持gzip
		}

		$allowgzip = $this->config['output']['gzip'] && empty($this->b['inajax']) && GZIP;
		$this->b['allowgzip'] = $allowgzip;//ajax 请求返回时会用到
		if(!ob_start($allowgzip ? 'ob_gzhandler' : null)) {//之前不能有输出
			ob_start();
		}

		@header('Content-Type: text/html; charset=utf-8');
	}

	//blog 设置
	private function _init_setting() {
		$cachepath = BLOG_ROOT.'/'.CACHEDIR.'/setting.txt';
		if($cache = cache($cachepath)){
			$this->b['setting']=$cache;
		}else{
			$setting=J::t('setting')->fetch_all();
			foreach($setting as $k=>$v){
				$this->b['setting'][$k]=json_decode($v['svalue'],true);
			}
			cache($cachepath,$this->b['setting']);
		}
	}
	//初始化用户信息
	private function _init_user() {

		$authuser=$this->b['cookie']['authuser'];
		if($authuser) {
			$authuser = baddslashes(explode("\t", authcode($authuser, 'DECODE')));
		}
		list($pwd, $uid) = empty($authuser) || count($authuser) < 2 ? array('', '') : $authuser;
		$uinfo=array();
		if($uid){
			$uinfo=getUser($uid);
		}
		if($uinfo && $pwd==$uinfo['password']){
			$this->b['uid']=$uinfo['uid'];
			$this->b['username']=$uinfo['username'];
			$this->b['groupid']=$uinfo['groupid'];
			if($uinfo['groupid']==1){
				$this->b['admin']=1;
			}
			$this->b['user']=$uinfo;
		}

	}
	//xss攻击检查
	private function _xss_check() {
		$temp = strtoupper(urldecode(urldecode($_SERVER['REQUEST_URI'])));
		if(strpos($temp, '<') !== false || strpos($temp, '"') !== false || strpos($temp, 'CONTENT-TRANSFER-ENCODING') !== false) {
			jam_error::system_error('您当前的访问请求当中含有非法字符');
		}
		return true;
	}

	//禁止蜘蛛
	function reject_robot() {
		if(IS_ROBOT) {
			exit(header("HTTP/1.1 403 Forbidden"));
		}
	}
	private function _get_client_ip() {
		$ip = $_SERVER['REMOTE_ADDR'];
		if (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
			foreach ($matches[0] as $xip) {
				if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
					$ip = $xip;
					break;
				}
			}
		}
		return $ip;
	}
	private function _get_script_url() {
		if(!isset($this->b['PHP_SELF'])){
			$scriptName = basename($_SERVER['SCRIPT_FILENAME']);
			if(basename($_SERVER['SCRIPT_NAME']) === $scriptName) {
				$this->b['PHP_SELF'] = $_SERVER['SCRIPT_NAME'];
			} else if(basename($_SERVER['PHP_SELF']) === $scriptName) {
				$this->b['PHP_SELF'] = $_SERVER['PHP_SELF'];
			} else if(isset($_SERVER['ORIG_SCRIPT_NAME']) && basename($_SERVER['ORIG_SCRIPT_NAME']) === $scriptName) {
				$this->b['PHP_SELF'] = $_SERVER['ORIG_SCRIPT_NAME'];
			} else if(($pos = strpos($_SERVER['PHP_SELF'],'/'.$scriptName)) !== false) {
				$this->b['PHP_SELF'] = substr($_SERVER['SCRIPT_NAME'],0,$pos).'/'.$scriptName;
			} else if(isset($_SERVER['DOCUMENT_ROOT']) && strpos($_SERVER['SCRIPT_FILENAME'],$_SERVER['DOCUMENT_ROOT']) === 0) {
				$this->b['PHP_SELF'] = str_replace('\\','/',str_replace($_SERVER['DOCUMENT_ROOT'],'',$_SERVER['SCRIPT_FILENAME']));
				$this->b['PHP_SELF'][0] != '/' && $this->b['PHP_SELF'] = '/'.$this->b['PHP_SELF'];
			} else {
				jam_error::system_error('request_tainting');
			}
		}

		return $this->b['PHP_SELF'];
	}
}


?>