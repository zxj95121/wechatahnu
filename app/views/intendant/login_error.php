<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>错误提示</title>
    <link rel="stylesheet" href="<?php echo httpd('/public/weui/weui.css') ?>"/>
    <link rel="stylesheet" href="<?php echo httpd('/public/weui/example.css') ?>"/>
</head>
<body ontouchstart>
	<div class="page msg_success js_show">
	    <div class="weui-msg">
	    	<input type="hidden" name="openid" value="<?php echo $openid; ?>">
	        <div class="icon-box">
	            <div class="weui-msg__icon-area"><i class="weui-icon-warn weui-icon_msg"></i></div>
	            <div class="icon-box__ctn">
	                <h3 class="icon-box__title">错误提示</h3>
	                <p class="icon-box__desc">您不是管理员，无法进行登录。</p>
	            </div>
	        </div>
	        <div class="weui-msg__opr-area">
	            <p class="weui-btn-area">
	                <a href="javascript:void(0)" class="weui-btn weui-btn_default">关闭</a>
	            </p>
	        </div>
	        <div class="weui-msg__extra-area">
	            <div class="weui-footer">
	                <p class="weui-footer__links">
	                    <a href="<?php echo $site_url; ?>" class="weui-footer__link"><?php echo $site_name; ?></a>
	                </p>
	                <p class="weui-footer__text"><?php echo $footer_text; ?></p>
	            </div>
	        </div>
	    </div>
	</div>

	<script src="<?php echo httpd('/public/weui/zepto.min.js') ?>"></script>
    <script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
    <script src="https://res.wx.qq.com/open/libs/weuijs/1.1.0/weui.min.js"></script>
    <script src="<?php echo httpd('/public/weui/example.js') ?>"></script>
	<script type="text/javascript" src="https://tajs.qq.com/stats?sId=60520182" charset="UTF-8"></script>
</body>
</html>