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


            <h3>
    <?php echo ($title); ?>
</h3>
<link rel="stylesheet" href="__PUBLIC__/static/libs/layui/css/layui.css">
<div class="filter">
    <form action="<?php echo C('cfg_app'); echo U(GROUP_NAME.'/User/index2');?>" method="post">
        <input name="data_from" id="data_from" type="text" class="inpMain" value="<?php echo ($data_from); ?>" size="20" placeholder="用户名查询" />
        <input name="stratdate" type="date" id="stratdate" placeholder="申请起始时间" class="inpMain"   value="<?php if($start_date){ echo $start_date ;} else { echo date('Y-m-d') ;}?>" style="height: 32px; font-size:18px"/>
        <input name="enddate" type="date" id="enddate" placeholder="申请截止时间" class="inpMain"   value="<?php if($end_date){ echo $end_date ;} else { echo date('Y-m-d',time()+24*60*60) ;}?>" style="height: 32px; font-size:18px"/>
        <input name="submit" type="submit" class="layui-btn" value="筛选" />
      <?php if($adminlogin['gid'] == 1){ ?>  
                <span class="layui-btn" id="daochu">导出</span> 
                 <?php } ?> 
    </form>
</div>
<!--
<textarea class="layui-textarea">我的短链接：<?php echo ($myurl); ?>    
我得长链接：<?php echo ($myurl2); ?></textarea>
-->
<div id="list">
        <table width="80%" border="0" cellpadding="8" cellspacing="0" class="layui-table">
            <tr>
                <th width="50" align="center"><input type="checkbox" name="" id="allChoose"></th>
                <?php if($adminlogin['gid'] == 1){ ?> 
                <th width="80" align="center">ID</th>
                <?php } ?> 
               
                <th width="120" align="center">注册时间</th>
                 
               <th width="120" align="center">渠道名称</th>
               
               <th width="120" align="center">用户名</th>
               
              <?php if($adminlogin['gid'] == 1){ ?>
                 <th width="120" align="center">IP</th>
               <th width="120" align="center">操作</th>
               <?php } ?> 
            </tr>
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td align="center"><input type="checkbox"  data='<?php echo ($vo["id"]); ?>' ></td>
                     <?php if($adminlogin['gid'] == 1){ ?> 
                    <td align="center"><?php echo ($vo["id"]); ?></td>
                   <?php } ?> 
                   
                     
                    
                    <td align="center"><?php echo (date('Y-m-d H:i:s',$vo["addtime"])); ?></td>
                    
                <td align="center"><?php echo ($vo["moban"]); ?></td>
                 
                     <td align="center"><?php echo ($vo["data_from"]); ?></td>
                     <?php if($adminlogin['gid'] == 1){ ?> 
                   <td align="center"><?php echo ($vo["yao_phone"]); ?></td>
                     <td align="center">
                       <a href="javascript:del('<?php echo ($vo["phone"]); ?>','<?php echo U(GROUP_NAME.'/User/del',array('id'=>$vo['id']));?>');">删除</a>
                       </td>
                 <?php } ?> 
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </table>
</div>
<?php if($adminlogin['gid'] == 1){ ?>
<button id="delall" class="do-action layui-btn layui-btn-small do-edit">删除所有</button><?php } ?>
<div class="clear"></div>
<div class="pager">
    <?php echo ($page); ?>
</div>
</div>

<script>
    $("#daochu").click(function(){
        var data_from = $("#data_from").val();
        var stratdate = $("#stratdate").val();
        var enddate = $("#enddate").val();
        if(stratdate == ""){
             layer.msg("起始时间不能为空");return;
        }
         if(enddate == ""){
             layer.msg("结束时间不能为空");return;
        }
         window.location.href = 'index.php?g=Admin&m=User&a=daochu&data_from='+data_from+"&stratdate="+stratdate+"&enddate="+enddate;
    })
    $("#allChoose").click(function(){
        var flag = $("#allChoose").is(':checked');
        if(!flag){
            $(":checkbox").removeAttr("checked");//取消全选
        }else{
            $(":checkbox").attr("checked","true");
        }
    })
    $("#delall").click(function(){
        var adIds = "";
        $(":checkbox:checked").each(function(i){  
            if(0==i){  
                adIds = $(this).attr('data');  
            }else{  
                adIds += (","+$(this).attr('data'));  
            }
            
        });
        
        $.ajax({
                    url : "index.php?g=Admin&m=User&a=alldel",
                    type : "post",
                    data : {adIds:adIds},
                    success : function(ret) {
                        if (ret.success) {
                            //var qq=ret.data.qq;
                            
                            layer.msg("成功删除"+ret.msg+"条数据");
                            setTimeout(function(){
                                window.location.href = 'index.php?g=Admin&m=User&a=index';
                            },1000);
                            
                        } else {
                            layer.msg(ret.msg);
                            
                        }
                    },
                    error : function() {
                        layer.msg("提交错误");
                        
                    }
                });
    })
    function del(uname,jumpurl){
        layer.confirm(
                '确定要删除用户:'+uname+'吗?',
                function (){
                    window.location.href = jumpurl;
                }
        );
    }
    function changepass(uid){
    layer.prompt({title: '输入新密码，并确认', formType: 1}, function(pass, index){
      if(pass == '' || pass == null){
        layer.msg('密码不能为空!');
      }else if(pass.length < 6){
        layer.msg("密码长度不能小于6位!");
      }else{
        $.post(
          "<?php echo U(GROUP_NAME.'/User/changepass');?>",
          {id:uid,pass:pass},
          function (data,state){
            if(state != "success"){
              layer.msg("网络通讯失败!");
            }else if(data.status == 1){
              layer.msg("密码修改成功!");
              layer.close(index);
            }else{
              layer.msg(data.msg);
            }
          }
        );
      }
    });
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