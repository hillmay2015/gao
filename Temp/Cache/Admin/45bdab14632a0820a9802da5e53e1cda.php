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


            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>跳转提示</title>
<style type="text/css">
*{ padding: 0; margin: 0; }
body{ background: #fff; font-family: '微软雅黑'; color: #333; font-size: 16px; }
.system-message{ padding: 24px 48px; }
.system-message h1{ font-size: 100px; font-weight: normal; line-height: 120px; margin-bottom: 12px; }
.system-message .jump{ padding-top: 10px}
.system-message .jump a{ color: #333;}
.system-message .success,.system-message .error{ line-height: 1.8em; font-size: 36px }
.system-message .detail{ font-size: 12px; line-height: 20px; margin-top: 12px; display:none}
</style>
</head>
<body>
<div class="system-message">
<?php if(isset($message)): ?><h1>:)</h1>
<p class="success"><?php echo($message); ?></p>
<?php else: ?>
<h1>:(</h1>
<p class="error"><?php echo($error); ?></p><?php endif; ?>
<p class="detail"></p>
<p class="jump">
页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait"><?php echo($waitSecond); ?></b>
</p>
</div>
<script type="text/javascript">
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time <= 0) {
		location.href = href;
		clearInterval(interval);
	};
}, 1000);
})();
</script>
</body>
</html>


        </div>
    </div>
    <div class="clear"></div>
   
    <!-- dcFooter 结束 -->
    <div class="clear"></div>
</div>
</body>
</html>