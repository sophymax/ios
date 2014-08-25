<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}
if(config('sidebar') !='开启' ){
	//首页
	register_sidebar(array(
		'name' => 'home',
		'id' => 'home',
		'description' => '注意此小工具只会在首页显示',
		'before_widget' => '<div class="%2$s" >',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="title">',
		'after_title' => '</h3>',
	));

	//分类
	register_sidebar(array(
		'name' => 'category',
		'id' => 'category',
		'description' => '注意此小工具只会在分类显示',
		'before_widget' => '<div class="%2$s" >',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="title">',
		'after_title' => '</h3>',
	));

	//文章
	register_sidebar(array(
		'name' => 'single',
		'id' => 'single',
		'description' => '注意此小工具只会在文章显示',
		'before_widget' => '<div class="%2$s" >',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="title">',
		'after_title' => '</h3>',
	));

	//页面
	register_sidebar(array(
		'name' => 'page',
		'id' => 'page',
		'description' => '注意此小工具只会在页面显示',
		'before_widget' => '<div class="%2$s" >',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="title">',
		'after_title' => '</h3>',
	));

	//其他
	register_sidebar(array(
		'name' => 'else',
		'id' => 'else',
		'description' => '注意此小工具除去上面的其他的显示的',
		'before_widget' => '<div class="%2$s" >',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="title">',
		'after_title' => '</h3>',
	));
	
}else{

	//统一边栏
	register_sidebar(array(
		'name' => 'whole',
		'id' => 'whole',
		'description' => '注意此小工具要在后台选项添加了才可用添加了其他全部失效',
		'before_widget' => '<div class="%2$s" >',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="title">',
		'after_title' => '</h3>',
	));
}
