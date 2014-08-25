<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}

//选项常规设置
define("options_admin",'admin');

//选项缓存设置
define("options_cache",'cache');

//选项主题信息
define("options_theme",'theme');

//选项名称前缀
define("options_name",'lianyue_');




//缓存目录
define("cache_dir", TEMPLATEPATH.'/cache/');

//缓存文件后缀
define('cache_file','__________'.md5(PHP_VERSION). md5( TEMPLATEPATH ).'.txt' );   //php 版本 + 本地 绝对路径