<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $options = get_option('otaku_options'); ?>
<title><?php if ( is_tag() ) { echo wp_title('Tag:');if($paged > 1) printf(' - 第%s页',$paged);echo ' | '; bloginfo( 'name' );} elseif ( is_archive() ) {echo wp_title('');  if($paged > 1) printf(' - 第%s页',$paged);    echo ' | ';    bloginfo( 'name' );} elseif ( is_search() ) {echo '&quot;'.wp_specialchars($s).'&quot;的搜索结果 | '; bloginfo( 'name' );} elseif ( is_home() ) {bloginfo( 'name' );$paged = get_query_var('paged'); if($paged > 1) printf(' - 第%s页',$paged);}  elseif ( is_404() ) {echo '页面不存在！ | '; bloginfo( 'name' );} else {echo wp_title( ' | ', false, right )  ; bloginfo( 'name' );} ?></title>
<?php if (is_single()) {$description = cut_str(strip_tags(apply_filters('the_content',$post->post_content)),200);$keywords = "";$tags = wp_get_post_tags($post->ID);foreach ($tags as $tag ) {$keywords = $keywords . $tag->name . ",";}} else if (is_category()) {$description = category_description();}?>
<meta name="description" content="<?php if (is_home()) { echo ($options['description_content']);} else echo $description;?>"/>
<meta name="keywords" content="<?php if (is_home()) { echo ($options['keyword_content']);} else echo $keywords;?>"/>
<link rel="icon" href="<?php bloginfo('template_url'); ?>/favicon.ico" type="image/x-icon" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'rss2_url' ); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'atom_url' ); ?>" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/style.css" />
<script type="text/javascript" src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
<script type="text/javascript">!window.jQuery && document.write('<script src="<?php bloginfo( 'template_url' ); ?>/jquery.min.js"><\/script>');</script>
<?php if ( is_singular() ){ ?>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/comments-ajax.js"></script>
<?php } ?>
<?php if($options['headcode']) : ?> 
	<?php echo($options['headcode']); ?>
<?php endif; ?>
<?php wp_head(); ?>
</head>

<body>
<div id="wrapper" class="cf"   style="margin:0 auto;">

	<div class="mainbg"></div>
	
   
    	
    <div class="header-wrapper">
        <div id="header" class="clear cf">
       		
            	
            </div>
