<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>后台管理</title>
    <link href="<?php echo CSSDIR;?>/bootstrap.css" rel="stylesheet">
	<link href="<?php echo CSSDIR;?>/admin.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="http://libs.useso.com/js/html5shiv/3.7/html5shiv.min.js"></script>
      <script src="http://libs.useso.com/js/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script src="<?php echo JSDIR;?>/jquery.min.js"></script>
    <script src="<?php echo JSDIR;?>/bootstrap.min.js"></script>
    <script src="<?php echo JSDIR;?>/autocomplete.min.js"></script>
	<script src="<?php echo JSDIR;?>/common.js"></script>
	<script src="<?php echo JSDIR;?>/admin.js"></script>
	<script src="<?php echo JSDIR;?>/lazyload.js"></script>
	<style type="text/css">

	</style>
  </head>
  <body class="bg1">


	  <div class="container mywidth">
		<div class="row bgrgba mynav">
			<div>
				<ul class="nav nav-pills">
				  <li role="presentation"><a href="<?php echo $_B['siteurl'];?>">首页</a></li>
				  <?php if(is_array($topmenu)) foreach($topmenu as $k => $v) { ?><li role="presentation" <?php echo $menu_active[$k];?>><a href="admin.php?action=<?php echo $k;?>"><?php echo $v;?></a></li>
				  <?php } ?>
				</ul>

			</div>
			
		</div>
		
	  </div>

	  <!-- sidebar -->

	  <div class="container">
		<div class="row" style="margin-top:10px;">
			<div class="col-md-2 text-center">
				<ul class="nav nav-pills nav-stacked"><?php if(is_array($sidemenu[$action])) foreach($sidemenu[$action] as $k => $v) { ?><li role="presentation" <?php echo $side_active[$k];?>><a href="admin.php?action=<?php echo $action;?>&do=<?php echo $k;?>"><?php echo $v;?></a></li>
					<?php } ?>
				</ul>
			</div>
			<!-- action page --><?php include display("$action",1);?></div>
	  </div>