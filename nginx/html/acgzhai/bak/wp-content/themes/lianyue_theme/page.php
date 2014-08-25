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
		<div  <?php post_class('post_page'); ?> id="post-<?php the_ID(); ?> page">
			<h1 class="title"><?php the_title(); ?></h1>
			<div class="content">
				<?php the_content(); ?>
			</div>
		</div>
		<?php comments_template( '', true ); ?>
	</div>
	<?php get_sidebar(); ?>
	<div class="clear"></div>
</div>
<?php get_footer(); ?>