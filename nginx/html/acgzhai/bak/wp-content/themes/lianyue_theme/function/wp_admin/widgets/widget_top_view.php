<?php
#��ȫ���
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}

//�Զ�ƥ�����
$cats = '';
if($category){
	if(is_single()){
		//����
		$category = get_the_category();
		$cats = @$category[0]->term_id;

	}elseif(is_category()){
		//����
		global $cat;
		$cats = $cat;
	}
}
//ʱ��
if($day){
	$arr['days'] = $day;
}
//����
if($cats){
	$arr['cat'] = $cats;
}
$arr['theme'] = 'widget_top_view';
$arr['value'] = 'view';
$arr['limit'] = $number;
echo '<ul>';
echo post_results($arr);
echo '<div class="clear"></div></ul>';
