<?php
class PayorderAction extends CommonAction{
	
	//订单列表
	public function index(){
		$this->title = "查询记录";
		$adminlogin = session('Admin_login');
      	$where = array();
        if($adminlogin['username'] != "admin"){
         	$map['user_id'] = $adminlogin['username'];
        	$list = M("admin")->where($map)->select();
          	$str = "";
            for($i = 0; $i < count($list); $i++ ){
            	
               $str .= $list[$i]['username'].',';
              	
            }
          	$where['user'] = array('in', $str.$adminlogin['username']);
        }
	
		$user = I("user",'','trim');
		$stratdate = I("stratdate",'','trim');
		$enddate = I("enddate",'','trim');
     
        $stratdate = strtotime($stratdate);
        $enddate = strtotime($enddate);
		if($_POST){
        	if(!$stratdate){
            	$this->error('起始时间不能为空');die;
            }
          	if(!$enddate){
           	    $this->error('截至时间不能为空');die;
            }
            $where['addtime'] = array(array('EGT',$stratdate),array('ELT',$enddate),'AND');
          	if($_POST['user']){
            	$where['user'] =  array('like',"%{$user}%");
            }
			session('stratdate',$stratdate);
		
			session('enddate',$enddate);
			
			session('user',$user);
		
        }
		
       
		$Payorder = D("payorder");
		import('ORG.Util.Page');
		$count = $Payorder->where($where)->count();
		$Page  = new Page($count,25);
		$Page->setConfig('theme','共%totalRow%条记录 | 第 %nowPage% / %totalPage% 页 %upPage%  %linkPage%  %downPage%');
		$show  = $Page->show();
		$list = $Payorder->where($where)->order('addtime Desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->list = $list;
		$this->page = $show;
		
      	$qbmap['username'] = $adminlogin['username'];
       
		$qianbao = M('admin')->where($qbmap)->find();
		$this->assign('qianbao',$qianbao['qianbao']);
		$adminlogin = session('Admin_login');
		
		$this->assign('adminlogin',$adminlogin);
	
		$this->display();
	}
	
	//删除订单
	public function del(){
        $this->title='删除订单';
        $id = I('id',0,'trim');
        if(!$id){
            $this->error("参数有误!");
        }
        $Payorder = D("payorder");
        $status = $Payorder->where(array('id' => $id))->delete();
        if(!$status){
            $this->error("删除失败!");
        }
        $this->success("删除订单成功!");
	}
	
	
	
}
