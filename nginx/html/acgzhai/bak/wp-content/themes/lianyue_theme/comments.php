<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}
?>
<div class="comments">
	<?php
		if ( have_comments() ) {
			echo '<ul class="commentlist">';
			wp_list_comments( array( 'callback' => 'lianyue_comment' ) );
			echo '</ul>';
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) {
				echo '<div class="vt_nav">';
				 paginate_comments_links(); 
				echo '</div>';
			}
		 }
	?>
	<span id="comment_ad"></span>
	<?php if ('open' == $post->comment_status) : ?>
	<div class="sb">
		<div id="respond">
			<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
			<?php if ( $user_ID ) : ?>
				<div class="user_logged">
					<?php	printf(__(' <a href="%1$s">%2$s</a> '), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?>
					<a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account'); ?>">
						<?php _e('Log out &raquo;'); ?>
					</a>
				</div>
			<?php else :
					if ( $comment_author != "" ) :
						?>
						<div class="user_logged">
							<?php echo "欢迎回来<strong>{$comment_author}</strong>";  ?>
							<span id="show_author_info">
								<a href="javascript:setStyleDisplay('author_info','');setStyleDisplay('show_author_info','none');setStyleDisplay('hide_author_info','');">[编辑]</a>
							</span>
							<span id="hide_author_info">
								<a href="javascript:setStyleDisplay('author_info','none');setStyleDisplay('show_author_info','');setStyleDisplay('hide_author_info','none');">[关闭]</a>
							</span>
						</div>
					<?php endif; 
						$lianyue_author = $comment_author;
						$lianyue_email = $comment_author_email;
						$lianyue_url = $comment_author_url;
						if(!$lianyue_author){
							$lianyue_author ='Name :';
							$lianyue_email ='Email :';
							$lianyue_url = 'Website :';
						}
					?>
					<div class="author_info" id="author_info">
						<label class="author">
							<input type="text" name="author" id="author" value="<?php echo $lianyue_author; ?>" tabindex="1">
						</label>
						<label class="email">
							<input type="text" name="email" id="email" value="<?php echo $lianyue_email; ?>" tabindex="2">
						</label>
						<label class="url">
							<input type="text" name="url" id="url" value="<?php echo $lianyue_url; ?>" tabindex="3">
						</label>
					</div>
					<?php if ( $comment_author != "" ) : ?>
						<script type="text/javascript">
							function setStyleDisplay(id, status)
							{
								document.getElementById(id).style.display = status;
							}
							setStyleDisplay('hide_author_info','none');
							setStyleDisplay('author_info','none');
						</script>
					<?php endif; ?>
			<?php endif; ?>
				<div class="smiley">
					<a href="javascript:grin('/01')"><img src="<?php bloginfo('template_url'); ?>/image/smiley/01.gif" class="wp-smiley"/></a>
					<a href="javascript:grin('/02')"><img src="<?php bloginfo('template_url'); ?>/image/smiley/02.gif" class="wp-smiley"/></a>
					<a href="javascript:grin('/03')"><img src="<?php bloginfo('template_url'); ?>/image/smiley/03.gif" class="wp-smiley"/></a>
					<a href="javascript:grin('/04')"><img src="<?php bloginfo('template_url'); ?>/image/smiley/04.gif" class="wp-smiley"/></a>
					<a href="javascript:grin('/05')"><img src="<?php bloginfo('template_url'); ?>/image/smiley/05.gif" class="wp-smiley"/></a>
					<a href="javascript:grin('/06')"><img src="<?php bloginfo('template_url'); ?>/image/smiley/06.gif" class="wp-smiley"/></a>
					<a href="javascript:grin('/07')"><img src="<?php bloginfo('template_url'); ?>/image/smiley/07.gif" class="wp-smiley"/></a>
					<a href="javascript:grin('/08')"><img src="<?php bloginfo('template_url'); ?>/image/smiley/08.gif" class="wp-smiley"/></a>
					<a href="javascript:grin('/09')"><img src="<?php bloginfo('template_url'); ?>/image/smiley/09.gif" class="wp-smiley"/></a>
					<a href="javascript:grin('/10')"><img src="<?php bloginfo('template_url'); ?>/image/smiley/10.gif" class="wp-smiley"/></a>
					<a href="javascript:grin('/11')"><img src="<?php bloginfo('template_url'); ?>/image/smiley/11.gif" class="wp-smiley"/></a>
					<a href="javascript:grin('/12')"><img src="<?php bloginfo('template_url'); ?>/image/smiley/12.gif" class="wp-smiley"/></a>
					<a href="javascript:grin('/13')"><img src="<?php bloginfo('template_url'); ?>/image/smiley/13.gif" class="wp-smiley"/></a>
					<a href="javascript:grin('/14')"><img src="<?php bloginfo('template_url'); ?>/image/smiley/14.gif" class="wp-smiley"/></a>
					<a href="javascript:grin('/15')"><img src="<?php bloginfo('template_url'); ?>/image/smiley/15.gif" class="wp-smiley"/></a>
					<a href="javascript:grin('/16')"><img src="<?php bloginfo('template_url'); ?>/image/smiley/16.gif" class="wp-smiley"/></a>
				</div>
				<div class="cancel_comment_reply">
					<?php
					if ( is_singular() )
							wp_enqueue_script( "comment-reply" ); 
					cancel_comment_reply_link() 
					?>
				</div>
				<textarea name="comment" id="comment" cols="93" rows="9" onkeydown=" if(event.altKey && window.event.keyCode == 83) {document.getElementById('submit').click();return false} if(event.ctrlKey&&event.keyCode==13){document.getElementById('submit').click();return false};"></textarea>
				<input name="submit" type="submit" id="submit" tabindex="5" value="Post Comment Alt + S (Ctrl + Enter)" />
				<?php comment_id_fields(); ?> 
				<?php do_action('comment_form', $post->ID); ?>
				<input type="hidden" id="name_key" name="name_key" value="<?php echo wp_create_nonce('lianyue_key'.get_the_ID());  ?>">
				<input type="hidden" name="action" value="article">
			</form>
		</div>
	</div>
<?php endif; ?>
</div>