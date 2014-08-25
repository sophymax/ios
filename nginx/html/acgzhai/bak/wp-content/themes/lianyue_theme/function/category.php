<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}
####################################################################################################
#
#	分类统一标题 
#
####################################################################################################
function category_title()
{
	$title = '<h2 class="title breadcrumb">';
	$title.= '<strong class="right">';
	$title.= get_previous_posts_link().get_next_posts_link();
	$title.= '</strong>';
	$title.= wp_breadcrumb();
	$title.= '</h2>';
	return $title;
}

####################################################################################################
#
#	blog 类型分类
#
####################################################################################################
function category_blog()
{
	global $more;    
	$more = 1; 
	$i=0;
	$blog = '';
	while (have_posts()) : the_post();
		if($i==1)
			$blog.='<span id="cat_blog_ad"></span>';
		$excerpt = str_replace(array("\r\n", "\r", "\n","\t", "\o", "\x0B"," "),"",strip_tags( get_the_content()) );
		$edit ='';
		if ( $url = get_edit_post_link( $post->ID ) )
			$edit = '<span class="edit"><a href="' . $url  . '" title="' . __('Edit This') . '" target="_blank">' . __('Edit This') . '</a></span>';
		if($i%2)
			$blog.= '<li>';
		else
			$blog.= '<li class="odd">';

		$blog.= '<h3><a href="'.get_permalink().'" '.post_color().' title="'.get_the_title().'" rel="bookmark"  target="_blank">';
		$blog.= get_the_title().'</a></h3>';
		$blog.= '<div class="excerpt">';
		$blog.= '<a href="'.get_permalink().'" title="'.get_the_title().'" rel="bookmark"  target="_blank">';
		$blog.= wp_image(200,140).'</a>';
		$blog.= '<p>'.block_uft8($excerpt,200).'</p><div class="clear"></div></div>';
		$blog.= '<div class="meta"><span class="comment">'.number_format(get_comments_number(0,1,'%')).'</span><span class="date">'.get_the_date().'</span><span class="view">'.number_format(post_view()).'</span><span class="category">'.get_the_category_list(',', ' ').'</span>'.$edit;
		$blog.= '</div>';
		$blog.= '</li>';
		$i++;
	 endwhile;


	echo '<div class="cat_blog cat_title content" id="cat_blog">';
	echo category_title();
	echo '<ul>' . $blog . '</ul>';
	echo '<div class="vt_nav">';
	vt_nav();
	echo '</div></div>';
	$blog ='';
}


####################################################################################################
#
#	list 类型分类
#
####################################################################################################

function category_list()
{
	$i=0;
	$list = '';
	while (have_posts()) : the_post();
		if($i==1)
			$list.='<span id="cat_list_ad"></span>';
		if($i%2)
			$list.= '<li class="odd">';
		else
			$list.= '<li>';
		$list.= '<span class="date">'.get_the_date('Y-m-d').'</span>';
		$list.= '<h3><a href="'.get_permalink().'" '.post_color().' title="'.get_the_title().'" rel="bookmark"  target="_blank">';
		$list.= get_the_title().'</a></h3>';
		$list.= '</li>';
		$i++;
	endwhile;

	
	echo '<div class="cat_list cat_title content" id="cat_list">';
	echo category_title();
	echo '<ul>' . $list . '</ul>';
	echo '<div class="vt_nav">';
	vt_nav();
	echo '</div></div>';

}


####################################################################################################
#
#	image 类型分类
#
####################################################################################################
function category_image()
{
	$i=0;
	$image = '';
	while (have_posts()) : the_post();
		if($i%6>=3)
			$image.= '<li class="odd">';
		else
			$image.= '<li>';
		$image.='<a href="'.get_permalink().'" '.post_color().' title="'.get_the_title().'" rel="bookmark"  target="_blank">';
		$image.=wp_image(206,150);
		$image.='<h3>'.get_the_title().'</h3></a></li>';
		$i++;
	endwhile;
	
	echo '<div class="cat_image	cat_title content" id="cat_image">';
	echo category_title();
	echo '<ul>' . $image . '<div class="clear"></div></ul>';
	echo '<div class="clear"></div><div class="vt_nav">';
	vt_nav();
	echo '</div></div>';

}