<?php

if(!defined('BLOG')) {
	exit('Access Denied');
}

define('BLOG_FUNCTION', true);
//蜘蛛
function checkrobot($useragent = '') {
	static $kw_spiders = array('bot', 'crawl', 'spider' ,'slurp', 'sohu-search', 'lycos', 'robozilla');
	static $kw_browsers = array('msie', 'netscape', 'opera', 'konqueror', 'mozilla');

	$useragent = strtolower(empty($useragent) ? $_SERVER['HTTP_USER_AGENT'] : $useragent);
	if(strpos($useragent, 'http://') === false && astrpos($useragent, $kw_browsers)) return false;
	if(astrpos($useragent, $kw_spiders)) return true;
	return false;
}
//strpos 支持数组
function astrpos($string, &$arr) {
	if(empty($string)) return false;
	foreach((array)$arr as $v) {
		if(strpos($string, $v) !== false) {
			return $v;
		}
	}
	return false;
}
//转义html实体 支持数组
function bhtmlspecialchars($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = bhtmlspecialchars($val);
		}
	} else {
		$string = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string);
		if(strpos($string, '&amp;#') !== false) {
			$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1', $string);//类似&#38889的unicode
		}
	}
	return $string;
}
//特殊字符 去除反斜杠
function bstripslashes($string) {
	if(empty($string)) return $string;
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = bstripslashes($val);
		}
	} else {
		$string = stripslashes($string);
	}
	return $string;
}
//特殊字符 增加反斜杠
function baddslashes($string) {
	if(is_array($string)) {
		$keys = array_keys($string);
		foreach($keys as $key) {
			$val = $string[$key];
			unset($string[$key]);
			$string[addslashes($key)] = baddslashes($val);
		}
	} else {
		$string = addslashes($string);
	}
	return $string;
}
//随机数 长度 ，纯数字
function random($length, $numeric = 0) {
	$seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
	if($numeric) {
		$hash = '';
	} else {
		$hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);
		$length--;
	}
	$max = strlen($seed) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $seed{mt_rand(0, $max)};
	}
	return $hash;
}
//设置cookie
function bsetcookie($var, $value = '', $life = 0) {
	global $_B;
	$config = $_B['config']['cookie'];
	$life = $life > 0 ? TIMESTAMP + $life : ($life < 0 ? TIMESTAMP - 600 : 0);
	$path = $config['cookiepath'];
	$var=$config['cookiepre'].$var;
	setcookie($var, $value, $life, $path, $config['cookiedomain']);
}
function getcookie($var){
	global $_B;
	$config = $_B['config']['cookie'];
	$var=$config['cookiepre'].$var;
	return $_COOKIE[$var];
}
//获取数据库缓存
function loadcache($cachenames) {
	global $_B;
	static $loaded = array();
	$cachenames = is_array($cachenames) ? $cachenames : array($cachenames);
	$caches = array();
	foreach ($cachenames as $k) {//若加载过，就不再加载
		if(!isset($loaded[$k])) {
			$caches[] = $k;
			$loaded[$k] = true;
		}
	}
	if(!empty($caches)) {
		$cachedata = C::t('users')->fetch_all($caches);
		foreach($cachedata as $cname => $data) {
				$_B[$cname] = $data;
		}
	}
	return true;
}

//引入模版
function display($tname,$admin=0,$return=false,$data=array()){
	require_once 'jam_template.php';
	$template = new template();
	if($admin){
		$tplpath=BLOG_ROOT.'/admin/'.$tname.'.htm';
		$tplcachepath=BLOG_ROOT.'/data/tplcache/admin/'.$tname.'.tpl.php';
	}else{
		$tplpath=BLOG_ROOT.'/theme/'.$tname.'.htm';
		$tplcachepath=BLOG_ROOT.'/data/tplcache/'.$tname.'.tpl.php';
	}
	$viewFile = $template->display($tname,$tplpath,$tplcachepath);
	if($return){
		extract($data);
		if(!ob_start($_B['allowgzip'] ? 'ob_gzhandler' : null)) {
			ob_start();
		}
		ob_implicit_flush(false);//缓存输出，不flush到浏览器
		require($viewFile);
		return ob_get_clean();
	}else{
		return $viewFile;
	}
}

