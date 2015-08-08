<?php include display('header',''); ?><div class="container shownotice alert alert-warning" role="alert">
		<p class="text-center"><span style="font-size:16px;"><?php echo $msg;?></span></p>
		<p class="text-center"><a href="<?php echo $ext['referer'];?>">返回上一级</a></p>
	</div><?php include display('footer',''); ?>