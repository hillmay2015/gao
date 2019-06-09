<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!-- saved from url=(0067)http:/zxhadmin.kfsmaff.com/channelmanagement/channeldatastatistics -->
<html><head lang="en"><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
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



    <script src="__PUBLIC__/moban/layer.js"></script><link rel="stylesheet" href="__PUBLIC__/moban/layer.css" id="layuicss-layer">
    <script src="__PUBLIC__/moban/echarts.js"></script>
    
    <script src="__PUBLIC__/moban/MyPlayer.js"></script>

    <title><?php echo C('cfg_sitename') ?></title>
    <style>
    .pull-left select{height: 30px !important}
        .form-control:focus, #focusedInput {
            border: 1px solid #599ef4;
            box-shadow: none;
        }
        .form-control{
            display: inline-block;
        }
        .loan_pop label{
            font-weight: normal;color: black;
        }
        .loan_pop textarea{
            padding-left:15px;
        }
        .boxShade{
            position: fixed;top: 0;right: 0;bottom: 0;left: 0;background: rgba(0,0,0, 0.5);z-index: 1000;
        }
        .loan_pop .pop_con{
            border-left:1px solid #ccc;border-right:1px solid #ccc;
        }
        .loan_pop .het{
            height: 120px !important;
            overflow-y:auto;
        }
        .loan_pop .het1{
            height: 164px !important;
            overflow-y:auto;
        }
        .loan_pop .het2{
            height: 294px !important;
            overflow-y:auto;
        }
        .loan_pop .wet{
           width: 360px !important;
        }
        .loan_pop.wet1{
            width: 450px !important;
        }
        .loan_pop.wet2{
            width: 720px !important;
        }
        .loan_pop .set{
            width: 200px !important;height: 36px !important;font-size: 13px !important;;
        }
        .loan_pop .loan_pop_inp{
            width:200px;height: 36px;font-size: 13px;
        }
        .loan_pop .hintBtn1{
            width: 60px;
            height: 28px;
            float: right !important;margin:7px 10px 0 0 !important;border: 1px solid #ccc !important;background-color: white !important;color: black !important;
        }
        .loan_pop .pop_con_inner p{
            display: inline-block;
        }
        .loan_pop .hintBtn2{
            width: 60px;
            height: 28px;
            float: right !important;margin:7px 10px 0 0 !important;
        }
        .loan_pop .hintFoot{
            border: 1px solid #ccc !important;border-top:none !important;
            height: 40px;
        }
        .loan_pop .hintFoot1{
            border: 1px solid #ccc !important;border-top:none !important;
            height: 46px;
        }
        .loan_pop .pop_con_inner i{
            display: inline-block !important;float: left !important;margin: 0 !important;
        }
        .loan_pop .pop_con_inner b{
            font-weight: normal;font-size: 13px;position: relative;top: 0px;left: 10px;
            line-height:24px;
        }
        .loan_pop .mgt{
            margin-top:10px !important;
        }
        .loan_pop .pop_con textarea{
            margin: 0;
            width: 100%;
            border: 1px solid #ccc;border-radius: 5px;height: 80px;
        }
        .pull-left input{
            width: 155px;
        }
     
        .table-wrap-tip td,
        .table-wrap-tip th{
            padding: 5px;
            text-align: center;
        }
    </style>
    
</head>

<body style="zoom: 1;">

    <div class="left-side sticky-left-side">
        <a href="#">
           <img src="<?php echo ($logourl); ?>"  style="width:100px;margin:20px 0 0 20px;">
       </a>
        <div class="left-side-inner">
            <ul class="nav nav-pills nav-stacked custom-nav js-left-nav"><li class="menu-list nav-active"><a href="#"><span>渠道管理</span></a><ul class="sub-menu-list"><li class="active"><a class="norefresh" url="#" href="#"> 渠道数据统计</a></li></ul></li></ul>
        </div>
    </div>

     <div class="main-content" style="min-height: 938px;">
        <div class="header-section">
            <a class="toggle-btn"></a>
            <div class="menu-right">
                <ul class="notification-menu nt-menu">
                    <li>
                        <a style="width: 134px;height: 48px;" id="slidedown_btn" href="<?php echo C('cfg_app'); ?>/Home/User/logout" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                           <span class="caret">退出</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-usermenu" aria-labelledby="slidedown_btn">
                           <li style="cursor: pointer;"><a onclick="ModifyPwdShow()"><i class="fa fa-cog"></i> 更换密码</a></li>
                            <li style="cursor: pointer;"><a href="<?php echo C('cfg_app'); ?>/Home/User/logout"><i class="fa fa-sign-out"></i> 退出</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="wrapper">
