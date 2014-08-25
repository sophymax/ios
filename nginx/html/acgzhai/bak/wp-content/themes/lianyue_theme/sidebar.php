<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}
?><div class="right sidebar" id="sidebar">
<?php
if(config('sidebar') =='开启' ){
	dynamic_sidebar('whole');
}elseif(is_home()){
	dynamic_sidebar('home');
}elseif(is_category()){
	dynamic_sidebar('category');
}elseif(is_single()){
	dynamic_sidebar('single');
}elseif(is_page()){
	dynamic_sidebar('page');
}else{
	dynamic_sidebar('else');
}

?>
</div>