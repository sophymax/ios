<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}

//选项后台等
include(TEMPLATEPATH . '/function/wp_admin/index.php');

//邮件发送
include(TEMPLATEPATH . '/function/email.php');

//常规必须的
include(TEMPLATEPATH . '/function/index.php');

//边栏
include(TEMPLATEPATH . '/function/sidebar.php');

//略缩图
include(TEMPLATEPATH . '/function/image.php');

//分类样式
include(TEMPLATEPATH . '/function/category.php');

//sql 操作
include(TEMPLATEPATH . '/function/single.php');

//广告等延迟加载
include(TEMPLATEPATH . '/function/footer.php');

//评论等
include(TEMPLATEPATH . '/function/comment.php');

//sql 操作
include(TEMPLATEPATH . '/function/class_sql.php');

//page 页面
include(TEMPLATEPATH . '/function/rewrite.php');

