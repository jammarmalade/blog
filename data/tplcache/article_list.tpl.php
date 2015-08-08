<?php include display('header',''); ?><div class="container" >
		<div class="row" style="margin-top:20px;">
		  <div class="col-xs-12 col-sm-6 col-md-8" style="padding:0px 30px;">
		  <!-- article list -->
		 <?php if(is_array($articles)) foreach($articles as $k => $v) { ?><div class="row row-bottom">
			  <a href="<?php echo $v['link'];?>" target="_blank" class="list-link"><h3><?php echo $v['subject'];?></h3></a>
			  <div class="list-content clearfix">
			    <?php if($imgids[$v['aid']]) { ?>
				  <div class="list-img"><a href="<?php echo $v['link'];?>" target="_blank"><img src="<?php echo IMGDIR;?>l.gif" class="lazy" data-original="<?php echo $imgids[$v['aid']];?>"></a></div>
				<?php } ?>
				<div><?php echo $v['content'];?></div>
			  </div>
			  <div class="list-tip">
			    <span><a href="<?php echo $v['link'];?>" target="_blank" class="list-tip-link" title="<?php echo $v['time'];?>"><?php echo $v['formattime'];?></a></span>
				<span><?php echo $v['author'];?></span> 
				<?php if($v['like']) { ?><span><?php echo $v['like'];?> 赞</span><?php } ?>
				<?php if($v['comments']) { ?><span><?php echo $v['comments'];?> 条评论</span><?php } ?>
			  </div>
			</div>
		 <?php } ?>
		 <!-- / article list -->
		
		  <!-- page -->
			<?php echo $pagehtml;?>

		  </div>

		  
		 <?php include display('sidebar',''); ?></div><?php include display('footer',''); ?>