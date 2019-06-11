<?php if (!defined('THINK_PATH')) exit();?><html><head>
    <link rel="stylesheet" href="__PUBLIC__/static/libs/layui/css/layui.css">
</head><body><div class="filter">
    <form action="<?php echo C('cfg_app'); echo U(GROUP_NAME.'/User/manager');?>" method="post">

        <input name="stratdate" type="date" id="stratdate" placeholder="申请起始时间" class="inpMain" value="2019-06-08" style="height: 32px; font-size:18px">
        <input name="enddate" type="date" id="enddate" placeholder="申请截止时间" class="inpMain" value="2019-06-09" style="height: 32px; font-size:18px">
        <input name="submit" type="submit" class="easyui-linkbutton" value="筛选">

    </form>
</div>

<div id="list">
    <table width="80%" border="0" cellpadding="8" cellspacing="0" class="layui-table">
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
        <tbody>
        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                <?php if($json["date_time"] == 1 ): ?><td><?php echo ($vo["addtime"]); ?></td><?php endif; ?>
                <?php if($json["qudaoname"] == 1 ): ?><td><?php echo ($vo["name"]); ?></td><?php endif; ?>
                <?php if($json["uvcount"] == 1 ): ?><td><?php echo ($vo["uvcount"]); ?></td><?php endif; ?>
                <?php if($json["zhucecount"] == 1 ): ?><td><?php echo ($vo["zhuceshu"]); ?></td><?php endif; ?>
                <?php if($json["shimingcount"] == 1 ): ?><td> <?php
 $shiming = floor($vo['zhuceshu']*$vo['shenqLv']/100); echo $shiming; ?>

                    </td><?php endif; ?>
                <?php if($json["loancount"] == 1 ): ?><td><?php $loanRenci = floor($shiming*$vo['loanRenci']/100);echo $loanRenci; ?></td><?php endif; ?>
                <?php if($json["succcount"] == 1 ): ?><td><?php $chenggongrenci = floor($loanRenci*$vo['chenggongrenci']/100); echo $chenggongrenci; ?></td><?php endif; ?>
                <?php if($json["loanlv"] == 1 ): ?><td><?php $jiekuanlv = round($loanRenci/$vo['zhuceshu']*100 , 2); echo $jiekuanlv; ?> %
                    </td><?php endif; ?>
                <?php if($json["tongguolv"] == 1 ): ?><td><?php $chenggongrenci = round($chenggongrenci/$vo['zhuceshu']*100 , 2); echo $chenggongrenci; ?> %
                    </td><?php endif; ?>
                <?php if($json["caozuo"] == 1 ): ?><td>
                        <a href="#">查看</a>
                    </td><?php endif; ?>
                </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>

        </tbody>
        </table>
</div>

<div class="clear"></div>
<div class="pager">
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
                    "/index.php?g=Admin&m=User&a=changepass",
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
</script></body></html>