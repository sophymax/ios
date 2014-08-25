<html lang="zh">
<head>
<meta charset="utf-8">
<title>糟糕！谷歌浏览器无法找到 <?php echo $_SERVER['HTTP_HOST']; ?></title>
<style media="screen, projection">
	html {background:#e6e6e6;font:.75em/1.5 arial,sans-serif;}
	body {margin:0;font: 12px "微软雅黑", "宋体";}
	div {margin:0 auto;width:98%;max-width:900px;}
	#content {background:#fff;border:2px solid #ccc;width:auto;margin-top:4.332em;padding:1.083em 2em 3em;}
	h1 {font-size:1.5em;margin:1.083em 0 0;color:#333;}
	h1 img {float:right;margin:-6px 0 0 40px;border:0;}
	#content .emph {font-size:1.5em;margin:.5em 0 0;}
	.ldred {color:#c00}
	#content p {font-size:1.083em;margin:-0.2em 0 0;}
	h2{font-size:1.083em;margin:1.083em 0 0;}
	ul{font-size:1.083em;line-height:1.37em;margin:0 0 0 1.5em;padding:0;}
	.snippet{color:#77C;}
	form{text-align:center;}
	input{font-family:arial,sans-serif;font-size:1em;}
	label{display:block;padding:0 0 .8em;text-align:left;}
	#search{width:250px;}
	#about{text-align:center;margin:1.8em 0 0;}
	#about p {margin:0;}
</style>
<!–[if IE]>
<style media="screen, projection">
	div {margin:0 15%;width:100%;}
	#content {margin:0%;margin-top:4.332em;}
</style>
<![endif]–>
 <script type="text/javascript" language="javascript">
	function reloadyemian()//
	{ 
		window.location.href="<?php bloginfo('siteurl');?>"; 
	} 
	window.setTimeout("reloadyemian();",4000); 
</script> 
</head>
<body>
<div>
	 <div id="content">
		 <h1>
			 <a href="<?php echo get_settings('home') ?>">
				<img src="<?php bloginfo('template_url');?>/image/404_logo.gif" alt="Google">
			 </a>
			 糟糕！谷歌浏览器无法找到 <?php echo $_SERVER['HTTP_HOST']; ?>
		 </h1>
		 <p class="emph">尝试重新载入： <a href="<?php bloginfo('home'); ?>"><?php  echo $_SERVER['HTTP_HOST']; ?></a></p>
		 <h2>更多建议 </h2>
		 <ul>
			 <li>访问 <?php  echo $_SERVER['HTTP_HOST']; ?> 的<a href="<?php bloginfo('home'); ?>">网站首页</a></li>
			 <li>进入 <a href="<?php bloginfo('home'); ?>"><?php  echo $_SERVER['HTTP_HOST']; ?></a></li>
			 <li>
				 <form action="<?php bloginfo('siteurl');?>" method="get">
					 <label for="search">在 <?php bloginfo('name'); ?>上搜索：</label>
					 <input type="text" id="search" name="search" value="<?php  echo $_SERVER['HTTP_HOST']; ?>">
					 <input type="submit" value="Google 搜索" >
				 </form>
			 </li>
		 </ul>
	 </div>
	 <div id="about">
		 <p>
			 <a href="<?php bloginfo('name'); ?>" ><?php bloginfo('name'); ?> 帮助</a>
			 -
			 <a href="<?php bloginfo('name'); ?>">为何会出现这个页面？</a>
		 </p>
		@2011 <?php bloginfo('name'); ?> -
		 <a href="<?php bloginfo('home'); ?>"><?php bloginfo('name'); ?> 主页</a>
	 </div>
</div>
</body>
</html>