<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}



####################################################################################################
#
#	选项数组
#
####################################################################################################
$options_admin = array (
    array( "type" => "tab",
			"desc" => "show"),
	array( "type" => "frame",
			"desc" => "Home 首页选项"),
	array( "type" => "br"),
	array( "type" => "cat"),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "name" => "图片分类: ",
           "desc" => "如<code>1,2,3,4</code> 留空不显示框架",
           "id" => options_name."home_tab_image",
		   "style" => "15em",
           "type" => "text",
           "std" => ""),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "name" => "列表分类: ",
           "desc" => "如<code>1,2,3,4</code> 留空不显示框架",
           "id" => options_name."home_list_loop",
		   "style" => "15em",
           "type" => "text",
           "std" => ""),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "name" => "列表显示: ",
           "desc" => "首页显示列表不 ",
           "id" => options_name."home_list",
           "type" => "select",
           "options_admin" => array("不显示", "博客列表","图片列表","标题列表"),
           "std" => ""),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "name" => "幻灯片&nbsp;&nbsp;&nbsp;: ",
           "desc" => "首页幻灯片和最新发表",
           "id" => options_name."home_slide",
           "type" => "select",
           "options_admin" => array("开启", "关闭"),
           "std" => ""),
	array( "type" => "/br"),		
	array( "type" => "/frame"),
	array( "type" => "frame",
		"desc" => "Category 分类选项"),
	array( "type" => "br"),
	array( "name" => "图片分类: ",
	   "desc" => "如<code>1,2,3,4</code>",
	   "id" => options_name."cat_image",
	   "style" => "15em",
	   "type" => "text",
	   "std" => ""),
	array( "name" => "并且设置成",
	   "desc" => "条一页",
	   "id" => options_name."cat_image_showposts",
	   "style" => "4em",
	   "type" => "text",
	   "std" => "15"),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "name" => "列表分类: ",
	   "desc" => "如<code>1,2,3,4</code>",
	   "id" => options_name."cat_list",
	   "style" => "15em",
	   "type" => "text",
	   "std" => ""),
	array( "name" => "并且设置成",
	   "desc" => "条一页",
	   "id" => options_name."cat_list_showposts",
	   "style" => "4em",
	   "type" => "text",
	   "std" => "20"),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "name" => "博客分类: ",
	   "desc" => "如<code>1,2,3,4</code>",
	   "id" => options_name."cat_blog",
	   "style" => "15em",
	   "type" => "text",
	   "std" => ""),
	array( "name" => "并且设置成",
	   "desc" => "条一页",
	   "id" => options_name."cat_blog_showposts",
	   "style" => "4em",
	   "type" => "text",
	   "std" => "12"),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "name" => "搜索页面: ",
           "desc" => "搜索页面显示样式",
           "id" => options_name."search",
           "type" => "select",
           "options_admin" => array("博客列表","图片列表","标题列表"),
           "std" => ""),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "name" => "其他显示: ",
           "desc" => "比如文章归档,日期归档 云标签 等..显示",
           "id" => options_name."archive",
           "type" => "select",
           "options_admin" => array("博客列表","图片列表","标题列表"),
           "std" => ""),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "type" => "show",
			"desc" => "注意默认分类列表以上全部没有添加了就成博客分类[设置条数请不要低于<code>阅读</code>里面设置的条数]"),
	array( "type" => "/br"),
	array( "type" => "/frame"),
	array( "type" => "frame",
			"desc" => "其他选项"),
	array( "type" => "br"),
	array( "name" => "特色图片 :",
		   "desc" => "特色图片是否截取相册内容  开启后会增大%35的查询时间 建议如果你有缓存插件就开启",
		   "id" => options_name."album",
		   "type" => "select",
		   "options_admin" => array("关闭", "开启"),
		   "std" => ""),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "name" => "回复邮件 :",
	   "desc" => "是否开启评论回复邮件提示",
	   "id" => options_name."comment_reply_mail",
	   "type" => "select",
	   "options_admin" => array("关闭", "开启"),
	   "std" => ""),
	array( "type" => "/br"),
	array( "type" => "br"),
    array( "name" => "网站分享 :",
           "desc" => "single 页面文章分享 代码提供商 <a href=\"http://www.jiathis.com/\" target=\"_blank\">jiathis 加网</a>",
           "id" => options_name."single_share",
           "type" => "select",
           "options_admin" => array("开启", "关闭"),
           "std" => ""),
	array( "type" => "/br"),
	array( "type" => "br"),
    array( "name" => "相关文章 :",
           "desc" => "single 页面 下面相关文章",
           "id" => options_name."single_related",
           "type" => "select",
           "options_admin" => array("开启", "关闭"),
           "std" => ""),
	array( "type" => "/br"),
	array( "type" => "br"),
    array( "name" => "统一边栏 :",
           "desc" => "统一边栏开启后小工具只有一个可用",
           "id" => options_name."sidebar",
           "type" => "select",
           "options_admin" => array("关闭", "开启"),
           "std" => ""),
	array( "type" => "/br"),
	array( "type" => "/frame"),
	array( "type" => "frame",
			"desc" => "代码添加"),
	array( "type" => "br"),
    array( "name" => "统计代码",
           "desc" => "『位于页尾最后面隐藏』不添加请留留空。",
           "id" => options_name."analytics",
           "type" => "textarea",
           "std" => '<script language="javascript" type="text/javascript" src="http://js.users.51.la/6484469.js"></script>'),
	array( "type" => "/br"),
	array( "type" => "br"),
    array( "name" => "页尾代码",
           "desc" => "不添加请留留空。",
           "id" => options_name."footer",
           "type" => "textarea",
           "std" => ""),
	array( "type" => "/br"),
	array( "type" => "/frame"),
	array( "type" => "/tab"),

	//常规结束
	//广告开始

	array( "type" => "tab"),
	array( "type" => "frame",
			"desc" => "首页广告"),
	array( "type" => "br"),
	array( "name" => "首页横幅导航下广告条",
           "desc" => "『990x[xxx]』不添加请留空",
           "id" => options_name."home_banner_ad",
           "type" => "textarea",
           "std" => ""),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "name" => "首页幻灯片下横幅广告",
           "desc" => "『990x[xxx]』不添加请留空",
           "id" => options_name."home_banner_ad2",
           "type" => "textarea",
           "std" => ""),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "name" => "首页左列表最下方广告",
           "desc" => "『690x[xxx]』不添加请留空",
           "id" => options_name."home_left_foot",
           "type" => "textarea",
           "std" => ""),
	array( "type" => "/br"),
	array( "type" => "/frame"),
	array( "type" => "frame",
			"desc" => "分类广告"),
	array( "type" => "br"),
	array( "name" => "列表分类一篇下方广告",
           "desc" => "『690x[xxx]』不添加请留空",
           "id" => options_name."cat_list_ad",
           "type" => "textarea",
           "std" => ""),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "name" => "博客分类一篇下方广告",
           "desc" => "『690x[xxx]』不添加请留空",
           "id" => options_name."cat_blog_ad",
           "type" => "textarea",
           "std" => ""),
	array( "type" => "/br"),
	array( "type" => "/frame"),
	array( "type" => "frame",
			"desc" => "文章广告"),
	array( "type" => "br"),
	array( "name" => "文章上方广告",
           "desc" => "『690x[xxx]』不添加请留空",
           "id" => options_name."single_head_ad",
           "type" => "textarea",
           "std" => ""),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "name" => "文章下方广告",
           "desc" => "『690x[xxx]』不添加请留空",
           "id" => options_name."single_foot_ad",
           "type" => "textarea",
           "std" => ""),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "name" => "评论上方广告",
           "desc" => "『690x[xxx]』不添加请留空",
           "id" => options_name."comment_ad",
           "type" => "textarea",
           "std" => ""),
	array( "type" => "/br"),
	array( "type" => "/frame"),
	array( "type" => "/tab"),

	//广告结束
	//SEO 开始

	array( "type" => "tab"),
	array( "type" => "frame",
			"desc" => "关键字描述"),
	array( "type" => "br"),
	array( "name" => "开关",
           "desc" => "包括文章页面.分页",
           "id" => options_name."seo",
           "type" => "select",
           "options_admin" => array("关闭", "开启"),
           "std" => "关闭"),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "name" => "首页关键字:",
           "desc" => "用英文<code>,</code>符号隔开",
           "id" => options_name."index_keywords",
		   "style" => "30em",
           "type" => "text",
           "std" => ""),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "name" => "首 页 描 述:",
           "desc" => "推荐200字符以内",
           "id" => options_name."index_description",
		   "style" => "30em",
           "type" => "text",
           "std" => ""),
	array( "type" => "/br"),
	array( "type" => "/frame"),
	array( "type" => "frame",
			"desc" => "标题优化"),
	array( "type" => "br"),
	array( "name" => "标题分割线: ",
	   "desc" => " 建议使用<code> _ </code><code> | </code><code> , </code>作为分割线",
	   "id" => options_name."title_line",
	   "style" => "5em",
	   "type" => "text",
	   "std" => " _ "),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "name" => "第几页显示: ",
	   "desc" => " 建议使用<code> _ </code><code> | </code><code> , </code>作为分割线",
	   "id" => options_name."title_page",
	   "style" => "5em",
	   "type" => "text",
	   "std" => "第%s页"),
	array( "type" => "/br"),
	array( "type" => "/frame"),
	array( "type" => "frame",
			"desc" => "TAG连接"),
	array( "type" => "br"),
	array( "name" => "开启",
           "desc" => "开启后自动给文章添加tag连接",
           "id" => options_name."tag",
		   "style" => "5em",
           "type" => "select",
           "options_admin" => array("关闭", "开启"),
           "std" => "关闭"),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "name" => "一个Tag小于:",
           "desc" => "个不连接",
           "id" => options_name."tag_from",
		   "style" => "4em",
           "type" => "text",
           "std" => "1"),
	array( "name" => "最大连接数:",
           "desc" => "个.",
           "id" => options_name."tag_to",
		   "style" => "4em",
           "type" => "text",
           "std" => "10"),
	array( "type" => "/br"),
	array( "type" => "/frame"),
	array( "type" => "/tab"),
	
	//SEO结束
	//smtp邮件开始
	array( "type" => "tab"),
	array( "type" => "frame",
			"desc" => "Smtp 邮件发送"),
	array( "type" => "br"),
	array( "name" => "开关",
	   "desc" => "开启后 通过smtp 发送邮件 需要远程连接服务器 可能速度会慢点",
	   "id" => options_name."smtp",
	   "type" => "select",
	   "options_admin" => array("关闭", "开启"),
	   "std" => "关闭"),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "name" => "邮件服务器:",
	   "desc" => "",
	   "id" => options_name."smtp_host",
	   "style" => "15em",
	   "type" => "text",
	   "std" => "smtp.qq.com"),
	array( "name" => "端口:",
	   "desc" => "",
	   "id" => options_name."smtp_port",
	   "style" => "4em",
	   "type" => "text",
	   "std" => "25"),
	array( "name" => "链接类型:",
	   "desc" => "",
	   "id" => options_name."smtp_secure",
	   "type" => "select",
	   "options_admin" => array("默认链接", "SSL链接","TLS链接"),
	   "std" => "关闭"),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "name" => "链接用户名:",
	   "desc" => "不需要登录请留空",
	   "id" => options_name."smtp_username",
	   "style" => "20em",
	   "type" => "text",
	   "std" => ""),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "name" => "&nbsp;&nbsp;&nbsp;链接密码:",
	   "desc" => "不需要登录请留空",
	   "id" => options_name."smtp_password",
	   "style" => "20em",
	   "type" => "text",
	   "std" => ""),
	array( "type" => "/br"),
	array( "type" => "/frame"),
	array( "type" => "/tab"),
	//smtp 邮件结束

	//防垃圾评论开始
	array( "type" => "tab"),
	array( "type" => "frame",
		"desc" => "Comment_options"),
	array( "type" => "br"),
	array( "name" => "禁止自带评论提交地址:",
	   "desc" => "如果你使用ajax提交建议删除自带post可以防止绝大部分垃圾评论",
	   "id" => options_name."comment_default",
	   "type" => "select",
	   "options_admin" => array("关闭", "开启"),
	   "std" => "关闭"),
	array( "type" => "/br"),
	array( "type" => "br"),
	array( "name" => "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;开启垃圾评论设置:",
	   "desc" => "开启下面禁止作者网址 禁止 内容 禁止邮箱 >>>注意对已登录用户无效",
	   "id" => options_name."comment_select",
	   "type" => "select",
	   "options_admin" => array("关闭", "开启"),
	   "std" => "关闭"),
	array( "type" => "/br"),
	array( "type" => "br"),
    array( "name" => "禁止 评论 url",
           "desc" => "一个一行 不允许留空",
           "id" => options_name."comment_url",
           "type" => "textarea",
           "std" => "baidu.com\r\nqq.com\r\ngoogle.com\r\nyoudao.com\r\nbing.com\r\nfacebook.com"),
	array( "type" => "/br"),
	array( "type" => "br"),
    array( "name" => "禁止 评论 内容",
           "desc" => "一个一行 不允许留空",
           "id" => options_name."comment_content",
           "type" => "textarea",
           "std" => "rel=\"bookmark\"\r\nrel='bookmark'"),
	array( "type" => "/br"),
	array( "type" => "br"),
    array( "name" => "禁止 评论  邮箱",
           "desc" => "一个一行 不允许留空",
           "id" => options_name."comment_mail",
           "type" => "textarea",
           "std" => ""),
	array( "type" => "/br"),
	array( "type" => "/frame"),
	array( "type" => "/tab"),
	);



