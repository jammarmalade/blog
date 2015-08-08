<div class="col-md-10 bgrgba jumbotron" style="padding:20px">
	<?php if($msg) { ?>
		<div class="alert alert-success" role="alert"><?php echo $msg;?></div>
	<?php } ?>

	<form class="form-horizontal" autocomplete="off" role="form" action="admin.php?action=setting&do=blog" id="settingFrom" name="settingFrom" method="post">
		<div class="form-group">
			<label for="blogname" class="col-sm-2 control-label">站点标题</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="blogName" name="settingnew[blogName]" value="<?php echo $blog['blogName'];?>">
			</div>
		</div>
		<div class="form-group">
			<label for="blogsubhead" class="col-sm-2 control-label">副标题</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="blogSubhead" name="settingnew[blogSubhead]" value="<?php echo $blog['blogSubhead'];?>">
			</div>
		</div>
		<div class="form-group">
			<label for="blogDescription" class="col-sm-2 control-label">站点描述</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="blogDescription" name="settingnew[blogDescription]" value="<?php echo $blog['blogDescription'];?>">
			</div>
		</div>
		<div class="form-group">
			<label for="adminEmail" class="col-sm-2 control-label">管理员邮箱</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="adminEmail" name="settingnew[adminEmail]" value="<?php echo $blog['adminEmail'];?>">
			</div>
		</div>
		<div class="form-group">
			<label for="icp" class="col-sm-2 control-label">ICP备案</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="icp" name="settingnew[icp]" value="<?php echo $blog['icp'];?>">
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" id="settingBlog" name="settingBlog" class="btn btn-default">提交</button>
			</div>
		</div>
	</form>

</div>