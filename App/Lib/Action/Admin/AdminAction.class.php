<?php
/**
 * Created by PhpStorm.
 * User: Somnus
 * Date: 2016/11/9
 * Time: 17:57
 */

class AdminAction extends CommonAction{

    //管理员列表
    public function index(){
        
        $this->title = '管理员列表';
        $this->seach_name = '';
        $Admin = D("admin");
        import('ORG.Util.Page');
        $where = array();
     	$adminlogin = session('Admin_login');
        if(IS_POST){
            $uname = I('username','','trim');
            if($uname){
                $where['name'] = array('like',"%{$uname}%");
                $this->seach_name = $uname;
            }
        }
//      	if($adminlogin['username'] != "admin"){
//        	$where['user_id'] = $adminlogin['username'];
//        }
//
        //判断是否是超级管理员 超级管理员查看所有用户
        //渠道商 只看属于渠道商的用户
        if($adminlogin['is_super']==1){

        }else{
            $where['pid']=$adminlogin['id'];
        }
        $count = $Admin->where($where)->count();
        $Page  = new Page($count,25);
        $Page->setConfig('theme','共%totalRow%条记录 | 第 %nowPage% / %totalPage% 页 %upPage%  %linkPage%  %downPage%');
        $show  = $Page->show();
        $list  = $Admin->order('addtime')
                       ->limit($Page->firstRow.','.$Page->listRows)
                       ->where($where)
                       ->select();
        $sumsjcount = 0;
        $sumklcount = 0;
        for($i = 0; $i < count($list); $i ++){
             $new = strtotime(date('Y-m-d'));
          
             $map['addtime'] = array(array('EGT',$new),array('ELT',$new+24*60*60),'AND');

             $map['data_from'] = $list[$i]['username'];
             $list[$i]['count'] = M('user')->where($map)->count();
             $sumsjcount = $sumsjcount+$list[$i]['count'];
             $map2['flag'] = 0;
             $map2['data_from'] = $list[$i]['username'];
             $map2['addtime'] = array(array('EGT',$new),array('ELT',$new+24*60*60),'AND');
             $map3['flag'] = 0;
             $map3['data_from'] = $list[$i]['username'];
             $map3['addtime'] = array(array('EGT',$new-24*60*60),array('ELT',$new),'AND');

             $list[$i]['sjcount'] = M('user')->where($map2)->count();
             $list[$i]['zuoricount'] = M('user')->where($map3)->count();

             $map4['addtime'] = array(array('EGT',$new-24*60*60),array('ELT',$new),'AND');
             $yestodaycount = M('user')->where($map4)->count();
           
        }

        $this->data = $list;
        $this->page = $show;

		$this->assign('adminlogin',$adminlogin);
      
        $qbmap['username'] = $adminlogin['username'];
     
		$qianbao = M('admin')->where($qbmap)->find();
		
		$this->assign('qianbao',$qianbao['qianbao']);
        $this->assign('sumsjcount',$sumsjcount);
        $this->assign('sumklcount',$sumklcount);
         $this->assign('yestodaycount',$yestodaycount);
        $this->display();
    }


    //添加管理员
    public function add(){
        $Admin = D("admin");
        $this->title = '添加用户';
        if(IS_POST){
            //添加
            $validate = array(
                array('username','require','管理员名称不能为空!'),
                array('username','','管理员名称已经存在！',0,'unique',1),
                array('password','require','管理员密码不能为空!'),
                array('password_confirm','password','两次密码输入不一致!',0,'confirm'),
            );
            $Admin->setProperty("_validate",$validate);
            if(!$Admin->create()){
                $this->error($Admin->getError());
            }
			
            $_POST['addtime'] = time();
            $_POST['lastlogin'] = 0;
			$_POST['gid'] =  $_POST['gid'];
            $_POST['password'] = $this->getpass($_POST['password']);
            if($_POST['gid']==1){
                $_POST['is_super'] = 1;//管理员
            }else{
                $_POST['is_super'] = 0;//渠道商
            }

            $_POST['tpl'] = $_POST['tpl'];//模板
            $_POST['pid'] = 0;//所属渠道商id  0 表示父级渠道商

          	$adminlogin = session('Admin_login');
    
            $json['date_time'] = $_POST['date_time'];
            $json['qudaoname'] = $_POST['qudaoname'];
            $json['zhucecount'] = $_POST['zhucecount'];
            $json['uvcount'] = $_POST['uvcount'];
            $json['shimingcount'] = $_POST['shimingcount'];
            $json['loancount'] = $_POST['loancount'];
            $json['succcount'] = $_POST['succcount'];
            $json['loanlv'] = $_POST['loanlv'];
            $json['tongguolv'] = $_POST['tongguolv'];
            $json['caozuo'] = $_POST['caozuo'];
            $_POST['auth'] = json_encode($json);

            $status = $Admin->add($_POST);
			//echo $Admin->getLastSql();  
            if(!$status){
				
                $this->error('添加失败!');
            }
            $this->success('添加成功!');
            exit;
        }
		$adminlogin = session('Admin_login');
        $this->assign('adminlogin',$adminlogin);
        $this->assign('is_super',$adminlogin['is_super']);
        $this->display();
    }
	// 设置组长
	public function setadmin(){
		$map['id'] = $_GET['editid'];
		$data['gid'] = '1';
		$status = M('admin')->where($map)->save($data);
			//echo $Admin->getLastSql();  
		if(!$status){
			
			$this->error('设置失败!');
		}
		$this->success('设置成功!');
	}

