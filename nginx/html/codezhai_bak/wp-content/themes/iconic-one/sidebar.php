<?php
/**
 * The sidebar containing the main widget area.
 * @package WordPress - Themonic Framework
 * @subpackage Iconic_One
 * @since Iconic One 1.0
 */
?>
	<?php if ( is_active_sidebar( 'themonic-sidebar' ) ) : ?>
		<div id="secondary" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'themonic-sidebar' ); ?>
		</div><!-- #secondary -->
	<?php else : ?>	
	 		<div id="secondary" class="widget-area" role="complementary">
			<?php if(!is_user_logged_in()){?>
			<div class="widget">
				<span class="vcard"><a class="url fn n" href="http://www.codezhai.com/wp-login.php" rel="nofollow" title="Login">登录</a></span>
				<span class="vcard"><a class="url fn n" href="http://www.codezhai.com/wp-login.php?action=register" rel="nofollow" title="Register">注册</a></span>
			</div>
			<?php } ?>
			<div class="widget widget_search">
				<?php get_search_form(); ?>
			</div>
			<div class="widget widget_recent_entries">
				<p class="widget-title"><?php _e( 'Recent Posts', 'themonic' ); ?></p>
				<ul><?php wp_get_archives('type=postbypost&limit=5'); ?></ul>
			</div>
			<div class="widget widget_pages">
			<p class="widget-title"><?php _e( 'Recommend', 'themonic' ); ?></p>
          <ul>
		<?php /*wp_list_pages('title_li='); */?>
		<li>
		<a href="http://www.codezhai.com/code/metaball-cocos2d-shader-cocos2dx/">metaball的cocos2d-x实现：shader实现元球，片段着色器的高效渲染</a>
		</li>
		<li>
		<a href="http://www.codezhai.com/code/%e5%a4%b4%e6%96%87%e4%bb%b6-ios-c-cocos2dx/">OC与C++头文件冲突：iOS下Objective-C与cocos2dx交互的要点</a>
		</li>
		<li>
		<a href="http://www.codezhai.com/code/openresty_ngx-location-capture_at_least_one_subrequest_should_be_specified/">openresty使用笔记3:ngx.location.capture造成的at least one subrequest should be specified错误</a>
		</li>
		<li>
		<a href="http://www.codezhai.com/tech/banned-for-life-google-android/">终生封杀:开发安卓应用的潜在风险,谷歌严厉的处罚政策</a>
		</li>
		<li>
		<a href="http://www.codezhai.com/tech/%E8%85%BE%E8%AE%AF-%E6%8A%84%E8%A2%AD-%E6%AF%95%E4%B8%9A%E8%AE%BE%E8%AE%A1-%E6%B8%B8%E6%88%8F/">清华一学生毕业设计游戏遭腾讯应用市场抄袭，审核团队监守自盗</a>
		</li>
		<li>
		<a href="http://www.codezhai.com/code/clickjacking-amazon-com/">在Amazon.com发现的一个clickjacking安全漏洞</a>
		</li>
		<li>
		<a href="http://www.codezhai.com/code/google-xss-game-appspot-com-%E8%B0%B7%E6%AD%8Cxss%E6%BC%8F%E6%B4%9E%E6%B5%8B%E8%AF%95%E6%B8%B8%E6%88%8F%E6%94%BB%E7%95%A5/">Google’s XSS Game:谷歌XSS漏洞测试游戏xss-game.appspot.com攻略</a>
		</li>
		<li>
		<a href="http://www.codezhai.com/code/openresty-%e7%bc%96%e8%af%91-%e5%8a%a8%e6%80%81%e9%93%be%e6%8e%a5%e5%ba%93-mcrypt-lua/">openresty使用笔记2:编写高速加密动态库之libmcrypt的lua插件化</a>
		</li>

	  </ul>
      </div>
	  
	  <div class="widget widget_tag_cloud">
       <p class="widget-title"><?php _e( 'Tag Cloud', 'themonic' ); ?></p>
        <?php wp_tag_cloud('smallest=10&largest=20&number=30&unit=px&format=flat&orderby=name'); ?>
			</div>





		</div><!-- #secondary -->
	<?php endif; ?>