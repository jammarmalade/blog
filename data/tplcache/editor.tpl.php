
<script src="<?php echo JSDIR;?>/editor.js"></script>
<div class="post-area" style="margin-bottom:50px;">
	<div class="btn-group edit-bar" role="group">
		<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="加粗" onclick="editor('<?php echo $areaid;?>','b');"><span class="glyphicon glyphicon-bold"></span></button>
		<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="斜线" onclick="editor('<?php echo $areaid;?>','i');"><span class="glyphicon glyphicon-italic"></span></button>
		<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="代码" onclick="editor('<?php echo $areaid;?>','code');"><b>CODE</b></button>
		<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="清除格式" onclick="editor('<?php echo $areaid;?>','delformat');"><b><span class="glyphicon glyphicon-erase"></span></b></button>
		<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="关键字" onclick="editor('<?php echo $areaid;?>','kbd');"><b><span class="glyphicon glyphicon-text-background"></span> </b></button>
		<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="引用" onclick="editor('<?php echo $areaid;?>','quote');"><b>引用</b></button>
		
		
	</div>

	<textarea class="form-control" rows="5" style="resize:vertical;" id="<?php echo $areaid;?>"></textarea>
	<div class="clearfix edit-bottom">
		<div class="submit-div">
			<span class="editor-notice"></span>
			<button type="button" class="btn btn-primary" id="<?php echo $editid;?>">评论</button>
		</div>
		<div class="edit-bottom-left"></div>
	</div>
</div>