    //修改管理信息
    public function edit(){
        $this->title = '修改用户信息';
        $Admin = D("admin");
        if(IS_POST){
            $editId = $_POST['editId'];
            $username = I('username','','trim');
			$qq = I('qq','','trim');
			$phone = I('phone','','trim');
			$name = I('name','','trim');
            $shenqLv = I('shenqLv','','trim');
            $fangkuanLv = I('fangkuanLv','','trim');

            $password = I('password','','trim');
            $password_confirm = I('password_confirm','','trim');
            $data = $Admin->where(array('id'=>$editId))->find();
            if(!$data){
                $this->error('管理员ID不存在!');
            }
            $status = I('gid','','trim');
            $aminfo  = $Admin->where(array('id' => $editId))->find();
            if($aminfo['username'] == 'admin'){
                 $status = 1;
               
            }
           
            //验证用户名是否存在
            $data = $Admin->where(array('username' => $username))->find();
            if(!$data || $data['id'] == $editId){
            $json['date_time'] = $_POST['date_time'];
            $json['qudaoname'] = $_POST['qudaoname'];
            $json['zhucecount'] = $_POST['zhucecount'];
            $json['uvcount'] = $_POST['uvcount'];
            $json['shimingcount'] = $_POST['shimingcount'];
            $json['loancount'] = $_POST['loancount'];
            $json['succcount'] = $_POST['succcount'];
            $json['loanlv'] = $_POST['loanlv'];
            $json['tongguolv'] = $_POST['tongguolv'];
            $json['caozuo'] = $_POST['caozuo'];
            $auth = json_encode($json);

                $arr = array(
                   // 'username' => $username,
                    'gid'   => $status,
					'name' => $name,
					'phone' => $phone,
					'qq' => $qq,
                    'user_id' =>  $_POST['mobanid'],
                    'fangkuanLv' => $fangkuanLv,
                    'shenqLv' => $shenqLv,
                    'auth' => $auth,
                    'url' =>  $_POST['url'],
                    'loanRenci' => $_POST['loanRenci'],
                    'chenggongrenci' => $_POST['chenggongrenci'],
                    'logourl' => $_POST['logourl'],
                     'tpl' => $_POST['tpl']

                );

                $Admin->where(array('id' => $editId))->save($arr);

				if($password){
                    //验证密码
                    if(!empty($password) && $password != $password_confirm){
                        $this->error('两次密码输入不一致!');
                    }else{
                       $Admin->where(array('id' => $editId))->save(array('password' => $this->getpass($password)));
    					
                    }
                }
                $this->success('修改成功!');die;
            }else{
                $this->error('管理名称已存在!');
            }
        }
        $editId = I('get.editid',0,'trim');
        $data = $Admin->where(array('id' => $editId))->find();
        if(!$data){
            $this->error('管理员ID不存在!');
        }
		$adminlogin = session('Admin_login');
		 $qbmap['username'] = $adminlogin['username'];
     
		$qianbao = M('admin')->where($qbmap)->find();
		
		$this->assign('qianbao',$qianbao['qianbao']);
        $adminlogin = session('Admin_login');
        $this->assign('adminlogin',$adminlogin);
        
        $this->data = $data;
        $this->assign('is_super', $data['is_super']);
        $this->assign('gid', $data['gid']);
        $this->assign('style', $data['tpl']);
        $json = json_decode($data['auth'],true);
        $this->assign("json", $json);
        $this->display();
    }
	 //修改管理信息
    public function edit2(){
        $this->title = '修改用户信息';
        $Admin = D("admin");
        if(IS_POST){
         $editId = $_POST['editId'];
            $username = $_POST['username'];
            $password = I('password','','trim');
            $password_confirm = I('password_confirm','','trim');
            $data = $Admin->where(array('id'=>$editId))->find();
            if(!$data){
                $this->error('管理员ID不存在!!');
            }
          
            //验证用户名是否存在
          
               
				
                //验证密码
                if(!empty($password) && $password != $password_confirm){
                    $this->error('两次密码输入不一致!');
                }else{
                   $Admin->where(array('id' => $editId))->save(array('password' => $this->getpass($password)));
					
                }
                $this->success('修改成功!');
          die;
        }
        $editId = I('get.editid',0,'trim');
        $data = $Admin->where(array('id' => $editId))->find();
        if(!$data){
            $this->error('管理员ID不存在!');  
        }
		$adminlogin = session('Admin_login');
        $this->assign('adminlogin',$adminlogin);
        $this->data = $data;
        $this->display();
    }