//是否是手机
function checkmobile() {
	global $_B;
	$mobile = array();
	static $touchbrowser_list =array('iphone', 'android', 'phone', 'mobile', 'wap', 'netfront', 'java', 'opera mobi', 'opera mini',
				'ucweb', 'windows ce', 'symbian', 'series', 'webos', 'sony', 'blackberry', 'dopod', 'nokia', 'samsung',
				'palmsource', 'xda', 'pieplus', 'meizu', 'midp', 'cldc', 'motorola', 'foma', 'docomo', 'up.browser',
				'up.link', 'blazer', 'helio', 'hosin', 'huawei', 'novarra', 'coolpad', 'webos', 'techfaith', 'palmsource',
				'alcatel', 'amoi', 'ktouch', 'nexian', 'ericsson', 'philips', 'sagem', 'wellcom', 'bunjalloo', 'maui', 'smartphone',
				'iemobile', 'spice', 'bird', 'zte-', 'longcos', 'pantech', 'gionee', 'portalmmm', 'jig browser', 'hiptop',
				'benq', 'haier', '^lct', '320x320', '240x320', '176x220');
	static $mobilebrowser_list =array('windows phone');
	static $wmlbrowser_list = array('cect', 'compal', 'ctl', 'lg', 'nec', 'tcl', 'alcatel', 'ericsson', 'bird', 'daxian', 'dbtel', 'eastcom',
			'pantech', 'dopod', 'philips', 'haier', 'konka', 'kejian', 'lenovo', 'benq', 'mot', 'soutec', 'nokia', 'sagem', 'sgh',
			'sed', 'capitel', 'panasonic', 'sonyericsson', 'sharp', 'amoi', 'panda', 'zte');

	$pad_list = array('ipad');

	$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);

	if(astrpos($useragent, $pad_list)) {
		return false;
	}
	if(($v = astrpos($useragent, $mobilebrowser_list))){
		$_B['mobile'] = $v;
		return '1';
	}
	if(($v = astrpos($useragent, $touchbrowser_list))){
		$_B['mobile'] = $v;
		return '2';
	}
	if(($v = astrpos($useragent, $wmlbrowser_list))) {
		$_B['mobile'] = $v;
		return '3';
	}
	$brower = array('mozilla', 'chrome', 'safari', 'opera', 'm3gate', 'winwap', 'openwave', 'myop');
	if(($v = astrpos($useragent, $brower))) {
		$_B['agent'] = $v;
	}
	$_B['mobile'] = 'unknown';
}

//输出json
function jsonOutput($status,$res=''){
//	header("Content-type:application/json;charset=UTF-8");
	$return['status']=$status;
	$return['data']=$res;
	echo json_encode($return,JSON_UNESCAPED_UNICODE);
	exit(); 
}

function fput($data,$isarr=0){
	if($isarr){
		file_put_contents(BLOG_ROOT.'/log.log',var_export($data,true).PHP_EOL,FILE_APPEND);
	}else{
		file_put_contents(BLOG_ROOT.'/log.log',$data.PHP_EOL,FILE_APPEND);
	}
}
//验证用户名
function check_username($username){
	$guestexp = '\xA1\xA1|\xAC\xA3|^Guest|^\xD3\xCE\xBF\xCD|\xB9\x43\xAB\xC8';
	$len = strlen($username);
	if($len > 15 || $len < 3 || preg_match("/\s+|^c:\\con\\con|[%,\*\"\s\<\>\&]|$guestexp/is", $username)) {
		return false;
	} else {
		return true;
	}
}
//验证邮箱
function check_email($email){
	return strlen($email) > 6 && strlen($email) <= 32 && preg_match("/^([a-z0-9\-_.+]+)@([a-z0-9\-]+[.][a-z0-9\-.]+)$/", $email);
}
//设置登录状态
function setloginstatus($user, $cookietime) {
	global $_B;
	$_B['uid'] = intval($user['uid']);
	$_B['username'] = $user['username'];
	$_B['groupid'] = $user['groupid'];
	$_B['user'] = $user;
	bsetcookie('authuser', authcode("{$user['password']}\t{$user['uid']}", 'ENCODE'), $cookietime);
}
//加密 解密
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	global $_B;
	$ckey_length = 4;
	$key = md5($key != '' ? $key : $_B['config']['security']['authkey']);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}

