<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo ($title); ?> - <?php
 $name = "cfg_sitetitle"; if(empty($name)){ echo ""; }else{ echo htmlspecialchars_decode(C($name)); } ?> </title>
    <link href="__PUBLIC__/main/css/public.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="__PUBLIC__/main/js/jquery.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/main/js/global.js"></script>
    <script type="text/javascript" src="__PUBLIC__/main/js/jquery.tab.js"></script>
    <script src="__PUBLIC__/layer/layer.js"></script>
</head>
<body>
<div id="dcWrap">

    <div class="right_top">
            <div>
			
			<!--
			<img src="<?php echo C('cfg_payimg');?>" alt="">
			-->
			
			<text>您好，<?php echo session('admin_user');?> </text>&nbsp;
			
                      <a href="<?php echo C('cfg_app'); ?>/Admin/Admin/chagemypass2">修改密码</a>
                  
			
			<a href="<?php echo C('cfg_app'); ?>/Admin/Index/logout" class="logout">退出</a>
			
</div>
</div>
    <!-- dcHead 结束 -->
    <html>
 <head>
  <link rel="stylesheet" href="__PUBLIC__/static/bootstrap.min.css" /> 
  <link rel="stylesheet" href="__PUBLIC__/static/mycss.css" /> 
 </head>
 <body>
  <div class="left"> 
   <div class="inner"> 
    <div class="left_head"> 
     <span style="color:#428bca"></span></a>
     <br /> 
    </div> 
   
   </div> 
   <?php if($adminlogin['gid'] ==1){ ?>
   <div class="nav_list"> 
    <div>
     <a href="<?php echo C('cfg_app'); echo U(GROUP_NAME.'/Main/index');?>">
      <div class="item">
       首页 
       <span class="arrow"> &gt; </span>
      </div>
	  </a>
    </div>

	<div>
     <a href="<?php echo C('cfg_app'); echo U(GROUP_NAME.'/System/index');?>">
      <div class="item">
       系统设置 
       <span class="arrow"> &gt; </span>
      </div></a>
    </div>
    <?php } ?>
<?php if($adminlogin['gid'] < 3){ ?>

	<div>
     <a href="<?php echo C('cfg_app'); echo U(GROUP_NAME.'/Admin/index');?>">
      <div class="item">
       后台管理员 
       <span class="arrow"> &gt; </span>
      </div></a>
    </div>
    <div>
     <a href="<?php echo C('cfg_app'); echo U(GROUP_NAME.'/User/deldata');?>">
      <div class="item">
       数据回收站
       <span class="arrow"> &gt; </span>
      </div></a>
    </div>
<?php } ?>
<div>


     <a href="<?php echo C('cfg_app'); echo U(GROUP_NAME.'/User/index2');?>">
      <div class="item">
       实时渠道数据	
       <span class="arrow"> &gt; </span>
      </div></a>
    </div> 	
		
	
    </div> 
   </div> 
  </div>
 </body>
</html>


    <div id="dcMain"> <!-- 当前位置 -->
        <div id="urHere">
            <?php echo ($title); ?>
        </div>
        <div id="index" class="mainBox" style="padding-top:18px;height:auto!important;height:550px;min-height:550px;">


            <h3>
    <a href="<?php echo C('cfg_app'); echo U(GROUP_NAME.'/Admin/index');?>" class="actionBtn">返回列表</a>
    <?php echo ($title); ?>
