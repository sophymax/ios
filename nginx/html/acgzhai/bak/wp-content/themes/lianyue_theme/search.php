<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}
 get_header(); ?>
<div class="cat search" id="search">
	<?php
	if(config('search')=='图片列表'){
		$posts = query_posts("$query_string&orderby=date&showposts=".config('cat_image_showposts'));
		category_image();
		wp_reset_query();
	}elseif(config('search')=='标题列表'){
		$posts = query_posts("$query_string&orderby=date&showposts=".config('cat_list_showposts'));
		category_list();
		wp_reset_query();
	}else{
		$posts = query_posts("$query_string&orderby=date&showposts=".config('cat_blog_showposts'));
		category_blog();
		wp_reset_query();
	}
		//category_list();
		//category_blog();
		//category_image();
		get_sidebar(); 
	?>
	<div class="clear"></div>
</div>
<?php get_footer(); ?>