//获取跳转来源
function getReferer(){
	global $_B;
	$referer = $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : $_B['siteurl'];
	$_B['referer'] = substr($referer, -1) == '?' ? substr($referer, 0, -1) : $referer;
}
//获取用户信息
function getUser($uid){
	static $users = array();
	if(empty($users[$uid])) {
		$users[$uid]=J::t('users')->find_by_pk($uid);
	}
	return $users[$uid];
}
//php 跳转 $replace【指示该报头是否替换之前的报头，或添加第二个报头】  http_response_code【把 HTTP 响应代码强制为指定的值。（PHP 4 以及更高版本可用）】
function bheader($string, $replace = true, $http_response_code = 0) {
	$islocation = substr(strtolower(trim($string)), 0, 8) == 'location';
	$string = str_replace(array("\r", "\n"), array('', ''), $string);
	if(empty($http_response_code) || PHP_VERSION < '4.3' ) {
		@header($string, $replace);
	} else {
		@header($string, $replace, $http_response_code);
	}
	if($islocation) {
		exit();
	}
}

function getSetting($type,$name=''){
	global $_B;
	if($name){
		echo $_B['setting'][$type][$name];
	}else{
		return $_B['setting'][$type];
	}
}
function btime($time,$ago='',$format=''){
	if($ago){
		$dur = TIMESTAMP - $time;  
		if ($dur < 0) {  
			return date('Y-m-d H:i:s',$time); 
		} else {
			if ($dur < 60) {  
				return $dur . ' 秒前';  
			} else {
				if ($dur < 3600) {  
					return floor($dur / 60) . ' 分钟前';  
				} else {
					if ($dur < 86400) {  
						return floor($dur / 3600) . ' 小时前';  
					} else {
						if ($dur < 604800) {
							$day = floor($dur / 86400);
							if($day==1){
								return '昨天 '.date('H:i',$time);
							}elseif($day==2){
								return '前天 '.date('H:i',$time);
							}else{
								return $day . ' 天前';  
							}
						} else {
							return date('n-j H:i',$time);
						}
					}
				}
			}
		}
	}else{
		return date($format ? $format :('Y-m-d H:i:s'),$time);
	}
}

