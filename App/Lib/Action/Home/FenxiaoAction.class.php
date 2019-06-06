<?php
class FenxiaoAction extends CommonAction{
	
	public function Index(){
		
		$user_sq = D("user");
		$user = $this->getLoginUser();
		
		if(!$user){
			$this->redirect('User/login');
		}
		$this->data = $user_sq->where(array('phone' => $user))->find();
		$this->userCount2 = $user_sq->where(array('yao_phone' => $user))->count();
		$this->display();
	}
	
	
	public function fenxiaolibiao(){
	
		$user = $this->getLoginUser();
		if(!$user){
			$this->redirect('User/login');
		}
		$u = D("User");
		$uu = $u->where(array('yao_phone' => $user))->select();
		
		$this->data = $uu;
		$this->display();
	}
		public function shentixian(){
	header('Content-Type:text/html;charset=utf-8');
		$this->display();
	}
		public function shentixian_add(){
			header('Content-Type:text/html;charset=utf-8');
	 $keyword = I("keyword",'','trim');
		$user = $this->getLoginUser();
		if(!$user){
			$this->redirect('User/login');
		}
	
			$user=M('user')->where(array('phone' => $user))->find();
		
		 if($keyword> $user['ketixian']){
            $this->error("申请提现失败!申请提现金额大于可提现金额");
			
        }
		else{
			$u0=M('user')->where(array('phone' => $user['phone']))->save(array('shenqing_tixian'=>$keyword));
		 if(!$u0){
            $this->error("申请提现失败!");
               }
		    {
              $this->success("申请提现成功!");
		      }
		}
		
	
	}
	
}
