<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!-- saved from url=(0024)http://twbk.twbaika.com/ -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="edge">


    <!-- 引入EasyUI -->
    <link id="easyuiTheme" rel="stylesheet" href="__PUBLIC__/tianwangbaika/easyui.css" type="text/css">

    <link href="__PUBLIC__/tianwangbaika/login.css" rel="stylesheet" type="text/css">
    <title></title>

</head>
<body>
<div class="picimg" style="background-color:rgb(255, 255, 255);background-image:url(&#39;__PUBLIC__/tianwangbaika/back.jpg&#39;); "> </div>
<div class="qlogo-Box">
    <span class="qspan"></span>
    <div class="qContent-login">
        <h2 class="ft qChina"></h2>
        <p class="ft qEnglish"></p>
        <div class="bj2">
            <img class="loginlogo" src="__PUBLIC__/tianwangbaika/loginlogo.png">
            <form id="loginform" method="post" action="#">
                <div class="qinfo-logo">
                    <table>
                        <tbody><tr>
                            <td width="130" class="textr">账号&nbsp;</td>
                            <td class="textl">
                                <input type="text" name="username" id="name" data-options="required:true" class="qiput" placeholder="请输入登录账号">
                            </td>
                        </tr>
                        <tr>
                            <td class="textr">密码&nbsp;</td>
                            <td class="textl">
                                <input type="password" name="password" id="password" data-options="required:true" class="qiput" placeholder="请输入登录密码">
                            </td>
                        </tr>
                        <!--   <tr>
                               <td class="textr">动态验证码&nbsp;</td>
                               <td class="textl" style="position: relative;">
                                   <input type="text" name="captcha" id="captcha" data-options="required:true" class="qiput" placeholder="请输入动态验证码" style="width: 145px;">
                                   <img class="huoqu" src="./twbk.twbaika.com_files/showcaptcha" onclick="initCode()" style="position: absolute; top: 17px;right: 89px;height: 40px;">
                               </td>
                           </tr>
                           <tr>
                               <td class="textr" id="sjht">手机验证码&nbsp;</td>
                               <td class="textl" style="position: relative;">
                                   <input type="text" name="captchaPhone" id="captchaPhone" data-options="required:true" class="qiput" placeholder="请输入手机验证码" style="width: 145px;">
                                   <span onclick="sendPhoneCode()" class="sendBtn cansend ">点击获取</span>
                               </td>
                           </tr>
                           <tr>
                               <td style="height: 10px; line-height: 10px;"></td>
                               <td style="height: 10px; line-height: 10px;">
                                   <span class="sjhshow"></span>
                               </td>
                           </tr>
                            <tr>
                               <td colspan="2"><input type="checkbox" value=""
                                   name="remenber" class="verticalm" id="remenber" style="width: 16px;height: 16px;" >
                                   <label class="verticalm" for="remenber" style="font-size:16px">记住我<span style="color:gray;">（公共电脑请勿勾选）</span></label></td>
                           </tr> -->
                        <tr>
                            <td class="textr">&nbsp;</td>
                            <td class="textl"><button class="qlogo-btn"  type="submit" lay-submit="" lay-filter="formSubmit" id="btn">登  录</button>
                            </td>
                        </tr>
                        </tbody></table>
                </div>
            </form>
        </div>
    </div>

</div>

</body></html>
<script>
    function tishi(str){
        $('#messageBox').text(str);
        $('#messageBox').show();
        setTimeout(function(){
            $('#messageBox').hide();
        },2200);
    }
    $("#btn").click(function() {
        alert('aaaa');
        var username=$('#name').val();
        var password=$('#password').val();


        if (password.length==0) {
            tishi('请输入密码');
            return false;
        }
        $.post(
            "<?php echo C('cfg_app'); ?>/Admin/Index/login",
            {
                username:username,
                password:password
            },
            function (data,state){
                if(state != "success"){
                    tishi('网络请求失败,请重试');
                    return false;
                }else if(data.status != 1){
                    tishi('帐号或密码错误');
                }else{
                    //登录成功
                    window.location.href = data.url;
                }
            }
        );
    });

</script>