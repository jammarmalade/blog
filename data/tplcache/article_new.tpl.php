<?php include display('header',''); ?><div class="container container-article-new">

	<div class="subject-article-new">
		<h4>文章标题（80个字符）</h4>
		<input type="text" class="form-control" id="subject" autocomplete="off" value="<?php echo $article['subject'];?>">
	</div><?php includeJSCSS('articleNew');?><script type="text/javascript">
		var defaultcontent='<?php echo $defaultcontent;?>';
	</script>
	
	
	<div id="article_content"></div>
	
	<div class="submit-div">
		<button type="button" class="btn btn-primary" action-type="article-new"><?php if($_GET['do']=='new') { ?>发布文章 <?php } else { ?> 提交修改<?php } ?> </button>
	</div>
</div><?php include display('footer',''); ?>