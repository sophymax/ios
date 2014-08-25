<?php
/*
 * Content display template, used for both single and index/category/search pages.
 * Iconic One uses custom excerpts on search, home, category and tag pages.
 * @package WordPress - Themonic Framework
 * @subpackage Iconic_One
 * @since Iconic One 1.0
 */
?>
<?php
if(!is_single()){
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="padding:0px;height:160px;overflow:hidden;">
<img src='<?php echo catch_that_image() ?>' style='width:26%;float:left;display:inline;margin:2%;height:110px;'>
		<?php if ( is_sticky() && is_home() && ! is_paged() ) : // for top sticky post with blue border ?>
		<div class="featured-post">
			<?php _e( 'Featured Article', 'themonic' ); ?>
		</div>
		<?php endif; ?>

<div style="width:62%;float:right;display:inline;margin:4%">
		<header class="entry-header"  style="font-size:20px;">
			<?php if ( is_single() ) : ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php else : ?>
			<h2 class="entry-title" style="font-size:20px;">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'themonic' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h2>
			<?php endif; // is_single() ?>
					<?php if ( is_single() ) : //for date on single page ?>	
	<?php if (false){?>
	<div class="below-title-meta" style="font-size:15px;">
		<div class="adt" style="font-size:15px;">
		<?php _e('By','themonic'); ?>
        <span class="author"  style="font-size:15px;">
         <?php echo the_author_posts_link(); ?>
        </span>
         <span class="meta-sep"  style="font-size:15px;">|</span> 
         <?php echo get_the_date(); ?> 
         </div>
		 <div class="adt-comment" style="font-size:15px;">
		 <a class="link-comments"  style="font-size:15px;" href="<?php  comments_link(); ?>"><?php comments_number(__('0 Comment','themonic'),__('1 Comment'),__('% Comments')); ?></a> 
         </div>       
     </div><!-- below title meta end -->
	<?php }?>		
			<?php endif; // display meta-date on single page() ?>
			
			</header><!-- .entry-header -->

		<?php if ( is_search() || is_home() || is_category() || is_tag() ) : // Display Excerpts for Search, home, category and tag pages ?>
		
		<div class="entry-summary">
				<!-- Ico nic One home page thumbnail with custom excerpt -->

<div class="excerpt-thumb">
    <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())) : ?>
        <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'themonic' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
            <?php the_post_thumbnail('excerpt-thumbnail', 'class=alignleft'); ?>
       		</a>
    <?php endif;?>
</div>
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'themonic' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'themonic' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>

	
</div>
	</article><!-- #post -->
<?php
}else{
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="padding:0px;">

		<?php if ( is_sticky() && is_home() && ! is_paged() ) : // for top sticky post with blue border ?>
		<div class="featured-post">
			<?php _e( 'Featured Article', 'themonic' ); ?>
		</div>
		<?php endif; ?>


		<header class="entry-header"  style="font-size:28px;">
			<?php if ( is_single() ) : ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php else : ?>
			<h2 class="entry-title" style="font-size:28px;">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'themonic' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h2>
			<?php endif; // is_single() ?>
					<?php if ( is_single() ) : //for date on single page ?>	
<?php if (false){?>
	<div class="below-title-meta">
		<div class="adt">
		<?php _e('By','themonic'); ?>
        <span class="author">
         <?php echo the_author_posts_link(); ?>
        </span>
         <span class="meta-sep">|</span> 
         <?php echo get_the_date(); ?> 
         </div>
		 <div class="adt-comment">
		 <a class="link-comments" href="<?php  comments_link(); ?>"><?php comments_number(__('0 Comment','themonic'),__('1 Comment'),__('% Comments')); ?></a> 
         </div>       
     </div><!-- below title meta end -->
	<?php }?>		
			<?php endif; // display meta-date on single page() ?>
			
			</header><!-- .entry-header -->

		<?php if ( is_search() || is_home() || is_category() || is_tag() ) : // Display Excerpts for Search, home, category and tag pages ?>
		
		<div class="entry-summary">
				<!-- Ico nic One home page thumbnail with custom excerpt -->

<div class="excerpt-thumb">
    <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())) : ?>
        <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'themonic' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
            <?php the_post_thumbnail('excerpt-thumbnail', 'class=alignleft'); ?>
       		</a>
    <?php endif;?>
</div>
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'themonic' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'themonic' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>

	

	</article><!-- #post -->



<?php
}
?>
