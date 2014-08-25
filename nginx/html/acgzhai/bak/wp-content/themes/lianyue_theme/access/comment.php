<?php
require( dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/wp-load.php' ); // 此 comments-ajax.php 位於主題資料夾,所以位置已不同
if ( 'POST' != $_SERVER['REQUEST_METHOD'] ) {
	header('Allow: POST');
	header('HTTP/1.1 405 Method Not Allowed');
	header('Content-Type: text/plain');
	die('theme:http://www.lianyue.org');
}

$lianyue_action =  isset($_POST['action'] )  ? trim(strip_tags($_POST['action'])) : '';
$lianyue_key =  isset($_POST['name_key'] )  ? trim(strip_tags($_POST['name_key'])) : '';

if( $lianyue_action == 'article' && $lianyue_key == wp_create_nonce('lianyue_key'.$_POST['comment_post_ID']) ){
	include(dirname(__FILE__) . '/comment_article.php');
}elseif($lianyue_action == 'mood'){
	include(dirname(__FILE__) . '/comment_mood.php');
}