</h3>
<form action="<?php echo C('cfg_app'); echo U(GROUP_NAME.'/Admin/add');?>" method="post">
    <table width="100%" border="0" cellpadding="6" cellspacing="0" class="tableBasic">
        <tr>
            <td width="100" align="right">登陆账号</td>
            <td>
                <input type="text" value="<?php echo generate_username(); ?>" name="username" size="40"
                       class="inpMain"/>
            </td>
        </tr>


        <tr>
            <td align="right">密码</td>
            <td>
                <input type="text" name="password" size="40" class="inpMain" value="123456"/>
            </td>
        </tr>
        <tr>
            <td align="right">密码</td>
            <td>
                <input type="text" name="password_confirm" size="40" class="inpMain" value="123456"/>
        </tr>
        <tr>
            <td align="right">渠道名称</td>
            <td>
                <input type="text" name="name" size="40" class="inpMain" placeholder=""/>
            </td>
        </tr>
        <tr>
            <td align="right">手机</td>
            <td>
                <input type="text" name="phone" size="40" class="inpMain" placeholder="可以不输入"/>
            </td>
        </tr>
        <tr>
            <td align="right">扣量比例</td>
            <td>
                <input type="text" name="qq" size="40" class="inpMain" placeholder="请输入整数即可"/>%
            </td>
        </tr>
        <tr>
            <td align="right">申请率（实名数量）</td>
            <td>
                <input type="text" name="shenqLv" size="40" class="inpMain" placeholder="请输入整数即可"/>%
            </td>
        </tr>
        <tr>
            <td align="right">申请借款人次</td>
            <td>
                <input type="text" name="loanRenci" size="40" class="inpMain" placeholder="请输入整数即可"/>%
            </td>
        </tr>
        <tr>
            <td align="right">申请成功人次</td>
            <td>
                <input type="text" name="chenggongrenci" size="40" class="inpMain" placeholder="请输入整数即可"/>%
            </td>
        </tr>
        <tr>
            <td align="right">放款率</td>
            <td>
                <input type="text" name="fangkuanLv" size="40" class="inpMain" placeholder="请输入整数即可"/>%
            </td>
        </tr>
        <tr>
            <td align="right">数据显示权限设置</td>
            <td>

                <label>
                    <input type="checkbox" id="date_time">
                    <input type="hidden" name="date_time" id="date_time11">
                    日期
                </label>
                <label>
                    <input type="checkbox" id="qudaoname">
                    <input type="hidden" name="qudaoname" id="qudaoname11">
                    渠道名
                </label>
                <label>
                    <input type="checkbox" id="zhucecount">
                    <input type="hidden" name="zhucecount" id="zhucecount11">
                    注册量
                </label>
                <label>
                    <input type="checkbox" id="uvcount">
                    <input type="hidden" name="uvcount" id="uvcount11">
                    UV量
                </label>
                <label>
                    <input type="checkbox" id="shimingcount">
                    <input type="hidden" name="shimingcount" id="shimingcount11">
                    实名认证
                </label>
                <label>
                    <input type="checkbox" id="loancount">
                    <input type="hidden" name="loancount" id="loancount11">
                    申请借款人数
                </label>
                <label>
                    <input type="checkbox" id="succcount">
                    <input type="hidden" name="succcount" id="succcount11">
                    申请成功人数
                </label>
                <label>
                    <input type="checkbox" id="loanlv">
                    <input type="hidden" name="loanlv" id="loanlv11">
                    借款率%
                </label>
                <label>
                    <input type="checkbox" id="tongguolv">
                    <input type="hidden" name="tongguolv" id="tongguolv11">
                    通过率%
                </label>
                <label>
                    <input type="checkbox" id="caozuo">
                    <input type="hidden" name="caozuo" id="caozuo11">
                    操作
                </label>
            </td>
        </tr>
        <tr>
            <td align="right">跳转链接</td>
            <td>


                <label>
                    <input type="text" name="url" value="<?php echo ($is_super); ?>" size="80" class="inpMain">

                </label>
            </td>
        </tr>
        <tr>
            <td align="right">权限设置</td>
            <td>

                <label>

                    <?php if($is_super == 0): ?><input type="radio" name="gid" value="3" checked>
                        推广员<?php endif; ?>

                    <?php if($is_super == 1): ?><input type="radio" name="gid" value="1">
                        普通管理员
                        <input type="radio" name="gid" value="2" checked>
                        渠道商<?php endif; ?>


                </label>
            </td>
        </tr>
        <!-- 超级管理员 添加渠道商 默认模板为 0-->
        <?php if($is_super == 1): ?><input type="hidden" value="0" name="tpl" checked><?php endif; ?>
        <!-- 渠道商 添加推广员 模板需要选择-->
        <?php if($is_super == 0): ?><tr>
                <td align="right">模板风格</td>
                <td>
                    <input type="radio" name="tpl" value="1" checked> 风格1
                    <input type="radio" name="tpl" value="2"> 风格2
                </td>
            </tr><?php endif; ?>
        <tr>
            <td align="right">LOGO</td>
            <td>
                <div id="list">

                    <label for="file">上传文件:</label>
                    <input type="file" name="file" id="file" onChange="uploadImg('payimg','imgdiv',this);"><br/>
                    <div id="imgdiv">

                        <img style="height: 200px" src="">

                    </div>
                    <input type="hidden" id="logourl" name="logourl" value="">

    </table>
    </div>
    </td>


    <tr>
        <td></td>
        <td>
            <input type="submit" name="submit" class="btn" value="提交"/>
        </td>
    </tr>
    </table>
