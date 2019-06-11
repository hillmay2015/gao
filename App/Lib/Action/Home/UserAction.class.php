<?php
class UserAction extends CommonAction{

	public function index(){
		//判断是否已登录
		$user = $this->getLoginUser();
		$this->user = $user;
		$this->display();
	}

	//用户登录
	public function login(){
		if(IS_POST){
			$data = array('status' => 0,'msg' => '未知错误');
			$type = I("type","pass",'trim');
			if($type == "pass"){//密码方式登录
				$password = I("password",'','trim');
				$phone = I("phone",'','trim');
				if(!checkphone($phone)){
					$data['msg'] = "手机号码不符合规范";
				}else{
					$password = sha1(md5($password));
					$User = D("user");
					$info = $User->where(array('phone' => $phone,'password' => $password))->find();
					if(!$info){
						$data['msg'] = "帐户名或密码错误";
					}else if($info['status'] != 1){
						$data['msg'] = "该账户已被禁止登录!";
					}else{
						$this->setLoginUser($phone);
						$data['status'] = 1;
					}
				}
			}else{//短信验证码登录
				$phone = I("phone",'','trim');
				$code = I("code",'','trim');
				$User = D("user");
				$Smscode = D("smscode");
				//判断手机号
				if(!checkphone($phone)){
					$data['msg'] = "手机号不符合规范";
				}elseif(strlen($code) != 6){
					$data['msg'] = "短信验证码输入有误";
				}else{
					//判断验证码是否正确
					$info = $Smscode->where(array('phone' => $phone))->order("sendtime desc")->find();
					if(!$info || $info['code'] != $code){
						$data['msg'] = "短信验证码输入有误";
					}elseif( (time()-30*60) > $info['sendtime']){
						$data['msg'] = "验证码已过期,请重新获取!";
					}else{
						//判断用户是否存在
						$count = $User->where(array('phone' => $phone))->count();
						if(!$count){
							$data['msg'] = "用户不存在,请先注册!";
						}else{
							$this->setLoginUser($phone);
							$data['status'] = 1;
						}
					}
				}
			}
			$this->ajaxReturn($data);
			exit;
		}
		//判断是否已登录
		if($this->getLoginUser()){
			$this->redirect(C('cfg_app')."/Home/Index/index");
		}
		$this->display();
	}

	//注销登陆
	public function logout(){
		$this->setLoginUser('');
		$this->redirect(C('cfg_app')."/Home/Index/index");
	}
    //注销登陆 模板1
    public function logout1(){
        $this->setLoginUser('');
        $this->redirect(C('cfg_app')."/Home/Index/index1");
    }
    //注销登陆 模板2
    public function logout2(){
        $this->setLoginUser('');
        $this->redirect(C('cfg_app')."/Home/Index/index2");
    }

	//用户注册
	public function signup(){
		if(IS_POST){
			$User = D("user");
			$data=array('status' => 0,'msg' => '未知错误');
			$password = I("password",'','trim');
			$code = I("code",'','trim');
			$phone = I("phone",'','trim');
			$yao_phone = I("yao_phone",'','trim');

			//再次验证手机号
			if(!checkphone($phone)){
				$data['msg'] = "手机号不符合规范!";
			}elseif(strlen($password) < 6 || strlen($password) > 16){
				$data['msg'] = "请输入6-16位密码!";
			}else{
				$count = $User->where(array('phone' => $phone))->count();
				if($count){
					$data['msg'] = "手机号已注册,请登录!";
					$this->ajaxReturn($data);exit;
				}
				//验证短信验证码
				$Smscode = D("Smscode");
				$info = $Smscode->where(array('phone' => $phone))->order("sendtime desc")->find();

					$password = sha1(md5($password));
					$arr = array(
						'phone' => $phone,
						'password' => $password,
						'yao_phone' => $yao_phone,
						'addtime' => time()
					);
					$status = $User->add($arr);
					if($status){
						//设置当前登录用户
						$this->setLoginUser($phone);
						$data['status'] = 1;
					}else{
						$data['msg'] = "注册账户失败!";
					}
			}
			$this->ajaxReturn($data);
			exit;
		}
		$this->display();
	}

	//发送验证码
	public function sendsmscode(){
		$data = array('status' => 0);
		$phone = I("phone",'','trim');
		$type = I("type","login",'trim');
		if($type == "reg"){
			$User = D("user");
			$count = $User->where(array('phone' => $phone))->count();
			if($count){
				$data['msg'] = "手机号已注册,请登录!";
				$this->ajaxReturn($data);exit;
			}
		}
		$verifycode = I("verifycode",'','trim');
		if(!checkphone($phone)){
			$data['msg'] = "手机号不规范";
		}else{
			if($_SESSION['verify'] != md5($verifycode) && $type != "zhima"){
				$data['msg'] = "图形验证码错误";
			}else{
				//判断发送次数
				$Maxcount = C('cfg_smsmaxcount');
				$Maxcount = intval($Maxcount);
				if(!$Maxcount){
					$Maxcount = 10;
				}
				$todaytime = strtotime(date("Y-m-d"));
				$Code = D("smscode");
				$where = array();
				$where['phone'] = $phone;
				$where['sendtime'] = array('GT',$todaytime);
				$count = $Code->where($where)->count();
				if($count >= $Maxcount){
					$data['msg'] = "验证码发送频繁,请明天再试";
				}else{
					$where = array(
						'sendtime' => array('GT',time()-60)
					);
					$count = $Code->where($where)->count();
					if($count){
						$data['msg'] = "验证码发送频繁,请稍后再试";
					}else{
						import("@.Class.Smsapi");
						$Smsapi = new Smsapi();
						$smscode = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
						//写入验证码记录
						$Code->add(array(
							'phone'    => $phone,
							'code'     => $smscode,
							'sendtime' => time()
						));
						$contstr = "【".C('cfg_smsname')."】您的验证码为{$smscode}，请于5分钟内正确输入，如非本人操作，请忽略此短信。";
						//$status = $Smsapi->send($phone,$contstr);
						 $sendurl = "http://121.196.200.192:9001/sms.aspx?action=send&userid=395&account=sxqz&password=11111111&mobile=$phone&content=$contstr&sendTime=&extno=";
						$result = $this->http_request($sendurl);
						$status = 0;
						if($status == '0'){
							$data['status'] = 1;
						}else{
							$data['msg'] = "验证码发送失败,错误码:".$status;
						}
					}
				}
			}
		}
		$this->ajaxReturn($data);
	}

