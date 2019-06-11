<?php
class InfoAction extends CommonAction{
	private $userinfo;
	function _initialize(){
		$user = $this->getLoginUser();
		if(!$user){
			$this->redirect('Index/Index');
		}
		$Userinfo = D("userinfo");
		$info = $Userinfo->where(array('user' => $this->getLoginUser()))->find();
		if(!$info){
			$infoid = $Userinfo->add(array('user' => $this->getLoginUser()));
			$info = array('id' => $infoid,'user' => $this->getLoginUser());
		}
		$this->userinfo = $info;
	}
	
	public function index(){ 

		$data_from = I("data_from",'','trim');
		$this->data_from = $data_from;
		$where = array();
      	$adminlogin = session('Admin_login');
		if($data_from){
			$where['phone'] = array('like',"%{$data_from}%");
		}
		$daycount = 2;
		if($_POST){
	      	if(!$_POST['stratdate']){
	      		$this->error('请输入起始时间');die;	
	      	}
	      	if(!$_POST['enddate']){
	      		$this->error('请输入结束时间');die;	
	      	}
	      	$create_date = strtotime($_POST['stratdate']);
	      	$enddate = strtotime($_POST['enddate']);
	      	$where['addtime'] = array(array('EGT',$create_date),array('ELT',$enddate),'AND');
	      	$daycount = diffBetweenTwoDays($create_date,$enddate);
	      	$this->assign('start_date',$_POST['stratdate']);
            $this->assign('end_date',$_POST['enddate']);
      	}
      	
      
		$User = D("user");
		$list = array();
		for($i = 1 ; $i < $daycount+1; $i ++){
			$map = array();
			$map2 = array();
			$newtime = strtotime(date('Y-m-d',time()+24*60*60));  
		
      		$map['data_from'] = $adminlogin['username'];
      		$map['flag'] = 0;
      		
			
			$day = $i*24*60*60;
			
			$map['addtime'] =  array(array('EGT',$newtime-$day),array('ELT',($newtime-$day)+24*60*60),'AND');
			
			$list[$i]['zhuceshu'] = $User->where($map)->count();
			$uData = $User->where($map)->find();
			$list[$i]['addtime'] = date('Y-m-d',$newtime-$day);
			$list[$i]['data_from'] = $adminlogin['username'];
			$usermap['username'] = $adminlogin['username'];
          	$uuData = M('admin')->where($usermap)->find();
          	
			$list[$i]['fangkuanLv'] = $uuData['fangkuanLv'];
			$list[$i]['shenqLv'] = $uuData['shenqLv'];
			$list[$i]['loanRenci'] = $uuData['loanRenci'];
			$list[$i]['chenggongrenci'] = $uuData['chenggongrenci'];
			$list[$i]['name'] = $uuData['name'];

			$map2['addtime'] = array(array('EGT',$newtime-$day),array('ELT',($newtime-$day)+24*60*60),'AND');
			$map2['data_from'] = $adminlogin['username'];
			$list[$i]['uvcount'] = M('user')->where($map2)->count();
		

		}
		
		$this->list = $list;
		$adminlogin = session('Admin_login');
		$this->assign('adminlogin',$adminlogin);
		$jsonmap['username'] = $adminlogin['username'];
		$data = M('admin')->where($jsonmap)->find();

		$json = json_decode($data['auth'],true);

        $this->assign("json", $json);
        $this->assign('logourl', $data['logourl']);
        if($adminlogin['tpl']==1){
            $this->display('index1');
        }else{
            $this->display('index2');
        }

		
	}
	
