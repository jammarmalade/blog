<?php if($do=='blog') { ?>

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
<?php } elseif($do=='nav') { ?>
	
<div class="row bgrgba-all col-md-10">
	<div class="panel bgrgba panel-default">
		<div class="panel-heading bgrgba">管理导航<span class="pull-right">修改后请：<a href="javascript:;" class="cache-nav">缓存导航</a></span></div>
		<div class="panel-body">
			<table class="table table-hover" border="0" cellpadding="0" cellspacing="0" style="border:0px;">
				<thead>
					<tr>
						<th width="20%">导航名称</th>
						<th width="10%">显示顺序</th>
						<th width="40%">链接</th>
						<th width="10%">可用</th>
						<th width="20%">操作</th>
					</tr>
				</thead>
				<tbody id="taglist"><?php if(is_array($nav)) foreach($nav as $k => $v) { ?><tr>
						<td><input type="text" class="form-control" value="<?php echo $v['name'];?>"></td>
						<td><input type="text" class="form-control" value="<?php echo $v['displayorder'];?>"></td>
						<td><input type="text" class="form-control" value="<?php echo $v['link'];?>"></td>
						<td><div class="checkbox"><label><input type="checkbox" <?php if($v['status']) { ?>checked="checked"<?php } ?>> 是</label></div></td>
						<td><button type="button" class="btn btn-default update-nav" data="<?php echo $v['id'];?>">修改</button> <button type="button" class="btn btn-default del-nav" data="<?php echo $v['id'];?>">删除</button></td>
					</tr><?php if(is_array($v['downnav'])) foreach($v['downnav'] as $k1 => $v1) { ?><tr>
							<td style="padding-left:40px;"><input type="text" class="form-control" value="<?php echo $v1['name'];?>"></td>
							<td><input type="text" class="form-control" value="<?php echo $v1['displayorder'];?>"></td>
							<td><input type="text" class="form-control" value="<?php echo $v1['link'];?>"></td>
							<td><div class="checkbox"><label><input type="checkbox" <?php if($v1['status']) { ?>checked="checked"<?php } ?>> 是</label></div></td>
							<td><button type="button" class="btn btn-default update-nav" data="<?php echo $v1['id'];?>">修改</button> <button type="button" class="btn btn-default del-nav" data="<?php echo $v1['id'];?>">删除</button></td>
						</tr>
					<?php } ?>
					<tr><td style="padding-left:40px;" colspan="5"><a href="javascript:;" class="addnav" data="<?php echo $v['id'];?>">添加二级导航</a></td></tr>
				<?php } ?>
				<tr><td colspan="5"><a href="javascript:;" class="addnav">添加主导航</a></td></tr>
				
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php } elseif($do=='seo') { ?>
<div class="row bgrgba-all col-md-10">
	<div class="panel bgrgba panel-default">
		<div class="panel-heading bgrgba">URL 静态化(<small class="bg-danger">需要 Web 服务器增加相应的 Rewrite 支持</small>)</div>
		<div class="panel-body">
			
		</div>
	</div>
</div>
<?php } ?>