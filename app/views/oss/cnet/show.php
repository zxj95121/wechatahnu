<?php
require_once "public/php/jssdk/jssdk.php";
$jssdk = new JSSDK(APPID, APPSECRET);
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?php echo $nickname; ?>的校园网</title>
    <link rel="stylesheet" href="<?php echo httpd('/public/weui/weui.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo httpd('/public/weui/example.css'); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo httpd('/public/bootstrap/css/bootstrap.min.css'); ?>">
    <style type="text/css">
    	.panel-heading h3{
    		position: relative;
    	}
    	.panel-heading span{
    		display: inline-block;
    		position: absolute;
    		right: 0px;
    	}
    </style>
</head>
<body>
	<!-- div class="container-fluid">
		<div class="row">
			<div style="width:98%;margin:0 auto;padding: 0px;" class="col-md-12">
				edf
			</div>
		</div>
	</div> -->
	<div class="page navbar js_show">
	    <div class="page__bd" style="height: 100%;">
	        <div class="weui-tab">
	            <div class="weui-navbar">
	                <div class="weui-navbar__item weui-bar__item_on">
	                    查看数据
	                </div>
	                <div class="weui-navbar__item">
	                    相关操作
	                </div>
	            </div>
	            <div class="weui-tab__panel">
	            	<div id="show" style="width: 100%;">
		            	<div class="panel panel-default">
					  		<div class="panel-heading">
					    		<h3 class="panel-title">数据总览 <span class="glyphicon glyphicon-chevron-down"></span></h3>
					  		</div>
					  		<div class="panel-body">
					    		<table class="table">
									<tr>
										<th style="border-top:0px solid transparent;">本月账户总额</th>
										<td style="border-top:0px solid transparent;"><?php echo $total; ?> 元</td>
									</tr>
									<tr>
										<th>本月消费金额</th>
										<td><?php echo $used; ?> 元</td>
									</tr>
									<tr>
										<th>本月流量总计</th>
										<td><?php echo $all; ?> G</td>
									</tr>
								</table>
								<a href="http://recharge.ahnu.edu.cn/">
									<span class="label label-primary" style = "font-size: 13px;">点我充值校园网（<span style="color:yellow;">牢记：所有的弹框别管它！</span>）</span>
								</a>
					  		</div>
						</div>

						<div class="panel panel-default">
					  		<div class="panel-heading">
					    		<h3 class="panel-title">本月流量详情 <span class="glyphicon glyphicon-chevron-down"></span></h3>
					  		</div>
					  		<div class="panel-body">
					    		<table class="table">
									<tr>
										<th style="border-top:0px solid transparent;">本月下载流量</th>
										<td style="border-top:0px solid transparent;"><?php echo $receive; ?> G</td>
									</tr>
									<tr>
										<th>本月上传流量</th>
										<td><?php echo $send; ?> G</td>
									</tr>
									<tr>
										<th>本月流量总计</th>
										<td><?php echo $all; ?> G</td>
									</tr>
								</table>
								<span class="label label-info">总流量乘以1.5与本月消费有些许差距，正常现象</span>
					  		</div>
						</div>
					</div>
					<div id="operate" style="display: none;width: 100%;">
						<div class="panel panel-default">
					  		<div class="panel-heading">
					    		<h3 class="panel-title">修改校园网密码 <span class="glyphicon glyphicon-chevron-down"></span></h3>
					  		</div>
					  		<div class="panel-body">
					    		<form class="form" id="passwordForm" name="passwordForm">
					    			<div class="input-group" style="margin-bottom: 15px;">
									  	<span class="input-group-addon" id="sizing-addon1">密　　码</span>
									  	<input type="password" name="password1" id="password1" class="form-control" placeholder="字母和数字-最少6位-最多16位" aria-describedby="sizing-addon1">
									</div>
									<div class="input-group" style="margin-bottom: 15px;">
									  	<span class="input-group-addon" id="sizing-addon2">确认密码</span>
									  	<input type="password" name="password2" id="password2" class="form-control" placeholder="字母和数字-最少6位-最多16位" aria-describedby="sizing-addon2">
									</div>
									<div class="form-group">
										<span style="color: red;font-size:13px;" id="editspan"></span>
									</div>
									<div class="form-group">
										<input type="hidden" id="openid" value="<?php echo $openid; ?>">
										<input type="button" class="form-control" id="submit" value="确 认 修 改">
									</div>
					    		</form>
								<span class="label label-danger">本系统已限制：一天只能修改一次，请牢记你修改后的密码。</span>
								<span class="label label-success">写青春网站开发团队-安师大13软件学长（QQ群：624256636）</span>
								<!-- <span class="label label-danger">抱歉:暂不支持修改校园网密码。</span> -->
					  		</div>
						</div>
					</div>
	            </div>
	        </div>
	    </div>
	</div>

	<div id="toast" style="opacity: 0; display: none;">
        <div class="weui-mask_transparent"></div>
        <div class="weui-toast">
            <i class="weui-icon-success-no-circle weui-icon_toast"></i>
            <p class="weui-toast__content">修改成功</p>
        </div>
    </div>


	<script type="text/javascript" src="<?php echo httpd('/public/weui/zepto.min.js') ?>"></script>
	<script src="<?php echo httpd('/public/js/jquery-3.1.1.min.js') ?>"></script>
    <script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
    <script src="https://res.wx.qq.com/open/libs/weuijs/1.1.0/weui.min.js"></script>
    <script src="<?php echo httpd('/public/weui/example.js') ?>"></script>
    <script type="text/javascript" src="<?php echo httpd('/public/bootstrap/js/bootstrap.min.js') ?>"></script>

    <script type="text/javascript">
        wx.config({
		    debug: false,
		    appId: '<?php echo $signPackage["appId"];?>',
		    timestamp: <?php echo $signPackage["timestamp"];?>,
		    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
		    signature: '<?php echo $signPackage["signature"];?>',
		    jsApiList: [
		      // 所有要调用的 API 都要加到这个列表中
				'hideAllNonBaseMenuItem',
				'onMenuShareTimeline',
				'onMenuShareQZone'
		    ]
		});
		wx.ready(function () {
		    // 在这里调用 API
		    // wx.hideAllNonBaseMenuItem();

		    wx.onMenuShareTimeline({
			    title: '<?php echo $nickname; ?>这个月校园网已经用了<?php echo $all;?>G,快来试一试，微信查一查自己用了多少校园网吧~', // 分享标题
			    link: 'wechat.zhangxianjian.com/oss/cnet/cnet', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
			    imgUrl: 'wechat.zhangxianjian.com/public/images/jssdk_xin.jpg', // 分享图标
			    success: function () { 
			        // 用户确认分享后执行的回调函数
			        alert('恭喜你，分享成功');
			    },
			    cancel: function () { 
			        // 用户取消分享后执行的回调函数
			        alert('你竟然取消分享。。');
			    }
			});
			wx.onMenuShareQZone({
			    title: '<?php echo $nickname; ?>这个月校园网已经用了<?php echo $all;?>G,快来试一试，微信查一查自己用了多少校园网吧~', // 分享标题
			    desc: '记得在微信打开链接哦', // 分享描述
			    link: 'wechat.zhangxianjian.com/oss/cnet/cnet', // 分享链接
			    imgUrl: 'wechat.zhangxianjian.com/public/images/jssdk_xin.jpg', // 分享图标
			    success: function () { 
			       // 用户确认分享后执行的回调函数
			       alert('恭喜你，分享成功');
			    },
			    cancel: function () { 
			        // 用户取消分享后执行的回调函数
			        alert('你竟然取消分享。。');
			    }
			});
		});
	</script>

    <script type="text/javascript">
    	$(function(){
    		$('.panel-title').click(function(){
    			var code = $(this).parent().next();
    			if (code.css('display') == 'none') {
    				code.slideDown();
    				$(this).find('span').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
    			} else {
    				code.slideUp();
    				$(this).find('span').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
    			}
    		})

    		$('.weui-navbar__item').click(function(){
    			if ($(this).index() == '1') {
    				$('.weui-navbar__item:eq(0)').removeClass('weui-bar__item_on');
    				$('.weui-navbar__item:eq(1)').addClass('weui-bar__item_on');
    				$('#show').css('display','none');
    				$('#operate').css('display','block');
    			} else {
    				$('.weui-navbar__item:eq(1)').removeClass('weui-bar__item_on');
    				$('.weui-navbar__item:eq(0)').addClass('weui-bar__item_on');
    				$('#operate').css('display','none');
    				$('#show').css('display','block');
    			}
    		})

    		$('#password1').focus(function(){
    			$('#editspan').html('');
    		})
    		$('#password2').focus(function(){
    			$('#editspan').html('');
    		})

    		$('#password1').blur(function(){
    			valid();
    		})
    		$('#password2').blur(function(){
    			valid();
    		})

    		$('#submit').click(function(){
    			if($('#submit').attr('dis')==1){
    				return;
    			}
    			var password1 = $('#password1').val();
    			var password2 = $('#password2').val();
    			var reg1 = /[0-9]+/;
    			var reg2 = /[a-zA-Z]+/;
    			var reg3 = /^[0-9a-zA-Z]{6,16}$/;
    			if(password1 == '') {
    				$('#editspan').html('密码不能为空');
    			} else if (password2 == '') {
    				$('#editspan').html('确认密码不能为空');
    			} else if (!reg1.test(password1) || !reg2.test(password1) || !reg3.test(password1)) {
    				$('#editspan').html('密码格式不正确');
    			} else if (!reg1.test(password2) || !reg2.test(password2) || !reg3.test(password2)) {
    				$('#editspan').html('确认密码格式不正确');
    			} else if (password1 != password2) {
    				$('#editspan').html('两次密码必须相等');
    			} else {
    				//进行ajax修改密码
    				$('#editspan').html('');
    				$('#submit').attr('dis', 1);
    				$('#submit').val('修 改 中...');
    				$.ajax({
    					url: '<?php echo httpd('/oss/cnet/editPassword'); ?>',
    					dataType: 'json',
    					data: {
    						password1: password1,
    						password2: password2,
    						openid: $('#openid').val()
    					},
    					type: 'post',
    					success: function(data){
    						console.log(data);
    						if (data.error == '1') {
    							alert(data.reason);
    							$('#submit').attr('dis', 0);
    							$('#submit').val('确 认 修 改');
    						} else if (data.error == '2'){
    							window.location.href='<?php echo httpd('/oss/cnet/rebinding'); ?>';
    						} else {
    							$('#toast').css({'opacity':'1','display':'block'});
    							$('#submit').attr('dis', 0);
    							$('#submit').val('确 认 修 改');
    							document.passwordForm.reset();
    							setTimeout(function(){
									$('#toast').css({'opacity':'0','display':'none'});
    							},1000);
    						}
    					}
    				})
    			}
    		})
    	})

    	function valid()
    	{
    		var password1 = $('#password1').val();
			var password2 = $('#password2').val();
			var reg1 = /[0-9]+/;
			var reg2 = /[a-zA-Z]+/;
			var reg3 = /^[0-9a-zA-Z]{6,16}$/;
			if(password1 == '') {
				$('#editspan').html('密码不能为空');
			} else if (!reg1.test(password1) || !reg2.test(password1) || !reg3.test(password1)) {
				$('#editspan').html('密码格式不正确');
			} else if (password2 == '') {
				$('#editspan').html('确认密码不能为空');
			} else if (!reg1.test(password2) || !reg2.test(password2) || !reg3.test(password2)) {
				$('#editspan').html('确认密码格式不正确');
			} else if (password1 != password2) {
				$('#editspan').html('两次密码必须相等');
			}
    	}
    </script>
</body>
</html>