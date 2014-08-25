<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}


//100000执行 1.27 秒
//10000执行 0.263 秒  
//1000执行  0.037 秒
//只读取   不包括写入  只读取图片地址


####################################################################################################
#
#	检测缓存是否存在
#
####################################################################################################
function image_cache($url,$width=120,$height=90,$file = '')
{
	if( config('cache_image') != '开启' )
		return $url;
	//本地保存地址
	$image_file = TEMPLATEPATH.'/cache/image/';
	
	//web 地址
	$image_url = get_bloginfo('template_url').'/cache/image/';
	
	//获得路径
	$home_url[] = $_SERVER['HTTP_HOST'];
	$home_url[] = preg_replace('/^www\./i', '', $_SERVER['HTTP_HOST']);
	$home_url = "({$home_url[0]}|{$home_url[1]})";
	$image_dir = "/^(http|https):\/\/{$home_url}/";
	$image_dir = preg_replace($image_dir, '',$url);

	//如果还有http 说明 就不是本地站 返回默认地址不做处理
	if(substr($image_dir,0,4)=='http')
		return $url;
	//过滤 参数
	$url = str_replace(array('$','?','"','\'','<','>','|',':','*'),"",$url);
	$url = str_replace(' ', '%20', $url);

	//根据地址获得文件类型
	$length = strlen($url);
	$type = substr($url,$length-4);
	$type = strtolower($type);
	if($type =='.png'){
		$image_type = '.png';
	}elseif($type =='.gif'){
		$image_type = '.gif';
	}elseif($type =='.jpg'){
		$image_type = '.jpg';
	}else{
		return $url;
	}
	if($file)
		$file.= '_';

	//文件保存名
	$image_name = "{$file}{$width}x{$height}____".md5($url.TEMPLATEPATH).$image_type;
	$image_file_name = $image_file.$image_name;


	//检测本地文件是否存在 存在就返回
	if(file_exists($image_file_name))
		return $image_url.$image_name;


	
	//判断index.html  和目录是否存在 是否存在	不存在就创建目录
	$index_html = $image_file.'index.html';
	if (!file_exists($index_html)){
		if (!is_dir($image_file)){
			@mkdir($image_file,0777);
		}
		@fwrite(fopen($index_html, "w"),'');
	}
	
	//处理地址 改成本地绝对地址
	$image_dir = $_SERVER['DOCUMENT_ROOT'].$image_dir;


	//创建特色图片
	$image_web = image_handle($image_dir,$image_file_name,$width,$height);
	if($image_web){
		return $image_url.$image_name;
	}else{
		return $url;
	}
}


