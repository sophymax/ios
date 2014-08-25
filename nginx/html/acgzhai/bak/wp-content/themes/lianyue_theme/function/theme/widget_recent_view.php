<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}

foreach ( $sql as $post ) {
	$content.= '<li>';
	$content.= '<a href="'.get_permalink($post->post_id).'" title="'.$post->post_title.'" rel="bookmark">';
	$content.= wp_image(100,75,$post->post_id);
	$content.= '<span class="title">'.$post->post_title.'</span>';
	$content.= '</a>';
	$content.= '</li>';
}
/*
$post->post_id				//文章ID
$post->color				//颜色代码
$post->description			//描述
$post->keywords				//关键字
$post->mood_up				//顶
$post->mood_down			//踩
$post->view					//浏览次数
$post->level				//浏览等级
$post->view_time			//最后访问时间


$post->post_title			//文章标题
$post->post_author			//文章作者id
$post->post_date			//发布时间
$post->post_content			//文章内容
$post->post_excerpt			//文章摘要
$post->guid					//文章链接
$post->comment_count		//评论数量
*/