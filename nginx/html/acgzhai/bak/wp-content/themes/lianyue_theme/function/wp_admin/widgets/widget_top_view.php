<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}

//自动匹配分类
$cats = '';
if($category){
	if(is_single()){
		//文章
		$category = get_the_category();
		$cats = @$category[0]->term_id;

	}elseif(is_category()){
		//分类
		global $cat;
		$cats = $cat;
	}
}
//时间
if($day){
	$arr['days'] = $day;
}
//分类
if($cats){
	$arr['cat'] = $cats;
}
$arr['theme'] = 'widget_top_view';
$arr['value'] = 'view';
$arr['limit'] = $number;
echo '<ul>';
echo post_results($arr);
echo '<div class="clear"></div></ul>';
