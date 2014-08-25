<?php
#安全检测
if (!defined('DB_NAME')) {
	die('theme:http://www.lianyue.org');
}

####################################################################################################
#
#	wp_mail 函数重写
#	wp_mail(mail地址,标题,内容);
#	发送失败返回假
#
####################################################################################################

if(config('smtp')=='开启'){
	add_action('phpmailer_init','smtp_rewrite',5);
}

function smtp_rewrite($mail) {
	$smtp_secure = config('smtp_secure');
	if($smtp_secure == 'SSL链接'){
		$secure = 'ssl';
	}elseif($smtp_secure == 'TLS链接'){
		$secure = 'tls';
	}else{
		$secure = '';
	}
	
	$smtp = array (
        'host' => stripslashes(config('smtp_host')),
        'port' => stripslashes(config('smtp_port')),
        'secure' => $secure,
        'username' => stripslashes(config('smtp_username')),
        'password' => stripslashes(config('smtp_password'))
    );

    $admin_info = get_userdata(1);
    //发送类型value
    $mail->Mailer = 'smtp';
    //发送者 mail
    $mail->From = $admin_info->user_email;
    //发送者 名称
    $mail->FromName = $admin_info->display_name;
    //发送类型
    $mail->SMTPSecure = $smtp['secure'];
    //发送服务器
    $mail->Host = $smtp['host'];
    //发送端口
    $mail->Port = $smtp['port'];
    //如果有用户名需要登录
    if ($smtp['username'] != '') {
        $mail->SMTPAuth = true;
        $mail->Username = $smtp['username'];
        $mail->Password = $smtp['password'];
    }
}

