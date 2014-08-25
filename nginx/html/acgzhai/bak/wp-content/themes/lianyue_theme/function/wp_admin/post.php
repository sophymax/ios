<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}
####################################################################################################
#
#	可视化 编辑器附加css
#
####################################################################################################
add_editor_style('/function/wp_admin/head/style/edit.css');

####################################################################################################
#
#	注册隐藏的自带编辑器按钮
#
####################################################################################################
function add_more_buttons($buttons) {
	$buttons[] = 'fontsizeselect';
	$buttons[] = 'styleselect';
	$buttons[] = 'fontselect';
	$buttons[] = 'hr';
	$buttons[] = 'sub';
	$buttons[] = 'sup';
	$buttons[] = 'cleanup';
	$buttons[] = 'image';
	$buttons[] = 'code';
	$buttons[] = 'media';
	$buttons[] = 'backcolor';
	$buttons[] = 'visualaid';
	return $buttons;
}
add_filter("mce_buttons_3", "add_more_buttons");

####################################################################################################
#
#	文章页面 可视化编辑器js
#
####################################################################################################
add_filter('mce_buttons_4', 'register_button');
add_filter('mce_external_plugins', 'add_plugin');

function register_button($buttons) {
   array_push($buttons, 'nextpage','warning','accepted','cancel','arrow','download','down');
   return $buttons;
}
function add_plugin($plugin_array) {
   $plugin_array['nextpage'] = get_bloginfo('template_url').'/function/wp_admin/head/script/edit.js';
   $plugin_array['warning'] = get_bloginfo('template_url').'/function/wp_admin/head/script/edit.js';
   $plugin_array['accepted'] = get_bloginfo('template_url').'/function/wp_admin/head/script/edit.js';
   $plugin_array['cancel'] = get_bloginfo('template_url').'/function/wp_admin/head/script/edit.js';
   $plugin_array['arrow'] = get_bloginfo('template_url').'/function/wp_admin/head/script/edit.js';
   $plugin_array['download'] = get_bloginfo('template_url').'/function/wp_admin/head/script/edit.js';
   $plugin_array['down'] = get_bloginfo('template_url').'/function/wp_admin/head/script/edit.js';
   return $plugin_array;
}

 

####################################################################################################
#
#	文章页面 html编辑器js
#
####################################################################################################
add_action( 'admin_print_footer_scripts', 'quicktagsbuttons', 100 );
function quicktagsbuttons()
{
	if(!strstr($_SERVER["PHP_SELF"],'post'))
		return;
	$url = get_bloginfo('template_url').'/function/wp_admin/head/';
	echo '<script  type="text/javascript" src="'.$url.'script/edit_html.js"></script>';
}



####################################################################################################
#	
#	 上传附件保存文件名
#
####################################################################################################
function upload_file($filename) {
		$parts = explode('.', $filename);
		$filename = array_shift($parts);
		$extension = array_pop($parts);
		foreach ( (array) $parts as $part) 
			$filename .= '.' . $part;
		
		if(preg_match('/[一-龥]/u', $filename)){
			$filename = md5($filename);
		}
		$filename .= '.' . $extension;
	return $filename ;
}
add_filter('sanitize_file_name', 'upload_file', 5,1);
####################################################################################################
#	
#	 上传图片插入接口
#
####################################################################################################
function image_insert($html) {
	return preg_replace('/"><img/is', '"  target="_blank"><img', $html);
}
add_filter('image_send_to_editor', 'image_insert', 5,1);
####################################################################################################
#	
#	 上传附件插入接口
#
####################################################################################################
function media_insert($html,$post_id,$meta) {
	return  '<div class="down"><a title="'.$meta['post_title'].'" href="'.$meta['url'].'" rel="attachment download" target="_blank"><span>'.$meta['post_title'].'</span></a></div>';
}
add_filter('media_send_to_editor', 'media_insert', 5,3);
####################################################################################################
#
#	注册发布选项值
#
####################################################################################################
add_action( 'save_post', 'lianyue_options_post' );
add_action('admin_menu','lianyue_post_options',1);
function lianyue_post_options()
{
    add_meta_box('lianyue_options','single_options','lianyue_options','post','normal','high');
    
}


