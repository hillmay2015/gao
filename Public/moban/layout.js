Date.prototype.format =function(format){
    var o = {
        "M+" : this.getMonth()+1, //month
        "d+" : this.getDate(), //day
        "h+" : this.getHours(), //hour
        "m+" : this.getMinutes(), //minute
        "s+" : this.getSeconds(), //second
        "q+" : Math.floor((this.getMonth()+3)/3), //quarter
        "S" : this.getMilliseconds() //millisecond
    }
    if(/(y+)/.test(format)) format=format.replace(RegExp.$1,(this.getFullYear()+"").substr(4- RegExp.$1.length));
    for(var k in o)if(new RegExp("("+ k +")").test(format))
        format = format.replace(RegExp.$1,
            RegExp.$1.length==1? o[k] :	("00"+ o[k]).substr((""+ o[k]).length));
    return format;
}

$(function(){
    jQuery('.main-content').css({'min-height':$(window).height()});
    $.post('/',{},function(result){
        if (result&&result.ret==200&&!!result.data){
            var menu = '';
            $.each(result.data,function(i,m){
                if (m.ChildMenu && m.ChildMenu.length > 0) {
                    menu+='<li class="menu-list"><a href="#" ><span>'+ m.DisplayName+'</span></a><ul class="sub-menu-list">';
                    var subMenu='';
                    $.each(m.ChildMenu,function(j,n){
                        subMenu+='<li><a class="norefresh" url="'+n.ControlUrl+'" href="'+n.ControlUrl+(n.HomeUrl?eval(n.HomeUrl):"")+'"> '+n.DisplayName+'</a></li>';
                    });
                    menu+=subMenu+'</ul></li>';
                }else{
                    menu+= '<li><a class="norefresh"  url="'+m.ControlUrl+'" href="'+m.ControlUrl+(m.HomeUrl?eval(m.HomeUrl):"")+'" ><span>'+ m.DisplayName+'</span></a></li>';
                }
            });
            $('.js-left-nav').append(menu);
            // menuPos();
            leftSelect();
        }
    });
    function GetDateStr(AddDayCount) {
        var dd = new Date();
        dd.setDate(dd.getDate()+AddDayCount);//获取AddDayCount天后的日期
        var y = dd.getFullYear();
        var m = (dd.getMonth()+1)<10?"0"+(dd.getMonth()+1):(dd.getMonth()+1);//获取当前月份的日期，不足10补0
        var d = dd.getDate()<10?"0"+dd.getDate():dd.getDate();//获取当前几号，不足10补0
        return y+"-"+m+"-"+d+" 00:00:00";
    }

    function menuPos(){
        setTimeout(function(){
            $(".js-left-nav").find('.sub-menu-list').each(function(){
                var parent = $(this).parent('.menu-list');
                $(this).css({
                    // position:'fixed',
                    // 'z-index':'10',
                    left:parent.width(),
                    top:parent.offset().top
                })
            })
        },100)
    
    }

    //左边菜单加选中状态
    function leftSelect(){
        var pathname = location.pathname;
        if (pathname!="/"){
            $('.js-left-nav .norefresh').filter(function(){
                return $(this).attr('url') == pathname;
            }).closest("li").addClass('active').parents('.menu-list').addClass('nav-active');
        }
    }

    $("body").delegate(".menu-list > a","click",function(){
        return false;
        var parent = jQuery(this).parent();
        var sub = parent.find('> ul');
        //if(!jQuery('body').hasClass('left-side-collapsed')) {
        if(sub.is(':visible')) {
            sub.slideUp(200, function(){//增加展开动画
                sub.css("display","");
                parent.removeClass("nav-active")
                //mainContentHeightAdjust();
            });
            // sub.slideUp(200, function(){
            //    parent.removeClass('nav-active');
            //    jQuery('.main-content').css({height: ''});
            //    mainContentHeightAdjust();
            // });
        } else {
            visibleSubMenuClose();
            sub.slideDown(200, function(){
                sub.css("display","");//解决某些情况下无法收起bug
                parent.addClass("nav-active")
                //mainContentHeightAdjust();
            });
        }
        //}
        return false;
    });
    $("body").delegate(".js-left-nav .norefresh","click",function(){
        // if ($(this).closest("li").hasClass('active')){
        // 	return false;
        // }
        $('.js-left-nav .active').removeClass('active');

        $(this).closest("li").addClass('active');
        $('.js-left-nav .nav-active').removeClass('nav-active');
        $(this).parents('.menu-list').addClass('nav-active');
        if(!jQuery('body').hasClass('left-side-collapsed')&&$('.js-left-nav .nav-active').length&&$(this).closest(".nav-active").length==0) {
            visibleSubMenuClose();
            // mainContentHeightAdjust();
        }
        var url=$(this).attr('href');
        getpage(url,1);
        //$('.wrapper').zload(url)
        $(window).css("scrollTop",0);
        return false;
    });
    window.onpopstate = function (e) {
        if (e.state){
            $('.js-left-nav .active').removeClass('active');
            visibleSubMenuClose();
            leftSelect();
            // mainContentHeightAdjust();
            $('.wrapper').empty().append(e.state.html);
            execjs(e.state.html);
        }
    }

    $('html').on("keyup",".onlyNumber",function(){
        this.value=this.value.replace(/\D/g,'');
    }).on("afterpaste",".onlyNumber",function(){
        this.value=this.value.replace(/\D/g,'');
    })

    function visibleSubMenuClose() {
        jQuery('.menu-list').each(function() {
            var t = jQuery(this);
            if(t.hasClass('nav-active')) {
                t.find('> ul').slideUp(200, function(){
                    t.removeClass('nav-active');
                });
            }
        });
    }

    //function mainContentHeightAdjust() {
    // Adjust main content height
    // var docHeight = jQuery(document).height();
    // if(docHeight > jQuery('.main-content').height()){
    //   	jQuery('.main-content').height(docHeight);
    // }
    //}
})

