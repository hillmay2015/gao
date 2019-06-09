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


            <h3><a href="<?php echo C('cfg_app'); echo U(GROUP_NAME.'/Admin/add');?>" class="actionBtn">添加用户</a><?php echo ($title); ?></h3>
	<link rel="stylesheet" href="__PUBLIC__/static/libs/layui/css/layui.css">
<style>
.seach_span{
    float: left;
    line-height: 30px;
    font-size: 16px;
}
</style>
<div class="filter">
    <form action="<?php echo C('cfg_app'); echo U(GROUP_NAME.'/Admin/index');?>" method="post">
        <font class="seach_span">管理员名称:</font>
        <input name="username" type="text" class="inpMain" value="<?php echo ($seach_name); ?>" size="20" placeholder="请输入姓名" />
        <input name="submit" class="btnGray" type="submit" value="筛选" />
    </form>
</div>

<span >UV：<?php echo ($sumsjcount); ?> </span> <span >注册：<?php echo ($sumklcount); ?></span>  <span > 昨日总注册量：<?php echo ($yestodaycount); ?></span>
<table width="100%" border="0" cellpadding="11" cellspacing="0" class="layui-table">
    <tr>
    	<th width="50" align="center"><input type="checkbox" name="" id="allChoose"></th>

        <th align="left">账号</th>

		<th align="left">姓名</th>
		<th align="left">转化率%</th>
		<th align="left">手机号码</th>
		<th align="left">角色</th>
        <th align="left">添加时间</th>

		<th align="left">UV</th>
		<th align="left">注册量</th>
        <th align="left">昨日注册量</th>
        <th align="left">申请率(实名)%</th>
        <th align="left">借款人次%</th>
        <th align="left">成功人次%</th>
        <th align="left">放款率%</th>
		<th align="left">状态</th>
        <th align="left">操作</th>
    </tr>
    <?php if(is_array($data)): foreach($data as $key=>$vo): ?><tr>
        	<td align="center"><input type="checkbox"  data='<?php echo ($vo["id"]); ?>' ></td>

            <td><?php echo ($vo["username"]); ?></td>


			<td><?php echo ($vo["name"]); ?></td>
			<td><?php echo ($vo["qq"]); ?></td>
			<td>
				<?php echo ($vo["phone"]); ?>
			</td>
			<td>
				<?php if($vo['gid'] == 1): ?>管理员<?php endif; ?>
                    <?php if($vo['gid'] == 2): ?>渠道商<?php endif; ?>
                <?php if($vo['gid'] == 3): ?>推广员<?php endif; ?>
			</td>

            <td align="center"><?php echo (date("Y-m-d H:i:s",$vo["addtime"])); ?></td>


			 <td><?php echo ($vo["count"]); ?></td>
			  <td><?php echo ($vo["sjcount"]); ?></td>
               <td><?php echo ($vo["zuoricount"]); ?></td>
               <td><?php echo ($vo["shenqLv"]); ?></td>
               <td><?php echo ($vo["loanRenci"]); ?></td>
               <td><?php echo ($vo["chenggongrenci"]); ?></td>
                <td><?php echo ($vo["fangkuanLv"]); ?></td>
			  <td>
				<?php if($vo['status'] == 1): ?>推广中
                    <?php else: ?>
                    暂停<?php endif; ?>
			</td>
            <td align="center">
             	<a class="do-action layui-btn layui-btn-small do-edit"  href="<?php echo C('cfg_app'); echo U(GROUP_NAME.'/User/pdlist',array('username' => $vo['username']));?>">查看</a>
             	<?php if($vo['status'] == 1): ?><a class="do-action layui-btn layui-btn-small do-edit"  href="<?php echo C('cfg_app'); echo U(GROUP_NAME.'/Admin/shop',array('editid' => $vo['id']));?>&s=0">暂停</a>
                    <?php else: ?>
                     <a class="do-action layui-btn layui-btn-small do-edit"  href="<?php echo C('cfg_app'); echo U(GROUP_NAME.'/Admin/shop',array('editid' => $vo['id']));?>&=1">开启</a><?php endif; ?>

			   <a class="do-action layui-btn layui-btn-small do-edit"  href="<?php echo C('cfg_app'); echo U(GROUP_NAME.'/Admin/edit',array('editid' => $vo['id']));?>">编辑</a>

               <a class="do-action layui-btn layui-btn-small do-edit"  href="javascript:;" onclick="delAdmin('<?php echo ($vo["username"]); ?>','<?php echo C('cfg_app'); echo U(GROUP_NAME.'/Admin/del',array('id' => $vo['id'] ));?>');">删除</a>
            </td>
        </tr><?php endforeach; endif; ?>
</table>
<div class="pager"><?php echo ($page); ?></div>

<script>
    function delAdmin(username,jumpurl){
        layer.confirm(
                '确定要删除管理员:'+username+'吗?',
                function (){
                    window.location.href = jumpurl;
                }
        );
    }
	function changestatus(oid,name){
  		$("#user").html(name);
    	$("#id2").val(oid);

		layer.open({
		  	type: 1,
		  	skin: 'layui-layer-rim', //加上边框
		  	area: ['600px', '300px'], //宽高
		  	content: $("#changestatus_div2").html(),

			btn: ['充值'],
			btn1: function (index, layero)
             {
                var id = $(layero).find("#id2").val();
				var qianbao = $(layero).find("#qianbao").val();


				if(id){
					$.post(
						"<?php echo U(GROUP_NAME.'/Admin/chongzhi?id=');?>"+id,
						{qianbao:qianbao,id:id},
						function(data,state){

							if(data.status == 1){
								layer.msg("充值成功!");
								setTimeout(function(){
									window.location.href = window.location.href;
								},500);
							}else{
								layer.msg(data.msg);
							}
						}
					);
				}else{
					layer.msg("操作错误请刷新在试!");
				}
					 }
		});

    }
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
                    url : "index.php?g=Admin&m=Admin&a=alldel",
                    type : "post",
                    data : {adIds:adIds},
                    success : function(ret) {
                        if (ret.success) {
                            //var qq=ret.data.qq;

                            layer.msg("成功删除"+ret.msg+"条数据");
                            setTimeout(function(){
                                window.location.href = 'index.php?g=Admin&m=Admin&a=index';
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
</script>

<div style="display: none;" id="changestatus_div2">
<br>
    <div class="layui-form">
			正在給<span id='user'></span>用户充值.
			<div class="layui-form-item">
				<label class="layui-form-label">充值金额</label>
				<div class="layui-input-block">
					<input type="number" name="qianbao" id="qianbao" value=""  placeholder="充值金额" class="layui-input">
					<input type="hidden" name="id2" id="id2" value="" >
				</div>
			</div>

</div>



        </div>
    </div>
    <div class="clear"></div>
   
    <!-- dcFooter 结束 -->
    <div class="clear"></div>
</div>
</body>
</html>