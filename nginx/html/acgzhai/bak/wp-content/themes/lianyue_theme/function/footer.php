<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}

####################################################################################################
#
#	分类统一标题 
#
####################################################################################################
function footer_load()
{
	?>
	<div class="analytics">
		<?php echo stripslashes( config('analytics') ); ?>
	</div>
	<span class="none">
		<?php 
			if(config('single_share')!='关闭'&& is_single())
				echo '<script type="text/javascript" src="http://v2.jiathis.com/code_mini/jia.js" charset="utf-8"></script>';
			if(config('home_banner_ad') && is_home())
				echo '<div id="home_banner_ad_delay"><div class="ads">'.stripslashes(config('home_banner_ad')).'</div></div>';
			if(config('home_banner_ad2') && is_home())
				echo '<div id="home_banner_ad2_delay"><div class="ads">'.stripslashes(config('home_banner_ad2')).'</div></div>';
			if(config('home_left_foot') && is_home())
				echo '<div id="home_left_foot_delay"><div class="ads">'.stripslashes(config('home_left_foot')).'</div></div>';
			if(config('cat_list_ad') && is_category())
				echo '<div id="cat_list_ad_delay"><div class="ads">'.stripslashes(config('cat_list_ad')).'</div></div>';
			if(config('cat_blog_ad') && is_category())
				echo '<div id="cat_blog_ad_delay"><div class="ads">'.stripslashes(config('cat_blog_ad')).'</div></div>';
			if(config('single_head_ad') && is_single())
				echo '<div id="single_head_ad_delay"><div class="ads">'.stripslashes(config('single_head_ad')).'</div></div>';
			if(config('single_foot_ad') && is_single())
				echo '<div id="single_foot_ad_delay"><div class="ads">'.stripslashes(config('single_foot_ad')).'</div></div>';
			if(config('comment_ad') && is_single())
				echo '<div id="comment_ad_delay"><div class="ads">'.stripslashes(config('comment_ad')).'</div></div>';
		?>
		<script type="text/javascript">
			show('home_banner_ad');
			show('home_banner_ad2');
			show('home_left_foot');
			show('cat_list_ad');
			show('cat_blog_ad');
			show('single_head_ad');
			show('single_foot_ad');
			show('comment_ad');
		</script>
	</span>
	<?php
}