<?php
/**
 * Footer section template.
 * @package WordPress
 * @subpackage Iconic_One
 * @since Iconic One 1.0
 */
?>
	</div><!-- #main .wrapper -->
	<footer id="colophon" role="contentinfo">
		<div class="site-info">
		<div class="footercopy"><?php echo get_theme_mod( 'textarea_copy', 'custom footer text left' ); ?><?php if ( is_home()) { ?>友情链接：<a  target="_blank"  href="http://www.51ity.com/">IT园-编程基地</a>&nbsp;<a   target="_blank"  href="http://www.hmol.com.cn/">华美在线-IT网络技术</a><?php } ?></div>
		<div class="footercredit"><?php echo get_theme_mod( 'custom_text_right', 'custom footer text right' ); ?></div>
		<div class="clear"></div>
		</div><!-- .site-info -->
		</footer><!-- #colophon -->
		<div class="site-wordpress">
		
				<!---->
				</div><!-- .site-info -->
				<div class="clear"></div>
</div><!-- #page -->

<?php wp_footer(); ?>
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fa684300c049024fc67e8bf49272e2b54' type='text/javascript'%3E%3C/script%3E"));
</script>
<!--<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-51483873-1', 'codezhai.com');
  ga('send', 'pageview');

</script>-->
</body>
</html>
