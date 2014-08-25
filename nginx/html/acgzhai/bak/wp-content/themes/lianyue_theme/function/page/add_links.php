<?php 
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}
get_header(); 
?>
<div class="post">
	<div class="left">
		<div  class="add_linsk" id="add_linsk">
			<h1 class="title">申请链接</h1>
				<form method="post">
					<table>
						<tbody>
							<?php
							$add_links = add_links();
							if($add_links){
								echo '<tr><td class="odd"></td><td>';
								if($add_links === true ){
									echo '<div class="yes">链接已经成功添加请等待审核!</div>';
								}else{
									echo "<div class=\"no\">$add_links</div>";
								}
								echo '</td></tr>';
							}
							?>
							<tr>
								<td class="odd">申请说明</td>
								<td>
									<p><b> 一般站链接要求 Baidu And Google > 500 正常收录&nbsp;&nbsp;&nbsp;&nbsp; 动漫 , ACG  WordPress相关  优先 正常收录即可</b></p>
								</td>
							</tr>
							<tr>
								<td class="odd">链接名称</td>
								<td><input type="text" class="text"  name="link_name" size="30" tabindex="1" value="<?php if(isset($_POST['link_name'])) echo $_POST['link_name'];?>" id="link_name"></td>
							</tr>
							<tr>
								<td class="odd">链接地址</td>
								<td><input type="text" class="text"  name="link_url" size="30" tabindex="1" value="<?php if(isset($_POST['link_url'])) echo $_POST['link_url'];?>" id="link_url"></td>
							</tr>
							<tr>
								<td class="odd">链接描述</td>
								<td><input type="text" class="text" name="link_description" size="30" tabindex="1" value="<?php if(isset($_POST['link_description'])) echo $_POST['link_description'];?>" id="link_description"></td>
							</tr>
							<tr>
								<td class="odd">链接说明</td>
								<td><textarea name="link_notes" id="link_notes" cols="50" rows="10" ><?php if(isset($_POST['link_notes'])) echo $_POST['link_notes'];?></textarea></td>
							</tr>
							<tr>
								<td class="odd">链接分类</td>
								<td>
								<?php
								global $wpdb; 
								$sql = "SELECT * FROM {$wpdb->term_taxonomy} taxonomy 
										INNER JOIN {$wpdb->terms} term  ON taxonomy.term_id = term.term_id 
										WHERE 1=1 
										AND taxonomy.taxonomy = 'link_category'
										";
								$links_cat = $wpdb->get_results ($sql);
								$links_html = '';
								foreach ( $links_cat as $value ) {
									$checked = '';
									if(isset($_POST['link_category'])){
										if(is_array($_POST['link_category'])){
											if(in_array($value->term_id,$_POST['link_category'])){
												$checked = 'checked="checked"';
											}
										}
									}
									$links_html.= '<label for="in-link-category-'.$value->term_id.'" class="selectit"><input value="'.$value->term_id.'" type="checkbox" class="checkbox" name="link_category[]" '.$checked.' id="in-link-category-'.$value->term_id.'">'.$value->name.' </label> ';
								}
								echo $links_html;
								?>
								</td>
							</tr>
						</tbody>
					</table>
					<div class="submit_div">
						<input type="submit" class="submit" value="添加链接">
					</div>
					<input type="hidden" id="name_key" name="name_key" value="<?php echo wp_create_nonce('lianyue_key'.$type);  ?>">
					<input type="hidden" id="action" name="action" value="add">
				</form>
		</div>
	</div>
	<?php get_sidebar(); ?>
	<div class="clear"></div>
</div>
<?php

function add_links() {
	if(!isset($_POST['action']))
		return false;
		
	$filter = array('\r\n', '\r', '\n', ' ', '\t', '\o', '\x0B','\'','"','\\','<','>');
	
	//链接地址
	$link_url = str_replace($filter,"",$_POST['link_url']);
	preg_match ( '/^(?:http|https):\/\/([0-9a-z\-\.]+)/i',$link_url,$link_url);
	$link_url = $link_url[0];	
	//链接名称
	$link_name = str_replace($filter,"",$_POST['link_name']);

	//链接描述
	$link_description = str_replace($filter,"",$_POST['link_description']);
	
	//链接说明
	$link_notes = str_replace($filter,"",$_POST['link_notes']);
	
	if(!$link_url)
		return '请输入正确的网站地址!';
	if(!$link_name)
		return '请输入网站名称!';
	if(!$link_description)
		return '请输入网站描述!';
	if(!$link_notes)
		return '请输入 申请链接说明!';

	global $wpdb;
	$sql = "SELECT link_url FROM {$wpdb->links}
			WHERE link_url LIKE ('{$link_url}%') ";
	$sql = $wpdb->get_row($sql);
	if($sql->link_url)
		return '你输入的链接已存在或者 正在审核中!';
	//$get_link = get_url($link_url,1);
	//if(!strstr($get_link,get_bloginfo('home')) && $get_link)
	//	return '检测到你尚未添加本站的链接';
	$link_add['link_url'] = $link_url;
	$link_add['link_name'] = $link_name;
	$link_add['link_image'] = '';
	$link_add['link_target'] = '_blank';
	$link_add['link_description'] = $link_description;
	$link_add['link_visible'] = 'N';
	$link_add['link_owner'] = 1;
	$link_add['link_rating'] = 0;
	$link_add['link_rel'] = '';
	$link_add['link_notes'] = $link_notes;
	$link_add['link_rss'] = '';
	$wpdb->insert( $wpdb->links,$link_add);
	$link_category = $_POST['link_category'];
	if(!isset($link_category[0]))
		$link_category[] = get_option( 'default_link_category' ) ;
	$link_category = array_map( 'intval', $link_category );
	$link_category = array_unique( $link_category );
	if (  ! isset( $link_category ) || 0 == count( $link_category ) || !is_array( $link_category )  ) 
		$link_category = array( get_option( 'default_link_category' ) );
	
	//过滤没有的分类
	foreach ( $link_category as $key=>$value ) {
		$sql = "SELECT taxonomy,term_id FROM {$wpdb->term_taxonomy}
				WHERE taxonomy = 'link_category' 
				AND  term_id = {$value} 
				";
		$sql = $wpdb->get_row($sql);
		if(!$sql->term_id)
			unset($link_category[$key]);
	}
	$link_id = (int) $wpdb->insert_id;
	wp_set_object_terms( $link_id, $link_category, 'link_category' );
	clean_bookmark_cache( $link_id );
	$url = get_bloginfo('siteurl');
	$content = <<<lianyue
	<p><b>申请的域名 :</b>{$link_add['link_url']}</p>
	<p><b>申请的名称 :</b>{$link_add['link_name']}</p>
	<p><b>申请的描述 :</b>{$link_add['link_description']}</p>
	<p><b>附加说明</b></p>
	{$link_add['link_description']}
	<p><a href="{$url}/wp-admin/link-manager.php?orderby=visible&order=asc" style="color: #DD4B39;">去审核友情链接</a></p>
lianyue;
	$content = convert_smilies($content);
	$headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
	wp_mail(get_bloginfo('admin_email'),'你的blog有新的链接申请',$content,$headers );
	return true;
}

 get_footer(); ?>
