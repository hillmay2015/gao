function progressLoad(){  
    $("<div class=\"datagrid-mask\" style=\"position:absolute;z-index: 9999;\"></div>").css({display:"block",width:"100%",height:$(window).height()}).appendTo("body");  
    $("<div class=\"datagrid-mask-msg\" style=\"position:absolute;z-index: 9999;\"></div>").html("正在处理，请稍候。。。").appendTo("body").css({display:"block",left:($(document.body).outerWidth(true) - 190) / 2,top:($(window).height() - 45) / 2});  
}

function progressClose(){
	$(".datagrid-mask").remove();  
	$(".datagrid-mask-msg").remove();
}