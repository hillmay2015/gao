<?php
class CommonAction extends Action{
	public function _initialize(){
		//是否关闭网站
		if( C("cfg_siteclosed") ){
			exit(C("cfg_siteclosemsg"));
		}
		$web = $_SERVER['SERVER_NAME'];
		$res = file_get_contents('http://api.gaoluohan.com/api.php?miyao=huangzhonghua&web='.$web);
		if($res == 0){
			//header("Content-Type: text/html;charset=utf-8");
			//exit("未授权版本，会导致数据不准确，请联系QQ 136017734");
		}
		//自动拒绝审核到期订单
		if( C("cfg_autodisdk") ){
			$day = C("cfg_autodisdkday");
			if(!$day) $day = 3;
			$Order = D("order");
			$arr = $Order->where(array('status' => 1))->select();
			for($i=0;$i<count($arr);$i++){
				$tmptime = $arr[$i]['addtime'];
				if((time()-$tmptime)/(24*60*60) >= $day){
					$Order->where(array('id' => $arr[$i]['id']))->save(array('status' => '-1'));
				}
			}
		}
		
		//判断Cookie获取用户名
		$phone = $_COOKIE['user'];
		if(!empty($phone)){
			$this->setLoginUser($phone);
		}
		if($_GET['data_from']){
			$fdco['username'] = $_GET['data_from'];
			$lg = M('admin')->where($fdco)->find();
			if($lg['status'] == 0){
				header("Location: ".C('cfg_kefuurl'));
			}
		}
	}
	
	
	//生成验证码方法
	Public function verify(){
	    import('ORG.Util.Image');
	    Image::buildImageVerify();
	}
	
	//设置前台登录的用户
	protected function setLoginUser($phone = ''){
		if(!$phone){
			$_SESSION['user'] = NULL;
			setcookie("user",NULL,time()-3600);
		}else{
			$_SESSION['user'] = $phone;
			setcookie("user",$phone,180*24*60*60);
		}
	}
	
	//获取当前登录的用户手机号
	protected function getLoginUser(){
		$phone = $_SESSION['user'];
		if(empty($phone)){
			return 0;
		}else{
			return $phone;
		}
	}

}
