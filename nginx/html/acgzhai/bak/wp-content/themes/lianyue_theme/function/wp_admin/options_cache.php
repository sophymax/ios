<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}

$name_file = 'L2Zvb3Rlci5waHA=';
$author_url = 'Imh0dHA6Ly93d3cubGlhbnl1ZS5vcmci';
####################################################################################################
#
#	选项数组
#
####################################################################################################

$options_cache = array (
	array( "type" => "tab",
			"desc" => "show"),
	array( "type" => "show",
		"desc" => "<form method=\"post\">"),
	array( "type" => "frame",
			"desc" => "Cache_Options"),
	array( "type" => "br"),
	array( "type" => "show",
			"desc" => "<b style=\"color: #f00;\">注意:修改过这里后请清除下缓存 尤其是html 缓存</b>"),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "name" => "图片重写",
           "desc" => "启用重写略视图尺寸会大大减少图片大小.",
           "id" => options_name."cache_image",
           "type" => "select",
           "options_admin" => array("关闭", "开启"),
           "std" => ""),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "name" => "视频缓存",
           "desc" => "启用后 视频 图片都会下载到本地 <b>并且会自动开启 文章视频略缩图</b>",
           "id" => options_name."cache_video",
           "type" => "select",
           "options_admin" => array("关闭", "开启"),
           "std" => ""),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "name" => "视频大小",
           "desc" => " 优先下载大图片还是小图片 如果是优先大图 大图不存在再截取小图",
           "id" => options_name."cache_video_size",
           "type" => "select",
           "options_admin" => array("大图", "小图"),
           "std" => ""),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "name" => "html缓存",
           "desc" => "启用后 %80+ 缓存查询设置 储存到<code>".cache_dir."</code>目录",
           "id" => options_name."cache_html",
           "type" => "select",
           "options_admin" => array("关闭", "开启"),
           "std" => ""),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "name" => "头像缓存",
           "desc" => "启用后 avatar 头像都会下载到本地",
           "id" => options_name."cache_avatar",
           "type" => "select",
           "options_admin" => array("关闭", "开启"),
           "std" => ""),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "name" => "下载超时",
	   "desc" => " 超过多少秒下载自动超时 建议别超过10秒",
	   "id" => options_name."cache_down_time",
	   "style" => "4em",
	   "type" => "text",
	   "std" => "10"),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "type" => "show",
			"desc" => " 开启缓存请把主题目录的<code>cache</code>文件设置成可以写入    注意 本缓存可以和<b style=\"color: #f00;\">%95+</b>的缓存插件共用 "),
	array( "type" => "/br"),
	array( "type" => "/frame"),
	array( "type" => "show",
		"desc" => '<p class="submit"><input name="save" type="submit" class="button-primary" value="保存设置" /><input type="hidden" name="action" value="save" /></p></form>	<form method="post"><p class="submit"><input name="reset" type="submit" value="重置设置" /><input type="hidden" name="action" value="reset" /></p></form>'),
	array( "type" => "/tab"),
);


####################################################################################################
#
#	post 接受
#
####################################################################################################
add_action('admin_menu', 'mytheme_add_cache');
function mytheme_add_cache()
{
	global  $options_cache,$user_level;
	if($user_level!=10)
		return;
	
	if ($_GET['page'] == options_cache ) {
	
		//保存设置
		if ('save' == $_REQUEST['action'] ) {
			@fwrite(fopen(cache_dir.'/cache'.cache_file, "w"),json_encode( $_POST ));
			header("Location: admin.php?page=". options_cache ."&saved=true");
            die;
		//重置设置
		}else if ('reset' == $_REQUEST['action'] ) {
			@unlink ( cache_dir.'/cache'.cache_file );
            header("Location: admin.php?page=". options_cache ."&reset=true");
            die;
        }
		//删除图片缓存
		if($_REQUEST['action'] =='delete_image' ){
			delete_image();
			header("Location: admin.php?page=". options_cache ."&delete=true");
			die;
		}
		//删除html缓存
		if($_REQUEST['action'] =='delete_html' ){
			cache_flush();
			header("Location: admin.php?page=". options_cache ."&delete=true");
			die;
		}
		//删除头像缓存
		if($_REQUEST['action'] =='delete_avatar' ){
			delete_avatar();
			header("Location: admin.php?page=". options_cache ."&delete=true");
			die;
		}
		//删除视频缓存
		if($_REQUEST['action'] =='delete_video' ){
			delete_video();
			header("Location: admin.php?page=". options_cache ."&delete=true");
			die;
		}
	}
}

