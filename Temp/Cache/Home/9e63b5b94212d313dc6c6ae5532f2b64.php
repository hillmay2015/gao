<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!-- saved from url=(0025)http://app.zzshandai.com/ -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="edge">

    <!-- 引入jQuery -->
    <script src="__PUBLIC__/lanrenjiekuan//jquery-1.8.3.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PUBLIC__/lanrenjiekuan//extjquery.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PUBLIC__/lanrenjiekuan//base64.js" type="text/javascript" charset="utf-8"></script>
    <!-- 引入EasyUI -->
    <link id="easyuiTheme" rel="stylesheet" href="__PUBLIC__/lanrenjiekuan//easyui.css" type="text/css">
    <script type="text/javascript" src="__PUBLIC__/lanrenjiekuan//jquery.easyui.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="__PUBLIC__/lanrenjiekuan//easyui-lang-zh_CN.js" charset="utf-8"></script>
    <link href="__PUBLIC__/lanrenjiekuan//login.css" rel="stylesheet" type="text/css">
    <title></title>

</head>
<body>
<div class="picimg" style="background-color:rgb(255, 255, 255);background-image:url(&#39;__PUBLIC__/lanrenjiekuan//back.jpg&#39;); "> </div>
<div class="qlogo-Box">
    <span class="qspan"></span>
    <div class="qContent-login">
        <h2 class="ft qChina"></h2>
        <p class="ft qEnglish"></p>
        <div class="bj2">
            <img class="loginlogo" src="__PUBLIC__/lanrenjiekuan//loginlogo.png">
            <form id="loginform" method="post" action="index.php?&g=Admin&m=Index&a=login">
                <div class="qinfo-logo">
                    <table>
                        <tbody><tr>
                            <td width="130" class="textr">账号&nbsp;</td>
                            <td class="textl">
                                <input type="text" name="username" id="username" data-options="required:true" class="qiput" onblur="hideChannel()" placeholder="请输入登录账号">
                            </td>
                        </tr>
                        <tr>
                            <td class="textr">密码&nbsp;</td>
                            <td class="textl">
                                <input type="password" name="password" id="password" data-options="required:true" class="qiput" placeholder="请输入登录密码">
                            </td>
                        </tr>


                        <!-- <tr>
                            <td colspan="2"><input type="checkbox" value=""
                                name="remenber" class="verticalm" id="remenber" style="width: 16px;height: 16px;" >
                                <label class="verticalm" for="remenber" style="font-size:16px">记住我<span style="color:gray;">（公共电脑请勿勾选）</span></label></td>
                        </tr> -->
                        <tr>
                            <td class="textr">&nbsp;</td>
                            <td class="textl"><button class="qlogo-btn"  type="submit" lay-submit="" lay-filter="formSubmit">登  录</button>
                            </td>
                        </tr>
                        </tbody></table>
                </div>
            </form>
        </div>
    </div>
    <p class="banbenhao">版本号V6.2.7</p>
</div>
<!-- <script>
    record();
</script> -->

</body></html>