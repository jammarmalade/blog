<?php include display('header',''); ?><div class="container" >
		<div class="row" style="margin-top:20px;">
		  <div class="col-xs-12 col-sm-6 col-md-8" style="padding:0px 30px;">
		  <!-- article info -->
				<div class="row">
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
				<div class="row" style="margin-top:50px;">
					<h4 style="padding-bottom:10px;border-bottom:1px solid #cecece;">精彩评论</h4>
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

				<div class="row" style="margin-top:10px;border-top:1px solid #cecece;">
					<h4 style="padding-bottom:10px;border-bottom:1px dashed #cecece;">发表评论<span id="recomment" style="color:#c1c1c1;margin-left:10px;"></span></h4><?php $areaid="comment_edit";$editid="addcomment";?><?php include display('editor',''); ?></div>


		 </div><?php include display('sidebar',''); ?></div><?php include display('footer',''); ?>