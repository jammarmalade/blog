<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php if($navtitle) { ?><?php echo $navtitle;?><?php } else { ?><?php echo $_B['setting']['blog']['blogName'];?><?php } ?></title>
	<meta name="keywords" content="">
	<meta name="description" content="<?php echo $_B['setting']['blog']['blogName'];?>-->">
    <link href="<?php echo CSSDIR;?>/bootstrap.css" rel="stylesheet">
	<link href="<?php echo CSSDIR;?>/common.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="http://libs.useso.com/js/html5shiv/3.7/html5shiv.min.js"></script>
      <script src="http://libs.useso.com/js/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script src="<?php echo JSDIR;?>/jquery.min.js"></script>
    <script src="<?php echo JSDIR;?>/bootstrap.min.js"></script>
	<script src="<?php echo JSDIR;?>/lazyload.js"></script>
	<script src="<?php echo JSDIR;?>/common.js"></script>
  </head>
  <body>

    <div class="container page-header">
	  <h2><?php echo $_B['setting']['blog']['blogName'];?><small style="margin-left:10px;"><?php echo $_B['setting']['blog']['blogSubhead'];?></small></h2>
	</div>
    <nav class="navbar navbar-inverse navbar-fixed-top bgrgba" role="navigation">
	  <div class="container">
		<div class="navbar-header">
		  <a class="navbar-brand active" href="<?php echo $_B['siteurl'];?>">首页</a>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		  <ul class="nav navbar-nav"><?php if(is_array(getSetting('nav'))) foreach(getSetting('nav') as $k => $v) { if($v['status']!=0) { ?>
					<?php if(isset($v['downnav']) && count($v['downnav'])) { ?>
						<li class="dropdown">
							<a href="<?php echo $v['link'];?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $v['name'];?><span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu"><?php if(is_array($v['downnav'])) foreach($v['downnav'] as $ck => $cv) { if($v['status']!=0) { ?>
										<li><a href="<?php echo $cv['link'];?>"><?php echo $cv['name'];?></a></li>
									<?php } ?>
								<?php } ?>
							</ul>
						</li>
					<?php } else { ?>
						<li><a href="<?php echo $v['link'];?>"><b><?php echo $v['name'];?></b></a></li>
					<?php } ?>
				<?php } ?>
			<?php } ?>
		  </ul>
		  <ul class="nav navbar-nav navbar-right">
		  <?php if($_B['uid']) { ?>
			<li>
				<a href="#" class=""><span class="glyphicon glyphicon-bell span-margin-left"></span>
				<?php if($_B['user']['notice']) { ?>
					<span class="badge span-margin-left msg-color brs"><?php echo $_B['user']['notice'];?></span>
				<?php } else { ?>
					提醒
				<?php } ?>
				</a>
			</li>
			<li>
				<a href="#"><span class="glyphicon glyphicon-envelope span-margin-left"></span>
					<span class="badge span-margin-left msg-color">
					<?php if($_B['user']['pm']) { ?>
						<?php echo $_B['user']['pm'];?>
					<?php } ?>
					</span>
				</a>
			</li>
			<li class="dropdown">
			  <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $_B['username'];?><span class="caret"></span></a>
			  <ul class="dropdown-menu" role="menu">
				<li><a href="index.php?m=article&do=new" target="_blank">写文章</a></li>
				<li class="divider"></li>
				<li><a href="admin.php" target="_blank" target="_blank">后台管理</a></li>
				<li><a href="index.php?m=user&do=logout">退出 <span class="glyphicon glyphicon-log-out span-margin-left"></span> </a></li>
			  </ul>
			</li>
		  <?php } else { ?>
		    <li><a href="#" data-toggle="modal" data-target="#login"><span class="glyphicon glyphicon-user"></span> 登录</a></li>
			<li><a href="index.php?m=user&do=reg"><span class="glyphicon glyphicon-piggy-bank"></span> 注册</a></li>
		  <?php } ?>
		  </ul>
		</div>
	  </div>
	</nav>