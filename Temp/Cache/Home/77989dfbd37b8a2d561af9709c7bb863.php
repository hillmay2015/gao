<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!-- saved from url=(0024)http://twbk.twbaika.com/ -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="edge">


    <!-- 引入jQuery -->
    <script src="__PUBLIC__/lanrenjiekuan/jquery-1.8.3.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PUBLIC__/lanrenjiekuan/extjquery.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PUBLIC__/lanrenjiekuan/base64.js" type="text/javascript" charset="utf-8"></script>

    <!-- 引入EasyUI -->
    <link id="easyuiTheme" rel="stylesheet" href="__PUBLIC__/tianwangbaika/easyui.css" type="text/css">

    <link href="__PUBLIC__/tianwangbaika/login.css" rel="stylesheet" type="text/css">
    <title></title>

</head>
<body>
<?php if(empty($user['back_img']) == true): ?><div class="picimg" style="background-color:rgb(255, 255, 255);background-image:url(&#39;__PUBLIC__/tianwangbaika/back.jpg&#39;); "> </div><?php endif; ?>
<?php if(empty($user['back_img']) != true): ?><div class="picimg" style="background-color:rgb(255, 255, 255);background-image:url(<?php echo ($user['back_img']); ?>); "> </div><?php endif; ?>
<div class="qlogo-Box">
    <span class="qspan"></span>
    <div class="qContent-login">
        <h2 class="ft qChina"></h2>
        <p class="ft qEnglish"></p>
        <div class="bj2">
            <?php if(empty($user['logourl']) != true): ?><img class="loginlogo" src="<?php echo ($user['logourl']); ?>"><?php endif; ?>
            <?php if(empty($user['logourl']) == true): ?><img class="loginlogo" src="__PUBLIC__/tianwangbaika/loginlogo.png"><?php endif; ?>


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
                        <tr>
                            <td class="textr">&nbsp;</td>
                            <td class="textl"><button class="qlogo-btn"  type="submit" lay-submit="" lay-filter="formSubmit" id="btn">登  录</button>
                            </td>
                        </tr>
                        </tbody></table>
                </div>

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