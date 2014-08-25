<?php
$post_id = intval($_POST['post_id']);
if(!mood_cookie($post_id))
	die('theme:http://www.lianyue.org');
$mood = $_POST['mood'];
if($mood == 'up'){
	$mood ='mood_up';
}else{
	$mood ='mood_down';
}
echo mood_add($post_id,$mood);