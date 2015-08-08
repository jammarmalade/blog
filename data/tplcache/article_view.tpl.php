<?php include display('header',''); ?><div class="container" >
		<div class="row" style="margin-top:20px;">
		  <div class="col-xs-12 col-sm-6 col-md-8" style="padding:0px 30px;">
		  <!-- article info -->
				<div class="row">
				  <h3><?php echo $article['subject'];?></h3>
				  <div class="list-tip">
					<span title="<?php echo $article['time'];?>"><?php echo $article['formattime'];?></span>
					<span><?php echo $article['author'];?></span> 
					<?php if($article['like']) { ?><span><?php echo $article['like'];?> 赞</span><?php } ?>
					<?php if($article['comments']) { ?><span><?php echo $article['comments'];?> 条评论</span><?php } ?>
					<span><?php echo $article['views'];?> 浏览</span>
					<?php if($_B['uid']==$article['authorid'] || $_B['admin']) { ?><span><a href="index.php?m=article&do=update&aid=<?php echo $article['aid'];?>">修改</a></span><?php } ?>
				  </div>
				  <div class="content">
					<p>
					  <?php echo $article['content'];?>
					</p>
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
					<h3 style="padding-bottom:10px;border-bottom:1px solid #c1c1c1;">精彩评论</h3>
					<div class="comments-list"><?php $list=array(1,2,3,4,5,6);$i=0;?><?php if(is_array($list)) foreach($list as $k => $v) { ?><div class="media">
					  <a class="media-left" href="#">
						<img src="<?php echo IMGDIR;?>jam.png" alt="admin" class="img-thumbnail">
					  </a>
					  <div class="media-body">
						<h4 class="media-heading">admin 回复 测试1</h4>
						阿森纳此刻三次健康阿森纳曾经看伤口参考价那是借口从那时进口车那就凯，撒踩你空间阿森纳曾经看三叉戟卡萨，诺静安寺重建卡萨诺空间年擦拭即可刹那间看三叉戟看三江口村那是进口车那就看水泥厂卡视角金卡四川内江卡萨诺参考就ask就从那是，进口车那就凯撒能否就看司法局喀纳斯房间看书就看是进口车拿手机开发年卡机我是你的空间阿森纳飞机库。
						<div class="row">
							2015-01-21 12:13    赞   回复
						</div>
					  </div>
					</div>
					<?php } ?>
					</div>

					 <!-- page -->
					  <div class="clearfix">
						<nav class="hidden-xs">
						  <ul class="pagination pull-right">
							<li class="disabled"><a href="#">&laquo;</a></li>
							<li class="active"><span>1 </span></li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>
							<li><a href="#">5</a></li>
							<li><a href="#">&raquo;</a></li>
						  </ul>
						</nav>

						<nav class="visible-xs-block">
						  <ul class="pager">
							<li class="pull-left disabled"><a href="#">上一页</a></li>
							<li class="pull-right"><a href="#">下一页</a></li>
						  </ul>
						</nav>
					  </div>
				</div>

				<div class="row">
					<h3 style="padding-bottom:10px;border-bottom:1px solid #c1c1c1;">发表评论</h3><?php $areaid="comment_edit";?><?php include display('editor',''); ?></div>


		 </div><?php include display('sidebar',''); ?></div><?php include display('footer',''); ?>