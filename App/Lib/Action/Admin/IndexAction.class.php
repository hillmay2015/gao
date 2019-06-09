<?php
class IndexAction extends CommonAction {
	
	public function index(){
		if(!$this->islogin()){
			$this->redirect('index.php?g=Home&m=Index&a=index');
		}else{
			$this->redirect(GROUP_NAME.'/Daikuan/index');
		}
	}
	
	public function login(){
		$this->title="登录系统";
		session(null);
		$msg['status'] = 0;
		if(IS_POST){
			$_validate = array(
				array('username','require','用户名不能为空!'),
				array('password','require','密码不能为空!'),
			);
			$Admin = D("admin");
			$Admin-> setProperty("_validate",$validate);
			$result = $Admin->create();
			if(!$result){
				$this->error($Admin->getError());
			}
			$username = I('username','','trim');
			$password = I('password','','trim');
			$password = $this->getpass($password);
			$tmp = $Admin->where(array('username' => $username,'password' => $password))
						 ->find();
			if($tmp){
				if($tmp['status']){
					//写入登录记录
					$Admin_login = D("admin_login");
					$Admin_login->add(array(
						'username'  => $username,
						'logintime' => time(),
						'loginip'	=> get_client_ip()
					));
					//更新最近登录时间
					$msg['status'] = 1;
					if($tmp['pid'] >0){//证明是推广员
						$this->setLoginUser($username);
						 session('Admin_login',$tmp); 
						
						$msg['url'] = C('cfg_app').'/Home/Info/index';

					}else{//证明是渠道商
						$this->setlogin($username);
						$Admin->where(array('username' => $username))
						  ->save(array('lastlogin' => time() ));
						  session('Admin_login',$tmp); 
						  //根据 tpl值来判断是哪个走哪个模板 
                       if($tmp['tpl']==1){
                           $msg['url'] = C('cfg_app').'/Admin/User/index1';
                       }

                        if($tmp['tpl']==2){
                            $msg['url'] = C('cfg_app').'/Admin/User/index2';
                        }

                    }

					 session('Admin_login',$tmp); 
					$this->ajaxReturn($msg);
					die;
				}else{

					$msg['msg'] = '该账户已被禁用!';
					$this->ajaxReturn($msg);
					die;
				}
			}else{
				
				$msg['msg'] = '用户名或密码错误!';
				$this->ajaxReturn($msg);
				die;
			}
			exit;
		}
		$this->display();
		
	}

	public function logout(){
		$this->title="注销登录";
		$this->setlogin('');
		session(null);
		$this->redirect(C('cfg_app').'/Home/Index/index');
	}


    public function logout1(){
        $this->title="注销登录";
        $this->setlogin('');
        session(null);
        $this->redirect(C('cfg_app').'/Home/Index/index1');
    }

    public function logout2(){
        $this->title="注销登录";
        $this->setlogin('');
        session(null);
        $this->redirect(C('cfg_app').'/Home/Index/index2');
    }
	/*public function daochu(){
		$filename = '申请列表'.date('YmdHis');  
		$header = array('编码','姓名','电话','qq','数据来源','芝麻分','微信号','年龄','创建日期','处理时间','状态');  
		
		$day = $_GET['day'];
		
		$where['create_date'] = array('like', $day."%");
		$Order = D("d_iou");
		$index = $Order->where($where)->order('create_date Desc')->field('sort_num,name,phone_number,qq,data_from,zhimafen,wechat,age,create_date,process_date,process_states')->select();
		//echo $Order->getLastSql();die;
		$this->exportexcel($index,$header,$filename);  
	}
	
	public function exportexcel($data=array(),$title=array(),$filename='report'){
		header("Content-type:application/octet-stream");
		header("Accept-Ranges:bytes");
		header("Content-type:application/vnd.ms-excel");  
		header("Content-Disposition:attachment;filename=".$filename.".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		//导出xls 开始
		if (!empty($title)){
			foreach ($title as $k => $v) {
				$title[$k]=iconv("UTF-8", "GB2312",$v);
			}
			$title= implode("\t", $title);
			echo "$title\n";
		}
		if (!empty($data)){
			foreach($data as $key=>$val){
				foreach ($val as $ck => $cv) {
					$data[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
				}
				$data[$key]=implode("\t", $data[$key]);
				
			}
		echo implode("\n",$data);
		}
	} */
	
	public function checkkouliang(){
		$newtime = strtotime(date("Y-m-d",time()));
		$where['addtime'] = array(array('EGT',$newtime),array('ELT',$newtime+24*60*60),'AND');
		$map['username'] = array('NEQ','admin');
		$admininfo = M('admin')->where($map)->select();
		
		for($i = 0; $i < count($admininfo); $i ++){
			$where['data_from'] = $admininfo[$i]['username'];
			$count = M('user')->where($where)->count();
			$r = ceil($count*($admininfo[$i]['qq']/100));		
			$where['flag'] = 1;
			$count2 = M('user')->where($where)->count();

			echo $r ;echo "<br>";

		}
	}
    //注册渠道商
    public function register(){
        $Admin = D("admin");
        $this->title = '添加用户';
        if(IS_POST){
            //添加
            $validate = array(
                array('username','require','渠道商名称不能为空!'),
                array('username','','渠道商名称已经存在！',0,'unique',1),
                array('password','require','渠道商密码不能为空!'),
                array('password_confirm','password','两次密码输入不一致!',0,'confirm'),
            );
            $Admin->setProperty("_validate",$validate);
            if(!$Admin->create()){
                $this->error($Admin->getError());
            }

            $_POST['addtime'] = time();
            $_POST['lastlogin'] = 0;
            $_POST['gid'] =  2;;
            $_POST['password'] = $this->getpass($_POST['password']);
            $_POST['is_super'] = 0;//渠道商
            $_POST['tpl'] = 0;//模板
            $_POST['pid'] = 0;//所属渠道商id  0 表示父级渠道商

            $adminlogin = session('Admin_login');

            $status = $Admin->add($_POST);


            if(!$status){
                $msg['state']=0;
                $msg['info']='注册失败';
                $this->ajaxReturn($msg);
            }else{
                $msg['state']=1;
                $msg['url']=C('cfg_app').'/Home/Index/index';
                $msg['info']='注册成功,请登录';
                $this->ajaxReturn($msg);
            }

        }
    }

}