	//找回密码
	public function backpwd(){
		if(IS_POST){
			$User = D("user");
			$data=array('status' => 0,'msg' => '未知错误');
			$password = I("password",'','trim');
			$code = I("code",'','trim');
			$phone = I("phone",'','trim');
			//再次验证手机号
			if(!checkphone($phone)){
				$data['msg'] = "手机号不符合规范!";
			}elseif(strlen($password) < 6 || strlen($password) > 16){
				$data['msg'] = "请输入6-16位密码!";
			}else{
				$count = $User->where(array('phone' => $phone))->count();
				if(!$count){
					$data['msg'] = "该账户还没有注册,请先注册!";
					$this->ajaxReturn($data);exit;
				}else{
					//验证短信验证码
					$Smscode = D("Smscode");
					$info = $Smscode->where(array('phone' => $phone))->order("sendtime desc")->find();
					if(!$info || $info['code'] != $code){
						$data['msg'] = "短信验证码有误!";
					}elseif( (time()-30*60) > $info['sendtime']){
						$data['msg'] = "验证码过时,请重新获取!";
					}else{
						$password = sha1(md5($password));
						$arr = array('password' => $password);
						$status = $User->where(array('phone' => $phone))->save($arr);
						if($status){
							$data['status'] = 1;
						}else{
							$data['msg'] = "修改密码失败!";
						}
					}
				}
			}
			$this->ajaxReturn($data);
		}
		$this->display();
	}

	//检查用户是否存在
	public function checkuser(){
		$data = array('status' => 0);
		$phone = I("phone",'','trim');
		$User = D("user");
		if($phone){
			$count = $User->where(array('phone' => $phone))->count();
			if($count){
				$data['status'] = 1;
			}
		}
		$this->ajaxReturn($data);
	}
	public function http_request($url,$data = null){
		if(function_exists('curl_init')){
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			if (!empty($data)){
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			}
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($curl);
			curl_close($curl);
			$result=preg_split("/[,\r\n]/",$output);
			if($result[1]==0){
				  return "curl success";
			}else{
				  return "curl error".$result[1];
			}
		}elseif(function_exists('file_get_contents')){

			$output=file_get_contents($url.$data);
			$result=preg_split("/[,\r\n]/",$output);

			if($result[1]==0){
				  return "success";
			}else{
				  return "error".$result[1];
			}
		}else{
			return false;
		}
	}

	public function manager(){
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
	    return $this->display();
    }

    /**
     * 推广员实时渠道查看数据
     */
    public function pdlist(){

        $where['data_from'] = $_GET['username'];
        //渠道数据统计

        //页面内查询


        //单日期查询

        if ($_GET) {
            if (!$_GET['stratdate']) {
                $this->error('请输入起始时间');
                die;
            }
            $create_date = strtotime($_GET['stratdate']);
            $enddate = strtotime($_GET['stratdate'])+24*60*60;//表示开始时间加一天的时间
            $where['addtime'] = array(array('EGT', $create_date), array('ELT', $enddate), 'AND');
            $where['data_from'] = $_GET['data_from'];
        }


        $User = D("user");
        import('ORG.Util.Page');

        $sjcount = $User->where($where)->count();
        $where['flag'] = 0;
        $count = $User->where($where)->count();

        $Page = new Page($count, 25);
        $Page->setConfig('theme', '共%totalRow%条记录 | 第 %nowPage% / %totalPage% 页 %upPage%  %linkPage%  %downPage%');
        $show = $Page->show();
        $list = $User->where($where)->order('addtime Desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();

        $this->list = $list;
        $this->page = $show;

        $adminlogin = session('Admin_login');
        $this->assign('adminlogin', $adminlogin);
        $this->assign('data_from', $_GET['username']);
        $this->assign("kouliangcount", $count);
        $this->assign("sjcount", $sjcount);
        $usermap['username'] = $_GET['username'];
        $uuData = M('admin')->where($usermap)->find();


        $myurl = "http://" . $_SERVER['SERVER_NAME'] . "/m.php/Home/Index/moban/data_from/" . $_GET['username'];

        if ($uuData['tpl'] > 0) {
            $login_url = "http://" . $_SERVER['SERVER_NAME'] . "/m.php/Home/Index/index" . $uuData['tpl'];//推广员登录链接
        } else {
            $login_url = "http://" . $_SERVER['SERVER_NAME'] . "/m.php/Home/Index/index";//渠道商和管理员登录链接
        }

        $this->assign("myurl2", $myurl);
        $this->assign('myurl', file_get_contents("http://h5ip.cn/index/api?url=" . urlencode($myurl)));
        $this->assign('login_url', $login_url);
        $this->assign('start_date',$_POST['stratdate']);
        $this->assign('end_date',$_POST['enddate']);
        $this->display();

    }
}
