<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}
?><ul>
	<form role="search" method="get" id="searchform" action="<?php bloginfo('home'); ?>">
		<input type="submit" id="submit" class="submit" value="搜索">
		<input type="text"  name="s" class="s" id="Search" title="Search" value="<?php _e('Search Posts'); ?>" onfocus="if (this.value == '<?php _e('Search Posts'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Search Posts'); ?>';}">
	</form>
</ul>