</form>
<script type="text/javascript">
    var date_time = 1;
    var qudaoname = 1;
    var zhucecount = 1;
    var uvcount = 1;
    var shimingcount = 1;
    var loancount = 1;
    var succcount = 1;
    var loanlv = 1;
    var tongguolv = 1;
    var caozuo = 1;
    if (date_time == 1) {
        $('#date_time').val(1);
        $('#date_time11').val(1);
        $('#date_time').attr('checked', true);
    }
    if (qudaoname == 1) {
        $('#qudaoname').val(1);
        $('#qudaoname11').val(1);
        $('#qudaoname').attr('checked', true);
    }
    if (zhucecount == 1) {
        $('#zhucecount').val(1);
        $('#zhucecount11').val(1);
        $('#zhucecount').attr('checked', true);
    }
    if (uvcount == 1) {
        $('#uvcount').val(1);
        $('#uvcount11').val(1);
        $('#uvcount').attr('checked', true);
    }
    if (shimingcount == 1) {
        $('#shimingcount').val(1);
        $('#shimingcount11').val(1);
        $('#shimingcount').attr('checked', true);
    }
    if (loancount == 1) {
        $('#loancount').val(1);
        $('#loancount11').val(1);
        $('#loancount').attr('checked', true);
    }
    if (succcount == 1) {
        $('#succcount').val(1);
        $('#succcount11').val(1);
        $('#succcount').attr('checked', true);
    }
    if (loanlv == 1) {
        $('#loanlv').val(1);
        $('#loanlv11').val(1);
        $('#loanlv').attr('checked', true);
    }
    if (tongguolv == 1) {
        $('#tongguolv').val(1);
        $('#tongguolv11').val(1);
        $('#tongguolv').attr('checked', true);
    }
    if (caozuo == 1) {
        $('#caozuo').val(1);
        $('#caozuo11').val(1);
        $('#caozuo').attr('checked', true);
    }
    $("#date_time").click(function () {
        if ($(this).is(":checked")) {
            $('#date_time').val(1);
            $('#date_time11').val(1);
            $('#date_time').attr('checked', true);
        } else {

            $('#date_time').val(0);
            $('#date_time11').val(0);
            $('#date_time').attr('checked', false);
        }
    })
    $("#qudaoname").click(function () {
        if ($(this).is(":checked")) {
            $('#qudaoname').val(1);
            $('#qudaoname11').val(1);
            $('#qudaoname').attr('checked', true);
        } else {

            $('#qudaoname').val(0);
            $('#qudaoname11').val(0);
            $('#qudaoname').attr('checked', false);
        }
    })
    $("#zhucecount").click(function () {
        if ($(this).is(":checked")) {
            $('#zhucecount').val(1);
            $('#zhucecount11').val(1);
            $('#zhucecount').attr('checked', true);
        } else {

            $('#zhucecount').val(0);
            $('#zhucecount11').val(0);
            $('#zhucecount').attr('checked', false);
        }
    })
    $("#uvcount").click(function () {
        if ($(this).is(":checked")) {
            $('#uvcount').val(1);
            $('#zhucecount11').val(1);
            $('#uvcount').attr('checked', true);
        } else {

            $('#uvcount').val(0);
            $('#uvcount11').val(0);
            $('#uvcount').attr('checked', false);
        }
    })
    $("#shimingcount").click(function () {
        if ($(this).is(":checked")) {
            $('#shimingcount').val(1);
            $('#shimingcount11').val(1);
            $('#shimingcount').attr('checked', true);
        } else {

            $('#shimingcount').val(0);
            $('#shimingcount11').val(0);
            $('#shimingcount').attr('checked', false);
        }
    })
    $("#loancount").click(function () {
        if ($(this).is(":checked")) {
            $('#loancount').val(1);
            $('#loancount11').val(1);
            $('#loancount').attr('checked', true);
        } else {

            $('#loancount').val(0);
            $('#loancount11').val(0);
            $('#loancount').attr('checked', false);
        }
    })
    $("#succcount").click(function () {
        if ($(this).is(":checked")) {
            $('#succcount').val(1);
            $('#succcount11').val(1);
            $('#succcount').attr('checked', true);
        } else {

            $('#succcount').val(0);
            $('#succcount11').val(0);
            $('#succcount').attr('checked', false);
        }
    })
    $("#loanlv").click(function () {
        if ($(this).is(":checked")) {
            $('#loanlv').val(1);
            $('#loanlv11').val(1);
            $('#loanlv').attr('checked', true);
        } else {

            $('#loanlv').val(0);
            $('#loanlv11').val(0);
            $('#loanlv').attr('checked', false);
        }
    })
    $("#tongguolv").click(function () {
        if ($(this).is(":checked")) {
            $('#tongguolv').val(1);
            $('#tongguolv11').val(1);
            $('#tongguolv').attr('checked', true);
        } else {

            $('#tongguolv').val(0);
            $('#tongguolv11').val(0);
            $('#tongguolv').attr('checked', false);
        }
    })
    $("#caozuo").click(function () {
        if ($(this).is(":checked")) {
            $('#caozuo').val(1);
            $('#caozuo11').val(1);
            $('#caozuo').attr('checked', true);
        } else {

            $('#caozuo').val(0);
            $('#caozuo11').val(0);
            $('#caozuo').attr('checked', false);
        }
    })
</script>

<script>
    function uploadImg(hiddenid, imgdiv, obj) {
        var filename = $(obj).val();
        if (filename != '' && filename != null) {
            isupload = true;
            var pic = $(obj)[0].files[0];
            var fd = new FormData();
            fd.append('imgFile', pic);

            $.ajax({
                url: "__PUBLIC__/main/js/kindeditor/php/upload_json.php",
                type: "post",
                dataType: 'json',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data && data.error == '0') {
                        alert("上传成功");
                        var imgurl = data.url;
                        $("#" + imgdiv).html('<img style="height: 200px" src="' + imgurl + '">');
                        $("#logourl").val(imgurl);

                    } else {
                        alert(data.error);
                    }
                },
                error: function () {
                    alert(data.error);
                }
            });
            isupload = false;
        }
        isupload = false;
    }
</script>


        </div>
    </div>
    <div class="clear"></div>
   
    <!-- dcFooter 结束 -->
    <div class="clear"></div>
</div>
</body>
</html>