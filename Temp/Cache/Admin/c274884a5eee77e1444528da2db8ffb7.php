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
   <?php if($adminlogin['gid'] < 3){ ?>
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


            <h3><?php echo ($title); ?></h3>
<link rel="shortcut icon" href="__PUBLIC__/logo.png" />
<script type="text/javascript">
    $(function(){ $(".idTabs").idTabs(); });
</script>
<div class="idTabs">
    <ul class="tab">
        <li><a href="#main">常规设置</a></li>
         
       <li><a href="#api">接口设置</a></li> 
    </ul>
    <style type="text/css">
        .yulan{

            width: 100px;
            height: 100px;
        }
    </style>
    <div class="items">
        <form action="<?php echo C('cfg_app'); echo U(GROUP_NAME.'/System/index');?>" method="post">
            <div id="main">
                <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
                    <tr>
                        <th width="131">名称</th>
                        <th>内容</th>
                    </tr> 
                    <tr>
                        <td align="right">站点名称</td>
                        <td>
                            <input type="text" name="sitename" value="<?php echo C('cfg_sitename');?>" size="80" class="inpMain" />
                        </td>
                    </tr>
                    <tr>
                        <td align="right">站点标题</td>
                        <td>
                            <input type="text" name="sitetitle" value="<?php echo C('cfg_sitetitle');?>" size="80" class="inpMain" />
                        </td>
                    </tr>
                    <tr>
                        <td align="right">站点地址</td>
                        <td>
                            <input type="text" name="siteurl" value="<?php echo C('cfg_siteurl');?>" size="80" class="inpMain" />
                        </td>
                    </tr>
                    <tr>
                        <td align="right">站点关键字</td>
                        <td>
                            <input type="text" name="sitekeywords" value="<?php echo C('cfg_sitekeywords');?>" size="80" class="inpMain" />
                        </td>
                    </tr>
                     <tr>
                        <td align="right">站点入口（谨慎修改）</td>
                        <td>
                            <input type="text" name="app" value="<?php echo C('cfg_app');?>" size="80" class="inpMain" />
                        </td>
                    </tr>
                    <tr>
                        <td align="right">是否关闭网站</td>
                        <td>
                            <label for="siteclosed_0">
                                <input type="radio" name="siteclosed" id="siteclosed_0" value="0" <?php if(C('cfg_siteclosed') == 0): ?>checked<?php endif; ?> >
                                否
                            </label>
                            <label for="siteclosed_1">
                                <input type="radio" name="siteclosed" id="siteclosed_1" value="1" <?php if(C('cfg_siteclosed') == 1): ?>checked<?php endif; ?> >
                                是
                            </label>
                        </td>
                    </tr>
                      <tr>
            <td align="right">设置后台模板</td>
            <td>
               

                <label>
                    <input type="radio" name="imgmoban" value="1" <?php if(C("cfg_imgmoban") == 1){echo "checked";} ?>>
                    模板1<img src="__PUBLIC__/login/demo1.png" class="yulan">
                    
                </label>
                  <label>
                    <input type="radio" name="imgmoban" value="2" <?php if(C("cfg_imgmoban") == 2){echo "checked";} ?>>
                    模板2<img src="__PUBLIC__/login/demo2.png" class="yulan">
                </label>
                 <label>
                    <input type="radio" name="imgmoban" value="3" <?php if(C("cfg_imgmoban") == 3){echo "checked";} ?>>
                    模板3<img src="__PUBLIC__/login/demo3.png" class="yulan">
                </label>
              
            </td>
            <tr>
                        <td align="right">登录背景色</td>
                        <td>
                           
        
            
                        <input  type="color" name="bg" id="onchange" value="<?php echo C('cfg_bg');?>">
                    </td>
                </tr>
        </tr>
                    <tr>
                        <td align="right">网站关闭提示</td>
                        <td>
                            <textarea name="siteclosemsg" cols="83" rows="8" class="textArea" /><?php echo C('cfg_siteclosemsg');?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">ICP备案证书号</td>
                        <td>
                            <input type="text" name="siteicp" value="<?php echo C('cfg_siteicp');?>" size="80" class="inpMain" />
                        </td>
                    </tr>
                    <tr>
                        <td align="right">统计/客服代码调用</td>
                        <td>
                            <textarea name="sitecode" cols="83" rows="8" class="textArea" /><?php echo C('cfg_sitecode');?></textarea>
                        </td>
                    </tr>
                </table>
            </div>
			
		
            <div id="api">
                <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
                    <tr>
                        <th width="131">名称</th>
                        <th>内容</th>
                    </tr>
                    <tr>
                        <td align="right">短信账号</td>
                        <td>
                            <input type="text" name="smssid" value="<?php echo C('cfg_smssid');?>" size="80" class="inpMain" />
                        </td>
                    </tr>
                    <tr>
                        <td align="right">短信密码</td>
                        <td>
                            <input type="text" name="smstoken" value="<?php echo C('cfg_smstoken');?>" size="80" class="inpMain" />
                        </td>
                    </tr>
                    <tr>
                        <td align="right">短信接口签名</td>
                        <td>
                            <input type="text" name="smsname" value="<?php echo C('cfg_smsname');?>" size="80" class="inpMain" />
                        </td>
                    </tr>
					<tr>
                        <td align="right">短信当日获取最大次数</td>
                        <td>
                            <input type="text" name="smsmaxcount" value="<?php echo C('cfg_smsmaxcount');?>" size="80" class="inpMain" />
                        </td>
                    </tr>
					 <tr>
                        <td align="right">网关地址</td>
                        <td>
                            <input type="password" name="wgurl" value="<?php echo C('cfg_wgurl');?>" size="80" class="inpMain" />
                        </td>
                    </tr>
					<tr>
                        <td align="right">网关用户名</td>
                        <td>
                            <input type="password" name="wguser" value="<?php echo C('cfg_wguser');?>" size="80" class="inpMain" />
                        </td>
                    </tr>
                     <tr>
                        <td align="right">网关密码</td>
                        <td>
                            <input type="password" name="wgpass" value="<?php echo C('cfg_wgpass');?>" size="80" class="inpMain" />
                        </td>
                    </tr>
				 
                </table>
            </div>


            <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
                <tr>
                    <td width="131"></td>
                    <td>
                        <input class="btn" type="submit" value="提交" />
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
</div>

<script>
function uploadImg(hiddenid,imgdiv,obj){
    var filename = $(obj).val();
    if(filename != '' && filename != null){
        isupload = true;
        var pic = $(obj)[0].files[0];
        var fd = new FormData();
        fd.append('imgFile', pic);
        
        $.ajax({
            url:"__PUBLIC__/main/js/kindeditor/php/upload_json.php",
            type:"post",
            dataType:'json',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            success:function(data){
                if(data && data.error == '0'){
                    alert("上传成功");
                    var imgurl = data.url;
                    $("#"+imgdiv).html('<img style="height: 200px" src="'+imgurl+'">');
                    $("#"+hiddenid).val(imgurl);
                    
                }else{
                    alert(data.error);
                }
            },
            error:function (){
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