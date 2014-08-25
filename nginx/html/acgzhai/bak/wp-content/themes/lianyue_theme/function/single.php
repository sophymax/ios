<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}
####################################################################################################
#
#	相关文章
#
####################################################################################################
function related($num = 5,$id=0)
{

	if($id){
		$post_id = $id;
	}else{
		global $post;
		$post_id = $post->ID;
	}

	$cache_related = cache_get("{$post_id}_{$num}",cache_related,'related');
	if($cache_related){
		return $cache_related;
	}

	$related = '';
	$posttags = get_the_tags($post_id);
	$i = 0;
	$exclude_id = '';

	if ($posttags ) {
		$tags = '';
		foreach($posttags as $tag ) $tags .= $tag->name . ',';
		$args = array('post_status' => 'publish',
		'tag_slug__in' => explode(',', $tags), // 只选择tag 文章
		'post__not_in' => explode(',', $exclude_id), //排除已经出现的
		'caller_get_posts' => 1, // 排除置顶文章
		'orderby' => 'comment_date', //依日期排序
		'posts_per_page' => $num
		);
		query_posts($args);
		while (have_posts() ) {
			the_post();
			$related.= '<li>';
			$related.= '<a href="'.get_permalink().'" title="'.get_the_title().'">';
			$related.=  wp_image(172,106);
			$related.= '<h3>'.get_the_title().'</h3>';
			$related.='</a>';
			$related.='</li>';
			
			$exclude_id .= ',' . $post->ID;
			$i ++;
		}
		wp_reset_query();
	}
	if ($i < $num ) {
		// 当tag 不足再提取分类
		$cats = '';
		foreach(get_the_category($post_id) as $cat ) $cats .= $cat->cat_ID . ',';
		$args = array('category__in' => explode(',', $cats), //只选择文章分类文章
		'post__not_in' => explode(',', $exclude_id),
		'caller_get_posts' => 1,
		'orderby' => 'comment_date',
		'posts_per_page' => $num - $i
		);
		query_posts($args);
		while (have_posts() ) {
			the_post();
			$related.= '<li>';
			$related.= '<a href="'.get_permalink().'" title="'.get_the_title().'">';
			$related.=  wp_image(172,106);
			$related.= '<h3>'.get_the_title().'</h3>';
			$related.='</a>';
			$related.='</li>';
			$i++;
		}
		wp_reset_query();
	}
	if($i == 0){
		$related .= '<p style="text-align:center;">没有相关文章</p>';
	}
	cache_add("{$post_id}_{$num}", $related,'related');
	return $related;
}



####################################################################################################
#
#	链接数量
#
####################################################################################################
$match_num_from = config('tag_from');
$match_num_to = config('tag_to');
if (config('tag') == "开启") {
	add_filter('the_content','tag_link',1);
 }
####################################################################################################
#
#	按照长度排序
#
####################################################################################################
function tag_sort($a, $b){
	if ( $a->name == $b->name )
		return 0;
	return ( strlen($a->name) > strlen($b->name) ) ? -1 : 1;
}
####################################################################################################
#
#	改变tag链接
#
####################################################################################################
function tag_link($content)
{
	global $match_num_from,$match_num_to;
	$posttags = get_the_tags();
	if ($posttags) {
		usort($posttags, "tag_sort");
		foreach($posttags as $tag) {
			$link = get_tag_link($tag->term_id); 
			$keyword = $tag->name;
			//连接代码
			$cleankeyword = stripslashes($keyword);
			$url = "<a href=\"$link\" title=\"".str_replace('%s',addcslashes($cleankeyword, '$'),__('View all posts in %s'))."\"";
			$url .= ' target="_blank" class="tag_link"';
			$url .= ">".addcslashes($cleankeyword, '$')."</a>";
			$limit = rand($match_num_from,$match_num_to);
			//不连接的 代码
			$content = preg_replace( '|(<a[^>]+>)(.*)('.$ex_word.')(.*)(</a[^>]*>)|U'.$case, '$1$2%&&&&&%$4$5', $content);
			$content = preg_replace( '|(<img)(.*?)('.$ex_word.')(.*?)(>)|U'.$case, '$1$2%&&&&&%$4$5', $content);
			//置入不连接
			$cleankeyword = preg_quote($cleankeyword,'\'');
			$regEx = '\'(?!((<.*?)|(<a.*?)))('. $cleankeyword . ')(?!(([^<>]*?)>)|([^>]*?</a>))\'s' . $case;
			$content = preg_replace($regEx,$url,$content,$limit);
			$content = str_replace( '%&&&&&%', stripslashes($ex_word), $content);
		}
	}
    return $content; 
}