	//身份信息
	//姓名、身份证号码、住址
	public function baseinfo(){
		if(IS_POST){
			$data = array('status' => 0,'msg' => '未知错误');
			$Userinfo = D("userinfo");
			$order = D("order");
			 $tduo = $order->where(array('user' => $this->getLoginUser(),'status' =>2))->count();
			if($tduo>0){
					$data['msg'] = "保存失败，你已经通过了贷款申请，不可以修改资料了";
					}
			else
			{
						
		
						
			 $status = $Userinfo->where(array('user' => $this->getLoginUser()))->save($_POST);
			 if(!$status){
				$data['msg'] = "保存失败，你没有修改任何资料";
			}else{
				
				
						$u = D("user")->where(array('phone' => $this->getLoginUser()))->save(array('truename'=>$_POST['name']));
						
if(!$u){
	$data['msg'] = "保存失败";
}
else{
	
	$data['status'] = 1;
	
	}
			 	
				
					
			 }
						}
			
			$this->ajaxReturn($data);
			exit;
		}
		$this->assign("userinfo",$this->userinfo);
		$this->display();
	}
	protected function base64($data){//图片转码base64
		$file = $data;
		$search="http://".$_SERVER['HTTP_HOST']."/";
		$file=str_replace($search,"",$file);
		if($fp = fopen($file,"rb", 0)) 
		{ 
		    $gambar = fread($fp,filesize($file)); 
		    fclose($fp);
		    $base64 = chunk_split(base64_encode($gambar)); 
		}
		return $base64;
	}
	protected function basecurl($base){
		    $host = "https://dm-21.data.aliyun.com";
		    $path = "/rest/160601/face/detection.json";
		    $method = "POST";
		    $appcode = "OloqTo7mcJUycLdhMbjryKV5FvmHodeA";
		    $headers = array();
		    array_push($headers, "Authorization:APPCODE " . $appcode);
		    //根据API的要求，定义相对应的Content-Type
		    array_push($headers, "Content-Type".":"."application/json; charset=UTF-8");
		    $querys = "";
		    $bodys = '{"inputs":[{"image":{"dataType":50,"dataValue":"'.$base.'"}}]}';
		    $url = $host . $path;
		
		    $curl = curl_init();
		    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
		    curl_setopt($curl, CURLOPT_URL, $url);
		    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		    curl_setopt($curl, CURLOPT_FAILONERROR, false);
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($curl, CURLOPT_HEADER, false);
		    if (1 == strpos("$".$host, "https://"))
		    {
		        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		    }
		    curl_setopt($curl, CURLOPT_POSTFIELDS, $bodys);
			$result=curl_exec($curl);
			return $result;
	}
	protected function sfzzmcurl($base) {
		//echo $base;
		$host = "https://dm-51.data.aliyun.com";
	    $path = "/rest/160601/ocr/ocr_idcard.json";
	    $method = "POST";
	    $appcode = "OloqTo7mcJUycLdhMbjryKV5FvmHodeA";
	    $headers = array();
	    array_push($headers, "Authorization:APPCODE " . $appcode);
	    //根据API的要求，定义相对应的Content-Type
	    array_push($headers, "Content-Type".":"."application/json; charset=UTF-8");
	    $querys = "";
	    $bodys =  "{
					    \"inputs\": [
					        {
					            \"image\": {
					                \"dataType\": 50,
					                \"dataValue\": \"".$base."\"
					            },
					            \"configure\": {
					                \"dataType\": 50,
					                \"dataValue\": \"{\\\"side\\\":\\\"face\\\"}\"
					            }
					        }
					    ]
					}";
	    $url = $host . $path;
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($curl, CURLOPT_FAILONERROR, false);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_HEADER,false);
	    if (1 == strpos("$".$host, "https://"))
	    {
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	    }
	    curl_setopt($curl, CURLOPT_POSTFIELDS, $bodys);
		$result=curl_exec($curl);
	    return $result;
	}
	protected function sfzfmcurl($base) {
		//echo $base;
		$host = "https://dm-51.data.aliyun.com";
	    $path = "/rest/160601/ocr/ocr_idcard.json";
	    $method = "POST";
	    $appcode = "OloqTo7mcJUycLdhMbjryKV5FvmHodeA";
	    $headers = array();
	    array_push($headers, "Authorization:APPCODE " . $appcode);
	    //根据API的要求，定义相对应的Content-Type
	    array_push($headers, "Content-Type".":"."application/json; charset=UTF-8");
	    $querys = "";
	    $bodys =  "{
					    \"inputs\": [
					        {
					            \"image\": {
					                \"dataType\": 50,
					                \"dataValue\": \"".$base."\"
					            },
					            \"configure\": {
					                \"dataType\": 50,
					                \"dataValue\": \"{\\\"side\\\":\\\"back\\\"}\"
					            }
					        }
					    ]
					}";
	    $url = $host . $path;
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($curl, CURLOPT_FAILONERROR, false);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_HEADER,false);
	    if (1 == strpos("$".$host, "https://"))
	    {
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	    }
	    curl_setopt($curl, CURLOPT_POSTFIELDS, $bodys);
		$result=curl_exec($curl);
	    return $result;
	}
	public function xycx(){
		
		$this->assign("userinfo",$this->userinfo);
		//print_r($this->userinfo);
		$this->display();
	}
	public function xycxpost(){
		
		if($_POST){
			
			$apiKey= C("cfg_api_key");
			//$name=$_POST['name'];
			//$card=$_POST['usercard'];
			$mobile=$_POST['mobile'];
			$mobilepassword=$_POST['mobilepassword'];
			$user=$_POST['user'];
			$input=$_POST['code'];
				
			if(!$input){
			
				$array=array(
					'method'=>'api.mobile.get',
					'apiKey'=>$apiKey,
					'version'=>'1.2.0',
					'username'=>$mobile,
					'password'=>base64_encode($mobilepassword),
				);
				$data=$this->paixu($array);
				
				$result=$this->curl($data);
				//echo $result;
				//exit;
				$result=json_decode($result,true);
				
				if($result['code']!="0010"){
					print_r($result);
					//echo "错误！查看手机号码或者服务密码是否正确";
					exit;
				}
				$token=$result['token'];
				cookie("token",$token);
				$getstatus=array(
					'method'=>'api.common.getStatus',
					'apiKey'=>$apiKey,
					'version'=>'1.2.0',
					'token'=>$token,
					'bizType'=>'mobile',
				);
				
				$status=$this->paixu($getstatus);
				
				$i = 1;
				while($i<=1){
					$resultstatus=$this->curl($status);
					$resultstatus=json_decode($resultstatus,true);
					if($resultstatus['code']){
						$i++;
						//print($resultstatus);
						
					}
					
				}
					if($resultstatus['code']=="2010"){
					exit("123");
				}
				//print_r($resultstatus);
				if($resultstatus['code']!="0000" and $resultstatus['code']=="0006"){
					exit("888");
				}
			}
			
			if($input){
					
				$inputarray=array(
					'method'=>'api.common.input',
					'apiKey'=>$apiKey,
					'version'=>'1.2.0',
					'token'=>cookie('token'),
					'input'=>$input,
				);
				

				$inputdata=$this->paixu($inputarray);
				
				$inputresult=$this->curl($inputdata);
				
				
				//echo $inputresult;
				$inputarr=json_decode($inputresult,true);
				
				
				if($inputarr['code']!="0009"){
					exit("111");
				}
				
			}
			//echo "ttttttt";
			$get=array(
				'method'=>'api.common.getResult',
				'apiKey'=>$apiKey,
				'version'=>'1.2.0',
				'token'=>cookie('token'),
				'bizType'=>'mobile',
			
			);
			//print_r($get);
			
			$mobiledata=$this->paixu($get);
			
			$resultdata=$this->curl($mobiledata);
			
	        
			$resultstatus=json_decode($resultdata,true);
			if($resultstatus['code']=="1114"){
					exit("1114");
				}
				
			$xycx=M('xycx');
			if($resultstatus['code']=="0000"){
				
				$file = "Upload/data/".$mobile.".txt";
				
				$adddata['user']=$user;
				$adddata['date']=date("Y-m-d H:i:s");
				$adddata['mobile']=$mobile;
				$adddata['text']=$resultdata;
				$res = $xycx->add($adddata);
				if($res){
				
					exit("999");
				}else{
					
					
					exit("插入数据库错误");
				}
			}
		}
	}
	protected function paixu($array){
		$apiSecret=C("cfg_api_secret");
		ksort($array);
			$i=0;
			foreach($array as $key=>$value){
				if($i==0){
					$str.=$key."=".$value;
					$i++;
				}else{
					$str.="&".$key."=".$value;	
				}
			}
			$sstr=$str.$apiSecret;
			$array['sign']=sha1($sstr);
			$data=http_build_query($array);
			return $data;
	}
	public function xycxcallback(){
		$input = file_get_contents('php://input');
		$input = json_decode($input,true);
		$data['date'] = date('Y-m-d H:i:s');
		$data['message'] = $input['message'];
		$data['task_id'] = $input['task_id']; 
		$data['name'] = $input['task_id'];
		$data['mobile'] = $input['mobile'];
		$map['mobile'] = $input['mobile'];
		$status = M('xybg')->where($map)->find();
		if(!$status){
			M('xybg')->add($data);
		}
		
	}
	protected function curl($data){
		$url="https://t.limuzhengxin.cn/api/gateway";//测试环境
		//$url="https://api.limuzhengxin.com/api/gateway";//正式环境
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		
		$output = curl_exec($ch);
		//echo curl_error($ch);
		curl_close($ch);
		return $output;
		//print_r($output);
	}
	
	
	public function gjjpost(){
		
		if($_POST){
			
			$apiKey= C("cfg_api_key");
			//$name=$_POST['name'];
			//$card=$_POST['usercard'];
			$mobile=$_POST['mobile'];
			$mobilepassword=$_POST['mobilepassword'];
			$user=$_POST['user'];
			$input=$_POST['code'];
			$realName = $_POST['realName'];
			$area = $_POST['area'];
			$area = $this->findHouseAare($area); 
			if($area == ""){
				exit("不支持该地区");
			}
			if(!$input){
			
				$array=array(
					'method'=>'api.housefund.get',
					'apiKey'=>$apiKey,
					'version'=>'1.2.0',
					'username'=>$mobile,
					'password'=>base64_encode($mobilepassword),
					'area' => $area,
					"realName"=>$realName,
				);
				$data=$this->paixu($array);
				
				$result=$this->curl($data);
				
				$result=json_decode($result,true);
				
				if($result['code']!="0010"){
					print_r($result);
					//echo "错误！查看手机号码或者服务密码是否正确";
					exit;
				}
				$token=$result['token'];
				cookie("token",$token);
				$getstatus=array(
					'method'=>'api.common.getStatus',
					'apiKey'=>$apiKey,
					'version'=>'1.2.0',
					'token'=>$token,
					'bizType'=>'housefund',
				);
				
				$status=$this->paixu($getstatus);
				
				$i = 1;
				while($i<=1){
					$resultstatus=$this->curl($status);
					$resultstatus=json_decode($resultstatus,true);
					if($resultstatus['code']){
						$i++;
						//print($resultstatus);
						
					}
					
				}
				
				if($resultstatus['code']=="2010"){
					exit("短信验证码发送超限");
				}
				//print_r($resultstatus);
				if($resultstatus['code']!="0000" and $resultstatus['code']=="0006"){
					exit("888");
				}
			}
			
			if($input){
					
				$inputarray=array(
					'method'=>'api.common.input',
					'apiKey'=>$apiKey,
					'version'=>'1.2.0',
					'token'=>cookie('token'),
					'input'=>$input,
				);
				

				$inputdata=$this->paixu($inputarray);
				
				$inputresult=$this->curl($inputdata);
				
				
				//echo $inputresult;
				$inputarr=json_decode($inputresult,true);
				
				
				if($inputarr['code']!="0009"){
					exit("111");
				}
				
			}
			//echo "ttttttt";
			$get=array(
				'method'=>'api.common.getResult',
				'apiKey'=>$apiKey,
				'version'=>'1.2.0',
				'token'=>cookie('token'),
				'bizType'=>'housefund',
			
			);
			//print_r($get);
			
			$mobiledata=$this->paixu($get);
			
			$resultdata=$this->curl($mobiledata);
			
	        
			$resultstatus=json_decode($resultdata,true);
			if($resultstatus['code']=="1114"){
					exit("查询结果缺少关键数据");
			}
			if($resultstatus['code']=="1115"){
					exit("查询结果为空");
			}
		
					
			$xycx=M('gjjbg');
			if($resultstatus['code']=="0000"){
				
				$adddata['user']=$user;
				$adddata['date']=date("Y-m-d H:i:s");
				$adddata['mobile']=$this->getLoginUser();
				$adddata['text']=$resultdata;
				$res = $xycx->add($adddata);
				if($res){
				
					exit("999");
				}else{
					exit("插入数据库错误");
				}
			}
		}
	}
	// 社保查询
	public function shebao(){
		$data = M("")->select();
		$this->display();
	}
	public function shebaopost(){
		if($_POST){
			$apiKey= C("cfg_api_key");
			//$name=$_POST['name'];
			//$card=$_POST['usercard'];
			$mobile=$_POST['mobile'];
			$mobilepassword=$_POST['mobilepassword'];
			$user=$_POST['user'];
			$input=$_POST['code'];
			$realName = $_POST['realName'];
			$area = $_POST['area'];
			$area = $this->findHouseAare($area); 
			if($area == ""){
				exit("不支持该地区");
			}
			if(!$input){
			
				$array=array(
					'method'=>'api.socialsecurity.get',
					'apiKey'=>$apiKey,
					'version'=>'1.2.0',
					'username'=>$mobile,
					'password'=>base64_encode($mobilepassword),
					'area' => $area,
					"realName"=>$realName,
				);
				$data=$this->paixu($array);
				
				$result=$this->curl($data);
				//echo $result;
				//exit;
				$result=json_decode($result,true);
				
				if($result['code']!="0010"){
					print_r($result);
					//echo "错误！查看手机号码或者服务密码是否正确";
					exit;
				}
				$token=$result['token'];
				cookie("token",$token);
				$getstatus=array(
					'method'=>'api.common.getStatus',
					'apiKey'=>$apiKey,
					'version'=>'1.2.0',
					'token'=>$token,
					'bizType'=>'socialsecurity',
				);
				
				$status=$this->paixu($getstatus);
				
				$i = 1;
				while($i<=1){
					$resultstatus=$this->curl($status);
					$resultstatus=json_decode($resultstatus,true);
					if($resultstatus['code']){
						$i++;
						//print($resultstatus);
						
					}
					
				}
					if($resultstatus['code']=="2010"){
					exit("123");
				}
				//print_r($resultstatus);
				if($resultstatus['code']!="0000" and $resultstatus['code']=="0006"){
					exit("888");
				}
			}
			
			if($input){
					
				$inputarray=array(
					'method'=>'api.common.input',
					'apiKey'=>$apiKey,
					'version'=>'1.2.0',
					'token'=>cookie('token'),
					'input'=>$input,
				);
				$inputdata=$this->paixu($inputarray);
				
				$inputresult=$this->curl($inputdata);
				//echo $inputresult;
				$inputarr=json_decode($inputresult,true);
				if($inputarr['code']!="0009"){
					exit("111");
				}
			}
			//echo "ttttttt";
			$get=array(
				'method'=>'api.common.getResult',
				'apiKey'=>$apiKey,
				'version'=>'1.2.0',
				'token'=>cookie('token'),
				'bizType'=>'socialsecurity',
			);
			//print_r($get);
			
			$mobiledata=$this->paixu($get);
			$resultdata=$this->curl($mobiledata);
			$resultstatus=json_decode($resultdata,true);
			if($resultstatus['code']=="1114"){
					exit("1114");
			}
			if($resultstatus['code']=="1115"){
					exit("查询数据为空");
			}				
			$xycx=M('sbbg');
			if($resultstatus['code']=="0000"){
				$adddata['user']=$user;
				$adddata['date']=date("Y-m-d H:i:s");
				$adddata['mobile'] = $this->getLoginUser();
				$adddata['text']=$resultdata;
				$res = $xycx->add($adddata);
				if($res){
				
					exit("999");
				}else{
					exit("插入数据库错误");
				}
			}
		}
	}
	//单位信息
	public function unitinfo(){
		if(IS_POST){
			$data = array('status' => 0,'msg' => '未知错误');
			$Userinfo = D("userinfo");
			$status = $Userinfo->where(array('user' => $this->getLoginUser()))->save($_POST);
			if(!$status){
				$data['msg'] = "操作失败";
			}else{
				$data['status'] = 1;
			}
			$this->ajaxReturn($data);
			exit;
		}
		$this->assign("userinfo",$this->userinfo);
		$this->display();
	}

	//银行卡信息
	public function bankinfo(){
		if(IS_POST){
			$data = array('status' => 0,'msg' => '未知错误');
			$bankcard = I("bankcard",0,'trim');
			if(strlen($bankcard) < 16 || strlen($bankcard) > 20){
				$data['msg'] = "不是有效的银行卡号!";
			}else{
				$Userinfo = D("userinfo");
				$status = $Userinfo->where(array('user' => $this->getLoginUser()))->save($_POST);
				if(!$status){
					$data['msg'] = "操作失败";
				}else{
					$data['status'] = 1;
				}
			}
			$this->ajaxReturn($data);
			exit;
		}
		$this->assign("userinfo",$this->userinfo);
		$this->display();
	}
	
	//芝麻信用授权确认
	public function zhimastepone(){
		$userinfo = $this->userinfo;
		if($userinfo['alipay']){
			$this->redirect('Info/index');
		}
		$this->display();
	}
	
	//芝麻信用授权
	public function zhimasteptwo(){
		$userinfo = $this->userinfo;
		if($userinfo['alipay']){
			$this->redirect('Info/index');
		}
		if(IS_POST){
			$data = array('status' => 0,'msg' => '未知错误');
			$code = I("code",'','trim');
			if(strlen($code) != 6){
				$data['msg'] = "短信验证码输入有误";
			}else{
				//判断验证码是否正确
				$Smscode = D("smscode");
				$info = $Smscode->where(array('phone' => $userinfo['user']))->order("sendtime desc")->find();
				if(!$info || $info['code'] != $code){
					$data['msg'] = "短信验证码输入有误";
				}elseif( (time()-30*60) > $info['sendtime']){
					$data['msg'] = "验证码已过期,请重新获取!";
				}else{
					$Userinfo = D("userinfo");
					$status = $Userinfo->where(array('user' => $userinfo['user']))->save(array('alipay' => '1'));
					if($status){
						$data['status'] = 1;
					}else{
						$data['msg'] = "授权失败!";
					}
				}
			}
			$this->ajaxReturn($data);
			exit;
		}
		$str = substr($userinfo['user'],0,3);
		$phone = $str;
		$str = substr($userinfo['user'],7,4);
		$phone .= '****' . $str;
		$this->phone = $phone;
		$this->assign("userinfo",$this->userinfo);
		$this->display();
	}

	public function otherinfo(){
		$Otherinfo = D("otherinfo");
		if(IS_POST){
			$otherinfo = $_POST['otherinfo'];
			if(empty($otherinfo)) $otherinfo = array();
			$str = json_encode($otherinfo);
			$status = $Otherinfo->where(array('user' => $this->getLoginUser()))->find();
			if(!$status){
				$Otherinfo->add(array(
					'user' => $this->getLoginUser(),
					'infojson' => $str,
					'addtime' => time()
				));
			}else{
				$Otherinfo->where(array('user' => $this->getLoginUser()))->save(array('infojson' => $str));
			}
			exit;
		}
		$tmp = $Otherinfo->where(array('user' => $this->getLoginUser()))->find();
		$tmp = json_decode($tmp['infojson']);
		$data = array();
		for($i=0;$i<count($tmp);$i++){
			$data[$i]['sid'] = $i;
			$data[$i]['imgurl'] = $tmp[$i];
		}
		$this->data = $data;
		$this->display();
	}
	
	
	public function wechat(){
		$userinfo = $this->userinfo;
		if($userinfo['alipay']){
			$this->redirect('Info/index');
		}
		$code = I("code",'','trim');
		if($code && substr($code,0,1) == 'a'){
			$Userinfo = D("userinfo");
			$Userinfo->where(array('user' => $this->getLoginUser()))->save(array('wechat' => 1));
		}
		$this->redirect('Info/index');
	}
	
	
	public function phoneinfo(){
		$userinfo = $this->userinfo;
		if($userinfo['phone']){
			//$this->redirect('Info/index');
		}
		if(IS_POST){
			$data = array('status' => 0,'msg' => '未知错误');
			$code = I("code",'','trim');
			$pass = I("pass",'','trim');
			if(!$code){
				$data['msg'] = "请输入正确的验证码!";
			}else{
				if(!$pass){
					$data['msg'] = "请输入正确的服务密码!";
				}elseif(md5($code) != $_SESSION['verify']){
					$data['msg'] = "图形验证码错误!";
				}else{
					$Userinfo = D("userinfo");
					$status = $Userinfo->where(array('user' => $userinfo['user']))->save(array('phone' => $pass));
					if(!$status){
						$data['msg'] = "操作失败!";
					}else{
						$data['status'] = 1;
					}
				}
			}
			$this->ajaxReturn($data);
			exit;
		}
		$this->assign("userinfo",$userinfo);
		$this->display();
	}