####################################################################################################
#
#	图片剪切处理
#
####################################################################################################
function image_handle($image_dir,$image_file,$new_width=120,$new_height=90)
{

	//缩放设置  0   1   2   3 
	$zoom_crop =1;

	//清晰度 越高 文件越大
	$quality = 90;

	//截取位置 t = 上左  b = 上中  l = 上右  r =中右  c =中中		
	$align = 'c';

	//默认图像过滤器
	$filters = '';

	//默认锐化值
	$sharpen = 0;

	//默认图片背景颜色
	$canvas_color = 'ffffff';

	//检测是否有那文件
	if(!file_exists($image_dir))
		return false;

	//原图数据信息
	$sData = getimagesize($image_dir);
	$origType = $sData[2];
	$image_type = $sData['mime'];

	$imageFilters = array (
		1 => array (IMG_FILTER_NEGATE, 0),
		2 => array (IMG_FILTER_GRAYSCALE, 0),
		3 => array (IMG_FILTER_BRIGHTNESS, 1),
		4 => array (IMG_FILTER_CONTRAST, 1),
		5 => array (IMG_FILTER_COLORIZE, 4),
		6 => array (IMG_FILTER_EDGEDETECT, 0),
		7 => array (IMG_FILTER_EMBOSS, 0),
		8 => array (IMG_FILTER_GAUSSIAN_BLUR, 0),
		9 => array (IMG_FILTER_SELECTIVE_BLUR, 0),
		10 => array (IMG_FILTER_MEAN_REMOVAL, 0),
		11 => array (IMG_FILTER_SMOOTH, 0),
	);

	//如果没有宽度高度设置默认值
	if ($new_width == 0 )
		$new_width = 100;
	if ($new_height == 0 )
		$new_height = 100;

	// 限制宽度高度
	$new_width = min ($new_width, 900);
	$new_height = min ($new_height, 900);

	// 打开现在有的图片
	if($image_type == 'image/jpg' || $image_type == 'image/jpeg' ){
		$image = imagecreatefromjpeg ($image_dir);
	}elseif($image_type == 'image/png' ){
		$image = imagecreatefrompng ($image_dir);
	}elseif($image_type == 'image/gif' ){
		$image = imagecreatefromgif ($image_dir);
	}else{
		return false;
	}
	


	// 获取原始的宽度和高度
	$width = imagesx ($image);
	$height = imagesy ($image);
	$origin_x = 0;
	$origin_y = 0;



	// 缩小和添加边框
	if ($zoom_crop == 3) {
		$final_height = $height * ($new_width / $width);
		if ($final_height > $new_height) {
			$new_width = $width * ($new_height / $height);
		} else {
			$new_height = $final_height;
		}
	}

	// 创建一个新的图像
	$canvas = imagecreatetruecolor ($new_width, $new_height);
	imagealphablending ($canvas, false);
	if (strlen ($canvas_color) < 6) {
		$canvas_color = 'ffffff';
	}
	$canvas_color_R = hexdec (substr ($canvas_color, 0, 2));
	$canvas_color_G = hexdec (substr ($canvas_color, 2, 2));
	$canvas_color_B = hexdec (substr ($canvas_color, 2, 2));

	//创建一个新的透明色的图像
	$color = imagecolorallocatealpha ($canvas, $canvas_color_R, $canvas_color_G, $canvas_color_B, 127);

	// 完全填充的新形象与分配的颜色背景。
	imagefill ($canvas, 0, 0, $color);

	// 缩小和添加边框
	if ($zoom_crop == 2) {
		$final_height = $height * ($new_width / $width);
		if ($final_height > $new_height) {
			$origin_x = $new_width / 2;
			$new_width = $width * ($new_height / $height);
			$origin_x = round ($origin_x - ($new_width / 2));
		} else {
			$origin_y = $new_height / 2;
			$new_height = $final_height;
			$origin_y = round ($origin_y - ($new_height / 2));
		}
	}

	// 恢复透明度混合
	imagesavealpha ($canvas, true);

	if ($zoom_crop > 0) {

		$src_x = $src_y = 0;
		$src_w = $width;
		$src_h = $height;
		$cmp_x = $width / $new_width;
		$cmp_y = $height / $new_height;

		// 计算X或Y坐标和源的宽度或高度
		if ($cmp_x > $cmp_y) {
			$src_w = round ($width / $cmp_x * $cmp_y);
			$src_x = round (($width - ($width / $cmp_x * $cmp_y)) / 2);
		} else if ($cmp_y > $cmp_x) {
			$src_h = round ($height / $cmp_y * $cmp_x);
			$src_y = round (($height - ($height / $cmp_y * $cmp_x)) / 2);

		}

		//位置裁剪！
		if ($align) {
			if (strpos ($align, 't') !== false) {
				$src_y = 0;
			}
			if (strpos ($align, 'b') !== false) {
				$src_y = $height - $src_h;
			}
			if (strpos ($align, 'l') !== false) {
				$src_x = 0;
			}
			if (strpos ($align, 'r') !== false) {
				$src_x = $width - $src_w;
			}
		}
		imagecopyresampled ($canvas, $image, $origin_x, $origin_y, $src_x, $src_y, $new_width, $new_height, $src_w, $src_h);
	} else {
		// 复制并调整其大小与重采样图像的一部分
		imagecopyresampled ($canvas, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	}

	if ($filters != '' && function_exists ('imagefilter')) {
		// 过滤器适用于图像
		$filterList = explode ('|', $filters);
		foreach ($filterList as $fl) {
			$filterSettings = explode (',', $fl);
			if (isset ($imageFilters[$filterSettings[0]])) {
				for ($i = 0; $i < 4; $i ++) {
					if (!isset ($filterSettings[$i])) {
						$filterSettings[$i] = null;
					} else {
						$filterSettings[$i] = (int) $filterSettings[$i];
					}
				}
				switch ($imageFilters[$filterSettings[0]][1]) {
					case 1:
						imagefilter ($canvas, $imageFilters[$filterSettings[0]][0], $filterSettings[1]);
						break;
					case 2:
						imagefilter ($canvas, $imageFilters[$filterSettings[0]][0], $filterSettings[1], $filterSettings[2]);
						break;
					case 3:
						imagefilter ($canvas, $imageFilters[$filterSettings[0]][0], $filterSettings[1], $filterSettings[2], $filterSettings[3]);
						break;
					case 4:
						imagefilter ($canvas, $imageFilters[$filterSettings[0]][0], $filterSettings[1], $filterSettings[2], $filterSettings[3], $filterSettings[4]);
						break;
					default:
						imagefilter ($canvas, $imageFilters[$filterSettings[0]][0]);
						break;
				}
			}
		}
	}

	//锐利化图像
	if ($sharpen && function_exists ('imageconvolution')) {
		$sharpenMatrix = array (
				array (-1,-1,-1),
				array (-1,16,-1),
				array (-1,-1,-1),
				);
		$divisor = 8;
		$offset = 0;
		imageconvolution ($canvas, $sharpenMatrix, $divisor, $offset);
	}

	//直接从WordPress核心代码提取。降低高达70％PNG的大小
	if ( (IMAGETYPE_PNG == $origType || IMAGETYPE_GIF == $origType) && function_exists('imageistruecolor') && !imageistruecolor( $image ) && imagecolortransparent( $image ) > 0 ){
		imagetruecolortopalette( $canvas, false, imagecolorstotal( $image ) );
	}

	$imgType = "";
	if(preg_match('/^image\/(?:jpg|jpeg)$/i', $image_type)){
		$imgType = 'jpg';
		@imagejpeg($canvas, $image_file, $quality); 
	} else if(preg_match('/^image\/png$/i', $image_type)){
		$imgType = 'png';
		@imagepng($canvas, $image_file, floor($quality * 0.09));
	} else if(preg_match('/^image\/gif$/i', $image_type)){
		$imgType = 'gif';
		@imagegif($canvas, $image_file);
	}
	return true;

}







####################################################################################################
#
#	特色图片
#
####################################################################################################
add_theme_support( 'post-thumbnails' );
add_theme_support( 'automatic-feed-links' ). 
set_post_thumbnail_size( 0, 0,true ); 


####################################################################################################
#
#	略缩图
#
####################################################################################################
function wp_image($w,$h,$post_id=0)
{
	
	if($post_id)
		$post = get_post($post_id);  
	else
		global $post;
	
	//读取缓存
	$cache = cache_get($post->ID,'image');
	if($cache !== false){
		if (config('cache_image') == "开启") 
			$cache = image_cache($cache,$w,$h);
		$cache = '<img src="'.$cache.'"alt="'.$post->post_title.'" class="post_thumbnail wp_thumbnail">';
		return $cache;
	}

	$thumbnail_images = thumbnail_images($post->ID);
	if ($thumbnail_images) {
		//文章内容图片
		$images = $thumbnail_images;
	}elseif($wp_video = wp_video( $post->ID )){
		//视频图片
		$images = $wp_video;
	}
	
	//如果还没就截取随机图片
	if(!$images){
		$images_rend = glob(TEMPLATEPATH."/image/image_post/*.*");
		$images_rend_id = array_rand($images_rend,1);
		$images_rend = $images_rend[$images_rend_id];
		$images_rend = str_replace( TEMPLATEPATH, get_bloginfo('template_url'),$images_rend);
		$images = $images_rend;	
	}
	
	cache_add($post->ID,$images,864000,'image');
	
	if (config('cache_image') == "开启") {
		$images = image_cache($images,$w,$h);
	}
	$images = '<img src="'.$images.'" alt="'.$post->post_title.'" class="post_thumbnail wp_thumbnail">';
	return $images;
}

####################################################################################################
#
#	获取文章图片
#
####################################################################################################
function thumbnail_images($post_id)
{
	//检测是否有特色图片
	$has_post_thumbnail= has_post_thumbnail($post_id);
	if ($has_post_thumbnail) {
		$timthumb_src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id),'full');
		$post_timthumb = $timthumb_src[0];
		return $post_timthumb;
	} else {
		//检测是否有文章内有插入图片
		$post_timthumb = '';
		$content = get_post($post_id); 
		$content = $content->post_content; 
		if( config('album') == '开启' ){
			$content = apply_filters('the_content', $content);
			$content = preg_replace('/<img(.*?)class=[\'"]wp-smiley[\'"](.*?)>/isU', '', $content); 
		}
		$content = preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/isU',$content, $index_matches); 
		$first_img_src = $index_matches [1];
		if (!empty($first_img_src) ) {
			$post_timthumb = $first_img_src;
		}
		return $post_timthumb;
	}
}

