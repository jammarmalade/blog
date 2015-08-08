<?php 

define('BLOG_ROOT', dirname(__FILE__));
define('CUR_T', 'admin');
require './source/jam_core.php';

$action=$_GET['action'];
$do=$_GET['do'];

//顶部导航栏
$topmenu=array(
	'setting'=>'全局设置',
	'tag'=>'标签设置',
	'stat'=>'查看统计',
);
//侧边栏 对应顶部导航的 key 
$sidemenu['setting']=array(
	'blog'=>'博客设置',
	'nav'=>'导航设置',
	'seo'=>'SEO设置',
);
$sidemenu['tag']=array(
	'list'=>'标签列表',
);

$actionarr=array_keys($topmenu);
if(!in_array($action,$actionarr)){
	$action='setting';
}

require BLOG_ROOT.'/admin/controler/'.$action.'.php';

?>