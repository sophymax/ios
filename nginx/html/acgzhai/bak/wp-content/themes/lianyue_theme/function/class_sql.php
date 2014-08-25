<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}
class sql_post{

	//表名
	var $sql_name = 'lianyue_post';
	
	function __construct() {
		global $table_prefix;
        $this->sql_name = $table_prefix.$this->sql_name;
    }
	
	//创建表
	function table()
	{
		global $wpdb;
		if( $this->sql_name == $wpdb->get_var("SHOW TABLES LIKE '{$this->sql_name}'"))
			return false;
		
		$sql = "CREATE TABLE {$this->sql_name} (
			id 						bigint(10) unsigned NOT NULL auto_increment				COMMENT '顺序id',
			post_id					mediumint(11)  NOT NULL									COMMENT '文章id',
			color					VARCHAR(7)   DEFAULT '' NOT NULL						COMMENT '文章颜色',	
			description				VARCHAR(200) DEFAULT '' NOT NULL 						COMMENT '文章描述',
			keywords				VARCHAR(200) DEFAULT '' NOT NULL						COMMENT '文章关键字',
			mood_up					VARCHAR(8) DEFAULT '' NOT NULL							COMMENT '文章表态顶',
			mood_down				VARCHAR(8) DEFAULT '' NOT NULL							COMMENT '文章表态踩',
			view_time				datetime DEFAULT '0000-00-00 00:00:00' NOT NULL			COMMENT '最后浏览时间',
			view					mediumint(11) DEFAULT '0' NOT NULL						COMMENT '浏览次数',
			level					mediumint(1) DEFAULT '0' NOT NULL						COMMENT '浏览等级',
			PRIMARY KEY  (id),
			UNIQUE KEY post_id (post_id)
			);";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		return dbDelta($sql);
	}
	
	//创建值
	function value($arr=array())
	{
		//文章id
		if(!isset($arr['post_id']))  return false;
		
		//文章标题颜色
		if(!isset($arr['color'])) $arr['color'] = '';
		
		//描述
		if(!isset($arr['description'])) $arr['description'] = '';
		
		//关键字
		if(!isset($arr['keywords'])) $arr['keywords'] = '';
		
		//表态 踩
		if(!isset($arr['mood_up'])) $arr['mood_up'] = 0;
		
		//表态 顶
		if(!isset($arr['mood_down'])) $arr['mood_down'] = 0;
		
		//浏览次数
		if(!isset($arr['view'])) $arr['view'] = 0;
		
		//浏览等级
		if(!isset($arr['level'])) $arr['level'] = 0;
		
		//浏览时间
		$arr['view_time'] = current_time('mysql');
		
		global $wpdb;
		$sql =  "INSERT INTO {$this->sql_name}
				(post_id,color,description,keywords,mood_up,mood_down,view,level,view_time) VALUES 
				('{$arr['post_id']}','{$arr['color']}','{$arr['description']}','{$arr['keywords']}','{$arr['mood_up']}','{$arr['mood_down']}','{$arr['view']}','{$arr['level']}','{$arr['view_time']}')";

		return $wpdb->query($sql);
	}
	
	//导出值
	function results($arr=array())
	{
	
		//显示条数
		if(!isset($arr['limit']))  $arr['limit'] = '10';

		//排序值
		if(!isset($arr['value']))  $arr['value'] = 'post_id';
		
		//排序方式
		if(!isset($arr['sort']))  $arr['sort'] = 'DESC';
		
		//限制分类
		if(!isset($arr['cat']))  $arr['cat'] = '';
		
		//限制时间
		if(!isset($arr['days']))  $arr['days'] = '';
		
		$config = '';
		if($arr['cat']) 
			$config.= " AND cat.term_taxonomy_id = {$arr['cat']} ";
		if($arr['days']) 
			$config.= " AND TO_DAYS(now( ))-TO_DAYS( post.post_date) < {$arr['days']} ";
		
		
		global $wpdb; 
		$sql = "SELECT * FROM {$this->sql_name}  sqls 
				INNER JOIN {$wpdb->posts} post  ON sqls.post_id = post.ID 
				INNER JOIN {$wpdb->term_relationships} cat  ON sqls.post_id = cat.object_id 
				WHERE 1=1 
				{$config} 
				AND post.post_type = 'post' 
				AND post.post_status = 'publish' 
				GROUP 	BY post_id 
				ORDER BY {$arr['value']} {$arr['sort']} LIMIT {$arr['limit']} ";
		$sql = $wpdb->get_results ($sql);
		return $sql;
	}
	
	//查询某一行
	function row($post_id)
	{
		if(!$post_id) return false;
		global $wpdb;
		$sql = "SELECT * FROM {$this->sql_name} 
				WHERE post_id = {$post_id}";
		$sql = $wpdb->get_row($sql);
		return $sql;
	
	}

	//更新某一行
	function update($post_id,$value,$content)
	{
		if(!$post_id) return false;
		global $wpdb; 
		$sql = "UPDATE {$this->sql_name} SET 
				{$value}='{$content}'
				WHERE post_id={$post_id}";
		$sql = $wpdb->query($sql);
		return $sql;
	}

}
$sql_post = new sql_post();
//$sql_post =  new sql_post();
//$sql_post->table();
//post_results();
//$array['post_id'] = rand(1,5000000);
//$sql_post->value($array);







