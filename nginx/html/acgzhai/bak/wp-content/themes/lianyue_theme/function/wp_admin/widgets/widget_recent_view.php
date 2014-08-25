<?php
#°²È«¼ì²â
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}

$arr['theme'] = 'widget_recent_view';
$arr['value'] = 'view_time';
$arr['limit'] = $number;
echo '<ul>';
echo post_results($arr);
echo '<div class="clear"></div></ul>';
