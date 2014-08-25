<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}


function detect_head()
{
	global $author_url;
	if(!function_exists("detect")){
		die('theme:'.$author_url);
	}
}
####################################################################################################
#
#	foreach 选项循环
#	为 选项页面 提供输入框等
#
####################################################################################################
function admin_foreach($arr = array())
{
	foreach($arr as $value) {
		switch ($value['type'] ) {
			
		case "tab":
			//tab 切换内容
			?>
			<div  class="metabox-holder tab_div <?php if( $value['desc']=='show'){echo 'show';}else{echo 'hide';} ?>">
			<div id="poststuff ">
			<?php
			break;
			
		case "/tab":
			// tab 切换内容 结束
			?>
			</div></div>
			<?php
			break;
			
		case "br":
			//div  换行
			?>
			<div class="inside" style="border-bottom: 1px solid #CCC;margin: 0;padding: 8px 10px;">
			<?php
			break;
			
		case "/br":
			// div  换行 结束
			?>
			</div>
			<?php
			break;
			
		case "frame":
			//div 框架 
			?>
			<div class="postbox ">
			<h3 class="hndle"><span><?php echo $value['desc']; ?></span></h3>
			<?php
			break;
			
		case "/frame":
			//div  框架结束
			?>
			</div>
			<?php
			break;
			
		case 'text':
			//text 输入框
			?>
			<label>
				<span class="description"><?php echo $value['name']; ?> </span>
				<input name="<?php echo $value['id']; ?>" style="width: <?php echo $value['style']; ?>;" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php echo config( $value['id'] ); ?>" />
				<span class="description"><?php echo $value['desc']; ?></span>
			</label>

			<?php
			break;
			
		case 'textarea':
			//textarea 输入框
			?>
			<p><?php echo $value['name']; ?></p>
			<textarea name="<?php echo $value['id']; ?>" rows="7" cols="80"  class="large-text code" style="word-break: break-all;" type="<?php echo $value['type']; ?>" cols="" rows=""><?php echo stripslashes(config($value['id'] )); ?></textarea>
			<p><?php echo $value['desc']; ?></p>

			<?php
			break;
			
		case 'select':
			//select 选项框
			?>
			<label>
				<span class="description"><?php echo $value['name']; ?></span>
				<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
					<?php
					foreach($value['options_admin'] as $option) {
						echo '<option';
						if (config($value['id'] ) == $option) {
							echo ' selected="selected"';
						} else if ($option == $value['std']) {
							echo ' selected="selected"';
						}
						echo '>';
						echo $option;
						echo '</option>';
					
					}
					?>
				</select>
				<span class="description"><?php echo $value['desc'];?></span>
			</label>

			<?php
			break;
			
		case "checkbox":
			//checkbox  勾勾框框
			?>
			
			<?php
			if (config($value['id'])) {
				$checked = "checked=\"checked\"";
			} else {
				$checked = "";
			}
			?>
			<label>
			<span class="description"><?php echo $value['name']; ?></span>
			<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
			<span class="description"><?php echo $value['desc']; ?></span>
			</label>

			<?php
			break;
			
		case "show":
			//show 显示框
			echo $value['desc'];
			
			break;
			
		case "cat":
			//cat切换
			?>
			<div class="allcatsid">
			<ul>
			<?php
			$categories = get_categories('hide_empty=0&orderby=id');
			$wp_cats = array();
			foreach($categories as $category_list ) {
				$wp_cats[$category_list->cat_ID] = $category_list->cat_name;
				echo '<li><h2>';
				echo $wp_cats[$category_list->cat_ID];
				echo '</h2><p>';
				echo $category_list->cat_ID;
				echo '</p></li>';
			}
			?>
			</ul>
			</div>
			<?php break;
	 
		}
	}
}


####################################################################################################
#
#	选项设置config
#	返回值 选项内容 
#	get_option('lianyue_520') = config('520');  也可以用 config('lianyue_520');
#
#####################################################################################################
function config( $o = '' )
{
	if(!$o)
		return;
	
	//判断是否加了lianyue_
	$length = strlen(options_name);
	if(substr($o, 0,$length)!=options_name)
		$o = options_name.$o;
	
	global $lianyue_cache;
	
	//cache_选项
	if(substr($o, 0,$length+6)==options_name.'cache_'){

	
		//判断是否有缓存 有就直接返回
		if(isset($lianyue_cache->data['config']['cache'][$o]))
			return $lianyue_cache->data['config']['cache'][$o];
			
		//默认设置成假
		$lianyue_cache->data['config'][$o] = false;
		$cache_file =  cache_dir.'/cache'.cache_file;
		if (!file_exists($cache_file)){
			global $options_cache;
			foreach($options_cache as $value) {
				$lianyue_cache->data['config']['cache'][$value['id']] = $value['std'];
			}
		}else{
			$fh = @fopen($cache_file,"r");
			$content = @fread($fh,filesize($cache_file));
			fclose($fh);
			$content = json_decode($content,true);
			foreach($content as $key=>$value) {
				$lianyue_cache->data['config']['cache'][$key] = $value;
			}
		}
		//返回
		return $lianyue_cache->data['config']['cache'][$o];
	}

	//判断是否有选项
	$admin	= cache_get('admin','config');
	if(isset($admin[$o]))
		return $admin[$o];
		
	$admin[$o] = false;
	global $options_admin;
	foreach ($options_admin as $value) {
		if (get_option( $value['id'] ) === false) {
			$admin[$value['id']] = $value['std'];
			$lianyue_cache->data['config']['admin'][$value['id']] = $value['std'];
		} else {
			$admin[$value['id']] = get_option( $value['id'] );
			$lianyue_cache->data['config']['admin'][$value['id']] = get_option( $value['id'] );
		}
	}

	cache_add('admin',$admin,864000,'config');
	return $admin[$o];
}