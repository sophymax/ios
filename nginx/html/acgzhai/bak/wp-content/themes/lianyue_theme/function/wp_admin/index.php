<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}
//选项注册
include(dirname(__FILE__)."/config.php");

//选项注册
include(dirname(__FILE__)."/admin.php");

//主题选项
include(dirname(__FILE__)."/options_admin.php");

//缓存选项
include(dirname(__FILE__)."/options_cache.php");

//主题信息
include(dirname(__FILE__)."/options_theme.php");

//发布选项
include(dirname(__FILE__)."/post.php");

//边栏小工具
include(dirname(__FILE__)."/widgets.php");

//缓存
include(dirname(__FILE__)."/cache.php");

//缓存动作删除接口
include(dirname(__FILE__)."/cache_hook.php");
####################################################################################################
#
#	后台导航添加
#
####################################################################################################
add_action('admin_menu', 'admin_menus');
function admin_menus()
{
	$admin_ico =  get_bloginfo('template_url') .'/function/wp_admin/head/image/ico_options.png';
	add_menu_page( '主题设置', '主题设置', 'edit_themes', options_admin, 'mytheme_admin', $admin_ico, 999999);
	add_submenu_page( options_admin,"主题设置","主题设置", '10', options_admin, 'mytheme_admin');
	add_submenu_page( options_admin,"缓存设置","缓存设置", '10', options_cache, 'mytheme_cache');
	add_submenu_page( options_admin,"主题信息","主题信息", '10', options_theme, 'mytheme_theme');
	add_submenu_page( options_admin,"恋月博客","<span style='color: #f00;'>恋月博客</span>", '10', 'lianyue', 'mytheme_lianyue');
	add_submenu_page( options_admin,"使用说明","<b style='color: #f00;'>使用说明</b>", '10', 'explain', 'mytheme_lianyue');
}
add_action('admin_menu', 'mytheme_lianyue');
function mytheme_lianyue()
{
	if ($_GET['page'] == 'lianyue' ) {
		global  $user_level;
		if($user_level!=10)
				return;
		header("Location: http://www.lianyue.org/");
		die;
	}
	if ($_GET['page'] == 'explain' ) {
		global  $user_level;
		if($user_level!=10)
				return;
		header("Location: http://www.lianyue.org/");
		die;
	}
}
detect();
####################################################################################################
#
#	主题转向
#
####################################################################################################
add_action('admin_menu', 'theme_redirect');
function theme_redirect()
{

	if (is_admin() && isset($_GET['activated']) && strstr($_SERVER['PHP_SELF'],'themes.php')){
		global  $user_level;
		if($user_level!=10)
			return;

		//创建文章附加表
		$sql_post = new sql_post;
		$sql_post->table();

		//转向
		wp_redirect( admin_url('admin.php?page='.options_admin) );
		die;
	}
}


detect();
####################################################################################################
#
#	后台js css
#
####################################################################################################
add_action('admin_head', 'admin_head_css_js');
function admin_head_css_js()
{
	$url = get_bloginfo('template_url').'/function/wp_admin/head/';
	//管理员
	if( $_GET['page'] == options_admin || $_GET['page'] == options_theme || $_GET['page'] == options_cache ){
		echo '<script type="text/javascript"  src="'.$url.'script/options.js"></script>';
		echo '<link   href="'.$url.'style/options.css" rel="stylesheet" type="text/css" media="screen" />';
	}

	//文章页面
	if( strstr($_SERVER["PHP_SELF"],'post') ){
		echo '<link   href="'.$url.'style/post.css" rel="stylesheet" type="text/css" media="screen" />';
	}
}


function my_admin_notice(){
	echo '<div class="error  ">
			<p>主题使用说明请到<a href="http://www.lianyue.org">http://www.lianyue.org</a> 查看<form method="post"> <input type="button" class="button tagadd" value="不再提示" tabindex="3"></form></p>
		</div>';
}
//add_action('admin_notices', 'my_admin_notice');



detect();
####################################################################################################
#
#	管理员后台 显示查询时间
#
####################################################################################################
add_action('admin_footer', 'queries_footer');
function queries_footer()
{
	echo  '<!--查询'.get_num_queries().'次,耗时'.timer_stop().'秒-->';

}