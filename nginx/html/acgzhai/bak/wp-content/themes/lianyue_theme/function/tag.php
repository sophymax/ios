<?php
#安全检测
if (!defined('DB_NAME')) {
	die('Error Bad child');
	exit; 
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
	if ( $a->name == $b->name ) return 0;
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





####################################################################################################
#
#	tag颜色
#
####################################################################################################
function colorCloud($text)
{ 
	$text = preg_replace_callback('|<a (.+?)>|i', 'colorCloudCallback', $text); 
	return $text; 
} 
function colorCloudCallback($matches) 
{
	$text = $matches[1]; 
	$color = dechex(rand(66999,2963578)); 
	$pattern = '/style=(\'|\")(.*)(\'|\")/i'; 
	$text = preg_replace($pattern, "style=\"color:#{$color};font-size:14px;\"", $text); 
	return "<a $text>"; 
}
add_filter('wp_tag_cloud', 'colorCloud', 1);