<?php include display('header',''); ?><div class="container" >
		<div class="row" style="margin-top:20px;">
		  <div class="col-xs-12 col-sm-6 col-md-8" style="padding:0px 30px;">
		  <!-- article info -->
				<div class="row content-area">
				  <div class="tag-show-area" style="display:none;">
					<a href="?m=tag&do=view&tid=123">测试</a>
					<a href="?m=tag&do=view&tid=12">测试2</a>
				  </div>
				  <div class="tag-edit-area clearfix">
					<div id="tags_item_add">
						<div><span>话题3</span><a href="javascript:;" data="88" class="t-rem" name="removetag"></a></div>
					</div>
					<div class="">
						<div class="tags-search-area"><input type="text" id="tags_ipt_add" placeholder="搜索标签" autocomplete="off"></div>
						<a class="a-btn" href="javascript:;">完成</a>
					</div>
				  </div>
				  <h3 id="article_subject" data="<?php echo $article['aid'];?>"><?php echo $article['subject'];?></h3>
				  <div class="list-tip">
					<span title="<?php echo $article['time'];?>"><?php echo $article['formattime'];?></span>
					<span><?php echo $article['author'];?></span> 
					<?php if($article['like']) { ?><span><?php echo $article['like'];?> 赞</span><?php } ?>
					<?php if($article['comments']) { ?><span><?php echo $article['comments'];?> 条评论</span><?php } ?>
					<span><?php echo $article['views'];?> 浏览</span>
					<?php if($_B['uid']==$article['authorid'] || $_B['admin']) { ?><span><a href="index.php?m=article&do=update&aid=<?php echo $article['aid'];?>">修改</a></span><?php } ?>
				  </div>
				  <div class="content">
					  <?php echo $article['content'];?>
				  </div>
				  <!-- like -->
				  <div class="text-center extend" style="margin-top:50px;">
					<button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-thumbs-up"></span> &nbsp;&nbsp;赞一个</button>
				  </div>
				</div>
		  <!-- / article info -->
				<div class="clearfix hidden-xs" style="margin-top:50px;">
					<span class="pull-left">上一篇</span><span class="pull-right">下一篇</span>
				</div>
				<!-- mobile -->
				<div class="visible-xs-block" style="margin-top:50px;">
					<button type="button" class="btn btn-primary btn-lg btn-block">上一篇</button>
				</div>
				<div class="visible-xs-block" style="margin-top:10px;">
					<button type="button" class="btn btn-primary btn-lg btn-block">下一篇</button>
				</div>
				
				<!-- comments list-->
				<div class="row" style="margin-top:50px;border-top:3px solid #428BCA;">
					<h2 class="title">精彩评论</h2>
					<div class="comments-list">
					<?php if($comlist) { include display('_comment',''); } else { ?>
						<div class="no-conmment">
							<p class="text-center"><span style="color:silver;">暂无评论</span></p>
						</div>
					<?php } ?>
					</div>
					<!-- comment page -->
					<?php if($next) { ?>
						<button type="button" class="btn btn-primary btn-block loadmore" data="index.php?m=comment&do=get&aid=<?php echo $article['aid'];?>&page=2"  style="margin-top:10px;">加载更多</button>
					<?php } ?>
				</div>
				<!-- code js -->
			    <?php includeJSCSS('code');?>    <script type="text/javascript">
				  SyntaxHighlighter.all();
			    </script>
				<div class="row" style="margin-top:10px;border-top:3px solid #428BCA;">
					<h2 class="title"><a name="comment" id="comment"></a>发表评论<span id="recomment" style="color:#c1c1c1;margin-left:10px;"></span></h2><?php $areaid="comment_edit";$editid="addcomment";?><?php include display('editor',''); ?></div>


		 </div><?php include display('sidebar',''); ?></div><?php include display('footer',''); ?>