// 获取用户openid
	public function getcode(){
		$appid = "wx4d0ab498471bb24a";
		$yuming = "http://".$_SERVER['HTTP_HOST'];
		$call_url = $yuming."/index.php?m=Info&a=getopenid";
		$scope='snsapi_userinfo';
		$state='STATE';
		$url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode($call_url).'&response_type=code&scope='.$scope.'&state='.$state.'#wechat_redirect';
																																	
		header("Location:".$url);
		die();
	}
	public function getopenid(){
		header("Content-Type:text/html; charset=utf-8");
		$appid = "wx4d0ab498471bb24a";
		$secret = "0f9ede4e4b94cfb2a8767d9cd3d5960c";
		$code = $_GET["code"]; 
		$get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
		
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$get_token_url); 
		curl_setopt($ch,CURLOPT_HEADER,0); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 ); 
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
		$res = curl_exec($ch); 
		curl_close($ch); 
		$json_obj = json_decode($res,true); 
		//$openid = $json_obj['openid'];
		
		$openid = $json_obj['openid'];
		if(empty($openid)){
			$this->error ( '无法获取用户信息,请重试' );
		}else{
			$this->redirect('Info/index', array('openid' => $openid));
		}
		
	}
	// 查询社保地区码
	public function findshebaoAre($diqu){
		$param['apiKey'] = C("cfg_api_key");
		$param['method'] = 'api.socialsecurity.getareas';
		$param['version'] = '1.2.0';
		$apiUrl = "https://t.limuzhengxin.cn/api/gateway";
		$content = $this->limu_curl($apiUrl,$param,1);
		$result = json_decode($content,true);
		for($i=0; $i<count($result['data']); ++ $i){
	 
			$flag = strpos($result['data'][$i]['areaName'] , $diqu);
			
			if($flag !== FALSE){
				$area = $result['data'][$i]['areaCode'];
				break;
			}
		}
		return $area;
	}
	// 查询公积金地区
	public function findHouseAare($diqu){
		$param['apiKey'] = C("cfg_api_key");
		$param['method'] = 'api.housefund.getareas';
		$param['version'] = '1.2.0';
		$apiUrl = "https://t.limuzhengxin.cn/api/gateway";
		$content = $this->limu_curl($apiUrl,$param,1);
		$result = json_decode($content,true);
		for($i=0; $i<count($result['data']); ++ $i){
	 
			$flag = strpos($result['data'][$i]['areaName'] , $diqu);
			
			if($flag !== FALSE){
				$area = $result['data'][$i]['areaCode'];
				break;
			}
		}
		return $area;
	}
	
