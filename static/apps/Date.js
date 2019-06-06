/**
 * <p>
 * 		日期格式化：data.format("yyyy-MM-dd HH:mm:ss") q:季度
 * </p>
 * @param fmt	日期格式
 * @returns		返回格式化后的字符串
 */
Date.prototype.format = function (fmt) { 
    var regexs = {
        "M+": this.getMonth() + 1, //月份 
        "d+": this.getDate(), //日 
        "H+": this.getHours(), //小时 
        "m+": this.getMinutes(), //分 
        "s+": this.getSeconds(), //秒 
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度 
        "S": this.getMilliseconds() //毫秒 
    };
    //年 
    if (/(y+)/.test(fmt)){
    	fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    } 
    //其他的格式化
    for (var k in regexs ){
    	if (new RegExp("(" + k + ")").test(fmt)){
    		fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (regexs[k]) : (("00" + regexs[k]).substr(("" + regexs[k]).length)));
    	}
    }
    return fmt;
}
/**
 * 日期格式
 * yyyy-MM-dd
 */
Date.dateStyle = "yyyy-MM-dd";
/**
 * 日期时间格式
 * yyyy-MM-dd HH:mm:ss
 */
Date.dateTimeStyle = "yyyy-MM-dd HH:mm:ss";
/**
 * 时间格式
 * HH:mm:ss
 */
Date.timeStyle = "HH:mm:ss";
/**
 * 将日期字符串（yyyy-MM-dd）转换为Date对象，
 * @param source 字符串
 */
Date.parseDate = function(source){
	var sdate = source.split("-")
	return new Date(sdate[0],sdate[1] - 1,sdate[2])
}
/**
 * 将日期时间字符串（yyyy-MM-dd HH:mm:ss）转换为Date对象
 * @param source 字符串
 */
Date.parseDateTime = function(source){
	var sdatetime = source.split(" ")
	var sdate = sdatetime[0].split("-")
	var stime = sdatetime[1].split(":")
	return new Date(sdate[0],sdate[1] - 1 ,sdate[2],stime[0],stime[1],stime[2]);
}
Date.parseTime = function(source){
	var stime = source.split(":")
	var now = new Date();
	return new Date(now.getFullYear(),now.getMonth() ,now.getDate(),stime[0],stime[1],stime[2]);
}