<style>
    .form-control.mgt.loan_pop_inp.price_ipt {width: 87px;margin-left: 8px;}
    h6.count_level {line-height: 16px;font-size: 14px;}
    .separator {margin-left: 8px;}
    h1,h6 {display: inline-block;font-weight: normal}
    #source_list:hover,#source_list:visited {background-color: #599ef4;border-color: #599ef4;}
    .addChannel .loan_pop .set{width: 232px !important;margin-right: 15px;}
    .addChannel .loan_pop #sourceUrl{ width: 400px !important;}
</style>
<div class="sticky-header">
    <div class="wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel_border">
                    <div class="panel_heading">
                        <form id="searchForm2" action="<?php echo C('cfg_app'); ?>/Home/Info/index" method="POST">
                            <ul class="nav pull-left">
                              
                             
                                <li class="pull-left">
                                    <input id="startDate" class="Wdate input-small" value="<?php echo date('Y-m-d');?>" type="date"" name="stratdate" autocomplete="off"> &nbsp;-&nbsp;
                                    <input id="endDate" class="Wdate input-small" value="<?php echo date('Y-m-d',time()+24*60*60);?>" type="date"  name="enddate" autocomplete="off">&nbsp;&nbsp;
                                </li>
                              
                                <li class="pull-left">
                                    <button type="submit" class="btn btn-info">搜索</button>
                                </li>
                                
                            </ul>
                        </form>
                    </div>
                    <div class="panel-body" style="overflow-x:auto;">
                        <form action="#" id="form2" method="post">
                            <table class="table table-hover table-striped table_thead_fixed" style="min-width:1450px;">
                                <thead>


                               
                                <tr>
                                <?php if($json["date_time"] == 1 ): ?><th>日期</th><?php endif; ?>
                                <?php if($json["qudaoname"] == 1 ): ?><th>渠道名</th><?php endif; ?>
                                  <?php if($json["uvcount"] == 1 ): ?><th>UV量</th><?php endif; ?>
                                  <?php if($json["zhucecount"] == 1 ): ?><th>注册量</th><?php endif; ?>
                                  <?php if($json["shimingcount"] == 1 ): ?><th>实名认证</th><?php endif; ?>
                                 <?php if($json["loancount"] == 1 ): ?><th>申请借款人数</th><?php endif; ?> 
                                    <?php if($json["succcount"] == 1 ): ?><th>申请成功人数</th><?php endif; ?> 
                                      <?php if($json["loanlv"] == 1 ): ?><th>借款率%</th><?php endif; ?> 
                                      <?php if($json["tongguolv"] == 1 ): ?><th>通过率%</th><?php endif; ?> 
                                    <?php if($json["caozuo"] == 1 ): ?><th>操作</th><?php endif; ?> 
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                 <?php if($json["date_time"] == 1 ): ?><td><?php echo ($vo["addtime"]); ?></td><?php endif; ?>
                                 <?php if($json["qudaoname"] == 1 ): ?><td><?php echo ($vo["name"]); ?></td><?php endif; ?>
                                      <?php if($json["uvcount"] == 1 ): ?><td><?php echo ($vo["uvcount"]); ?></td><?php endif; ?>
                                     <?php if($json["zhucecount"] == 1 ): ?><td><?php echo ($vo["zhuceshu"]); ?></td><?php endif; ?>
                                    <?php if($json["shimingcount"] == 1 ): ?><td> <?php  $shiming = floor($vo['zhuceshu']*$vo['shenqLv']/100); echo $shiming; ?>
                                
                                    </td><?php endif; ?>
                                      <?php if($json["loancount"] == 1 ): ?><td><?php $loanRenci = floor($shiming*$vo['loanRenci']/100);echo $loanRenci; ?></td><?php endif; ?>
                                     <?php if($json["succcount"] == 1 ): ?><td><?php $chenggongrenci = floor($loanRenci*$vo['chenggongrenci']/100); echo $chenggongrenci; ?></td><?php endif; ?>
                                         <?php if($json["loanlv"] == 1 ): ?><td><?php $jiekuanlv = round($loanRenci/$vo['zhuceshu']*100 , 2); echo $jiekuanlv; ?> %</td><?php endif; ?>
                                          <?php if($json["tongguolv"] == 1 ): ?><td><?php $chenggongrenci = round($chenggongrenci/$vo['zhuceshu']*100 , 2); echo $chenggongrenci; ?> %
                                     </td><?php endif; ?>
                                     <?php if($json["caozuo"] == 1 ): ?><td>
                                        <a href="#">查看</a>
                                    </td><?php endif; ?>
                                     </td>
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
                                            <div class="pagination" id="pagination2" data-url="" currentpage="1" pagecount="1"></div>
                                          
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

    <div class="boxShade addChannel hide1">
        <div class="loan_pop wet2" style="height:425px;">
            <div class="pop_header">
                <span class="pop_header_txt">添加渠道</span>
                <span class="pop_close" onclick="closePopup($(&#39;.addChannel&#39;))">×</span>
            </div>
            <div class="pop_con het2" style="height: 340px !important;">
                <div class="pop_con_inner">
                    <div class="form-inline mgt">
                        <select name="" id="companyName" class="form-control set">
                            <option value="">请选择公司名称</option>
                            
                                    <option value="144">SHJL01</option>
                            
                        </select>
                        <select name="" id="balanceType" class="form-control set">
                            <option value="">请选择结算方式</option>
                            <option value="单条结算">单条结算</option>
                            <option value="综合结算">综合结算</option>
                        </select>
                    </div>
                    
                    <div class="form-inline mgt">
                        <input name="balancePrice" id="sourceName" class="form-control set" placeholder="请输入渠道名称">
                        <div class="form-control set" id="sourceUrl" style="border: none;display:none">链接地址：wwww.baidu.com</div>
                    </div>
                    <div class="form-inline mgt">
                        <select name="balanceWay" id="balanceWay" class="form-control set">
                            <option value="">选择计价方式</option>
                            <option value="A">A</option>
                            <option value="S">S</option>
                            <option value="A+">A阶梯结算</option>
                            <option value="S+">S阶梯结算</option>
                        </select>
                        <select name="balanceStair" id="balanceStair" class="form-control set" style="display:none;">
                            <option value="">选择阶梯级数</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                        </select>
                        <input name="balancePrice" id="balancePrice_ipt" class="form-control set canRadix" style="display:none;" placeholder="请输入单价">
                    </div>
                    <div class="count_level_container">
                        
                    </div>
                    <div class="form-inline mgt">
                        <select name="" id="sourceState" class="form-control set">
                            <option value="ON">启用</option>
                            <option value="OFF">停用</option>
                        </select>
                    </div>
                    <textarea name="" class="form-control mgt" id="remark" style="height:106px;" placeholder="备注（选填）"></textarea>
                </div>
            </div>
            <div class="pop_footer hintFoot1">
                <a class="btn allow_btn hintBtn1" onclick="closePopup($(&#39;.addChannel&#39;))">取消</a>
                <a class="btn allow_btn hintBtn2" id="provide_btn" onclick="addSourse()">确认</a>
            </div>
        </div>
    </div>