####################################################################################################
#
#	 记录最后浏览时间
#
####################################################################################################
function post_view_time($post_id='')
{
	if(!$post_id){
		global $post;
		$post_id = $post->ID;
		if(!$post_id) return;
	}
	$sql_post = new sql_post();
	$time = current_time('mysql');
	if(!$sql_post->update($post_id,'view_time',$time)){
		$sql_post->value(array('post_id'=>$post_id));
		$sql_post->update($post_id,'view_time',$time);
	}
}



####################################################################################################
#
#	 循环导出文章
#
####################################################################################################
function post_results( $arr = array() )
{
	if(!isset($arr['theme']))  $arr['theme'] = 'theme';
	$key = '';
	foreach ( $arr as $value ) {
		$key.= $value;
	}
	$cache = cache_get($key,'mysql');
	if( $cache !== false ){
		return $cache;
	}
	$sql_post = new sql_post();
	$sql = $sql_post->results($arr);
	$content = '';
	include(dirname(__FILE__)."/theme/{$arr['theme']}.php");
	cache_add($key,$content,300,'mysql');
	return $content;
}

####################################################################################################
#
#	 查询 某个行
#
####################################################################################################

function post_row($value,$post_id='')
{
	if(!$post_id){
		global $post;
		$post_id = $post->ID;
		if(!$post_id) return;
	}
	$cache = cache_get($post_id,'mysql');
	if( $cache !== false ){
		return $cache->$value;
	}
	$sql_post = new sql_post();
	$content = $sql_post->row($post_id);
	if(!isset($content->$value)) return;
	cache_add($post_id,$content,86400,'mysql');
	return $content->$value;
}

####################################################################################################
#
#	 浏览次数
#
####################################################################################################

function post_view($post_id='',$single = 0)
{
 
	if(!$post_id){
		global $post;
		$post_id = $post->ID;
		if(!$post_id) return;
	}
	if(!$single){
		return post_row('view',$post_id);
	}else{
		$sql_post = new sql_post();
		$content = $sql_post->row($post_id);
		$view = $content->view;
		$view++;
		if(!$sql_post->update($post_id,'view',$view)) $sql_post->value(array('post_id'=>$post_id));
		return $view;
	}
}


####################################################################################################
#
#	 标题颜色代码
#
####################################################################################################


function post_color($post_id = '',$echo=0)
{
	if(!$post_id){
		global $post;
		$post_id = $post->ID;
		if(!$post_id) return;
	}
	$color = post_row('color',$post_id);
	$color = $color ? ' style="color:'.$color.'" ' : '';
	if($echo)
		echo $color;
	else
		return $color;
}

####################################################################################################
#
#	 level 浏览等级
#
####################################################################################################
function post_level($post_id = '')
{
	if(!$post_id){
		global $post;
		$post_id = $post->ID;
		if(!$post_id) return;
	}
	$level = post_row('level',$post_id);
	if( $level && !is_user_logged_in() ){
		return false;
	}
	return true;
}
####################################################################################################
#
#	 mood 文章表态
#
####################################################################################################
function post_mood($post_id = '')
{
	if(!$post_id){
		global $post;
		$post_id = $post->ID;
		if(!$post_id) return;
	}
	$mood_up = post_row('mood_up',$post_id);
		if(!$mood_up)
			$mood_up = 0;
	$mood_down = post_row('mood_down',$post_id);
		if(!$mood_down)
			$mood_down = 0;
	if(mood_cookie($post_id)):
		return  <<<lianyue
		<span class="up" onclick="mood_comment('{$post_id}','up');">{$mood_up}</span>
		<span class="down" onclick="mood_comment('{$post_id}','down');">{$mood_down}</span>
lianyue;
	endif;
	return  <<<lianyue
		<span class="up" onclick="window.alert('你已经表态过了!');">{$mood_up}</span>
		<span class="down" onclick="window.alert('你已经表态过了!');">{$mood_down}</span>
lianyue;
}

//添加add
function mood_add($post_id = '',$mood = 'mood_up')
{
	global $sql_post;
	$content = $sql_post->row($post_id);
	$mood_down = $content->mood_down;
	$mood_up = $content->mood_up;
	if( $mood == 'mood_up' ){
		$mood_up++;
		$sql_post->update($post_id,'mood_up',$mood_up);
	}else{
		$mood_down++;
		$sql_post->update($post_id,'mood_down',$mood_down);
	}
	if(!isset($_COOKIE['single_mood'])){
		$cookie[$post_id] = $_GET['mood'];
	}else{
		$cookie = $_COOKIE['single_mood'];
		$cookie = stripslashes($cookie);
		$cookie = json_decode($cookie, true);
		$cookie[$post_id] = 1;
	}
	$cookie = json_encode($cookie);
	setcookie("single_mood", $cookie, time()+864000,"/");
	$html = <<<lianyue
		<span class="up" onclick="window.alert('你已经表态过了!');">{$mood_up}</span>
		<span class="down" onclick="window.alert('你已经表态过了!');">{$mood_down}</span>
lianyue;
	cache_delete($post_id,'mysql');
return $html;
}


//是否可点击
function mood_cookie($post_id = '')
{
	if(!$_COOKIE['single_mood'])
		return true;
	$cookie = $_COOKIE['single_mood'];
	$cookie = stripslashes($cookie);
	$cookie = json_decode($cookie, true);
	if(!isset($cookie[$post_id])){
		return true;
	}
	return false;
}
