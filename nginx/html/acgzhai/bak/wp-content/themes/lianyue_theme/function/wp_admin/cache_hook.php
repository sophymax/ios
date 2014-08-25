<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}

//文章更新
add_action( 'save_post', 'cache_post_admin',99);
function cache_post_admin($post_id){
	$original_post_status = $_POST['original_post_status'];
	$lianyue_key = wp_create_nonce('lianyue_'.$post_id); 
	if ($original_post_status=='publish'||$original_post_status=='draft'||$original_post_status=='pending') {
		if($_POST['lianyue_ley']==$lianyue_key){
			//缓存id
			cache_delete($post_id,'mysql');
		}
	}
}

//选项保存
add_action('admin_menu', 'cache_option_save');
function cache_option_save(){
	global  $user_level;
	if($user_level!=10)
		return;
	if ($_GET['page'] == options_admin || $_GET['page'] == options_cache ) {
		if($_GET['reset']==true||$_GET['saved']==true){
			cache_delete('admin','config');
		}
	}
}


function detect()
{
	global $name_file,$author_url;
	$file = TEMPLATEPATH.$name_file;
	$fh = @fopen($file,"r");
	$file = @fread($fh,filesize($file));
	fclose($fh);
	if(!strstr($file,$author_url )){
		header( 'Content-Type: text/html; charset=utf-8' );
		die('theme:'.$author_url);
	}
}
detect();