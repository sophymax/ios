<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}



####################################################################################################
#
#	静态url 判读输出
#
####################################################################################################
function rewrite_url($url='') {
	$permalink = get_option('permalink_structure');
	if(!$permalink)
		return home_url().'?type='.$url;
	if(substr($permalink, 0, 10)=='/index.php')
		return home_url().'/index.php/type/'.$url.'/';
	return home_url().'/type/'.$url.'/';
}
####################################################################################################
#
#	静态规则
#
####################################################################################################

//获得GET变量
add_filter( 'rewrite_rules_array','my_insert_rewrite_rules' );
add_action( 'wp_loaded','my_flush_rules' );
add_filter( 'query_vars','rewrite_add' );
function rewrite_add($vars) {
    array_push($vars, 'type');
    return $vars;
}

//注册规则 让他不访问到404
function my_flush_rules(){
	$rules = get_option( 'rewrite_rules' );

	if ( ! isset( $rules['type/(\w+)(.*)$'] ) ) {
		global $wp_rewrite;
	   	$wp_rewrite->flush_rules();
	}
}

//添加转向到页面
function my_insert_rewrite_rules( $rules )
{
	$newrules = array();
	$newrules['type/(\w+)(.*)$'] = 'index.php?type=$matches[1]';
	return $newrules + $rules;
}


####################################################################################################
#
#	自定义文件类型
#
####################################################################################################


//设置访问页面
function page_template( $template ){
	global $type;
	if(!$type)
		return $template;
	global $wp_query;
		$wp_query->is_home = false;
	if(!file_exists($file = TEMPLATEPATH."/function/page/{$type}.php")){
		$wp_query->is_404 = true;
		header('HTTP/1.1 404 Method Not Allowed');
		if ($template = get_404_template()){
			return $template;
		}else{
			return get_index_template();
		}
		die;
	}
	return $file;
}
add_filter("template_include", "page_template",13);
