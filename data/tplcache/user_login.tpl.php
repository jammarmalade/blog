<?php if(!$_B['ajax']) { include display('header',''); } ?>
	<div class="" id="login" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h3 class="modal-title" id="login"><span class="glyphicon glyphicon-user span-margin-right"></span> 欢迎登录</h3>
		  </div>
		  <div class="modal-body clearfix">
			<div class="hidden-xs col-sm-4 col-md-4">
				<img src="<?php echo IMGDIR;?>qq_connect_3.png" style="margin-bottom:10px;">
				<img src="<?php echo IMGDIR;?>sina_connect_3.png">
			</div>
			<div class="col-xs-12 col-sm-8 col-md-8" style="border-left:1px solid silver;">
				<input class="form-control" type="text" id="li_username" placeholder="昵称/邮箱" style="margin-bottom:10px;">
				<input class="form-control" type="password" id="li_pwd" placeholder="密码" style="margin-bottom:10px;">
				<div class="checkbox">
					<label>
					  <input type="checkbox" id="li_autologin">自动登录
					</label>
					<a href="index.php?m=user&do=reg" class="pull-right">注册本站 >>></a>
				</div>
				<div><span class="label label-danger" id="li_error"></span></div>
				<div class="visible-xs-block" style="border-top:1px solid silver;">
					<div class="col-xs-12" style="margin:20px auto;"><img src="<?php echo IMGDIR;?>qq_connect_4.png"></div>
					<div class="col-xs-12" style="margin-bottom:5px;"><img src="<?php echo IMGDIR;?>sina_connect_4.png"></div>
				</div>
			</div>
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			<button type="button" class="btn btn-primary" id="btn_login">登录</button>
		  </div>
		</div>
	  </div>
	</div>
<?php if(!$_B['ajax']) { include display('footer',''); } ?>