<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}
####################################################################################################
#	
#	class 缓存类
#
####################################################################################################
class lianyue_cache{

	var $dir =  '';
	var $file = '';
	var $data = array();
	
	
	//修改默认值
	function __construct() {
	
		$this->dir = cache_dir.'/html/';
		$this->file = cache_file;
		
	}
	
	//创建缓存
	function add( $key, $data ,$time = 60, $group = 'default'){
	
		$time = intval($time);
		if(!$group)
			$group = 'default';
		$this->data[$group][$key] = $data;
		
		//如果没有时间就不写入 文件 返回真
		if(!$time)
			return true;
		
		
		//本地包含选择目录绝对地址
		$dir = $this->dir.$group.'/';
		//检测 index.html
		if (!file_exists($dir.'/index.html')){
			if (!is_dir($dir)){
				@mkdir($dir,0777);
			}
			$fh = @fopen($dir.'/index.html',"w");
			@fwrite($fh,'');
			fclose($fh);
		}
		
		//最低缓存1分钟
		if($time<60)
			$time = 60;
		
		//写入判断类型 
		$arr['time'] = time() + $time;
		if(is_object($data)){
		
			$arr['type'] = 'object';
			$data = json_encode( $data );
		}elseif(is_array($data)){
		
			$arr['type'] = 'array';
			$data = json_encode( $data );
		}elseif(is_numeric($data)){
		
			$arr['type'] = 'numeric';
		}else{
		
			$arr['type'] = 'string';
		}
		$arr = json_encode( $arr );
		$arr = str_pad($arr,50,' ',STR_PAD_RIGHT);
		
		//创建文件
		$file = $dir.'/'.$key.$this->file;
		$fh = @fopen($file, "w");
		@fwrite($fh,$arr.$data);
		@fclose($fh);
	}
	
	//读取缓存
	function get( $key , $group = 'default' ){
	
		if(!$group)
			$group = 'default';
		
		//判断是否已经有有了就直接返回
		if(isset($this->data[$group][$key]))
			return $this->data[$group][$key];

			
		$file = $this->dir.$group.'/'.$key.$this->file;
		//判断文件是否存在
		if(!file_exists($file))
			return false;
		
		$size = filesize($file);
		//读取缓存内容
		//$content = file_get_contents($cache_dir);
		$fh = @fopen( $file,"r");
		$data = @fread($fh,$size);
		@fclose($fh);
		
		//检查数组时间是否过期  内容类型
		$arr = substr($data, 0,50);
		$arr = json_decode($arr,true);
		if($arr['time']<time())
			return false;
			
		$data = substr($data, 50,$size-50);
		if($arr['type']=='array'){
			$data = json_decode($data,true);
		}elseif($arr['type']=='object'){
			$data = json_decode($data,false);
		}
		 
		if( $data === false){
			$data ='';
		}
		//储存进 数组
		$this->data[$group][$key] = $data;
		return $data;
	}

	//删除缓存
	function delete( $key , $group = 'default' ){
		if(!$group)
			$group = 'default';
		
		//删除数组里面的内容
		unset($this->data[$group][$key]);
	
		//再删除文件
		if($group)
			$group = "/{$group}/";

		//目录地址,html地址
		$file = $this->dir.$group.'/'.$key.$this->file;
		//判断文件是否存在
		if( !file_exists( $file ) )
			return false;
		@unlink ( $file );
		return true;
	}
	//	删除全部缓存
	function delete_all($group = '' ){

		//加上目录地址
		$dir = $this->dir.$group;
		//打开目录
		$handle = @opendir($dir);
		//循环
		while ($file = readdir($handle)){
			if ($file != '.' && $file != '..'){
				$address = $dir .'/'. $file;
				if ( is_dir( $address ) ){
					$this->delete_all($file);
				}else{
					@unlink($address);
				}
			}
		}
		$this->data = array();
		return true;
	}

	//	删除指定目录缓存
	function delete_dir( $group = 'default' ){
		if(!$group)
			$group = 'default';
		//加上目录地址
		$dir = $this->dir.$group;
		if(!is_dir($dir))
			return false;
		//打开目录
		$handle = @opendir($dir);
		//循环
		while ($file = readdir($handle)){
			if ($file != '.' && $file != '..'){
				$address = $dir .'/'. $file;
				@unlink($address);
			}
		}
		return true;
	}
}
$lianyue_cache = new lianyue_cache();


####################################################################################################
#
#	创建缓存html 
#
####################################################################################################
function cache_add( $key, $data ,$time = 60, $group = ''){

	if( config('cache_html') != '开启')
		return false;
	global $lianyue_cache;	
	return $lianyue_cache->add( $key, $data ,$time , $group );
	
}
####################################################################################################
#
#	读取缓存html 
#
####################################################################################################
function cache_get( $key , $group = '' ){

	if( config('cache_html') != '开启')
		return false;
	global $lianyue_cache;	
	return $lianyue_cache->get( $key , $group  );
	 
}
####################################################################################################
#
#	删除html缓存
#
####################################################################################################
function cache_delete( $key , $group = ''){

	if( config('cache_html') != '开启')
		return false;
	
	global $lianyue_cache;	
	return $lianyue_cache->delete( $key , $group  );
}

####################################################################################################
#
#	删除html全部缓存
#
####################################################################################################
function cache_flush( $group = '' ){

	if( config('cache_html') != '开启')
		return false;
	global $lianyue_cache;	
	return $lianyue_cache->delete_all( $group );
}

####################################################################################################
#
#	删除图片缓存 目录  里面所有内容
#
####################################################################################################
function delete_image(){
	$dir = cache_dir.'/image/';
    $handle = @opendir($dir);
    if ($handle){
        while ($file = readdir($handle)){
            if ($file != '.' && $file != '..'){	
                @unlink($dir . '/' . $file);
            }
        }
        closedir($handle);
    }
	return true;
}
####################################################################################################
#
#	删除视频缓存 目录  里面所有内容
#
####################################################################################################
function delete_video(){
	$dir = cache_dir.'/video/';
    $handle = @opendir($dir);
    if ($handle){
        while ($file = readdir($handle)){
            if ($file != '.' && $file != '..'){	
                @unlink($dir . '/' . $file);
            }
        }
        closedir($handle);
    }
	return true;
}
####################################################################################################
#
#	删除头像缓存 目录  里面所有内容
#
####################################################################################################
function delete_avatar()
{
	$dir = cache_dir.'/avatar/';
    $handle = @opendir($dir);
    if ($handle){
        while ($file = readdir($handle)){
            if ($file != '.' && $file != '..'){	
                @unlink($dir . '/' . $file);
            }
        }
        closedir($handle);
    }
	return true;
}


####################################################################################################
#
#	 avatar 头像缓存
#
####################################################################################################
function cache_avatar($content,$comment,$size,$default)
{
	$avatar_url = get_bloginfo('template_url').'/cache/avatar/';
	$avatar_file = cache_dir.'/avatar/';
	$file = md5($comment->comment_author_email).'___'.$size.'.jpg';
	if(!file_exists($avatar_file.$file)){
		preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/isU',$content, $index_matches);
		$avatar = $index_matches[1];
		$down = get_url($avatar);
		if(!$down){
			return $content;
		}
		@fwrite(fopen($avatar_file.$file, "w"),$down);
	}
	$avatar_url.= $file;
	return "<img alt='' src='{$avatar_url}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";

}
if( config('cache_avatar')== '开启' ){
	add_filter('get_avatar', 'cache_avatar', 10, 4);
}