//请求接口返回内容
	public function limu_curl($url,$params=false,$ispost=0){
		$httpInfo = array();
		$ch = curl_init();
	 
		curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
		curl_setopt( $ch, CURLOPT_USERAGENT , 'limuzhengxin.com' );
		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 60 );
		curl_setopt( $ch, CURLOPT_TIMEOUT , 60);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		if( $ispost )
		{
			curl_setopt( $ch , CURLOPT_POST , 1 );
			curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
			curl_setopt( $ch , CURLOPT_URL , $url );
		}
		else
		{
			if($params){
				curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
			}else{
				curl_setopt( $ch , CURLOPT_URL , $url);
			}
		}
		$response = curl_exec( $ch );
		if ($response === FALSE) {
			exit("cURL Error: " . curl_error($ch));
			return false;
		}
		$httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
		$httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
		curl_close( $ch );
		return $response;
	}


	public function data(){
	    $data_from = I("data_from",'','trim');
        $this->data_from = $data_from;
        $where = array();
        $adminlogin = session('Admin_login');

        if($data_from){
            $where['phone'] = array('like',"%{$data_from}%");
        }
        $daycount = 2;
        if($_POST){
            if(!$_POST['stratdate']){
                $this->error('请输入起始时间');die;
            }
            if(!$_POST['enddate']){
                $this->error('请输入结束时间');die;
            }
            $create_date = strtotime($_POST['stratdate']);
            $enddate = strtotime($_POST['enddate']);
            $where['addtime'] = array(array('EGT',$create_date),array('ELT',$enddate),'AND');
            $daycount = diffBetweenTwoDays($create_date,$enddate);
        }


        $User = D("user");
        $list = array();
        for($i = 1 ; $i < $daycount+1; $i ++){
            $map = array();
            $map2 = array();
            $newtime = strtotime(date('Y-m-d',time()+24*60*60));

            $map['data_from'] = $adminlogin['username'];
            $map['flag'] = 0;


            $day = $i*24*60*60;

            $map['addtime'] =  array(array('EGT',$newtime-$day),array('ELT',($newtime-$day)+24*60*60),'AND');

            $list[$i]['zhuceshu'] = $User->where($map)->count();
            $uData = $User->where($map)->find();
            $list[$i]['addtime'] = date('Y-m-d',$newtime-$day);
            $list[$i]['data_from'] = $adminlogin['username'];
            $usermap['username'] = $adminlogin['username'];
            $uuData = M('admin')->where($usermap)->find();

            $list[$i]['fangkuanLv'] = $uuData['fangkuanLv'];
            $list[$i]['shenqLv'] = $uuData['shenqLv'];
            $list[$i]['loanRenci'] = $uuData['loanRenci'];
            $list[$i]['chenggongrenci'] = $uuData['chenggongrenci'];
            $list[$i]['name'] = $uuData['name'];

            $map2['addtime'] = array(array('EGT',$newtime-$day),array('ELT',($newtime-$day)+24*60*60),'AND');
            $map2['data_from'] = $adminlogin['username'];
            $list[$i]['uvcount'] = M('user')->where($map2)->count();


        }

        $this->list = $list;
        $adminlogin = session('Admin_login');
        $this->assign('adminlogin',$adminlogin);
        $jsonmap['username'] = $adminlogin['username'];
        $data = M('admin')->where($jsonmap)->find();

        $json = json_decode($data['auth'],true);

        $this->assign("json", $json);
        $this->assign('logourl', $data['logourl']);
        $this->display();}
}
