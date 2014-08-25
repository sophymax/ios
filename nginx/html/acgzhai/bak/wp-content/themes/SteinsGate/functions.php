<?php
//加入自定义菜单
add_theme_support( 'menus' );if( function_exists( 'register_nav_menus' ) ) {register_nav_menus(array('topbar-menu' => 'Topbars Menu','header-menu' => 'Header Menu',));}
//加入缩略图
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 380, 250, true);
//加入后台选项
include_once('functions/settings.php');
//视频短代码
include_once('functions/embedcodecn.php');
//HTML编辑器按钮
add_action('admin_print_scripts', 'my_quicktags');
function my_quicktags() {
    wp_enqueue_script(
        'my_quicktags',
        get_stylesheet_directory_uri().'/functions/my-quicktags.js',
        array('quicktags')
    );
};
//邮件回复通知
function comment_mail_notify($comment_id) {
	  $admin_email = get_bloginfo ('admin_email'); 
	  $comment = get_comment($comment_id);
	  $comment_author_email = trim($comment->comment_author_email);
	  $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
	  $to = $parent_id ? trim(get_comment($parent_id)->comment_author_email) : '';
	  $spam_confirmed = $comment->comment_approved;
	  if (($parent_id != '') && ($spam_confirmed != 'spam') && ($to != $admin_email)) {
		$wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
		$subject = '您在 [' . get_option("blogname") . '] 的留言有了新回复';
		$message = '
		<div>
		  <p>' . trim(get_comment($parent_id)->comment_author) . ', 您好!</p>
		  <p>您在 《' . get_the_title($comment->comment_post_ID) . '》 的留言:<br />'
		   . trim(get_comment($parent_id)->comment_content) . '</p>
		  <p>' . trim($comment->comment_author) . ' 给你的回复:<br />'
		   . trim($comment->comment_content) . '<br /></p>
		  <p>你可以点击<a href="' . htmlspecialchars(get_comment_link($parent_id, array('type' => 'comment'))) . '">查看完整内容</a></p>
		  <p>欢迎再度光临<a href="' . get_option('home') . '">' . get_option('blogname') . '</a></p>
		  <p>(此邮件由系统自动发出, 请勿回复.)</p>
		</div>';
		$from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
		$headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
		wp_mail( $to, $subject, $message, $headers );
	  }
	}
