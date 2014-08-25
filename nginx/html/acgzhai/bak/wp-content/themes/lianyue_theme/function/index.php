<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}
####################################################################################################
#
#	删除多余注册项
#
####################################################################################################
remove_action( 'wp_head', 'wp_generator');
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

//删除 转换全角
remove_filter('the_content', 'wptexturize');

####################################################################################################
#
#	导航注册
#
####################################################################################################
register_nav_menus(array('menu_head' => 'header导航'));





####################################################################################################
#
#	截断UTF_8 文字
#
####################################################################################################
function block_uft8($content,$bottom,$hide='...')
{
	$returnstr='';
	$i=0;
	$n=0;
	$str_length=strlen($content);
	while (($n<$bottom) and($i<=$str_length)) {
		$temp_str=substr($content,$i,1);
		$ascnum=Ord($temp_str);
		if($ascnum>=224)  {
			$returnstr=$returnstr.substr($content,$i,3);
			$i=$i+3;
			$n++;
		} else if($ascnum>=192){
			$returnstr=$returnstr.substr($content,$i,2);
			$i=$i+2;
			$n++;
		} else if($ascnum>=65 && $ascnum<=90){
			$returnstr=$returnstr.substr($content,$i,1);
			$i=$i+1;
			$n++;
		} else{
			$returnstr=$returnstr.substr($content,$i,1);
			$i=$i+1;
			$n=$n+0.5;
		}
	}
	if ($str_length>$bottom) {
		$returnstr = $returnstr .$hide;
	}
	return $returnstr;
}

####################################################################################################
#
#	分页代码
#
####################################################################################################
function vt_nav( $p = 2 )
{
	if ( is_singular() ) return;
	global $wp_query, $paged;
	$max_page = $wp_query->max_num_pages;
	if ( $max_page == 1 ) return;
	if ( empty( $paged ) ) $paged = 1;
	echo '<span class="page-numbers">' . $paged . ' / ' . $max_page . ' </span> ';
	if ( $paged > 1 ) p_link( $paged - 1, __('&laquo; Previous'),__('&laquo; Previous') );
	if ( $paged > $p + 1 ) p_link( 1, 'First page' );
	if ( $paged > $p + 2 ) echo '<span class="page-numbers">...</span>';
	for( $i = $paged - $p; $i <= $paged + $p; $i++ ) {
		if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<span class='page-numbers current'>{$i}</span> " : p_link( $i );
	}
	if ( $paged < $max_page - $p - 1 ) echo '<span class="page-numbers">...</span>';
	if ( $paged < $max_page - $p ) p_link( $max_page, 'Last page' );
	if ( $paged < $max_page ) p_link( $paged + 1, __('Next &raquo;'), __('Next &raquo;') );
}
function p_link( $i, $title = '', $linktype = '' )
{
	if ( $title == '' ) $title = "The {$i} page";
	if ( $linktype == '' ) { $linktext = $i; } else { $linktext = $linktype; }
	echo "<a class='page-numbers' href='", esc_html( get_pagenum_link( $i ) ), "' title='{$title}'>{$linktext}</a> ";
}


####################################################################################################
#
#	breadcrumb导航
#
####################################################################################################
function wp_breadcrumb()
{
	$line = ' >> ';
	global $page, $paged, $type;
	$pages = '';
	if ( $paged >= 2 ){
		$pages.= $line . '第' . $paged . '页';
	}
	if ( $page >= 2 ){
		$pages.= $line . '第' . $page . '页';
	}
	$breadcrumb = __('Current position').' : <a href="'.get_bloginfo('home').'">'.__('Home').'</a>';
	if($type == 'links'){
		$breadcrumb.= $line . '友情链接';
	}elseif(is_home()){
		$breadcrumb.= '';
	}elseif(is_category()){
		$breadcrumb.= $line . single_cat_title("", false);
	}elseif(is_search()){
		global $s;
		$breadcrumb.= $line . '搜索 <b>'.$s.'</b> 的结果';
	}elseif(is_tag()){
		$breadcrumb.= $line . '标签'.$line .single_tag_title("", false);
	}elseif(is_archive()){
		$breadcrumb.= $line . '存档'.wp_title($line,false,'left');
	}elseif(is_attachment()){
		$breadcrumb.= $line . '附件'.wp_title($line,false,'left');
	}
	$breadcrumb.= $pages;
	return $breadcrumb;
}