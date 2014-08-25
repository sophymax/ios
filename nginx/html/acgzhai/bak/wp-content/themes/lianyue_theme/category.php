<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}
 get_header(); ?>
<div class="cat">
	<?php
	$cat_blog = config('cat_blog');
	$cat_blog = explode(",",$cat_blog);

	$cat_list = config('cat_list');
	$cat_list = explode(",",$cat_list);
	
	$cat_image = config('cat_image');
	$cat_image = explode(",",$cat_image);
	
	if ( is_category($cat_blog) ) {
		$posts = query_posts("$query_string&orderby=date&showposts=".config('cat_blog_showposts'));
		category_blog();
		wp_reset_query();
	}elseif( is_category($cat_image) ){
		$posts = query_posts("$query_string&orderby=date&showposts=".config('cat_image_showposts'));
		category_image();
		wp_reset_query();
	}elseif( is_category($cat_list) ){
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