<?php
require_once "public/php/jssdk/jssdk.php";
$jssdk = new JSSDK(APPID, APPSECRET);
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>登录确认</title>
    <link rel="stylesheet" href="<?php echo httpd('/public/weui/weui.css') ?>"/>
    <link rel="stylesheet" href="<?php echo httpd('/public/weui/example.css') ?>"/>
</head>
<body ontouchstart>
	<div class="page msg_success js_show">
	    <div class="weui-msg">
	    	<input type="hidden" name="openid" id="openid" value="<?php echo $openid; ?>">
	    	<input type="hidden" name="state" id="state" value="<?php echo $state; ?>">
	        <div class="weui-msg__icon-area"><i class="weui-icon-info weui-icon_msg"></i></div>
	        <div class="weui-msg__text-area">
	            <h2 class="weui-msg__title">友情提示</h2>
	            <p class="weui-msg__desc">您将登录<span><?php echo $site_name; ?></span>管理后台
	        </div>
	        <div class="weui-msg__opr-area">
	            <p class="weui-btn-area">
	                <a href="javascript:void(0)" id="login" class="weui-btn weui-btn_primary">确认登录</a>
	                <a href="javascript:void(0)" id="exit" class="weui-btn weui-btn_default">不是本人操作</a>
	            </p>
	        </div>
	        <div id="toast" style="opacity: 0; display: none;">
		        <div class="weui-mask_transparent"></div>
		        <div class="weui-toast">
		            <i class="weui-icon-success-no-circle weui-icon_toast"></i>
		            <p class="weui-toast__content">登录成功</p>
		        </div>
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

	    <div id="dialogs">
	        <!--BEGIN dialog2-->
	        <div class="js_dialog" id="iosDialog2" style="opacity: 0; display: none;">
	            <div class="weui-mask"></div>
	            <div class="weui-dialog">
	                <div class="weui-dialog__bd">对不起，二维码已失效</div>
	                <div class="weui-dialog__ft">
	                    <a href="javascript:void(0);" class="weui-dialog__btn weui-dialog__btn_primary" id="iosDialog2_close">知道了</a>
	                </div>
	            </div>
	        </div>
	        <!--END dialog2-->

	        <!--BEGIN dialog3-->
	        <div class="js_dialog" id="iosDialog3" style="opacity: 0; display: none;">
	            <div class="weui-mask"></div>
	            <div class="weui-dialog">
	                <div class="weui-dialog__bd">登陆成功，请在电脑上输入密码</div>
	                <div class="weui-dialog__ft">
	                    <a href="javascript:void(0);" class="weui-dialog__btn weui-dialog__btn_primary" id="iosDialog3_close">确　认</a>
	                </div>
	            </div>
	        </div>
	        <!--END dialog3-->
    	</div>
	</div>

	<script type="text/javascript" src="<?php echo httpd('/public/weui/zepto.min.js') ?>"></script>
	<script src="<?php echo httpd('/public/js/jquery-3.1.1.min.js') ?>"></script>
    <script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
    <script src="https://res.wx.qq.com/open/libs/weuijs/1.1.0/weui.min.js"></script>
    <script src="<?php echo httpd('/public/weui/example.js') ?>"></script>

    <script type="text/javascript">
    	$(function(){
    		
    	})
    </script>

    <script type="text/javascript">
        wx.config({
		    debug: false,
		    appId: '<?php echo $signPackage["appId"];?>',
		    timestamp: <?php echo $signPackage["timestamp"];?>,
		    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
		    signature: '<?php echo $signPackage["signature"];?>',
		    jsApiList: [
		      // 所有要调用的 API 都要加到这个列表中
		      	'onMenuShareTimeline',
				'onMenuShareAppMessage',
				'onMenuShareQQ',
				'onMenuShareWeibo',
				'onMenuShareQZone',
				'startRecord',
				'stopRecord',
				'onVoiceRecordEnd',
				'playVoice',
				'pauseVoice',
				'stopVoice',
				'onVoicePlayEnd',
				'uploadVoice',
				'downloadVoice',
				'chooseImage',
				'previewImage',
				'uploadImage',
				'downloadImage',
				'translateVoice',
				'getNetworkType',
				'openLocation',
				'getLocation',
				'hideOptionMenu',
				'showOptionMenu',
				'hideMenuItems',
				'showMenuItems',
				'hideAllNonBaseMenuItem',
				'showAllNonBaseMenuItem',
				'closeWindow',
				'scanQRCode',
				'chooseWXPay',
				'openProductSpecificView',
				'addCard',
				'chooseCard',
				'openCard'
		    ]
		});
		wx.ready(function () {
		    // 在这里调用 API
		    wx.showAllNonBaseMenuItem();

		    $('#exit').click(function(){
		    	wx.closeWindow();
		    });

		    $('#login').click(function(){
		    	var openid = $('#openid').val();
		    	var state = $('#state').val();
		    	$.ajax({
		    		url: '<?php echo httpd('/Intendant/login/confirm') ?>',
		    		dataType: 'json',
		    		type: 'post',
		    		data: {
		    			openid: openid,
		    			state: state
		    		},
		    		success: function(data) {
		    			// console.log(data);
		    			if (data.error == '1') {
		    				$('#iosDialog2').css({'display':'block','opacity':'1'});
		    			} else {
		    				//确认登陆成功
		    				$('#iosDialog3').css({'display':'block','opacity':'1'});
		    			}
		    		}
		    	});
		    })

		    $('#iosDialog2_close').click(function(){
    			$('#iosDialog2').css({'display':'none','opacity':'0'});
    			setTimeout(function(){wx.closeWindow();},500);
    		})

    		$('#iosDialog3_close').click(function(){
    			$('#iosDialog3').css({'display':'none','opacity':'0'});
    			setTimeout(function(){wx.closeWindow();},500);
    		})
		});
	</script>
</body>
</html>