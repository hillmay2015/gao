<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!-- saved from url=(0067)http:/zxhadmin.kfsmaff.com/channelmanagement/channeldatastatistics -->
<html>
<head lang="en">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="author" content="lock">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link href="__PUBLIC__/moban/bootstrap.min.css" rel="stylesheet">
    <link href="__PUBLIC__/moban/font-awesome.min.css" rel="stylesheet">
    <link href="__PUBLIC__/moban/layout.css" rel="stylesheet">
    <link href="__PUBLIC__/moban/index.css" rel="stylesheet">
    <link href="__PUBLIC__/moban/style-responsive.css" rel="stylesheet">
    <link href="__PUBLIC__/moban/box.css" rel="stylesheet">
    <link href="__PUBLIC__/moban/WdatePicker.css" rel="stylesheet" type="text/css">


    <script src="__PUBLIC__/moban/layer.js"></script>
    <link rel="stylesheet" href="__PUBLIC__/moban/layer.css" id="layuicss-layer">
    <script src="__PUBLIC__/moban/echarts.js"></script>

    <script src="__PUBLIC__/moban/MyPlayer.js"></script>

    <title>
        <?php echo C('cfg_sitename') ?>
    </title>


</head>

<body style="zoom: 1;">

<div class="left-side sticky-left-side">
    <a href="#">
        <img src="<?php echo ($logourl); ?>" style="width:100px;margin:20px 0 0 20px;">
    </a>
    <div class="left-side-inner">
        <ul class="nav nav-pills nav-stacked custom-nav js-left-nav">
            <li class="menu-list "><a href="<?php echo C('cfg_app'); echo U(GROUP_NAME.'/Info/index');?>"><span>渠道管理</span></a></li>
            <li class="menu-list nav-active"><a href="<?php echo C('cfg_app'); echo U(GROUP_NAME.'/User/pdlist');?>"><span>渠道数据统计</span></a></li>
        </ul>
    </div>
</div>

<div class="main-content" style="min-height: 938px;">
    <div class="header-section">
        <a class="toggle-btn"></a>
        <div class="menu-right">
            <ul class="notification-menu nt-menu">
                <li>
                    <a style="width: 134px;height: 48px;" id="slidedown_btn"
                       href="<?php echo C('cfg_app'); ?>/Home/User/logout1" class="btn btn-default dropdown-toggle"
                       data-toggle="dropdown">
                        <span class="caret">退出</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-usermenu" aria-labelledby="slidedown_btn">
                        <li style="cursor: pointer;"><a onclick="ModifyPwdShow()"><i class="fa fa-cog"></i> 更换密码</a>
                        </li>
                        <li style="cursor: pointer;"><a href="<?php echo C('cfg_app'); ?>/Home/User/logout"><i
                                class="fa fa-sign-out"></i> 退出</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="wrapper">
        <div class="sticky-header">
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel_border">
                            <div class="panel_heading">
                                <form id="searchForm2" action="<?php echo C('cfg_app'); ?>/Home/Info/index"
                                      method="POST">
                                    <ul class="nav pull-left">

                                        <li class="pull-left">
                                           <input name="username" value="" placeholder="请输入用户名" >
                                        </li>

                                        <li class="pull-left">
                                            <button type="submit" class="btn btn-info">搜索</button>
                                        </li>

                                    </ul>
                                </form>
                            </div>
                            <div class="panel-body" style="overflow-x:auto;">
                                <form action="#" id="form2" method="post">
                                    <table class="table table-hover table-striped table_thead_fixed"
                                           style="min-width:1450px;">
                                        <thead>
                                        <tr>
                                            <th width="80" align="center">注册时间</th>
                                            <th width="120" align="center">注册时间</th>
                                            <th width="120" align="center">ip</th>
                                            <th width="120" align="center">渠道名称</th>

                                            <th width="120" align="center">用户名</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                              <td><?php echo ($vo["id"]); ?></td>
                                                <td><?php echo (date('Y-m-d H:i:s',$vo["addtime"])); ?></td>
                                                <td><?php echo ($vo["yao_phone"]); ?></td>
                                                <td><?php echo ($vo["data_from"]); ?></td>
                                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="14">
                                                <div class="fl">
                                                    <div class="pagination">

                                                        <!--   每页20条&nbsp;&nbsp;共1条


                                                           &nbsp;&nbsp;总费用0.00元
                                                           -->
                                                    </div>
                                                </div>
                                                <div class="fl">
                                                    <div class="pagination" id="pagination2" data-url="" currentpage="1"
                                                         pagecount="1"></div>

                                                </div>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


</body>
</html>