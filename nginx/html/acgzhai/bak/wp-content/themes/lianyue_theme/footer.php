<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}
if(is_home()):
?>
<div class="links">
	<h3 class="title"><strong class="right"> <a href="<?php echo rewrite_url('add_links'); ?>" title="申请链接" >申请链接</a> | <a href="<?php echo rewrite_url('links'); ?>" title="所有链接" >所有链接</a> </strong>友情链接</h3>
	<ul>
		<?php echo  wp_list_bookmarks('title_li=&title_before=&title_after=&categorize=0&orderby=id&order=DESC&category=&echo=0'); ?>
		<div class="clear"></div>
	</ul>
	<div class="clear"></div>
</div>
<?php endif; ?>
</div>
<div class="footer" id="footer">
	<p>Copyright&nbsp;&#169;&nbsp;2009-2014&nbsp;<a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>&nbsp;All Rights Reserved! Powered by WP and Theme By <a href="http://www.lianyue.org" target="_blank" rel="nofollow external">恋月</a></p>
	<!--<p><?php echo stripslashes(config('footer')); wp_register('', ' | '); wp_loginout(); ?> | <a href="mailto:<?php bloginfo('admin_email'); ?>">联系站长</a></p>-->
</div>
<?php
wp_footer();
footer_load();
echo '<!--查询'. get_num_queries().'次,耗时'. timer_stop().'秒-->';
?>
</body>
</html>