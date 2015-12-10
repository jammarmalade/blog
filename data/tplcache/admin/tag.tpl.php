<?php if($do=='list') { ?>

<div class="jumbotron bgrgba-all col-md-10" style="padding:20px">
	<div class="row">
		<div class="panel panel-default bgrgba">
			<div class="panel-heading">添加标签</div>
			<div class="panel-body">
				<div class="col-md-6">
					<input type="text" class="form-control" id="addtag">
				</div>
				<div class="col-md-1">
					<button type="button" class="btn btn-default" id="addtagbtn">添加</button>
				</div>
				<div class="col-md-4">
					<span class="label label-danger"></span>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="panel panel-default bgrgba">
			<div class="panel-heading">标签列表</div>
			<div class="panel-body">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>标签id</th>
							<th>标签名称</th>
							<th>创建人</th>
							<th>创建时间</th>
						</tr>
					</thead>
					<tbody id="taglist"><?php if(is_array($taginfo)) foreach($taginfo as $k => $v) { ?><tr>
							<td><?php echo $v['tagid'];?></td>
							<td	><?php echo $v['tagname'];?></td>
							<td	><?php echo $v['username'];?></td>
							<td><?php echo btime($v['dateline']);; ?></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>

				<?php echo $pagehtml;?>

			</div>
		</div>
	</div>

</div>

<?php } ?>