<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}
$i = 0;
foreach ( $sql as $post ) {
	$content.= $i%2 ?'<li>' : '<li class="odd">';
	$content.= '<span class="view">'.$post->view.'</span>';
	$content.= '<a href="'.get_permalink($post->post_id).'" title="'.$post->post_title.'" rel="bookmark">';
	$content.= $post->post_title;
	$content.= '</a>';
	$content.= '</li>';
	$i++;
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