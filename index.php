<?php 


define('BLOG_ROOT', dirname(__FILE__));
define('CUR_T', 'index');
require './source/jam_core.php';

$m=$_GET['m'];
$do=$_GET['do'];
$marr=array('article','user','upload','comment');
if(!in_array($m,$marr)){
	$m='article';
}

require BLOG_ROOT.'/source/controller/'.$m.'.php';

?>