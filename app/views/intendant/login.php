<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">


        <title>管理员登录</title>


        <!-- Bootstrap core CSS -->
        <link href="/public/admin/css/bootstrap.min.css" rel="stylesheet">
        <link href="/public/admin/css/bootstrap-reset.css" rel="stylesheet">

        <!--Animation css-->
        <link href="/public/admin/css/animate.css" rel="stylesheet">

        <!--Icon-fonts css-->
        <link href="/public/admin/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="/public/admin/assets/ionicon/css/ionicons.min.css" rel="stylesheet" />

        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="/public/admin/assets/morris/morris.css">


        <!-- Custom styles for this template -->
        <link href="/public/admin/css/style.css" rel="stylesheet">
        <link href="/public/admin/css/helper.css" rel="stylesheet">
        <link href="/public/admin/css/style-responsive.css" rel="stylesheet" />

        <link rel="stylesheet" href="<?php echo httpd('/public/weui/weui.css') ?>"/>
        <link rel="stylesheet" href="<?php echo httpd('/public/weui/example.css') ?>"/>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->

    </head>


    <body style="background-image: url('/public/admin/images/login_bg.jpg');">

        <div class="wrapper-page animated fadeInDown" style="margin-top:60px;">
            <div class="panel panel-color panel-primary">
                <div class="panel-heading"> 
                   <h3 class="text-center m-t-10"> 欢迎登陆， <strong><?php echo $site_name; ?></strong> </h3>
                </div> 

                <form class="form-horizontal m-t-40" action="index.html" style="text-align: center;">
                                            
                    <div class="form-group" style = "display: inline-block;">
                        <div class="col-md-12" style="text-align: center;">
                        	<img src="/public/admin/images/login_qrcode/<?php echo $qrcode['name'];?>" style="width:220px;height:220px;"/>
                            <div class="js_status" class style="display: none;position: relative;">
                                <div class="status" style="position: absolute;top: 10px;">
                                    <i class="weui-icon-success"></i>
                                    <div class="status_txt"><h5>扫描成功</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        
                        <div class="col-xs-12" id="tishi">
                            请使用微信扫描二维码登录“<?php echo $site_name;?>”管理后台
                        </div>
                    </div>

                    <div class="form-group has-success" id="password_div" style="display: none;">
                        <div class="col-xs-8 col-xs-offset-2">
                               <input type="text" class="form-control" name="password" id="password" placeholder="请输入登录密码">
                        </div>
                    </div>
                    
                    <div class="form-group text-right" id="login_btn_div" style="display: none;">
                        <div class="col-xs-12">
                            <button class="btn btn-purple w-md" type="submit">确认登录</button>
                        </div>
                    </div>
                    <div class="form-group m-t-30" style="text-align: left;">
                        <div class="col-sm-5 col-sm-offset-2">
                            <a href="recoverpw.html"><i class="fa fa-lock m-r-5"></i> 忘记密码?</a>
                        </div>
                        <div class="col-sm-5" style="cursor: pointer;">
                            <a href="recoverpw.html"><i class="ion-person m-r-5"></i> 申请管理员</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <iframe id="frame" name="polling" style="display: none;"></iframe>


        <!-- js placed at the end of the document so the pages load faster -->
        <script src="/public/admin/js/jquery.js"></script>
        <script src="/public/admin/js/bootstrap.min.js"></script>
        <script src="/public/admin/js/pace.min.js"></script>
        <script src="/public/admin/js/wow.min.js"></script>
        <script src="/public/admin/js/jquery.nicescroll.js" type="text/javascript"></script>

        <script type="text/javascript" src="<?php echo httpd('/public/weui/zepto.min.js') ?>"></script>
        <script src="<?php echo httpd('/public/js/jquery-3.1.1.min.js') ?>"></script>
        <script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
        <script src="https://res.wx.qq.com/open/libs/weuijs/1.1.0/weui.min.js"></script>
        <script src="<?php echo httpd('/public/weui/example.js') ?>"></script>
            

        <!--common script for all pages-->
        <script src="/public/admin/js/jquery.app.js"></script>

        <script type="text/javascript">
            $(function () {
            
                var interval = window.setInterval(function () {
                    $("#frame").attr("src", "<?php echo httpd('/Intendant/login/is_login/'.$state); ?>");
                    // 延迟1秒再重新请求
                    window.setTimeout(function () {
                        window.frames["polling"].location.reload();
                    }, 1000);
                    var response = $($("#frame").get(0).contentDocument).find("body").text().trim();
                    if (response == 1) {
                        $('#password_div').css('display', 'block');
                        $('#login_btn_div').css('display', 'block');
                        $('#password')[0].focus();
                        clearInterval(interval);
                    }
                }, 5000);
                
            });
        </script>
    </body>
</html>
