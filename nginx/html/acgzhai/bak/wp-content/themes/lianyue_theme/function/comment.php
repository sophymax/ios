<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}


####################################################################################################
#
#	评论回复邮件发送 不是自己写的
#
####################################################################################################

function comment_mail_notify($comment_id) {
  $comment = get_comment($comment_id);
  $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
  $spam_confirmed = $comment->comment_approved;
  if (($parent_id != '') && ($spam_confirmed != 'spam')) {
    $wp_email = 'wordpress@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));//发件人e-mail地址
    $to = trim(get_comment($parent_id)->comment_author_email);
    $subject = '您在['.get_option("blogname").']的留言有了回复';
    $message = '
    <div style="background-color:#eef2fa; border:1px solid #d8e3e8; color:#111; padding:0 15px; -moz-border-radius:5px; -webkit-border-radius:5px; -khtml-border-radius:5px;">
      <p>'.trim(get_comment($parent_id)->comment_author).', 您好!</p>
      <p>这是您在《'.get_the_title($comment->comment_post_ID).'》中的留言:<br />'
       .trim(get_comment($parent_id)->comment_content).'</p>
      <p>以下是 '.trim($comment->comment_author).' 给您的回复:<br />'
       .trim($comment->comment_content).'<br /></p>
      <p>您可以<a href="' . htmlspecialchars(get_comment_link($parent_id)) . '">点击这里查看回复的完整内容.</a></p>
      <p>欢迎再度光临 <a href="' . get_option('home') . '">' . get_option('blogname') . '</a></p>
      <p>此邮件为系统自动发出!</p>
    </div>';
    $message = convert_smilies($message);
    $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
    $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
    wp_mail( $to, $subject, $message, $headers );
    //echo 'mail to ', $to, '<br/> ' , $subject, $message; // for testing
  }
}
if(config('comment_reply_mail')){
	add_action('comment_post', 'comment_mail_notify');
}
####################################################################################################
#
#	留言表情
#
####################################################################################################

if ( !isset( $wpsmiliestrans ) ) {
		$wpsmiliestrans = array(
		'/01' => '01.gif',
		'/02' => '02.gif',
		'/03' => '03.gif',
		'/04' => '04.gif',
		'/05' => '05.gif',
		'/06' => '06.gif',
		'/07' => '07.gif',
		'/08' => '08.gif',
		'/09' => '09.gif',
		'/10' => '10.gif',
		'/11' => '11.gif',
		'/12' => '12.gif',
		'/13' => '13.gif',
		'/14' => '14.gif',
		'/15' => '15.gif',
		'/16' => '16.gif',

		);
}
function custom_smilies_src($src, $img)
{
	return get_bloginfo('template_directory').'/image/smiley/' . $img;
}
add_filter('smilies_src', 'custom_smilies_src', 10, 2);

####################################################################################################
#
#	访客链接新窗口打开
#
####################################################################################################
function comment_author_link_window()
{
	global $comment; 
	$url = get_comment_author_url(); 
	$author = get_comment_author(); 
	$home =  get_option('home');
	if ( empty( $url ) || 'http://' == $url )
		$return = $author; 
	else 
		$return = "<a href='$home?url=$url' rel='external nofollow' target='_blank'>$author</a>"; 
	return $return; 
}

add_filter('get_comment_author_link', 'comment_author_link_window'); 

####################################################################################################
#
#	评论转向
#
####################################################################################################
function redirect_comment_link()
{
	$redirect = $_GET['url'];
	if($redirect){
		if(strpos($_SERVER['HTTP_REFERER'],get_option('home')) !== false){
			header("Location: $redirect");
			exit;
		} else {
			header("Location:".get_option('home'));
			exit;
		}
	}
}

add_action('init', 'redirect_comment_link');



####################################################################################################
#
#	禁止评论内容
#
####################################################################################################

