<?php

#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}
get_header(); 
?>
<span id="home_banner_ad"></span>
<?php if(config('home_slide')!='关闭'): ?>
	<div class="home_1">
		<div class="slide left" style="width:700px;">
			<?php
			$args = array(
						'posts_per_page' => 5,
						'post__in' => get_option('sticky_posts'),
						'caller_get_posts' => 1
						);
			query_posts($args);
				while ( have_posts() ) : the_post();
				?>
					<div class="changeDiv">
						<h2>
							<a   href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark" target="_blank"><?php the_title(); ?></a>
							<em><?php 
									$excerpt = str_replace(array("\r\n", "\r", "\n", " ", "\t", "\o", "\x0B", ".", "?"),"",get_the_content(''));
									echo block_uft8(strip_tags($excerpt),36); 
								?></em>
						</h2>
						<a   href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark" target="_blank"><?php echo wp_image(700,270); ?></a>
					</div>
				<?php
				endwhile;
			wp_reset_query();
			?>
		<ul class="thumb">
			<?php
			$args = array(
						'posts_per_page' => 5,
						'post__in' => get_option('sticky_posts'),
						'caller_get_posts' => 1
						);
			query_posts($args);
				while ( have_posts() ) : the_post();
				?>
				<li>
					<a  href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark" target="_blank">
						<?php echo wp_image(50,50); ?>
						<em></em>
					</a>
				</li>
				<?php
				endwhile;
			wp_reset_query();
			?>
		</ul>
		</div>
		<div class="newest left" id="newest">
			<h3 class="title">最新发布</h3>
			<ul>
			<?php
				$content = '';
				$i = 1;
				query_posts('caller_get_posts=1&posts_per_page=5');
				while (have_posts()) : the_post();
					$title = get_the_title();
					$link =	get_permalink();
					$image = wp_image(26,26);
					$color = post_color();
					$content.= "<li>
								<a   target=\"_blank\" href=\"{$link}\" class=\"img\" title=\"{$title}\">{$image}</a>
								<h3><a target=\"_blank\"  href=\"{$link}\" title=\"{$title}\"  {$color} class=\"link\" ><em>{$i}</em>{$title}</a></h3>
								</li>";
					$i++;
				endwhile;
				wp_reset_query();
				echo $content;
			?>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
<?php endif; ?>
<span id="home_banner_ad2"></span>
<?php
/*
	<div class="home_2 home_tab" id="home_tab">
		<h2 class="nav_tab">
			<strong>首页四格</strong>
			<sup>Four-frame</sup>
			<span class="hover">最新主题</span>
			<span>热门主题</span>	
			<span>随机主题</span>
			<span>blog文章</span>
		</h2>
		<ul>
			<p>1</p>
			<p>1</p>
			<p>1</p>
			<p>1</p>
			<p>1</p>
			<p>1</p>
			<p>1</p>
			<p>1</p>
			<p>1</p>
		</ul>
		<ul style="display: none;">
			2
		</ul>
		<ul style="display: none;">
			3
		</ul>
		<ul style="display: none;">
			4
		</ul>
	</div>
*/
?>
	<div class="home_3">
		<div class="home_cat left" id="home_cat">
			<?php if(config('home_tab_image')): ?>
			<div class="home_cat_tab" >
				<h2 class="nav_tab">
					<strong>图片分类</strong>
					<sup>Category</sup>
					<?php
						$categories = explode(",",config('home_tab_image'));
						$home_cat_nav = '';
						foreach ($categories as $category) {
							$cat_title = get_cat_name($category);  //名称
							//$cat_id = get_cat_ID( $category_name );   //分类id
							$cat_link =  get_category_link( $category );  //分类链接
							$cat_array = array_search($category,$categories);  //数组下标
							if($cat_array==0)
								$home_cat_nav.= '<span class="hover" title="'.$cat_title.'">'.$cat_title.'</span>';
							else
								$home_cat_nav.= '<span title="'.$cat_title.'">'.$cat_title.'</span>';
						}
						echo $home_cat_nav;
					?>
				</h2>
				<?php
					$home_cat_content = '';
					foreach ($categories as $category) {
						$cat_array = array_search($category,$categories);  //数组下标
						if($cat_array==0)
							$home_cat_content.='<ul style="display: block;">';
						else
							$home_cat_content.='<ul style="display: none;">';

						query_posts("showposts=6&cat=$category");
							while (have_posts()) : the_post();

								$home_cat_content.='<li>';
								$home_cat_content.='<a href="'.get_permalink().'" '.post_color().' title="'.get_the_title().'" rel="bookmark" target="_blank">';
								$home_cat_content.=wp_image(206,150);
								$home_cat_content.='<span>'.get_the_title().'</span></a></li>';
							endwhile;
						wp_reset_query();
						$home_cat_content.='<div class="clear"></div></ul>';
					}
					echo $home_cat_content;
				?>
			</div>
			<?php 
			endif; 
			if(config('home_list_loop')):
			?>
			<div class="home_cat_list" id="home_cat_list">
				<?php
					$categories = explode(",",config('home_list_loop'));
					$cat_list = '';
					foreach ($categories as $category) {
						$cat_title = get_cat_name($category);  //名称
						//$cat_id = get_cat_ID( $category_name );   //分类id
						$cat_link =  get_category_link( $category );  //分类链接
						$cat_array = array_search($category,$categories);  //数组下标
						if($cat_array%2==1)
							$cat_list.= '<div class="list left list_right">';
						else
							$cat_list.= '<div class="list left">';
						$cat_list.= '<h3 class="title"><a href="'.$cat_link.'" class="more">'.__('More...').'</a><a   href="'.$cat_link.'">'.$cat_title.'</a></h3>';
						query_posts("showposts=8&cat=$category");
							$i = 0;
							$cat_list.= '<ul>';
							while (have_posts()) : the_post();
								if($i%2==0)
									$cat_list.= '<li>';
								else
									$cat_list.= '<li class="odd">';
								$cat_list.= '<span class="date">'.get_the_date('Y-m-d').'</span>';
								$cat_list.= '<a href="'.get_permalink().'" title="'.get_the_title().'" '.post_color().' rel="bookmark" target="_blank">';
								$cat_list.= get_the_title().'</a>';
								$cat_list.= '</li>';
								$i++;
							endwhile;
							$cat_list.= '</ul>';
						wp_reset_query();
						$cat_list.= '</div>';
					}
					echo $cat_list;
				?>
			<div class="clear"></div>
			</div>
		 <?php
		 endif; 
		 if(config('home_list')=='博客列表'){
			$posts = query_posts("$query_string&orderby=date&caller_get_posts=1&showposts=".config('cat_blog_showposts'));
			category_blog();
			wp_reset_query();
		 }elseif(config('home_list')=='图片列表'){
			$posts = query_posts("$query_string&orderby=date&caller_get_posts=1&showposts=".config('cat_image_showposts'));
			category_image();
			wp_reset_query();
		 }if(config('home_list')=='标题列表'){
			$posts = query_posts("$query_string&orderby=date&caller_get_posts=1&showposts=".config('cat_list_showposts'));
			category_list();
			wp_reset_query();
		 }
		 ?>
		 <span id="home_left_foot"></span>

		</div>
		<?php get_sidebar(); ?>
		<div class="clear"></div>
	</div>
<?php get_footer(); ?>