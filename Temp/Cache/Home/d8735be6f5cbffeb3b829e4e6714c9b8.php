<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!-- saved from url=(0042)http://twbk.twbaika.com/admin/unifiedLogin -->
<html class="panel-fit"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">




    <meta http-equiv="X-UA-Compatible" content="edge">


    <link id="easyuiTheme" rel="stylesheet" href="__PUBLIC__/tianwangbaika/easyui(1).css" type="text/css">
    <link rel="stylesheet" href="__PUBLIC__/tianwangbaika/credit.css" type="text/css">

    <style type="text/css">
        /*按钮 zyh add at 2014-8-28*/
        .button_green{ background:#5db75d; border:1px solid #4aa44a; padding: 0 5px;border-radius:5px; color:#FFFFFF;cursor:pointer;}/**按钮中的文字，白色字体**/
        .button_gray{ background:#b4b4b4; border:1px solid #a5a5a5; padding: 0 5px;border-radius:5px; color:#FFFFFF;cursor:pointer;}/*灰色*/
        .button_yellow{ background:#f0ad4e; border:1px solid #da9a3f; padding: 0 5px;border-radius:5px; color:#FFFFFF;cursor:pointer;}/*黄色*/
        .button_bisque{ background:#ff751a; border:1px solid #e46816; padding: 0 5px;border-radius:5px; color:#FFFFFF;cursor:pointer;}/*橘黄色*/
        .button_red{ background:#FF0000; border:1px solid #e46816; padding: 0 5px;border-radius:5px; color:#FFFFFF;cursor:pointer;}/*红色*/
    </style>

    <title></title>

    <link href="__PUBLIC__/tianwangbaika/styleTop.css" rel="stylesheet" type="text/css">
    <link href="__PUBLIC__/tianwangbaika//mychart.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="__PUBLIC__/tianwangbaika/layer.css" id="layuicss-skinlayercss">
    <style>
        .selected{ background:#E0ECFF;cursor: default;}
        .hover{ background:#E0ECFF;cursor:pointer;}
        a{text-decoration:none}
        .navlist{list-style-type:none;margin:0px;padding: 10px;}
        .navlist li div{margin: 2px 0px; padding-top: 2px 0; border: 1px  #ffffff;padding-left: 10px;}
        .tabs-header{
            background-color: #f3f3f3;
        }
        #index_layout .panel-tool {
            right: 5px;
            left: initial;
        }
        #layerContent{
            padding: 15px;
            text-align: center;
        }
        #layerContent .block {
            display: inline-block;
            padding: 20px;
        }
        #layerContent div:hover{
            background: #e0ecff;
            cursor: pointer;
        }
        #layerContent .block div:nth-of-type(1){
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            color: #1e9afa;
        }
        #layerContent .block div:nth-of-type(2){
            font-size: 14px;
            color: #000;
            padding-top: 15px;
        }

        #navview .panel-header{
            padding:5px;
        }


        .licenseview{
            display:none;
            width: 680px;
            height: 300px;
            left: 50%;
            top:50%;
            position: fixed;
            margin-left: -390px;
            margin-top: -200px;
            z-index: 1000;
            background-color: #fff;
            border-radius: 1rem;
        }
        .bacview{
            display:none;
            position:fixed;
            left:0;
            top:0;
            width: 100%;
            height: 100%;
            z-index: 999;
            background-color: #808080;
            opacity: 0.7;
        }
        .ltitle{
            text-align: center;
            height: 2.2rem;
            line-height: 2.2rem;
            font-weight: bold;
            color: #0099FF;
            font-family: '微软雅黑 Bold', '微软雅黑';
            font-weight: 700;
            margin-top: 3rem;
            font-size: 20px;
        }
        .zjdkh{
            padding-left: 40px;
            font-family: '微软雅黑 Bold', '微软雅黑';
            font-weight: 700;
            color: #333333;
        }
        .lpcontent{
            font-family: '微软雅黑 Regular', '微软雅黑';
            font-weight: 400;
            padding-left: 40px;
            padding-right: 40px;
            font-size: 14px;
            margin-top: 1rem;
            margin-bottom: 1rem;
        }
        .lpblack{
            color: #333333;
        }
        .aleft{
            width: 240px;
            height: 40px;
            font-family: '微软雅黑 Regular', '微软雅黑';
            font-weight: 400;
            font-size: 14px;
            background-color: #1d91fa;
            color: #fff;
            border-radius: 0.5rem;
            display: block;
            line-height: 40px;
            text-align: center;
        }
        .aright{
            width: 240px;
            height: 40px;
            font-family: '微软雅黑 Regular', '微软雅黑';
            font-weight: 400;
            font-size: 14px;
            background-color: #f1f1f1;
            color: #666;
            border-radius: 0.5rem;
            display: block;
            line-height: 40px;
            text-align: center;
            border: 1px #666 solid;
            margin: 0 auto;
        }
        .licenseview a:hover{
            text-decoration:none;
        }
    </style>

</head>
<body class="panel-noscroll" style="">
<noscript>
    <div style=" position:absolute; z-index:100000; height:2046px;top:0px;left:0px; width:100%; background:white; text-align:center;">
        <img src="/images/noscript.gif" alt='抱歉，请开启脚本支持！' />
    </div>
</noscript>


<div id="loading" style="position: fixed; top: -50%; left: -50%; width: 200%; height: 200%; background: rgb(255, 255, 255); z-index: 100; overflow: hidden; display: none;">
    <img src="./ajax-loader.gif" style="position: absolute;top: 0;left: 0;right: 0;bottom: 0;margin: auto;">
</div>
<div id="index_layout" class="layout" style="width: 1918px; height: 805px;">


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
    <!--顶部banner-->
    <div class="panel layout-panel layout-panel-north" style="left: 0px; top: 0px; width: 1920px;"><div data-options="region:'north'" style="overflow: hidden; background-color: rgb(243, 243, 243); width: 1918px; height: 48px;" title="" class="panel-body panel-body-noheader layout-body">
        <div class="clearfix top-box">
            <div class="fl top-left">
                <img src="/Public/tianwangbaika/logo.png" alt="" style="height:30px;padding: 10px;">
            </div>
            <div class="fr top-right textr">
                <ul>
                    <li class="hello-text">

                        <span>admin，您好！</span>
                        <a href="/index.php?g=Admin&amp;m=Index&amp;a=logout">退出</a>
                        <a href="javaScript:void;" onclick="alert('暂不支持')">修改密码</a>
                    </li>
                </ul>
            </div>
        </div>
    </div></div>
    <!--主工作区-->
    <div class="panel layout-panel layout-panel-center" style="left: 155px; top: 0px; width: 1763px;"><div data-options="region:&#39;center&#39;" style="overflow: hidden; width: 1763px; height: 805px;" title="" class="panel-body panel-body-noheader layout-body panel-noscroll">
        <div id="index_tabs" style="width: 1763px; height: 805px;" class="tabs-container"><div class="tabs-header tabs-header-noborder" style="width: 1763px;"><div class="tabs-scroller-left" style="display: none;"></div><div class="tabs-scroller-right" style="display: none;"></div><div class="tabs-wrap" style="margin-left: 0px; margin-right: 0px; width: 1763px;"><ul class="tabs"><li class=""><a href="javascript:void(0)" class="tabs-inner"><span class="tabs-title">我的工作台</span><span class="tabs-icon"></span></a></li><li class="tabs-selected"><a href="javascript:void(0)" class="tabs-inner"><span class="tabs-title tabs-closable" style="padding-right: 20px;">渠道流量统计</span><span class="tabs-icon"></span></a><span class="tabs-p-tool"><a href="javascript:void(0)" class="icon-mini-refresh"></a></span><a href="javascript:void(0)" class="tabs-close"></a></li></ul></div></div><div class="tabs-panels tabs-panels-noborder" style="height: 777px; width: 1763px;">
            <div class="panel" style="display: none; width: 1763px;"><div title="" data-options="border:false" class="panel-body panel-body-noheader panel-body-noborder" style="width: 1761px; height: 775px;">

            </div></div>
            <div class="panel" style="display: block; width: 1763px;"><div title="" class="panel-body panel-body-noheader panel-body-noborder" style="width: 1761px; height: 775px;"><iframe scrolling="auto" src="<?php echo C('cfg_app'); ?>/Home/User/manager" frameborder="0" style="border:0;width:100%;height:99.4%;"></iframe></div></div></div></div>

    </div></div>
    <div class="layout-split-proxy-h" style="display: none; top: 0px; left: 150px; width: 5px; height: 805px;"></div><div class="layout-split-proxy-v" style="display: none;"></div></div>


<div id="tabsMenu" style="width: 135px; display: none; left: 0px; top: 0px;" class="menu-top menu"><div class="menu-line"></div>
    <div type="refresh" name="" href="" class="menu-item" style="height: 20px;"><div class="menu-text">刷新</div></div>
    <div class="menu-sep"></div>
    <div type="close" name="" href="" class="menu-item" style="height: 20px;"><div class="menu-text">关闭</div></div>
    <div type="closeOther" name="" href="" class="menu-item" style="height: 20px;"><div class="menu-text">关闭其他</div></div>
    <div type="closeAll" name="" href="" class="menu-item" style="height: 20px;"><div class="menu-text">关闭所有</div></div>
</div></body></html>