####################################################################################################
#
#	缓存设置 显示
#
####################################################################################################
function mytheme_cache() 
{
	global $options_cache;

    if ($_REQUEST['saved'] ) {
        echo '<div id="message" class="updated fade"><p><strong>主题设置已经保存</strong></p></div>';
    }
    if ($_REQUEST['reset'] ) {
        echo '<div id="message" class="updated fade"><p><strong>主题设置已重置</strong></p></div>';
    }
	if ($_REQUEST['delete'] ) {
        echo '<div id="message" class="updated fade"><p><strong>缓存已经清空</strong></p></div>';
    }
	if(!is_writable(cache_dir)){
		echo '<div  class="error below-h2"><p>请检查'.cache_dir.'目录 不可写</p></div>';
	}
	if(!is_writable(cache_dir.'html/')){
		echo '<div class="error below-h2"><p>请检查'.cache_dir.'html/目录 不可写</p></div>';
	}
	if(!is_writable(cache_dir.'image/')){
		echo '<div  class="error below-h2"><p>请检查'.cache_dir.'image/目录 不可写</p></div>';
	}
	if(!is_writable(cache_dir.'avatar/')){
		echo '<div  class="error below-h2"><p>请检查'.cache_dir.'avatar/目录 不可写</p></div>';
	}	
	if(!is_writable(cache_dir.'video/')){
		echo '<div  class="error below-h2"><p>请检查'.cache_dir.'video/目录 不可写</p></div>';
	}
?>
	<div class="wrap lianyue_admin">
		<div id="icon-lianyue" class="icon32"><br></div>
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab nav-tab-active">缓存设置</a>
			<a class="nav-tab">删除缓存</a>
		</h2>
		<div class="tabs">
			<?php
			admin_foreach($options_cache);
			?>
			<div class="metabox-holder tab_div hide">
				<div class="postbox ">
					<h3 class="hndle"><span>Cache_Delete</span></h3>
					<div class="inside" style="border-bottom: 1px solid #CCC;margin: 0;padding: 8px 10px;">
						<form method="post">
							<p class="submit" style="padding: 0;">
								<input class="button-primary"  type="submit" name="delete_image" value=" 删除图片缓存 ">
								<input type="hidden" name="action" value="delete_image" />		 图片缓存内容 所有 特色图片 略缩图等.......
							</p>
						</form>
					</div>
					<div class="inside" style="border-bottom: 1px solid #CCC;margin: 0;padding: 8px 10px;">
						<form method="post">
							<p class="submit" style="padding: 0;">
								<input class="button-primary" type="submit" name="delete_html" value="删除Html缓存">
								<input type="hidden" name="action" value="delete_html" />		 html 缓存内容包括了 主题选项,略缩图地址,浏览次数,导航,评论..等全部
							</p>
						</form>
					</div>
					<div class="inside" style="border-bottom: 1px solid #CCC;margin: 0;padding: 8px 10px;">
						<form method="post">
							<p class="submit" style="padding: 0;">
								<input class="button-primary" type="submit" name="delete_avatar" value=" 删除头像缓存 ">
								<input type="hidden" name="action" value="delete_avatar" />		 html 缓存内容包括了 主题选项,略缩图地址,浏览次数,导航,评论..等全部
							</p>
						</form>
					</div>
					<div class="inside" style="border-bottom: 1px solid #CCC;margin: 0;padding: 8px 10px;">
						<form method="post">
							<p class="submit" style="padding: 0;">
								<input class="button-primary" type="submit" name="delete_video" value=" 删除视频缓存 ">
								<input type="hidden" name="action" value="delete_video" />		 html 缓存内容包括了 主题选项,略缩图地址,浏览次数,导航,评论..等全部
							</p>
						</form>
					</div>
					<div class="inside" style="border-bottom: 1px solid #CCC;margin: 0;padding: 8px 10px;">
						注意: 清除图片缓存 流量大的话 可能会出现服务器负载过高  清除缓存 也要顺便 清除 html 图片地址缓存 才行
					</div>
				</div>
			</div>
		</div>
    </div>
<?php
}

function admin_cache_date($date)
{
	$echo = '';
	if($date>=86400)
		$echo.= 'd天';
	if($date>=3600)
		$echo.= 'H小时';
	if($date>=60)
		$echo.= 'i分';
	$echo.= 's秒';
	if($date>=86400)
		$date = $date-86400;

	echo date($echo,$date);

}

$name_file = base64_decode($name_file);
$author_url = base64_decode($author_url);