    //删除管理员
    public function del(){
        $this->title='删除管理员';
        $id = I('get.id',0,'trim');
        $Admin = D("admin");
        //判断是否为唯一未禁用管理员
        $num = $Admin->where(array('status' => 1))->count();
        if($num == 1){
            $this->error('必须保留一个未禁用管理员!');
        }
        $status = $Admin->delete($id);
        if(!$status){
            $this->error('删除失败!');
        }
        $this->success('删除成功!');
    }


    //修改自己信息
    public function chagemypass(){
        $username = $this->getlogin();
        $Admin = D("admin");
        $data = $Admin->where(array('username' => $username))->find();
        if(!$data){
            $this->setlogin('');
            $this->error('非法操作!',U(GROUP_NAME.'/Index/login'));
        }
        $this->redirect(U(GROUP_NAME.'/Admin/Admin/edit',array('editid'=>$data['id'])));
    }
	 //修改自己信息
    public function chagemypass2(){
        $username = $this->getlogin();
        
        $Admin = D("admin");
        $data = $Admin->where(array('username' => $username))->find();
        if(!$data){
            $this->setlogin('');
            $this->error('非法操作!',"/".C('cfg_app').'/Index/login');
        }
        $this->redirect(C('cfg_app').'/Admin/Admin/edit2',array('editid'=>$data['id']));
    }
	// 給用户充值
	public function chongzhi(){
		$data['status'] = 0;
		if($_POST){
          	
			
          
			$map['id'] = $_POST['id'];
			$jine = $_POST['qianbao'];
          	
          	
          	$adminlogin = session('Admin_login');
          	$map2['username'] = $adminlogin['username'];
          	$userdata = M('admin')->where($map2)->find();
          	if($userdata['qianbao'] < $jine ){
			
              $data['msg'] = '当前账户余额不足无法充值';
              $this->ajaxReturn($data);
              die;
			}
          	if($adminlogin['username'] != "admin"){
                M('admin')->where($map)->setInc('qianbao', $jine);
                M('admin')->where($map)->setInc('leiji_chongzhi', $jine);
              	
              	$res = M("admin")->where($map2)->setDec('qianbao',$jine);
                $admin = M('admin')->where($map)->find();
                $czdata['user'] = $admin['username'];
                $czdata['money'] = $jine;
                $czdata['addtime'] = time();
                $czdata['type'] = "充值";
                M('czorder')->add($czdata);
            }else{
            	M('admin')->where($map)->setInc('qianbao', $jine);
                M('admin')->where($map)->setInc('leiji_chongzhi', $jine);
              	
            
                $admin = M('admin')->where($map)->find();
                $czdata['user'] = $admin['username'];
                $czdata['money'] = $jine;
                $czdata['addtime'] = time();
                $czdata['type'] = "充值";
                M('czorder')->add($czdata);
            }
			$data['status'] = 1;
			$this->ajaxReturn($data);
		}
		$data['msg'] = '非法操作';
		$this->ajaxReturn($data);
	}
    public function shop(){
        $map['id'] = $_GET['editid'];
      
		$adinfo = M('admin')->where($map)->find();
		if($adinfo['status'] == 1){
			$data['status'] = 0;
		}else{
			$data['status'] = 1;
		}
        $res = M('admin')->where($map)->save($data);
        if($res){
             $this->success('设置成功!');
         }else{
             $this->error('设置失败!');
         }
    }
    // 批量删除
    public function alldel(){
        if(IS_POST){
            $adIds = $_POST['adIds'];
            $adIds = str_replace("undefined,","",$adIds);
            $where = "id in($adIds)";
            
            $Order = M('admin');
            $r = $Order->where($where)->select();   
            $ret = $Order->where($where)->delete();

            if($ret){
                $data['success'] = 1;
                $data['msg'] = $ret;
                
            }else{
                $data['success'] = 0;
                $data['msg'] = '删除错误'.$adIds;
            }
        }else{
            $data['msg'] = "提交错误";
            
        }
        for($i = 0 ; $i < count($r); $i ++ ){
            M('del')->add($r[$i]);
        }
        $this->ajaxReturn($data);
    }



}