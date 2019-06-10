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

 <div class="nav_list">
  <?php if($adminlogin['gid'] ==1){ ?>
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

  <div>


   <a href="<?php echo C('cfg_app'); echo U(GROUP_NAME.'/User/index2');?>">
    <div class="item">
     实时渠道数据
     <span class="arrow"> &gt; </span>
    </div></a>
  </div>
<?php } ?>

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


            <?php if($install_status == 1): ?><div class="warning">您还没有删除 install 文件夹，出于安全的考虑，我们建议您删除 install 文件夹。</div><?php endif; ?>

<div id="douApi"></div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="indexBoxTwo">
    <tr>
        <td width="65%" valign="top" class="pr">
            <div class="indexBox">
                <div class="boxTitle">系统基本信息</div>
                <ul>
                    <table width="100%" border="0" cellspacing="0" cellpadding="7" class="tableBasic">
                        <tr>
                            <td width="120">PHP 版本：</td>
                            <td><strong> <?php echo PHP_VERSION; ?> </strong></td>
                            <td width="100">Base版本：</td>
                            <td><strong> v<?php echo THINK_VERSION; ?> </strong></td>
                        </tr>
                        <tr>
                            <td>缓存目录：</td>
                            <td><strong> <?php echo TEMP_PATH; ?> </strong></td>
                            <td>系统语言：</td>
                            <td><strong>zh_cn</strong></td>
                        </tr>
                        <tr>
                            <td>调试模式：</td>
                            <td><strong> <?php if(APP_DEBUG)echo '是';else echo '否'; ?> </strong></td>
                            <td>当前IP：</td>
                            <td><strong> <?php echo get_client_ip(); ?> </strong></td>
                        </tr>
                        <tr>
                            <td>内存统计支持：</td>
                            <td><strong> <?php echo MEMORY_LIMIT_ON; ?> </strong></td>
                            <td>编码：</td>
                            <td><strong>UTF-8</strong></td>
                        </tr>
                        <tr>
                            <td>SomCNS版本：</td>
                            <td><strong>v<?php echo C('install_vis');?></strong></td>
                            <td>安装日期：</td>
                            <td><strong> <?php echo C('install_time');?> </strong></td>
                        </tr>
                    </table>
                </ul>
            </div>
        </td>
        <td valign="top" class="pl">
            <div class="indexBox">
                <div class="boxTitle">登录记录</div>
                <ul>
                    <table width="100%" border="0" cellspacing="0" cellpadding="7" class="tableBasic">
                        <tr>
                            <th width="45%">IP地址</th>
                            <th width="55%">登录时间</th>
                        </tr>
                        <?php if(is_array($loginData)): foreach($loginData as $key=>$vo): ?><tr>
                                <td align="center"><?php echo ($vo["loginip"]); ?></td>
                                <td align="center"><?php echo (date('Y/m/d H:i:s',$vo["logintime"])); ?></td>
                            </tr><?php endforeach; endif; ?>
                    </table>
                </ul>
            </div>
        </td>
    </tr>
</table>
<div class="indexBox">
    <div class="boxTitle">服务器信息</div>
    <ul>
        <table width="100%" border="0" cellspacing="0" cellpadding="7" class="tableBasic">
            <tr>
                <td width="120" valign="top">PHP 版本：</td>
                <td valign="top"> <?php echo PHP_VERSION; ?> </td>
                <td width="100" valign="top">MySQL 版本：</td>
                <td valign="top"> <?php echo mysql_get_server_info(); ?> </td>
                <td width="100" valign="top">服务器操作系统：</td>
                <td valign="top"> <?php echo PHP_OS; ?> </td>
            </tr>
            <tr>
                <td valign="top">文件上传限制：</td>
                <td valign="top">2M</td>
                <td valign="top">GD 库支持：</td>
                <td valign="top"> <?php if(function_exists('imagecreate')){echo '是';}else{echo '否';} ?> </td>
                <td valign="top">Web 服务器：</td>
                <td valign="top"> <?php echo php_uname(); ?> </td>
            </tr>
        </table>
    </ul>
</div>


        </div>
    </div>
    <div class="clear"></div>
   
    <!-- dcFooter 结束 -->
    <div class="clear"></div>
</div>
</body>
</html>