####################################################################################################
#
#	WordPress视频图片截取
#
####################################################################################################
function wp_video( $post_id )
{
	if( config('cache_video') == '开启' ){
		if(config('cache_video_size') != '大图' )
			return down_video($post_id,false);
		else
			return down_video($post_id,true);
	}
	return false;
}
####################################################################################################
#
#	下载video 图片 并且保存
#
####################################################################################################
function down_video($post_id,$size = true )
{	
	$video_url = get_bloginfo('template_url').'/cache/video/';
	$video_file = cache_dir.'/video/';
	$file = video_id($post_id);
	if(!$file)
		return false;
	$size = $size ? 'large' : 'small' ;
	$file = md5("{$file['type']}+++{$file['id']}").'___'.$size.'.jpg';
	if(file_exists($video_file.$file)){
		return $video_url.$file;
	}
	$video_arr = video_image($post_id);
	if(!$video_arr)
		return false;
	
	$content = get_url($video_arr[$size]);
	if(!$content && $size != 'small')
		$content = get_url($video_arr['small']);
	if(!$content){
		$images_rend = glob(TEMPLATEPATH."/image/image_post/*.*");
		$images_rend_id = array_rand($images_rend,1);
		$images_rend = $images_rend[$images_rend_id];
		$images_rend = str_replace( TEMPLATEPATH, get_bloginfo('template_url'),$images_rend);
		$content = $images_rend;		
	}
	@fwrite(fopen($video_file.$file, "w"),$content);
	return $video_url.$file;
}