####################################################################################################
#
#	接收主题选项
#	并且转向到相应页面
#
####################################################################################################
add_action('admin_menu', 'mytheme_add_admin');
function mytheme_add_admin()
{	
    global  $options_admin,$user_level;
	if($user_level!=10)
		return;

    if ($_GET['page'] == options_admin ) {
        //保存设置
        if ('save' == $_REQUEST['action'] ) {
            foreach($options_admin as $value) {
                update_option($value['id'], $_REQUEST[ $value['id'] ] );
            }
            
            foreach($options_admin as $value) {
                if (isset($_REQUEST[ $value['id'] ] ) ) {
                    update_option($value['id'], $_REQUEST[ $value['id'] ]  );
                } else {
                    delete_option($value['id'] );
                }
            }
            
            header("Location: admin.php?page=". options_admin ."&saved=true");
            die;
		//重置设置
        } else if ('reset' == $_REQUEST['action'] ) {
            foreach($options_admin as $value) {
                delete_option($value['id'] );
            }
            header("Location: admin.php?page=". options_admin ."&reset=true");
            die;
        }
    }

}

####################################################################################################
#
#	主题选项 需要显示的内容
#
####################################################################################################
function mytheme_admin()
{
    
    global $options_admin;
    
    if ($_REQUEST['saved'] ) {
        echo '<div id="message" class="updated fade"><p><strong>主题设置已经保存</strong></p></div>';
    }
    if ($_REQUEST['reset'] ) {
        echo '<div id="message" class="updated fade"><p><strong>主题设置已重置</strong></p></div>';
    }

    
    ?>
    <div class="wrap lianyue_admin">
		<div id="icon-lianyue" class="icon32"><br></div>
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab nav-tab-active">常规设置</a>
			<a class="nav-tab">广告设置</a>
			<a class="nav-tab">SEO 优化</a>
			<a class="nav-tab">SMTP 邮件</a>
			<a class="nav-tab">防垃圾评论</a>
		</h2>
			<form method="post" class="tabs">
				<?php admin_foreach($options_admin); ?>
				<p class="submit">
					<input name="save" type="submit" class="button-primary" value="保存设置" />
					<input type="hidden" name="action" value="save" />
				</p>
			</form>
		<form method="post">
			<p class="submit">
				<input name="reset" type="submit" value="重置设置" />
				<input type="hidden" name="action" value="reset" />
			</p>
		</form>
    </div>
    <?php
}