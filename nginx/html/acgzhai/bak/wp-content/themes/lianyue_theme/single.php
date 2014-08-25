<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}

get_header();
 the_post();
?>
<div class="post">
	<div class="left">
		<div  <?php post_class('post_single'); ?> id="post-<?php the_ID(); ?>">
			<h1 class="title"<?php echo	post_color(); ?>><?php the_title(); ?></h1>
			<div class="meta">
				<span class="share">
				<?php if(config('single_share')!='关闭'): ?>
					<div id="ckepop">
						<a class="jiathis_button_tools_1"></a>
						<a class="jiathis_button_tools_2"></a>
						<a class="jiathis_button_tools_3"></a>
						<a class="jiathis jiathis_txt jiathis_separator jtico jtico_jiathis" >更多</a>
					</div>
				<?php endif; ?>
				</span>
				<?php
					$edit ='';
					if ( $url = get_edit_post_link( $post->ID ) )
						$edit = '<span class="edit"><a href="' . $url  . '" title="' . __('Edit This') . '" target="_blank">' . __('Edit This') . '</a></span>';
					$meta = '<span class="date">'.get_the_date().'</span>'; 
					$meta.= '<span class="view">'.number_format(post_view('',1)).'</span>';
					$meta.= '<span class="comment">'.number_format(get_comments_number(0,1,'%')).'</span>';
					$meta.= $edit;
					echo $meta;
				?>
			</div>
			<span id="single_head_ad"></span>
			<div class="content">
				<?php
				if(post_level()){
					post_view_time();
					the_content();
				}else{
					echo '对不起 请登录后浏览';
				}
				?>
			</div>
			<?php
			$array = array( 'before' => '<div class="page_links"><span clss="pages">'.__('Pages:').'</span>',
							'after' => '</div>',
							//'next_or_number' => 'number',
							//'link_before' => '<span clss="pages">',
							//'link_after' => '</span>',
							'pagelink' => '<span>%</span>'
							);
			wp_link_pages( $array );
					?>
			<div class="mood right ">
				<?php echo post_mood(); ?>
			</div>
			<div class="tags" id="tag">
				<?php the_tags('','', ''); ?>
			</div>
			<div class="nav_single" id="nav_single">
				<span class="previous"><?php previous_post_link( ' %link' , '&laquo; %title' , true ) ?></span>
				<span class="next"><?php next_post_link( '%link ' , '%title &raquo;' , true ) ?></span>
				<div class="clear"></div>
			</div>
		</div>
		<span id="single_foot_ad"></span>
		<?php if(config('single_related') != '关闭' ):  ?>
		<div class="related">
			<h2 class="title">相关文章</h2>
			<ul>
				<?php echo related(4); ?>
			</ul>
		</div>
		<?php endif; ?>
		<?php comments_template( '', true ); ?>
	</div>
	<?php get_sidebar(); ?>
	<div class="clear"></div>
</div>
<?php get_footer(); ?>