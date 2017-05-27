<?php
require_once "public/php/jssdk/jssdk.php";
$jssdk = new JSSDK(APPID, APPSECRET);
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>校园网帐号绑定</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<link type="text/css" rel="stylesheet" href="/public/css/oss_cnet_basic.css" />
		<style type="text/css">
			#head{
				background-image:url('<?php echo $headimgurl; ?>');
			}
		</style>
	</head>
	<body>
		<div id="big">
			<div id="title">
				<h3>开源软件&&蓝天论坛微信</h3>
				<p>请绑定校园网帐号</p>
			</div>
			<div id="head">
			</div>
			<!-- <p>注意:请认准本页面从安师大蓝天论坛微信公众号进入。</p> -->
			<div id="form">
				<div id="userName" class="input">
	                <lable>账　号：</lable>
	                <input type="text" id="username" name="name" placeholder="请输入校园网账号" isok=0 required/>
	            </div>
	            <div id="passWord" class="input">
	                <lable>密　码：</lable>
	                <input type="password" id="password" name="password" placeholder="请输入密码" isok=0 required/>
	            </div>
	            <p id="tishi">让你看不到，哈哈哈</p>

            	<button id="login_btn" type="submit">确认绑定</button>
			</div>
			<div id="information">
				<h3>注意</h3>
				<p>蓝天开源查校园网唯一方式</p>
				<p>开源或蓝天官方微信</p>
				<p>自定义菜单网址跳转</p>
				<p>其他方式请勿输密码</p>
			</div>
		</div>
		<script type="text/javascript" src="/public/js/jquery-3.1.1.min.js"></script>
		<script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
			
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
			    ]
			});
			wx.ready(function () {
			    // 在这里调用 API
			    wx.hideAllNonBaseMenuItem();
			});
		</script>
		<script type="text/javascript">
			$(function(){
				var width=parseInt(document.body.clientWidth);
				var height=parseInt(window.innerHeight);
				$('#big').css('top',0.03*height+'px');
				$('#big').css('height',0.97*height+'px');
				$('#title').css('height',0.15*height+'px');
				$('#form').css('marginTop',0.06*height+'px');

				/*开始js检查*/
				$('#username').blur(function(){
					var username=$(this).val();
					var reg=/[0-9a-zA-Z_]{5,20}/;
					var usernamejquery=$(this);
					if(!reg.test(username)){
						$('#tishi').html('账号输入不正确！');
						$('#tishi').css('opacity',1);
						$(this).attr('isok',0);
					}
					else{
						// 请求后台看是否已经有该数据
						$.ajax({
							url:'<?php echo httpd('/oss/cnet/valid_number');?>',
							type:'post',
							data:{
								username:username
							},
							dataType:'json',
							success:function(data){
								console.log(data);
								if(data.error==0){
									//表示账号未绑定
									$('#tishi').css('opacity',0);
									usernamejquery.attr('isok',1);
								}
								else{
									//表示该学号已绑定
									$('#tishi').html('该校园网账号已经进行过绑定！');
									$('#tishi').css('opacity',1);
									usernamejquery.attr('isok',0);
								}
							}
						});
					}
				})
				$('#password').blur(function(){
					var password=$(this).val();
					if(password==''){
						$('#tishi').html('密码不能为空！');
						$('#tishi').css('opacity',1);
						$(this).attr('isok',0);
					}
					else{
						$(this).attr('isok',1);
						$('#tishi').css('opacity',0);
					}
				})

				$('#login_btn').click(function(){
					var username=$('#username').val();
					var password=$('#password').val();
					//先检查是否为空，并做出提示
					if(username==''){
						$('#tishi').html('账号不能为空！');
						$('#tishi').css('opacity',1);
						$('#username').attr('isok',0);
						return;
					}
					if(password==''){
						$('#tishi').html('密码不能为空！');
						$('#tishi').css('opacity',1);
						$('#password').attr('isok',0);
						return;
					}
					if($('#username').attr('isok')==1&&$('#password').attr('isok')==1){
						$('#tishi').html('正在绑定...');
						$('#tishi').css('opacity',1);
						$.ajax({
							url:'<?php echo httpd('/oss/cnet/valid_bind');?>',
							type:'post',
							data:{
								username: username,
								password: password,
								openid: '<?php echo $openid; ?>'
							},
							dataType:'json',
							success: function(data){
								if(data.error==0){
									//表示账号密码无误
									$('#tishi').html('绑定成功！页面即将跳转...');
									$('#tishi').css('opacity',1);
									setTimeout(function(){$('#username').val('');$('#password').val('');window.location.href="<?php echo httpd('/oss/cnet/show?nickname='.$nickname); ?>";},500);
								}
								else{
									//绑定失败
									$('#tishi').html('帐号或密码不正确，绑定失败。');
									$('#tishi').css('opacity',1);
								}
							}
						});
					}
				})
			})
		</script>
	</body>
</html>