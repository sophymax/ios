<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}
detect_head();
?><!DOCTYPE html>
<html <?php language_attributes(); ?> xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php

global $page, $paged,$cpage,$type;
//分割线
$line = config('title_line');
//第几页
$pages='';
if ( $paged >= 2 ){
	$pages.= str_replace('%s', $paged   ,config('title_page'));
	$pages.= $line;
}
if( $page >= 2 ){
	$pages.= str_replace('%s',  $page ,config('title_page'));
	$pages.= $line;
}
if($cpage >= 2 ){
	$pages.= '评论'.str_replace('%s',  $cpage ,config('title_page'));
	$pages.= $line;
}

//整站标题
$blog_name = get_bloginfo('name');

if(is_home()){

	//首页
	$title = $blog_name . $line . $pages . get_bloginfo('description');
}elseif(is_category()){

	//分页
	$title =  single_cat_title("", false). $line . $pages .$blog_name;
}elseif(is_attachment()){

	//附件
	$title = get_the_title() . get_the_title( $post->post_parent ) . $blog_name;
}elseif(is_single()){

	//文章
	$cat = '';
	foreach (get_the_category() as $category)
	{
		$cat.= $category->cat_name .$line; 
	}
	$title = get_the_title() . $line . $pages . $cat . $blog_name;
}elseif(is_tag()){

	//标签
	$tags = $line . '标签';
	$title =  single_tag_title("", false) . $tags . $line . $pages . $blog_name;
}elseif(is_404()){

	//404
	$_404 = '404页面';
	$title =  $_404 . $line . $blog_name;
}elseif(is_author()){

	//作者
	$author = '作者';
	$title =  wp_title($line ,false,'right')  . $author . $line . $blog_name;
}elseif(is_archive()){

	//存档
	$archive = '存档页面';
	$title =  wp_title($line ,false,'right') . $archive . $line . $pages . $blog_name;
}elseif( $type == 'add_links' ){

	//申请链接
	$links = '申请链接';
	$title =  wp_title($line ,false,'right') . $links . $line . $blog_name;
}elseif( $type == 'links' ){

	//友情链接
	$links = '友情链接';
	$title =  wp_title($line ,false,'right') . $links . $line . $blog_name;
}else{
	//其他
	$title =  wp_title($line,false,'right') . $pages . $blog_name;
}

echo $title; ?></title>
<link rel="canonical" href="<?php echo get_permalink($post->ID);?>" />
<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/image/favicon.ico" />
<link title="RSS 2.0" type="application/rss+xml" href="<?php bloginfo('rss2_url'); ?>" rel="alternate" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link id="style_css" href="<?php bloginfo('template_url');?>/style.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/script/jquery.js"></script> 
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/script/lianyue.js"></script>
<?php
if (config('seo') == "开启") {
    
    if (is_attachment()) {
	
		//附件 
        $description = wp_title('',false) .','. block_uft8(strip_tags($post->post_content),100);
        $keywords = "" ;
    } else if (is_single()) {
	
		//文章 
		$single_description = post_row('description');
		if($single_description){
			$description = $single_description;
		}else{
			$description = block_uft8(strip_tags($post->post_content),100);
			$description = str_replace(array("\r\n", "\r", "\n", " ", "\t", "\o", "\x0B", ".", "?"),"",$description);
			$description = str_replace(array("\""), "", $description);
		}
		$keywords = "";
		$single_keywords = post_row('keywords');
		if($single_keywords){
			$keywords = $single_keywords;
		}else{
			$tags = wp_get_post_tags($post->ID);
			foreach($tags as $tag ) {
				$keywords = $keywords . $tag->name . ",";
			}
			$keywords = rtrim($keywords,',');
		}
    } else if (is_category()) {
	
		
        //分类
        foreach((get_the_category()) as $category) {
            $catname = $category->category_nicename ;
            //取分类名
            $description = $category->category_description;
            $cat = $category->cat_name;
        }
        query_posts('category_name='.$catname);
		if (have_posts()) : 
			while (have_posts()) : the_post();
				$posttags = get_the_tags();
				$count=0;
					if ($posttags) {
						foreach($posttags as $tag) {
							$count++;
							if ($count <= 1){
								$all_tags_arr[] = $tag -> name; 
								//用 $tag 把 $all_tags_arr 变成多维数组，再由array_unique函数进行处理
							} 
						} 
					}
		endwhile;
		endif;
		wp_reset_query();
        if (!empty($all_tags_arr)) {
            $tags_arr = array_unique($all_tags_arr);
            //去除重复的tag
            $keywords = $cat.',' .implode(',',$tags_arr) ;
            $category->cat_name;
        }
    } else if (is_home()) {
	
		 //首页
        $description = stripslashes(config('index_description'));
        $keywords = stripslashes(config('index_keywords'));
    } else if (is_tag()) {
	
		//标签
        $description =wp_title('',false) ."Tag Archive page";
        $keywords = wp_title('Tag,Archive,',false) ."";
    }
    if (!empty($keywords)) {
        echo "<meta name=\"Keywords\" content=\"$keywords\" />\n";
    }
    if (!empty($description)) {
        echo "<meta name=\"description\" content=\"$description\"/>\n";
    }
}

wp_head();
?>
<!--[if IE 8]>
<style type="text/css">
.search_head{margin-top:16px;}
.menu_head ul li ul{top:30px;}
</style>
<![endif]-->
</head>
<body <?php body_class( $class ); ?> >
<div class="header_bg"></div>
<div class="wrapper" id="wrapper">
	<div class="header" id="header">
		<h1 class="logo left" id="logo">
			<?php $logo_title = get_bloginfo('name').' _ '.get_bloginfo('description');   ?>
			<a href="<?php  bloginfo('home'); ?>" title="<?php echo $logo_title; ?>">
				<span class="none"><?php echo $logo_title.' | '.get_bloginfo('home'); ?></span>
				<img src="<?php bloginfo('template_url'); ?>/image/logo.png" alt="<?php echo $logo_title; ?>" />
			</a>
		</h1>
		<div class="right header_right">
			<div class="search_head" id="search" style="height:30px;">
				<!--<form  role="search" action="<?php bloginfo('home'); ?>" method="get">
					<input type="text" name="s" class="s" id="s" title="Search" value="<?php _e('Search Posts'); ?>" onfocus="if (this.value == '<?php _e('Search Posts'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Search Posts'); ?>';}">
					<input type="submit" class="submit" value="<?php _e('Search'); ?>">
				</form>-->
			</div>
			<div class="clear"></div>
			<?php
				$menu_arr = array(	'theme_location' =>'menu_head',
									'container' => '',
									'depth' => 2,
									'container' => 'ul',
									'menu_class'  => 'menu_head',
									'menu_id'  => 'menu',
									'items_wrap' => '<div class="%2$s" id="%1$s"><ul>%3$s</ul></div>',
									'echo'  => false
									);
				$menu_head = wp_nav_menu($menu_arr); 
				echo $menu_head;
			?>
		</div>
	</div>