add_action('comment_post', 'comment_mail_notify');
/* Mini Pagenavi v1.0 by Willin Kan. */
function pagenavi( $p = 2 ) {if ( is_singular() ) return; global $wp_query, $paged;$max_page = $wp_query->max_num_pages;if ( $max_page == 1 ) return; if ( empty( $paged ) ) $paged = 1;echo '<span class="pagescout">Page: ' . $paged . ' of ' . $max_page . ' </span> '; if ( $paged > $p + 1 ) p_link( 1, '第 1 页' );if ( $paged > $p + 2 ) echo '<span class="page-numbers"> ... </span>';for( $i = $paged - $p; $i <= $paged + $p; $i++ ) { if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<span class='page-numbers current'>{$i}</span> " : p_link( $i );}if ( $paged < $max_page - $p - 1 ) echo '<span class="page-numbers"> ... </span>';if ( $paged < $max_page - $p ) p_link( $max_page, '最末页' );}
	function p_link( $i, $title = '' ) { if ( $title == '' ) $title = "第 {$i} 页";echo "<a class='page-numbers' href='", esc_html( get_pagenum_link( $i ) ), "' title='{$title}'>{$i}</a> ";}
// 中文截断文字
	function cut_str($string, $sublen, $start = 0, $code = 'UTF-8'){if($code == 'UTF-8'){$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";preg_match_all($pa, $string, $t_string);if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen))."...";return join('', array_slice($t_string[0], $start, $sublen));}else{$start = $start*2;$sublen = $sublen*2;$strlen = strlen($string);$tmpstr = '';for($i=0; $i<$strlen; $i++){ if($i>=$start && $i<($start+$sublen)){if(ord(substr($string, $i, 1))>129) $tmpstr.= substr($string, $i, 2);else $tmpstr.= substr($string, $i, 1);}if(ord(substr($string, $i, 1))>129) $i++;}if(strlen($tmpstr)<$strlen ) $tmpstr.= "...";return $tmpstr;}}
//去掉无效的rel
foreach(array(
        'rsd_link',//rel="EditURI"
        'index_rel_link',//rel="index"
        'start_post_rel_link',//rel="start"
        'wlwmanifest_link'//rel="wlwmanifest"
    ) as $xx)
    remove_action('wp_head',$xx);//X掉以上
    //rel="category"或rel="category tag", 这个最巨量
    function the_category_filter($thelist){
        return preg_replace('/rel=".*?"/','rel="tag"',$thelist);
    }   
add_filter('the_category','the_category_filter');
//更换默认头像
function newgravatar ($avatar_defaults) {
    $myavatar = get_bloginfo('template_directory') . '/images/guestico.png';
    $avatar_defaults[$myavatar] = "默认头像";
return $avatar_defaults;
}
add_filter( 'avatar_defaults', 'newgravatar' );
//评论表情
if ( !isset( $wpsmiliestrans ) ) {
		$wpsmiliestrans = array(
		':em01:' => '01.gif',
		':em02:' => '02.gif',
		':em03:' => '03.gif',
		':em04:' => '04.gif',
		':em05:' => '05.gif',
		':em06:' => '06.gif',
		':em07:' => '07.gif',
		':em08:' => '08.gif',
		':em09:' => '09.gif',
		':em10:' => '10.gif',
		);
}
function custom_smilies_src($src, $img)
{
	return get_bloginfo('template_directory').'/smilies/' . $img;
}
add_filter('smilies_src', 'custom_smilies_src', 10, 2);
//聊天形式短代码 - Left君
function chatLeft( $atts, $content = null ) {
	global $url;
	$url = get_bloginfo( 'template_directory' );
	extract( shortcode_atts( array(
		'id' => '左童鞋',
		'avatar' => 'avatar_b',
		'dir' => 'left',
	), $atts ) );

	return '<div class="chatbox cf"><div class="'.$avatar.' chat_avatar '.$dir.'"><img src="'.$url.'/images/'.$avatar.'.jpg"></div><div class="chat_content '.$dir.'"><div class="chat_bub"><div class="chat_arrow"></div><div class="chat_meta">'.$id.'</div><p>'.$content.'</p></div></div></div>';
}
add_shortcode( 'chatl', 'chatLeft' );
//聊天形式短代码 - Right君
function chatRight( $atts, $content = null ) {
	global $url;
	$url = get_bloginfo( 'template_directory' );
	extract( shortcode_atts( array(
		'id' => '右童鞋',
		'avatar' => 'avatar_a',
		'dir' => 'right',
	), $atts ) );

	return '<div class="chatbox cf"><div class="'.$avatar.' chat_avatar '.$dir.'"><img src="'.$url.'/images/'.$avatar.'.jpg"></div><div class="chat_content '.$dir.'"><div class="chat_bub"><div class="chat_arrow"></div><div class="chat_meta">'.$id.'</div><p>'.$content.'</p></div></div></div>';
}
add_shortcode( 'chatr', 'chatRight' );
//自定义评论结构
function otakism_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment;
   global $commentcount,$comment_depth;
   $otakism_comment_depth = $comment_depth-1;
   if(!$otakism_comment_depth){
		$otakism_comment_depth = '&nbsp;&nbsp';
	}
   if(!$commentcount) {
	   $page = ( !empty($in_comment_loop) ) ? get_query_var('cpage')-1 : get_page_of_comment( $comment->comment_ID, $args )-1;
	   $cpp=get_option('comments_per_page');
	   $commentcount = $cpp * $page;
	}
?>
   <li <?php comment_class(); ?><?php if( $depth > 1){ echo 'style="margin-left:35px;"';} ?> id="comment-<?php comment_ID() ?>" >
		<div id="comment-<?php comment_ID(); ?>" class="comment-body cf">
			<div class="comment-avatar left"><a href="<?php comment_author_url(); ?>"><?php echo get_avatar( $comment, $size = '60'); ?></a></div>
			<div class="comment-content left">
				<div class="comment-name"><?php printf(__('%s'), get_comment_author_link()) ?></div>
                <div class="comment-entry"><?php comment_text() ?></div>
                <div class="comment-meta cf">
                    <div class="comment-date left"><?php comment_date('Y.m.j') ?> at <?php comment_time('H:i'); ?></div>
                    <div class="comment-reply left"><?php comment_reply_link(array_merge( $args, array('reply_text' => '回复','depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div>
                    <div class="useragent left">
						<?php if (function_exists("CID_init")) {CID_print_comment_browser();} ?>
                    </div>
				</div>
            </div> 
            <div class="comment-floor right">
            	<?php
			if(get_option('default_comments_page')=='newest'){
				if(!$parent_id = $comment->comment_parent ){
					++$commentcount;
					}
				echo '<span>#'.$commentcount.'<strong>'.$otakism_comment_depth .'</strong></span>';
			}else{

				if(!$parent_id = $comment->comment_parent ){
					--$commentcount;
					}
				echo '<span>#'.$commentcount.'<strong>'.$otakism_comment_depth .'</strong></span>';

			}
		?>
            </div> 
    	</div>
    </li>
<?php } ?>