####################################################################################################
#
#	获取视频 id 类型
#
####################################################################################################
function video_id($post_id)
{
	$content = get_post($post_id); 
	$content = $content->post_content; 
	if( config('album') == '开启' ){
		$content = apply_filters('the_content', $content);
	}
	if(preg_match('/http:\/\/v\.youku\.com\/v\_show\/id\_([\w\-]+)[\=|.]/i',$content, $matches)){
	
		//youku
		return array('type'=>'youku','id'=>$matches[1]);
	}elseif(preg_match('/http:\/\/player\.youku\.com\/player\.php\/sid\/([\w\-]+)[\=|\/]/i',$content, $matches)){
	
		//youku
		return array('type'=>'youku','id'=>$matches[1]);
	}elseif(preg_match('/http:\/\/www\.tudou\.com\/programs\/view\/([\w\-]+)\//i',$content, $matches)){

		//tudou
		return array('type'=>'tudou','id'=>$matches[1]);
	}elseif(preg_match('/http:\/\/www\.tudou\.com\/v\/([\w\-]+)\//i',$content, $matches)){
	
		//tudou
		return array('type'=>'tudou','id'=>$matches[1]);
	}elseif(preg_match('/http:\/\/video\.sina\.com\.cn\/v\/b\/([\w\-]+)-/i',$content, $matches)){
	
		//sina
		return array('type'=>'sina','id'=>$matches[1]);
	}elseif(preg_match('/http:\/\/you\.video\.sina\.com\.cn\/api\/sinawebApi\/outplayrefer.php\/vid=([\w\-]+)_([0-9]+)_/i',$content, $matches)){

		//sina
		return array('type'=>'sina','id'=>$matches[1]);
	}elseif(preg_match('/http:\/\/my\.ku6\.com\/watch\?v=([\w\-]+)/i',$content, $matches)){
	
		//ku6
		return array('type'=>'ku6','id'=>$matches[1]);
	}elseif(preg_match('/http:\/\/player\.ku6\.com\/refer\/([\w\-]+)\//i',$content, $matches)){
	
		//ku6
		return array('type'=>'ku6','id'=>$matches[1]);
	}elseif(preg_match('/http:\/\/v\.ku6\.com\/show\/([\w\-]+)/i',$content, $matches)){

		//ku6
		$matches[1].= '..';
		return array('type'=>'ku6','id'=>$matches[1]);
	}elseif(preg_match('/http:\/\/player\.ku6\.com\/refer\/([\w\-]+)/i',$content, $matches)){
	
		//ku6
		$matches[1].= '..';
		return array('type'=>'ku6','id'=>$matches[1]);
	}elseif(preg_match('/http:\/\/v.ku6.com\/special\/show_(?:[0-9]+)\/([\w\-]+)/i',$content, $matches)){
	
		//ku6
		$matches[1].= '..';
		return array('type'=>'ku6','id'=>$matches[1]);
	}elseif(preg_match('/http:\/\/www\.56\.com\/(?:[\w]+)\/v_([\w\-]+)\./i',$content, $matches)){

		//56
		return array('type'=>'56','id'=>$matches[1]);
	}elseif(preg_match('/http:\/\/player.56.com\/v_([\w\-]+)./i',$content, $matches)){
	
		//56
		return array('type'=>'56','id'=>$matches[1]);
	}
	return false;
}

