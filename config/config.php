<?php


$_config = array();

$_config['db']['1']['host'] = 'localhost';
$_config['db']['1']['user'] = 'root';
$_config['db']['1']['pw'] = '123456';
$_config['db']['1']['charset'] = 'utf8';
$_config['db']['1']['pconnect'] = '0';
$_config['db']['1']['dbname'] = 'blog';
$_config['db']['1']['tablepre'] = 'pre_';

$_config['output']['imagepath'] = 'asset/image/';//图片路径

$_config['cookie']['cookiepath'] = '/';
$_config['cookie']['cookiepre'] = 'jam_';
$_config['cookie']['cookiedomain'] = '';

$_config['security']['authkey'] = 'jamblog2015';
$_config['security']['attackevasive'] = '0';//防护大量正常请求造成的拒绝服务攻击(502)
?>