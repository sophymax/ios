<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}
####################################################################################################
#
#	最近浏览 class
#
####################################################################################################

class recent_view_widget extends WP_Widget {
    //函数创建边栏  ID , 名称 , 描述
    function __construct()
    {
        parent::WP_Widget('recent_view', '最近浏览----------->[边栏]', array('description' => 'WordPress 最近浏览 显示' ) );
    }
    
    //需要显示的内容 
    function widget($args, $instance )
    {
        extract($args );
        $title = apply_filters('widget_title', $instance['title'] );
		$number = absint( $instance['number'] );
        echo $before_widget;
        if ($title ) {
            echo $before_title . $title . $after_title;
        }
		include(dirname(__FILE__)."/widgets/widget_recent_view.php");
         echo $after_widget;
    }
    
    //边栏 选项数据更新
    function update($new_instance, $old_instance )
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
        return $instance;
    }
    
    //边栏设置
    function form($instance )
    {
		$title = $instance['title'] ? esc_attr($instance[ 'title' ]) : '最近浏览';
		$number = isset($instance['number']) ? absint($instance['number']) : 8;
        ?>
        <p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
			<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
		</p>

        <?php
    }
    
}

add_action( 'widgets_init', create_function( '', 'register_widget("recent_view_widget");' ) );




####################################################################################################
#
#	随机文章 class
#
####################################################################################################


class random_single_widget extends WP_Widget {
    //函数创建边栏  ID , 名称 , 描述
    function __construct()
    {
        parent::WP_Widget('random_single', '随机文章----------->[边栏]', array('description' => 'WordPress 随机文章添加的说' ) );
    }
    
    //需要显示的内容 
    function widget($args, $instance )
    {
        extract($args );
        $title = apply_filters('widget_title', $instance['title'] );
		$number = absint( $instance['number'] );
		$category = absint( $instance['category'] );
        echo $before_widget;
        if ($title ) {
            echo $before_title . $title . $after_title;
        }
		include(dirname(__FILE__)."/widgets/widget_random_single.php");
         echo $after_widget;
    }
    
    //边栏 选项数据更新
    function update($new_instance, $old_instance )
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['category'] = (int) $new_instance['category'];
        return $instance;
    }
    
    //边栏设置
    function form($instance )
    {
		$title = $instance['title'] ? esc_attr($instance[ 'title' ]) : '随机文章';
		$number = isset($instance['number']) ? absint($instance['number']) : 10;
		$category = isset($instance['category']) ? absint($instance['category']) : 0;
        ?>
        <p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('自动匹配分类:'); ?></label>
			<select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
				<option <?php if($category==0) echo 'selected="selected"' ; ?> value="0">关闭</option>
				<option <?php if($category==1) echo 'selected="selected"' ; ?>  value="1">开启</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
			<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
		</p>
        <?php
    }
    
}

add_action( 'widgets_init', create_function( '', 'register_widget("random_single_widget");' ) );





####################################################################################################
#
#	热门浏览 class
#
####################################################################################################


class top_view_widget extends WP_Widget {
    //函数创建边栏  ID , 名称 , 描述
    function __construct()
    {
        parent::WP_Widget('top_view', '热门浏览----------->[边栏]', array('description' => 'WordPress 热门文章的说' ) );
    }
    
    //需要显示的内容 
    function widget($args, $instance )
    {
        extract($args );
        $title = apply_filters('widget_title', $instance['title'] );
		$number = absint( $instance['number'] );
		$category = absint( $instance['category'] );
		$day = absint( $instance['day'] );
        echo $before_widget;
        if ($title ) {
            echo $before_title . $title . $after_title;
        }
		include(dirname(__FILE__)."/widgets/widget_top_view.php");
         echo $after_widget;
    }
    
    //边栏 选项数据更新
    function update($new_instance, $old_instance )
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['category'] = (int) $new_instance['category'];
		$instance['day'] = (int) $new_instance['day'];
        return $instance;
    }
    
    //边栏设置
    function form($instance )
    {
		$title = $instance['title'] ? esc_attr($instance[ 'title' ]) : '热门文章';
		$number = isset($instance['number']) ? absint($instance['number']) : 10;
		$category = isset($instance['category']) ? absint($instance['category']) : 0;
		$day = isset($instance['day']) ? absint($instance['day']) : 0;
        ?>
        <p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('自动匹配分类:'); ?></label>
			<select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
				<option <?php if($category==0) echo 'selected="selected"' ; ?> value="0">关闭</option>
				<option <?php if($category==1) echo 'selected="selected"' ; ?>  value="1">开启</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
			<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('day'); ?>">多少天内的文章 0不限制</label>
			<input id="<?php echo $this->get_field_id('day'); ?>" name="<?php echo $this->get_field_name('day'); ?>" type="text" value="<?php echo $day; ?>" size="3" />
		</p>
        <?php
    }
    
}

add_action( 'widgets_init', create_function( '', 'register_widget("top_view_widget");' ) );