####################################################################################################
#
#	文章选项 关键字等
#
####################################################################################################
function lianyue_options()
{
    global $user_level,$post;
	
	//echo $post->post_status;		//draft ==草稿		 	auto-draft == 新文章组			publish==已经发布		pending==等待审核
	//echo $user_level;
	//print_r($post);
    $sql_post = new sql_post();    
    if ( !is_admin() || !is_user_logged_in() ) {
		return;
	}
	if ($post->filter == 'raw') {
	
		//添加文章
		if( $user_level == 10 ){
			$post_color = ''; 
			$post_mood_up = 0; 
			$post_mood_down = 0;
			$post_view = 0;
		}
		$post_description = ''; 
		$post_keywords = ''; 
		$post_level = 0;

	} else if ( $post->filter == 'edit'){
	
		//编辑文章
		$content = $sql_post->row($post->ID);
		if(!$content->id){
			$sql_post->value(array('post_id'=>$_GET['post']));
			$content = $sql_post->row($post->ID);
		}
		
		if( $user_level == 10 ){
			$post_color = $content->color; 
			$post_mood_up = $content->mood_up; 
			$post_mood_down = $content->mood_down;
			$post_view = $content->view;
		}
		$post_description = $content->description; 
		$post_keywords = $content->keywords; 
		$post_level = $content->level;
	}
	
	//验证表单
	$post_key = wp_create_nonce('lianyue_'.$post->ID); 
	if( $user_level == 10 ):
	

	?>
	<div class="inside"  id="lianyue_div">
		<span class="description">标题颜色:</span>
		<input name="lianyue_color" style="width:8em;" id="lianyue_color" type="text" value="<?php echo $post_color; ?>">
		<span class="description">浏览次数:</span>
		<input name="lianyue_view" style="width:8em;" id="lianyue_view" type="text" value="<?php echo $post_view; ?>">
		<span class="description">表态顶:</span>
		<input name="lianyue_mood_up" style="width:8em;" id="lianyue_mood_up" type="text" value="<?php echo $post_mood_up; ?>">
		<span class="description">表态踩:</span>
		<input name="lianyue_mood_down" style="width:8em;" id="lianyue_mood_down" type="text" value="<?php echo $post_mood_down; ?>">

	</div>
	<div class="inside"  id="lianyue_div"><b>注:</b>标题颜色留空 等于默认颜色  颜色为写法<code>#FFFFFF</code></div>
	<?php endif; ?>
	<div class="inside"  id="lianyue_div">
		<span class="description">浏览等级:</span>
		<select id="lianyue_level" name="lianyue_level" >
			<option value="0"<?php if($post_level==0) { echo' selected="selected" '; } ?>>所有访客</option>
			<option value="1"<?php if($post_level==1) { echo' selected="selected" '; } ?>>仅会员</option>
		</select>
	</div>

	<div class="inside"  id="lianyue_div">
		<span class="description">描&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;述:</span>
		<input name="lianyue_description" style="width:93%;" id="lianyue_description" type="text" value="<?php echo $post_description; ?>">
	</div>
	
	<div class="inside" id="lianyue_div" >
		<span class="description">&nbsp;关&nbsp;键&nbsp;字:</span>
		<input name="lianyue_keywords" style="width:93%;" id="lianyue_keywords" type="text" value="<?php echo $post_keywords; ?>">
	</div>
	<div class="inside"  id="lianyue_div" style="border-bottom:0;padding:8px 8px 0px 15px;">关键字多个请用<code> <b>,</b>  </code>分割</div>
	<input type="hidden" id="lianyue_key" name="lianyue_ley" value="<?php echo $post_key;  ?>">
	<?php
}

####################################################################################################
#
#	接受post数据
#
####################################################################################################
function lianyue_options_post($post_id)
{
	global $user_level,$post;
	

	//检测是否点击按钮
	if(!isset($_POST['lianyue_ley']))  return;
	
	//检测key是否正确
	$lianyue_key = wp_create_nonce('lianyue_'.$post_id); 
	if ($_POST['lianyue_ley'] != $lianyue_key ) return;
	
	//检测用户是否有权利修改这篇文章
	 if(!current_user_can( 'edit_post', $post_id )) return;
	 
	$filter = array("\r\n", "\r", "\n", " ", "\t", "\o", "\x0B", ".", "?", "<", ">", "\\", "/", "%","@","&","*","#","!",")","(","+","$",'^',"~",'ã��','ã��','ï¼�','â��','ã��','ï¼�','ã��','ã��','{','}','ï¼�','ã��','ã��','ï¿¥','Ã�','ï¼�','ï¼�','â��','ï½�',':','ï¼�','â��','â�¦','`');


	//描述
	$arr['description'] = $_POST['lianyue_description'];
	$arr['description'] = str_replace('，',",",$arr['description']);
	$arr['description'] = str_replace($filter,"",$arr['description']);
	
	
	//关键字
	$arr['keywords'] = $_POST['lianyue_keywords'];
	$arr['keywords'] = str_replace('，',",",$arr['keywords']);
	$arr['keywords'] = str_replace($filter,"",$arr['keywords']);
	
	//浏览等级
	$arr['level'] = intval($_POST['lianyue_level']);
	$arr['level'] = $arr['level'] ? 1 : 0;
	

	
	if( $user_level == 10 ){
	
		//文章标题颜色
		$arr['color'] = $_POST['lianyue_color'];
	
		//表态顶
		$arr['mood_up'] = $_POST['lianyue_mood_up'];
		
		//表态踩
		$arr['mood_down'] = $_POST['lianyue_mood_down'];
		
		//浏览
		$arr['view'] = $_POST['lianyue_view'];
		
	}
	
	$sql_post = new sql_post();
	
	if( $post->post_status == "draft" ){
		$arr['post_id'] = $post_id;
		//发布
		$sql_post->value($arr);
	}elseif( $post->post_status == "publish" ){
	
		foreach ($arr as $value => $content ){
			$sql_post->update($post_id,$value,$content);
		}
		//更新
	}
}


