<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}
add_action('admin_menu', 'mytheme_add_theme');
function mytheme_add_theme()
{	
    global  $user_level;
	if($user_level!=10)
		return;
	if ($_GET['page'] == options_theme ) {
		if($_REQUEST['action'] == 'create_post_sql' ){
			$sql_post = new sql_post();
			if($sql_post->table()){
				header("Location: admin.php?page=". options_theme ."&create=true");
			}else{
				header("Location: admin.php?page=". options_theme ."&failure=true");
			}
			die;
		}
	}
}

####################################################################################################
#
#	显示 主题信息
#
####################################################################################################
function mytheme_theme()
{
	
	$style = get_theme_data(TEMPLATEPATH . '/style.css');
	
	global $wpdb;
	$sql_post = new sql_post();
	$sql_post_name = $wpdb->get_var("SHOW TABLES LIKE '{$sql_post->sql_name}'");
	if ($_REQUEST['create'] ) {
        echo '<div id="message" class="updated fade"><p><strong>数据库创建成功</strong></p></div>';
    }
	if ($_REQUEST['failure'] ) {
        echo '<div  class="error below-h2"><p>数据库创建失败[已经存在数据库]</p></div>';
    }
?>
	<script src="<?php bloginfo('template_url'); ?>/php/functions/admin/js/admin.js"></script>
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/php/functions/wp-admin/admin/css/admin.css" type="text/css" media="screen" />
	<div class="wrap lianyue_admin">
		<div id="icon-lianyue" class="icon32"><br></div>
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab nav-tab-active">主题信息</a>
			<a class="nav-tab">主题说明</a>
		</h2>
		<div class="tabs">
			<div class="metabox-holder tab_div show">
				<div id="poststuff ">
					<div class="postbox ">
						<h3 class="hndle"><span>主题信息</span></h3>
						<div class="inside" style="border-bottom: 1px solid #CCC;margin: 0;padding: 8px 10px;">
							<span class="description">主题版本:</span>
							<input  style="width: 15em;"  type="text" value="<?php echo $style['Version']; ?>" disabled="disabled">
						</div>
						<div class="inside" style="border-bottom: 1px solid #CCC;margin: 0;padding: 8px 10px;">
							<span class="description">主题名称:</span>
							<input  style="width: 15em;"  type="text" value="<?php echo $style['Title']; ?>" disabled="disabled">
						</div>
						<div class="inside" style="border-bottom: 1px solid #CCC;margin: 0;padding: 8px 10px;">
							<span class="description">出炉时间:</span>
							<input  style="width: 15em;"  type="text" value="<?php echo '2012-1-22'; ?>" disabled="disabled">
						</div>
						<div class="inside" style="border-bottom: 1px solid #CCC;margin: 0;padding: 8px 10px;">
							<span class="description">主题版权:</span>
							<input  style="width: 15em;"  type="text" value="免费授权" disabled="disabled">
						</div>
						<div class="inside" style="border-bottom: 1px solid #CCC;margin: 0;padding: 8px 10px;">
							<span class="description">主题作者:</span>
							<input  style="width: 15em;"  type="text" value="lianyue" disabled="disabled">
						</div>
						<div class="inside" style="border-bottom: 1px solid #CCC;margin: 0;padding: 8px 10px;">
							<span class="description">作者网站:</span>
							<input  style="width: 15em;"  type="text" value="<?php echo $style['URI']; ?>" disabled="disabled">
						</div>
						<div class="inside" style="border-bottom: 1px solid #CCC;margin: 0;padding: 8px 10px;">
							<form method="post">
								<span class="description">POST 文章数据库:</span>
								<input  style="width: 15em;"  type="text" value="<?php echo $sql_post_name; ?>" disabled="disabled">
									&nbsp;&nbsp;&nbsp;
									<input class="button-primary" type="submit" name="create_post_sql" value="创建数据库">
									<input type="hidden" name="action" value="create_post_sql">
							</form>
						</div>
						<div class="inside" style="border-bottom: 1px solid #CCC;margin: 0;padding: 8px 10px;">
							免费主题不允许改版权一旦发现后果自负
						</div>
					</div>
				</div>
			</div>
			<div class="metabox-holder tab_div hide">
				<div id="poststuff ">
					<div class="postbox ">
						<h3 class="hndle"><span>主题说明</span></h3>
						<div class="inside" style="border-bottom: 1px solid #CCC;margin: 0;padding: 8px 10px;">
							<p> 作者QQ :<code> 554044542 </code> QQ群 : <code>77177786</code></p>
						</div>
						<div class="inside" style="border-bottom: 1px solid #CCC;margin: 0;padding: 8px 10px;">
							<p> 使用说明请到 <a href="http://www.lianyue.org" target="_blank">http://www.lianyue.org</a> 搜索</p>
						</div>
						<div class="inside" style="border-bottom: 1px solid #CCC;margin: 0;padding: 8px 10px;">
							正式版 V1.0
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
}