function getpage(url,is_condition){
    $.zget(url,"",function(result){
        history.pushState({html:result}, "有个钱包", url);
        $('.wrapper').empty().append(result);
        execjs(result);
        if (is_condition){
            SearchCondition(url)
        }
    });
    return false;
}

$('html').on('click','.skip',function () {
    var href = $(this).attr('href');
    getpage(href);
    return false;
})
$('html').on('click','.skip1',function () {
    // alert(1)
    // e.preventDefault();/"([^=]*)"/g
    var tel = $('.input-medium').eq(0).val();
    var names = $('.input-medium').eq(1).val();
    var nm = $('.input-medium').eq(2).val();
    var input_id = $('.input_id').val();
    var qudao = $('.input-medium').eq(3).val();
    var time = $('#startDate').val();
    var aa  =$('#endDate').val();
    var bb = $('#overdue_num').val();
    var cc = $('#action_type').val();
    var dd = $('#handleType').val();
    var ff = $('#collector').val();
    var gg = $('#loanTermCount').val();
    var riskId = $('#riskId').val();
    var companyt= $("#outsourcing_companyt").val();

    var isWindows = $("#isWindows").val();
    var isCenterShow = $("#isCenterShow").val();
    var isShare = $("#isShare").val();
    var status = $("#status").val();

    window.sessionStorage.URl= window.location.href;
    window.sessionStorage.tel=tel;
    window.sessionStorage.names=names;
    window.sessionStorage.nm=nm;
    window.sessionStorage.input_id=input_id;
    window.sessionStorage.qudao=qudao;
    window.sessionStorage.time=time;
    window.sessionStorage.aa=aa;
    window.sessionStorage.bb=bb;
    window.sessionStorage.cc=cc;
    window.sessionStorage.dd=dd;
    window.sessionStorage.ff=ff;
    window.sessionStorage.gg=gg;
    window.sessionStorage.RiskId=riskId;
    window.sessionStorage.companyt=companyt;

    window.sessionStorage.isWindows=isWindows;
    window.sessionStorage.isCenterShow=isCenterShow;
    window.sessionStorage.isShare=isShare;
    window.sessionStorage.status=status;

    var href = $(this).attr('href');
    getpage(href);
    
    return false;
})
$('html').on('mousedown','.norefresh',function () {
    window.sessionStorage.clear();

})
$('html').on('mouseup','.pull-left button[type="submit"]',function () {
    window.sessionStorage.clear();
    var collector = $("#collector").val();
    var outsourcing_companyt = $("#outsourcing_companyt").val();
    window.sessionStorage.collector=collector;
    window.sessionStorage.collectorOrgId=$("#collectorOrgId").val();
    window.sessionStorage.outsourcing_companyt=outsourcing_companyt;
    window.sessionStorage.shows = $("#locationType").val();
    window.sessionStorage.collectionUserTeam = $("#collectionUserTeam").val();
    window.sessionStorage.channel = $("#channel").val();
    if($(".serviceType").val() == 'PDL'){
        window.sessionStorage.flags= 1;
    }
})
// function zaq(name) {
//     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
//     var r = window.location.search.substr(1).match(reg);
//     if(r!=null)return  unescape(r[2]); return null;
// }

function getUrlString(str,name){
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = str.substr(str.indexOf("?")).substr(1).match(reg);
    var context = "";
    if (r != null)
        context = r[2];
    reg = null;
    r = null;
    return context == null || context == "" || context == "undefined" ? "" : context;
}
function isBlank(obj){
    return(!obj || $.trim(obj) === "");
}
function execjs(html){
    // 第一步：匹配加载的页面中是否含有js
    var regDetectJs = /<script(.|\n)*?>(.|\n|\r\n)*?<\/script>/ig;
    var jsContained = html.match(regDetectJs);
    // 第二步：如果包含js，则一段一段的取出js再加载执行
    if(jsContained) {
        // 分段取出js正则
        var regGetJS = /<script(.|\n)*?>((.|\n|\r\n)*)?<\/script>/im;

        // 按顺序分段执行js
        var jsNums = jsContained.length;
        for (var i=0; i<jsNums; i++) {
            var jsSection = jsContained[i].match(regGetJS);

            if(jsSection[2]) {
                if(window.execScript) {
                    // 给IE的特殊待遇
                    window.execScript(jsSection[2]);
                } else {
                    // 给其他大部分浏览器用的
                    window.eval(jsSection[2]);
                }
            }
        }
    }
}