</div>

</div>
    </div>



     
    <div class="dialog-modifypwd hide1" id="dialog-modifypwd" title="修改密码" style="padding-top: 20px; overflow: hidden;">
        <div class="form-horizontal">
            <div class="form-group error-con" style="display: none;">
                <label class="col-sm-3 control-label"></label>
                <div class="col-sm-5" style="padding: 0;">
                    <span class="form-control error" style="border: none; color: red;"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">用户名：</label>
                <div class="col-sm-5" style="padding: 0;">
                    <span class="form-control" style="border: none;">用户管理员</span>
                </div>
            </div>
            <div class="form-group">
                <label for="orgpwd" class="col-sm-3 control-label">原密码：</label>
                <div class="col-sm-5" style="padding: 0;">
                    <input type="password" placeholder="请填写原密码" maxlength="25" id="orgpwd" value="" name="orgpwd" class="form-control" autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <label for="newpwd" class="col-sm-3 control-label">新密码：</label>
                <div class="col-sm-5" style="padding: 0;">
                    <input type="password" placeholder="请填写新密码" maxlength="25" id="newpwd" value="" name="newpwd" class="form-control" autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <label for="newpwd2" class="col-sm-3 control-label">确认密码：</label>
                <div class="col-sm-5" style="padding: 0;">
                    <input type="password" placeholder="请再次填写新密码" maxlength="25" id="newpwd2" value="" name="newpwd2" class="form-control" autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3">
                    <button type="button" class="btn btn-info" onclick="ModifyPwd()">提交</button>
                </div>
            </div>
        </div>
    </div>




</body></html>