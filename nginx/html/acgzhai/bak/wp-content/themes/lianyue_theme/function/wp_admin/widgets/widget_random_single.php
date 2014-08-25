<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}
//自动匹配分类
$config = '';
if($category){
	if(is_single()){
		//文章
		$category = get_the_category();
		$cat = '';
		$i = 0;
		foreach ($category as $value){
			if($i) $cat.= ',';
			$cat.= $value->term_id;
			$i++;
		}
		$config = "&cat={$cat}";

	}elseif(is_category()){
		//分类
		global $cat;
		$config =  "&cat={$cat}";
	}
}

$content ='<ul>';
global $authordata;
query_posts("posts_per_page={$number}{$config}&caller_get_posts=1&orderby=rand"); 
	while ( have_posts() ) : the_post();
		$title = get_the_title();
		$link =	get_permalink();
		$image = wp_image(65,55);
		$date = get_the_date();
		$color = post_color();
		$author = sprintf(
                '<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
                get_author_posts_url( $authordata->ID, $authordata->user_nicename ),
                esc_attr( sprintf( __( 'Posts by %s' ), get_the_author() ) ),
                get_the_author()
				);
		$content.= "<li><a href=\"{$link}\" title=\"{$title}\" rel=\"bookmark\">
				{$image}</a>
				<div class=\"title\"><a href=\"{$link}\" {$color} title=\"{$title}\" rel=\"bookmark\">{$title}</a></div>
				<div class=\"author\">{$author}</div>
				<div class=\"time\">{$date}</div>
				</a></li>";
	endwhile;
wp_reset_query();

echo "{$content}</ul>";