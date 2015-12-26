<?php if(!$_B['ajax']) { include display('header',''); ?><div class="container clearfix">
<?php } ?>
	
	<div class="center-block" style="width:300px;<?php if($_B['ajax']) { ?>margin:20px;<?php } ?>">
		<input class="form-control" type="text" id="li_username" placeholder="昵称/邮箱" style="margin-bottom:10px;">
		<input class="form-control" type="password" id="li_pwd" placeholder="密码" style="margin-bottom:10px;">
		<div class="checkbox">
			<label>
			  <input type="checkbox" id="li_autologin">自动登录
			</label>
			<a href="index.php?m=user&do=reg" class="pull-right">注册本站 >>></a>
		</div>
		<div><span class="label label-danger" id="li_error"></span></div>
	</div>

<?php if(!$_B['ajax']) { ?>
</div><?php include display('footer',''); } ?>