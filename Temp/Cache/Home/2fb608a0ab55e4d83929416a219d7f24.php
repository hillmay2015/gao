<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!-- saved from url=(0035)http://twbk.twbaika.com/admin/index -->
<html class="panel-fit"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">



    <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE">


    <link href="__PUBLIC__/tianwangbaika/default.css" rel="stylesheet" type="text/css">
    <link href="__PUBLIC__/tianwangbaika/top.css" rel="stylesheet" type="text/css">
    <link href="__PUBLIC__/tianwangbaika/easyui.css" rel="stylesheet" type="text/css">
    <link href="__PUBLIC__/tianwangbaika/icon.css" rel="stylesheet" type="text/css">
    <link href="__PUBLIC__/tianwangbaika/easyui.css" rel="stylesheet" type="text/css">
</head>
<body class="easyui-layout layout panel-noscroll">

<body class="easyui-layout layout panel-noscroll">

<noscript>
    <div style=" position:absolute; z-index:100000; height:2046px;top:0px;left:0px; width:100%; background:white; text-align:center;">
        <img src="/images/noscript.gif" alt='抱歉，请开启脚本支持！' />
    </div>
</noscript>

<div id="index_layout" class="layout" style="width: 1920px; height: 889px;">
    <!--顶部Banner-->
    <div class="panel layout-panel layout-panel-north" style="left: 0px; top: 0px; width: 1920px;"><div data-options="region:'north'" style="overflow: hidden; background-color: rgb(243, 243, 243); width: 1918px; height: 48px;" title="" class="panel-body panel-body-noheader layout-body">
        <div class="clearfix top-box">
            <div class="fl top-left">
                <img src="/Public/tianwangbaika/logo.png" alt="" style="height:30px;padding: 10px;">
            </div>
            <div class="fr top-right textr">
                <ul>
                    <li class="hello-text">

                        <span>admin，您好！</span>
                        <a href="/m.php/Admin/Index/logout">退出</a>
                        <a href="javaScript:void;" onclick="alert('暂不支持')">修改密码</a>
                    </li>
                </ul>
            </div>
        </div>
    </div></div>

    <!--左侧导航菜单-->
    <div class="panel layout-panel layout-panel-west layout-split-west" style="left: 0px; top: 0px; width: 155px;"><div class="panel-header" style="width: 141px;"><div class="panel-title">功能导航</div><div class="panel-tool"><a class="panel-tool-collapse" href="javascript:void(0)" style="display: none;"></a><a href="javascript:void(0)" class="layout-button-left"></a></div></div><div data-options="region:&#39;west&#39;,split:true" title="" style="width: 155px; overflow: hidden auto; height: 775px;" class="panel-noscroll panel-body layout-body">
        <div id="navview" class="easyui-accordion accordion accordion-noborder" data-options="fit:true,border:false" style="width: 155px; height: 775px;">





            <div class="panel" style="width: 155px;"><div class="panel-header accordion-header accordion-header-selected" style="width: 145px; height: 16px;"><div class="panel-title">渠道管理</div><div class="panel-tool"><a class="accordion-collapse" href="javascript:void(0)"></a></div></div><div title="" data-options="iconCls:&#39;&#39;" class="panel-with-icon panel-body accordion-body" style="display: block; width: 155px; height: 747px;">
                <ul class="navlist">

                    <li>
                        <div class="selected">
                            <a class="navlinkbutton" id="idx2" data-options="iconCls:&#39;icon-save&#39;" plain="true" href="javascript:void(0);" onclick="">渠道流量统计</a>
                        </div>
                    </li>


                </ul>
            </div></div>


        </div>
    </div></div>

    <div class="bacview"></div>


    <!--主工作区-->
    <div class="panel layout-panel layout-panel-center" style="left: 0px; top: 49px; width: 1920px;"><div data-options="region:'center'" style="overflow: hidden; width: 1918px; height: 805px;" title="" class="panel-body panel-body-noheader layout-body">
        <iframe id="otherIf" name="otherIf" style="width: 100%;height: 100%" frameborder="0" src="<?php echo C('cfg_app'); echo U('Home/User/manager');?>">
        </iframe>
    </div></div>

    <!--底部版权标识-->
    <div class="panel layout-panel layout-panel-south layout-split-south" style="left: 0px; top: 856px; width: 1920px;"><div data-options="region:'south',split:true" style="height: 30px; background: rgb(255, 255, 255); width: 1918px;" class="panel-noscroll panel-body panel-body-noheader layout-body" title="">
        <div class="easyui-layout layout" data-options="fit:true" style="background: rgb(255, 255, 255); text-align: center; color: rgb(21, 66, 139); font-weight: bold; width: 1918px; height: 30px;">
            <div style="margin-top: 5px">版本号V5.1.8天王白卡</div>
            <div class="layout-split-proxy-h"></div><div class="layout-split-proxy-v"></div></div>
    </div></div>
    <div class="layout-split-proxy-h"></div><div class="layout-split-proxy-v"></div></div>

<div class="layout-split-proxy-h"></div><div class="layout-split-proxy-v"></div></body>