####################################################################################################
#
#	获得视频图片地址
#
####################################################################################################
function video_image( $post_id )
{
	$video = video_id($post_id);
	if( $video == false )
		return false;
	
	if($video['type'] == 'youku'){
		//youku
		$content = "http://v.youku.com/player/getPlayList/VideoIDS/{$video['id']}/timezone/+08/version/5/source/out?ran=3683&password=&n=3";
		$content = get_url($content);
		$content = json_decode($content,true);
		if(isset($content['data'][0]['logo'])){
			$video['large'] = $content['data'][0]['logo'];
			$video['small'] = str_replace(".com/1", ".com/0", $video['large']);
			return $video;
		}
		return false;
	}elseif($video['type'] == 'tudou') {
		//tudou
		$content = "http://www.tudou.com/programs/view/{$video['id']}/";
		$content = get_url($content,1);
		$content = strip_tags( $content, '<script>' );
		preg_match('/pic\s*\=\s*\'([\w\-\/\:\.]+)/i',$content, $matches);
		if(isset($matches[1])){
			$video['small'] = $matches[1];
			preg_match('/lpic\s*=\s*\"([\w\-\/\:\.]+)/i',$content, $matches);
			$video['large'] = $matches[1];
			return $video;
		}
		return false;
	}elseif($video['type'] == 'sina') {
		//sina 
		$content = "http://interface.video.sina.com.cn/interface/common/getVideoImage.php?vid={$video['id']}";
		$content = get_url($content);
		preg_match('/imgurl=([\w\-\/\:\.]+)/i',$content, $matches);
		if(isset($matches[1])){
			$video['large'] = $matches[1];
			$video['small'] = str_replace("_2.jpg", "_1.jpg", $matches[1]);
			return  $video;
		}
		return false;
	}elseif($video['type'] == 'ku6'){
		//ku6
		$content = "http://v.ku6.com/fetchVideo4Player/{$video['id']}.html";
		$content = get_url($content);
		$content = json_decode($content,true);
		if(isset($content['data']['picpath'])){
			$video['small'] = $content['data']['picpath'];
			$video['large'] = $content['data']['bigpicpath'];
			return  $video;
		}
		return false;
	}elseif($video['type'] == '56'){
		//56
		$content = "http://vxml.56.com/json/{$video['id']}/?src=out";
		$content = get_url($content);
		$content = json_decode($content,true);
		if(isset($content['info']['img'])){
			$video['small'] = $content['info']['img'];
			$video['large'] = $content['info']['bimg'];
			return  $video;
		}
		return false;
	}
}




####################################################################################################
#
#	打开url 文件
#
####################################################################################################
function get_url($url,$zip = 0)
{
	$context['http'] = array( 'timeout'=>config('cache_down_time')) ;
	$context = stream_context_create($context); 
	$content = @file_get_contents($url, false, $context);
	if($zip)
		$content = ungzip($content);
	
	return $content;
}