function lianyue_comment_post( $incoming_comment ) 
{
	global $user_level;
	if( $user_level < 7 ){

		//禁止wp默认提交页面提交
		if( strstr($_SERVER['PHP_SELF'],'wp-comments-post.php') && config('comment_default') == '开启' ){
			wp_die('Please submit the correct address'); 
		}

		//检测评论正确性
		if( $_POST['name_key'] != wp_create_nonce('lianyue_key'.$incoming_comment['comment_post_ID']) && strstr($_SERVER['PHP_SELF'],'wp-comments-post.php')){
			wp_die('Verify that the information is incorrect error'); 
		}

		//已经登录直接返回
		if( is_user_logged_in() ){
			return $incoming_comment ;
		}

		//开启评论检测
		if(config('comment_select') =='开启'){

			//检测url
			$url = config('comment_url');
			$url = trim($url,' ');
			$url = trim($url,"\r\n");
			$url = trim($url,"\n");
			if($url){
				$error_url = str_replace("/","\/",$url);
				$error_url = str_replace(array("\r\n","\n"),"|",$error_url);
				$error_url = "/{$error_url}/";
				$error_url = preg_match($error_url,$incoming_comment['comment_author_url']);
				if($error_url){
					wp_die('Your Website is prohibited'); 
				}
			}

			//检测内容
			$content = config('comment_content');
			$content = trim($content,' ');
			$content = trim($content,"\r\n");
			$content = trim($content,"\n");
			if($content){
				$error_content = str_replace("/","\/",$content);
				$error_content = str_replace(array("\r\n","\n"),"|",$error_content);
				$error_content = "/{$error_content}/";
				$error_content = preg_match($error_content,$incoming_comment['comment_content']);
				if($error_content){
					wp_die('Your Content is prohibited'); 
				}
			}

			//检测 mail
			$mail = config('comment_mail');
			$mail = trim($mail,' ');
			$mail = trim($mail,"\r\n");
			$mail = trim($mail,"\n");
			if($mail){
				$error_mail = str_replace("/","\/",$mail);
				$error_mail = str_replace(array("\r\n","\n"),"|",$error_mail);
				$error_mail = "/{$error_mail}/";
				$error_mail = preg_match($error_mail,$incoming_comment['comment_author_email']);
				if($error_mail){
					wp_die('Your Email is prohibited'); 
				}
			}
			
		}
	
	}
	return( $incoming_comment );
}
add_filter('preprocess_comment', 'lianyue_comment_post');
####################################################################################################
#
#	评论样式
#
####################################################################################################
function lianyue_comment( $comment, $args, $depth )
{
	global $comment_depth,$commentcount,$commentsum,$wpdb,$post,$commentreplycount;
	$lianyue_comment_depth = $comment_depth-1;
	if(!$lianyue_comment_depth){
		$lianyue_comment_depth = '&nbsp;&nbsp';
	}
	if(get_option('default_comments_page')=='newest'){
		if(!$commentcount){
			$page = get_query_var('cpage');
			$cpp = get_option('comments_per_page');
			if( $page == null){
				$commentcount=0;
			}else{
				$commentcount = $cpp * ($page-1);
			}
		}
		
	}else if(!$commentcount) {
		$comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_post_ID = $post->ID AND comment_type = '' AND comment_approved = '1' AND !comment_parent");
		$cnt = count($comments);
		$page = get_query_var('cpage');
		$cpp = get_option('comments_per_page');
		if( $page == null){ 
			$commentcount = $cnt +1;
		}else if( ceil($cnt / $cpp)==1 || ($page != null && $page>1 && $page==ceil($cnt/$cpp))){
			$commentcount = $cnt+1;
		}else {
			$commentcount = $cpp * $page +1;
		}
	 }
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
	case 'pingback' :
	case 'trackback' :
	?>
<li id="li-comment-<?php comment_ID(); ?>">
<div id="comment-<?php comment_ID(); ?>"<?php comment_class(); ?>>
<div class="comment_meta">
<?php
	printf( __( '%1$s%2$s' ),
		sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
		sprintf( '<span class="time">%3$s</span>',
				esc_url( get_comment_link( $comment->comment_ID ) ),
				get_comment_time( 'c' ),
				sprintf( __( '%1$s at %2$s' ), get_comment_date(), get_comment_time() )
		)
	);
?>
<?php if ( $comment->comment_approved == '0' ) : ?>
	<span class="approved"><?php _e( 'Your comment is awaiting moderation.' ); ?></span>
<?php endif; ?>
<span class="reply">
<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
</span>
<?php edit_comment_link( __( '编辑' ), '<span class="edit_link">', '</span>' ); ?>
</div>

<div class="gravatar"><?php echo get_avatar( $comment, $size = '50'); ?></div>


<div class="comment_content"><?php comment_text(); ?></div>
<div class="floor">
		<?php
			if(get_option('default_comments_page')=='newest'){
				if(!$parent_id = $comment->comment_parent ){
					++$commentcount;
					}
				echo '<span>#'.$commentcount.'</span><strong>'.$lianyue_comment_depth .'</strong>';
			}else{

				if(!$parent_id = $comment->comment_parent ){
					--$commentcount;
					}
				echo '<span>#'.$commentcount.'</span><strong>'.$lianyue_comment_depth .'</strong>';

			}
		?>
</div>
</div>
	<?php
	break;
	default :
	?>
<li id="li-comment-<?php comment_ID(); ?>">
<div id="comment-<?php comment_ID(); ?>"<?php comment_class(); ?>>
<div class="comment_meta">
<?php
	printf( __( '%1$s%2$s' ),
		sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
		sprintf( '<span class="time">%3$s</span>',
				esc_url( get_comment_link( $comment->comment_ID ) ),
				get_comment_time( 'c' ),
				sprintf( __( '%1$s at %2$s' ), get_comment_date(), get_comment_time() )
		)
	);
?>
<?php if ( $comment->comment_approved == '0' ) : ?>
	<span class="approved"><?php _e( 'Your comment is awaiting moderation.' ); ?></span>
<?php endif; ?>
<span class="reply">
<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
</span>
<?php edit_comment_link( __( '编辑' ), '<span class="edit_link">', '</span>' ); ?>
</div>
<div class="gravatar"><?php echo get_avatar( $comment, $size = '50'); ?></div>

<div class="comment_content"><?php comment_text(); ?></div>
<div class="floor">
		<?php
			if(get_option('default_comments_page')=='newest'){
				if(!$parent_id = $comment->comment_parent ){
					++$commentcount;
					}
				echo '<span>#'.$commentcount.'</span><strong>'.$lianyue_comment_depth .'</strong>';
			}else{

				if(!$parent_id = $comment->comment_parent ){
					--$commentcount;
					}
				echo '<span>#'.$commentcount.'</span><strong>'.$lianyue_comment_depth .'</strong>';

			}
		?>
</div>
</div>
		<?php
	break;
	endswitch;
}
?>