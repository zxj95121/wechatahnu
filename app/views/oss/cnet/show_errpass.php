<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>校园网详情</title>
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
	<div class="container-fluid">
		<div class="row">
			<div class="jumbotron">
	  			<h1>哎呀，出错了。</h1>
	  			<p>可能是因为您的帐号密码失效了，请点击按钮去重新进行帐号绑定。</p>
	  			<p>
	  				<form method="post" action="<?php echo httpd('/oss/cnet/rebinding'); ?>">
	  					<input type="hidden" name="openid" value="<?php echo $openid; ?>">
	  					<button type="submit" class="btn btn-info btn-lg">重新绑定</button>
	  				</form>
	  			</p>
			</div>
		</div>
	</div>

	

	<script type="text/javascript" src="<?php echo httpd('/public/weui/zepto.min.js') ?>"></script>
	<script src="<?php echo httpd('/public/js/jquery-3.1.1.min.js') ?>"></script>
    <script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
    <script src="https://res.wx.qq.com/open/libs/weuijs/1.1.0/weui.min.js"></script>
    <script src="<?php echo httpd('/public/weui/example.js') ?>"></script>
    <script type="text/javascript" src="<?php echo httpd('/public/bootstrap/js/bootstrap.min.js') ?>"></script>

    <script type="text/javascript">
    	$(function(){

    	})
    </script>
</body>
</html>