####################################################################################################
#
#	unzip gzip 解压缩
#
####################################################################################################
function ungzip($dat) {
    if (! function_exists ( "gzdecode" )) {
      function gzdecode($data) {
        $len = strlen ( $data );
        if ($len < 18 || strcmp ( substr ( $data, 0, 2 ), "\x1f\x8b" )) {
          return null; // Not GZIP format (See RFC 1952)
        }
        $method = ord ( substr ( $data, 2, 1 ) ); // Compression method
        $flags = ord ( substr ( $data, 3, 1 ) ); // Flags
        if ($flags & 31 != $flags) {
          // Reserved bits are set -- NOT ALLOWED by RFC 1952
          return null;
        }
        // NOTE: $mtime may be negative (PHP integer limitations)
        $mtime = unpack ( "V", substr ( $data, 4, 4 ) );
        $mtime = $mtime [1];
        $xfl = substr ( $data, 8, 1 );
        $os = substr ( $data, 8, 1 );
        $headerlen = 10;
        $extralen = 0;
        $extra = "";
        if ($flags & 4) {
          // 2-byte length prefixed EXTRA data in header
          if ($len - $headerlen - 2 < 8) {
            return false; // Invalid format
          }
          $extralen = unpack ( "v", substr ( $data, 8, 2 ) );
          $extralen = $extralen [1];
          if ($len - $headerlen - 2 - $extralen < 8) {
            return false; // Invalid format
          }
          $extra = substr ( $data, 10, $extralen );
          $headerlen += 2 + $extralen;
        }
        
        $filenamelen = 0;
        $filename = "";
        if ($flags & 8) {
          // C-style string file NAME data in header
          if ($len - $headerlen - 1 < 8) {
            return false; // Invalid format
          }
          $filenamelen = strpos ( substr ( $data, 8 + $extralen ), chr ( 0 ) );
          if ($filenamelen === false || $len - $headerlen - $filenamelen - 1 < 8) {
            return false; // Invalid format
          }
          $filename = substr ( $data, $headerlen, $filenamelen );
          $headerlen += $filenamelen + 1;
        }
        
        $commentlen = 0;
        $comment = "";
        if ($flags & 16) {
          // C-style string COMMENT data in header
          if ($len - $headerlen - 1 < 8) {
            return false; // Invalid format
          }
          $commentlen = strpos ( substr ( $data, 8 + $extralen + $filenamelen ), chr ( 0 ) );
          if ($commentlen === false || $len - $headerlen - $commentlen - 1 < 8) {
            return false; // Invalid header format
          }
          $comment = substr ( $data, $headerlen, $commentlen );
          $headerlen += $commentlen + 1;
        }
        
        $headercrc = "";
        if ($flags & 1) {
          // 2-bytes (lowest order) of CRC32 on header present
          if ($len - $headerlen - 2 < 8) {
            return false; // Invalid format
          }
          $calccrc = crc32 ( substr ( $data, 0, $headerlen ) ) & 0xffff;
          $headercrc = unpack ( "v", substr ( $data, $headerlen, 2 ) );
          $headercrc = $headercrc [1];
          if ($headercrc != $calccrc) {
            return false; // Bad header CRC
          }
          $headerlen += 2;
        }
        
        // GZIP FOOTER - These be negative due to PHP's limitations
        $datacrc = unpack ( "V", substr ( $data, - 8, 4 ) );
        $datacrc = $datacrc [1];
        $isize = unpack ( "V", substr ( $data, - 4 ) );
        $isize = $isize [1];
        
        // Perform the decompression:
        $bodylen = $len - $headerlen - 8;
        if ($bodylen < 1) {
          // This should never happen - IMPLEMENTATION BUG!
          return null;
        }
        $body = substr ( $data, $headerlen, $bodylen );
        $data = "";
        if ($bodylen > 0) {
          switch ($method) {
            case 8 :
              // Currently the only supported compression method:
              $data = gzinflate ( $body );
              break;
            default :
              // Unknown compression method
              return false;
          }
        } else {
          // I'm not sure if zero-byte body content is allowed.
        // Allow it for now...  Do nothing...
        }
        
        // Verifiy decompressed size and CRC32:
        // NOTE: This may fail with large data sizes depending on how
        //       PHP's integer limitations affect strlen() since $isize
        //       may be negative for large sizes.
        if ($isize != strlen ( $data ) || crc32 ( $data ) != $datacrc) {
          // Bad format!  Length or CRC doesn't match!
          return false;
        }
        return $data;
      }
    }//if
    $res = gzdecode($dat);
    if($res != null) {
      return $res;
    }
    return $dat;
  }//ungzip

