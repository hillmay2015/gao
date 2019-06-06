<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!-- saved from url=(0033)http://zxhadmin.kfsmaff.com/login -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>渠道商注册</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="author" content="">
    <meta name="description" content="">
    <link href="__PUBLIC__/moban/layout.css" rel="stylesheet">
    <link href="__PUBLIC__/moban/style-responsive.css" rel="stylesheet">

    <style>
        .help-block {
            color: red;
        }
        body{
        background-color: <?php echo C('cfg_bg');?> !important;
        }
    </style>
</head>
<body class="login-body" style="">
<div class="container">
    <form class="form-signin" method="post" action="#"  novalidate="novalidate">
        <div class="form-signin-heading text-center">
            <h1 class="sign-title">渠道商注册</h1>
        </div>
        <div class="login-wrap">
            <input id="phone" type="text" class="form-control" name="phone" placeholder="请填写手机号" autofocus="">

            <input id="name" type="text" class="form-control" name="username" placeholder="请填写用户名" autofocus="">
            <input id="password" type="password" class="form-control" name="password" placeholder="请填写密码">
            <input id="confirm_password" type="password" class="form-control" name="confirm_password" placeholder="请再次确认密码">

            <input type="button" class="btn btn-lg btn-login btn-block" id="btn" value="注册">
        </div>
    </form>
</div>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/home/css/newpay-bb7fcb5546.css">
<link rel="stylesheet" type="text/css" href="__PUBLIC__/home/css/feiqi-ee5401a8e6.css">
<script src="__PUBLIC__/home/js/jquery.js"></script>
<script src="__PUBLIC__/home/js/fontsizeset.js"></script>
<script src="__PUBLIC__/home/js/mui.min.js"></script>
<div style="display: none;top:45%" class="errdeo" id="messageBox">

</div>
<script>
    function tishi(str){
        $('#messageBox').text(str);
        $('#messageBox').show();
        setTimeout(function(){
            $('#messageBox').hide();
        },2200);
    }
    $("#btn").click(function() {
        var phone=$('#phone').val();
        var username=$('#name').val();
        var password=$('#password').val();
        var confirm_password=$('#confirm_password').val();

        if (phone.length==0) {
            tishi('请输入手机号');
            return false;
        }

        if (username.length==0) {
            tishi('请输入用户名');
            return false;
        }
        if (password.length==0) {
            tishi('请输入密码');
            return false;
        }
        if (password!=confirm_password) {
            tishi('两次密码输入不一致');
            return false;
        }
        $.post(
            "<?php echo C('cfg_app'); ?>/Admin/Index/register",
            {
                phone:phone,
                username:username,
                password:password,
                confirm_password:confirm_password
            },
            function (data,state){

             if(data.status == 0){
                 //注册失败
                 tishi(data.info);
             }else{
                 window.location.href = data.url;
                }
            }
        );
    });

</script>

</body></html>