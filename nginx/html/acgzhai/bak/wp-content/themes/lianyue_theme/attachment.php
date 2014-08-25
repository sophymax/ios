<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}
the_post();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php

//分割线
$line = config('title_line');

//整站标题
$blog_name = get_bloginfo('name');

//其他
$title =  wp_title($line,false,'right') . $blog_name;
echo $title; ?></title>
<link rel="canonical" href="<?php echo get_permalink($post->ID);?>" />
<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico" />
<link title="RSS 2.0" type="application/rss+xml" href="<?php bloginfo('rss2_url'); ?>" rel="alternate" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link id="style_css" href="<?php bloginfo('template_url');?>/style.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/script/jquery.js"></script> 
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/script/lianyue.js"></script>
<?php

if ( wp_attachment_is_image() ) :
//注册附加 查询表
function filter_where_previous( $where = '' ) {
	global $post;
	$where .= " AND ID < {$post->ID} ";
	return $where;
}
//注册附加 查询表
function filter_where_next( $where = '' ) {
	global $post;
	$where .= " AND ID > {$post->ID} ";
	return $where;
}

$image_arr['post_parent'] = null ;
$image_arr['post_type'] = 'attachment';
$image_arr['post_mime_type'] = 'image';
$image_arr['post_status'] = 'inherit';
$image_arr['numberposts'] = 2;
$image_arr['orderby'] = 'ID';
$image_arr['suppress_filters'] = '';

//上一页
add_filter( 'posts_where', 'filter_where_previous' );
$image_arr['order'] = 'DESC';
$previous_post = array_values(get_children($image_arr));
remove_filter( 'posts_where', 'filter_where_previous' );

//下一页
add_filter( 'posts_where', 'filter_where_next' );
$image_arr['order'] = 'ASC';
$next_page = array_values(get_children($image_arr));
remove_filter( 'posts_where', 'filter_where_next' );

//储存全部数组
if($previous_post[1])
	$previous_posts[] = $previous_post[1];
$previous_posts[] = $previous_post[0];
$current_post[0] = $post;
$arr_post = array_merge( $previous_posts , $current_post , $next_page );
?>
<script type="text/javascript">
<!--
jQuery(document).ready(function($) {
	$('.annex .media .image img').hover(
		function(){
			upNext(this);
		}	
	)
});
//翻页
function upNext(bigimg){
	var lefturl		= '<?php echo get_permalink($previous_post[0]->ID);  ?>';
	var righturl	= '<?php echo get_permalink($next_page[0]->ID);  ?>';
	var imgurl		= righturl;
	var width	= bigimg.width;
	var height	= bigimg.height;
	bigimg.onmousemove=function(){
		if(event.offsetX<width/2 && lefturl){
			bigimg.style.cursor	= 'url(<?php bloginfo('template_url'); ?>/image/arr_left.cur),auto';
			imgurl = lefturl;
		}else if(righturl){
			bigimg.style.cursor	= 'url(<?php bloginfo('template_url'); ?>/image/arr_right.cur),auto';
			imgurl = righturl;
		}
	}
	bigimg.onmouseup=function(){
		if(imgurl){
			top.location=imgurl;
		}
	}
}
//-->
</script>
<?php
endif;
if (config('seo') == "开启") {
	$description = wp_title('',false) .','. block_uft8(strip_tags($post->post_content),100);
	$keywords = "" ;
}
wp_head();
?>
</head>
<body <?php body_class( $class ); ?> >
<div class="wrapper" id="wrapper">
	<div class="annex" id="attachment">
		<div <?php post_class('media left'); ?> id="post-<?php the_ID(); ?>">
			<?php 
			echo '<h2 class="title breadcrumb">'.wp_breadcrumb().'</h2>';
			if ( wp_attachment_is_image() ) :
			?>
			<div class="image">
				<?php
					$attachment_width = apply_filters( 'twentyten_attachment_size', 760 );
					$attachment_height = apply_filters( 'twentyten_attachment_height', 99999 );
					echo wp_get_attachment_image( $post->ID, array( $attachment_width, $attachment_height ) );
				?>
			</div>
			<?php
			else:
				echo '<div class="down"><a href="'. wp_get_attachment_url() .'" title="'.esc_attr( get_the_title() ).'" class="attachment" target="_blank" rel="attachment">下载文件</a></div>';
			
			
			endif;
			
			$description = strip_tags(apply_filters('the_content', $post->post_content));
			if($description)
				echo '<div class="description">'.$description.'</div>';
				
			if ( wp_attachment_is_image() ) :
			?>
			<div class="simg">
				<ul>
				<?php
				$html = '';
				foreach ( $arr_post as $value ) {
					$s = $value->post_content ? block_uft8(strip_tags($value->post_content),50) : $value->post_title;
					$html.= '<li>';
					$html.= '<a href="'.get_permalink($value->ID).'" title="'.$s.'" rel="bookmark">';
					$html.= '<img src="'.image_cache($value->guid,140,105).'" alt="'.$s.'">';
					$html.= '<span class="title"><p>'.$value->post_title.'</p></span>';
					$html.= '</a>';
					$html.= '</li>';
				
				}
				echo $html;
				?><div class="clear"></div>
				</ul>
			</div>
			<?php endif; ?>
		</div>
		<div class="media_meta right">
			<div class="meta">
				<h2 class="title">附件信息</h2>
				<ul>
					<?php  
					//print_r($post);
						if ( wp_attachment_is_image() )
							$metadata = wp_get_attachment_metadata();
						$the_date = get_the_date();
						$type_annex = $post->post_mime_type;
						$filename = esc_html( basename( $post->guid ) );
						if ( wp_attachment_is_image() ) 
							$annex_url = '<a href="'.$post->guid.'" target="_blank">点击查看</a>';
						else
							$annex_url = '<a href="'.$post->guid.'" target="_blank">点击下载</a>';
						echo "<li><span>名称：</span>{$filename}</li>";
						echo "<li><span>日期：</span>{$the_date}</li>";
						if ( wp_attachment_is_image() )
							echo "<li><span>尺寸：</span>{$metadata['width']}×{$metadata['height']}像素</li>";
						echo "<li><span>类型：</span>{$type_annex}</li>";
						echo "<li><span>地址：</span>{$annex_url}</li>";
						
					?>
				</ul>
			</div>
			<div class="single">
				<h2 class="title">文章地址</h2>
				<ul>
				<?php
				$single = '';
				foreach ( $post->ancestors as $value ) {
					$single.= '<li>';
					$single.= '<a href="'.get_permalink($value).'" title="'.get_the_title($value).'" rel="bookmark"  target="_blank">';
					$single.= wp_image(140,105,$value);
					$single.= '<span class="title">'.get_the_title($value).'</span></a></li>';
				
				}
				echo $single;
				?>
				</ul>
			</div>	
		</div>
	<div class="clear"></div>
	</div>
<?php get_footer(); ?>