function page($count,$page,$limit,$link,$showpage=10){
	$html = '';
	$middlepage = ceil($showpage / 2);
	$tmp='?';
	if(strpos($link, '?')){
		$tmp='&';
	}
	$countpage = ceil($count / $limit);
	if ($page <= 1) {
		if($page==$countpage){
			return '';
		}
		$head = '<li><a href="#">上一页</a></li>';
	} else {
		$head = '<li><a href="' . $link . $tmp.'page=' . ($page - 1) . '">上一页</a></li>';
	}
	if ($page >= $countpage) {
		$end = '<li><a href="#">下一页</a></li>';
	} else {
		$end = '<li><a href="' . $link . $tmp.'page=' . ($page + 1) . '">下一页</a></li>';
	}
	$predot = $enddot = '';
	if ($page - $middlepage <= 1) {
		$from = 1;
	} else {
		$predot = '...';
		$from = $page - $middlepage;
	}
	if (($from + $showpage) >= $countpage) {
		$to = $countpage;
		$from = $to - $showpage;
		if($from <= 0){
			$from = 1;
		}
	} else {
		$enddot = '...';
		$to = $from + $showpage;
	}
	if($from==1){
		$predot='';
	}
	if($from==$countpage){
		$enddot='';
	}
	$html.='<nav><ul class="pagination" style="float:right;">';
	$html.=$head;
	if ($predot) {
		$html.='<li><a href="#">' . $predot . '</a></li>';
	}
	for ($i = $from; $i <= $to; $i++) {
		if ($i == $page) {
			$html.='<li class="active"><a href="#">' . $i . '</a></li>';
		} else {
			$html.='<li><a href="' . $link . $tmp.'page=' . $i . '">' . $i . '</a></li>';
		}
	}
	if ($enddot) {
		$html.='<li><a href="#">' . $enddot . '</a></li>';
	}
	$html.=$end;
	$html.='</ul></nav>';
	return $html;
/*
	$html='';
	if($page<=1){
		$head='<li class="disabled"><a href="#">&laquo;</a></li>';
	}else{
		$head='<li><a href="'.$link.'&page='.($page-1).'">&laquo;</a></li>';
	}
	$countpage=ceil($count/$limit);
	if($page>=$countpage){
		$end='<li class="disabled"><a href="#">&raquo;</a></li>';
	}else{
		$end='<li><a href="'.$link.'&page='.($page+1).'">&raquo;</a></li>';
	}
	$predot=$enddot='';
	if($page-2<=0){
		$from=1;
	}else{
		$predot='...';
		$from=$page-2;
	}
	if(($from+4)>=$countpage){
		$to=$countpage;
	}else{
		$enddot='...';
		$to=$from+4;
	}

	$html.='<nav><ul class="pagination" style="float:right;">';
	$html.=$head;
	if($predot){
		$html.='<li><span>'.$predot.'</span></li>';
	}
	for($i=$from;$i<=$to;$i++){
		if($i==$page){
			$html.='<li class="active"><span>'.$i.'</span></li>';
		}else{
			$html.='<li><a href="'.$link.'&page='.$i.'">'.$i.'</a></li>';
		}
	}
	if($enddot){
		$html.='<li><span>'.$enddot.'</span></li>';
	}
	$html.=$end;
	$html.='</ul></nav>';
	return $html;
	*/
}
//二维数组排序，指定key值
function multi_array_sort($multi_array, $sort_key, $sort = SORT_ASC) {
	if (is_array($multi_array)) {
		foreach ($multi_array as $row_array) {
			if (is_array($row_array)) {
				$key_array[] = $row_array[$sort_key];
			} else {
				return false;
			}
		}
	} else {
		return false;
	}
	array_multisort($key_array, $sort, $multi_array);
	return $multi_array;
}
//截取字符串
function cutstr($string, $length, $dot = ' ...') {
	if(strlen($string) <= $length) {
		return $string;
	}
	$pre = chr(1);
	$end = chr(1);
	$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array($pre.'&'.$end, $pre.'"'.$end, $pre.'<'.$end, $pre.'>'.$end), $string);
	$strcut = '';
	$n = $tn = $noc = 0;
	while($n < strlen($string)) {
		$t = ord($string[$n]);
		if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
			$tn = 1; $n++; $noc++;
		} elseif(194 <= $t && $t <= 223) {
			$tn = 2; $n += 2; $noc += 2;
		} elseif(224 <= $t && $t <= 239) {
			$tn = 3; $n += 3; $noc += 2;
		} elseif(240 <= $t && $t <= 247) {
			$tn = 4; $n += 4; $noc += 2;
		} elseif(248 <= $t && $t <= 251) {
			$tn = 5; $n += 5; $noc += 2;
		} elseif($t == 252 || $t == 253) {
			$tn = 6; $n += 6; $noc += 2;
		} else {
			$n++;
		}
		if($noc >= $length) {
			break;
		}
	}
	if($noc > $length) {
		$n -= $tn;
	}
	$strcut = substr($string, 0, $n);
	$strcut = str_replace(array($pre.'&'.$end, $pre.'"'.$end, $pre.'<'.$end, $pre.'>'.$end), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);
	$pos = strrpos($strcut, chr(1));
	if($pos !== false) {
		$strcut = substr($strcut,0,$pos);
	}
	return $strcut.$dot;
}
//引入 function
function libfile($funname){
	$filepath=BLOG_ROOT.'/source/function/function_'.$funname.'.php';
	return realpath($filepath);
}
//获取/存入缓存
function cache($path,$data=''){
	if($data){
		if($fp = fopen($path, 'w')) {
			flock($fp, 2);
			fwrite($fp, json_encode($data));
			fclose($fp);
		}
	}else{
		if(file_exists($path)){
			$cache = json_decode(file_get_contents($path),true);
			if($cache){
				return $cache;
			}else{
				return '';
			}
		}
	}
}
//错误提示
function shownotice($msg,$ext=array()){
	global $_B;
	include display('shownotice');
	exit();
}
//登录检查
function checkLogin($msg=''){
	global $_B;
	if(!$_B['uid']){
		if($_B['ajax']){
			jsonOutput(2,'login');
		}else{
			$msg = $msg =='' ? '请先登录' : $msg;
			$_B['navtitle'] = '提示 - '.$msg;
			shownotice($msg,array('referer'=>$_B['referer']));
		}
	}
	return true;
}
//引入js和css,压缩和未压缩
//$page 对应页面/或标识
function includeJSCSS($page='all'){
	
	$asset=array();
	//-----------头部引入 all
	//js jquery2.1
	$asset['all']['js'][]=array(
		'debug' => JSDIR.'/jquery.min.js',	//测试
		'online' => JSDIR.'/jquery.min.js',	//线上
	);
	//jq 1.9 之后废弃了一些api,导致一些老的插件不能用,此文件就是解决这个问题的
	$asset['all']['js'][]=array(
		'debug' => JSDIR.'/jquery-migrate-1.2.1.min.js',
		'online' => JSDIR.'/jquery-migrate-1.2.1.min.js',
	);
	$asset['all']['js'][]=array(
		'debug' => JSDIR.'/bootstrap.min.js',
		'online' => JSDIR.'/bootstrap.min.js',
	);
	$asset['all']['js'][]=array(
		'debug' => JSDIR.'/lazyload.js',
		'online' => JSDIR.'/lazyload.min.js',
	);
	$asset['all']['js'][]=array(
		'debug' => JSDIR.'/autocomplete.js',
		'online' => JSDIR.'/autocomplete.min.js',
	);
	$asset['all']['js'][]=array(
		'debug' => JSDIR.'/common.js',
		'online' => JSDIR.'/common.min.js',
	);
	//弹出层插件
	$asset['all']['js'][]=array(
		'debug' => 'asset/layer/layer.js',
		'online' => 'asset/layer/layer.js',
	);
	//css 
	$asset['all']['css'][]=array(
		'debug' => CSSDIR.'/bootstrap.css',
		'online' => CSSDIR.'/bootstrap.min.css',
	);
	$asset['all']['css'][]=array(
		'debug' => CSSDIR.'/common.css',
		'online' => CSSDIR.'/common.min.css',
	);

	//------添加文章编辑器 articleNew
	//js
	$asset['articleNew']['js'][]=array(
		'debug' => JSDIR.'/summernote.js',
		'online' => JSDIR.'/summernote.min.js',
	);
	$asset['articleNew']['js'][]=array(
		'debug' => JSDIR.'/summernote-zh-CN.js',
		'online' => JSDIR.'/summernote-zh-CN.min.js',
	);
	$asset['articleNew']['js'][]=array(
		'debug' => JSDIR.'/article-new.js',
		'online' => JSDIR.'/article-new.min.js',
	);
	//css
	$asset['articleNew']['css'][]=array(
		'debug' => CSSDIR.'/font-awesome.min.css',
		'online' => CSSDIR.'/font-awesome.min.css',
	);
	$asset['articleNew']['css'][]=array(
		'debug' => CSSDIR.'/summernote.min.css',
		'online' => CSSDIR.'/summernote.min.css',
	);
	//-------简单(ubb)编辑器 editor
	$asset['editor']['js'][]=array(
		'debug' => JSDIR.'/editor.js',
		'online' => JSDIR.'/editor.min.js',
	);
	//--------右侧电子时钟
	//js
	$asset['clock']['js'][]=array(
		'debug' => JSDIR.'/clock/moment.min.js',
		'online' => JSDIR.'/clock/moment.min.js',
	);
	$asset['clock']['js'][]=array(
		'debug' => JSDIR.'/clock/script.js',
		'online' => JSDIR.'/clock/script.min.js',
	);
	$asset['clock']['js'][]=array(
		'debug' => JSDIR.'/clock/html5.js',
		'online' => JSDIR.'/clock/html5.min.js',
	);
	//css
	$asset['clock']['css'][]=array(
		'debug' => CSSDIR.'/clock.css',
		'online' => CSSDIR.'/clock.min.css',
	);
	//--------代码高亮
	//js
	$asset['code']['js'][]=array(
		'debug' => JSDIR.'/code/shbrush.js',
		'online' => JSDIR.'/code/shbrush.js',
	);
	//css
	$asset['code']['css'][]=array(
		'debug' => CSSDIR.'/code/shcore.css',
		'online' => CSSDIR.'/code/shcore.css',
	);
	$asset['code']['css'][]=array(
		'debug' => CSSDIR.'/code/shthemedefault.css',
		'online' => CSSDIR.'/code/shthemedefault.css',
	);

	$tmp = $asset[$page];
	$csses = $tmp['css'];
	$jses = $tmp['js'];
	$html= '';
	foreach($csses as $cssLinks){
		if(BLOG_DEBUG){
			$_tmpLink = $cssLinks['debug'];
		}else{
			$_tmpLink = $cssLinks['online'];
		}
		echo '<link rel="stylesheet" type="text/css" href="' . $_tmpLink . '" />' . PHP_EOL;
	}
	foreach($jses as $jsLinks){
		if(BLOG_DEBUG){
			$_tmpLink = $jsLinks['debug'];
		}else{
			$_tmpLink = $jsLinks['online'];
		}
		echo '<script src="'.$_tmpLink.'" type="text/javascript"></script>' . PHP_EOL;
	}
}

?>