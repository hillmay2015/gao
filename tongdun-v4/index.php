<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>保镖报告的插件</title>
    <!--<link rel="stylesheet" href="http://cdnjs.tongdun.cn/bodyguard/css/tdstyle.1.0.css">-->
    <!--<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>-->
    <script src="https://code.jquery.com/jquery-1.9.0.min.js"></script>
    <script src="tdreportv4.js"></script>
    <!--<script type="text/javascript" charset="utf-8" src="http://cdnjs.tongdun.cn/bodyguard/tdreportv4.1.0.min.js"></script>-->
</head>
<body>
<div>背景内容</div>
<script>
	var resultMsg = <?php echo $res =  file_get_contents("http://127.0.0.56/Upload//tongdun//18628337024.log");?>;
    var td_data = [resultMsg];

    $.showReport(td_data);
</script>

</body>
</html>