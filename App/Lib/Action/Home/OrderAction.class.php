<?php
class OrderAction extends CommonAction{
	
	public function checkorder(){
		$data = array('status' => 0,'msg' => '未知错误!');
		if(!$this->getLoginUser()){
			$data['status'] = 1;
		}else{
			$day = $this->yesdaikuan($this->getLoginUser());
			if(!$day){
				$data['status'] = 1;
			}else{
				$data['msg'] = "您最近一次订单审核失败,请".$day."天后再次提交!";
			}
		}
		$this->ajaxReturn($data);
	}
	
	private function yesdaikuan($user){
		//先查找最近一次失败订单
		$Order = D("order");
		$info = $Order->where(array('user' => $this->getLoginUser()))->order("addtime Desc")->find();
		if(!$info){
			return 0;
		}
		if($info['status'] != '-1'){
			return 0;
		}
		$tmptime = $info['addtime'];
		$tmptime = time()-$tmptime;
		$tmptime = $tmptime/(24*60*60);
		$disdkdleyday = C("cfg_disdkdleyday");
		if(!$disdkdleyday) $disdkdleyday = 0;
		if($tmptime > $disdkdleyday){
			return 0;
		}
		return ceil($disdkdleyday-$tmptime);
	}
	
	public function daikuan(){
		if(!$this->getLoginUser()){
			$this->redirect('User/login');
		}
		$Userinfo = D("userinfo");
		$info = $Userinfo->where(array('user' => $this->getLoginUser()))->find();
		if(!$info){
			$this->redirect('Info/index');
		}
		
		if($info['bankcard']==''){
			$this->redirect('Info/index');
		}
		//判断用户最近一次失败订单是否超过预期时间
		$yesdaikuan = $this->yesdaikuan($this->getLoginUser());
		if($yesdaikuan){
			$this->redirect('Index/index');
		}
		$money = I("money",0,'trim');
		$month = I("month",0,'trim');
		$money = (float)$money;
		$month = (int)$month;
		$dismonths = C("cfg_dkmonths");
		$dismonths = explode(",",$dismonths);
		$fuwufei = C('cfg_fuwufei');
		$fuwufei = explode(",",$fuwufei);
		if($money > C('cfg_maxmoney') || $money < C('cfg_minmoney')){
			//借款金额不允许
			$this->redirect('Index/index');
		}
		if(!in_array($month,$dismonths)){
			//不允许的分期月
			$this->redirect('Index/index');
		}
		$temp = $fuwufei[0] / 100;
		$rixi = $money * $temp / 12 ;
		$rixi = ceil((float)$rixi);
		$fuwufei = $fuwufei[$month-1] * $money / 100;
		$order = array(
			'money'   => $money,
			'fuwufei' => $fuwufei,
			'month'   => $month,
			'huankuan'=> ceil((float)($money/$month)),
			'bank'	  => $info['bankname'],
			'banknum' => $info['bankcard'],
			'name' => $info['name'],
			'rixi'	  => $rixi
		);
		$addorder = I("get.trueorder",0,'trim');
		if($addorder){
			$data = array('status' => 0,'msg' => '未知错误','payurl' => '');
			//创建订单
			$ordernum = neworderNum();
			$arr = array(
				'ordernum' => $ordernum,
				'type'	   => '审核费',
				'money'	   => C('cfg_shenhefei'),
				'addtime'  => time(),
				'status'   => 0,
				'user'	   => $this->getLoginUser()
			);
			$Payorder = D("payorder");
			$status = $Payorder->add($arr);
			if(!$status){
				$data['msg'] = '创建订单失败!';
			}else{
				$Order = D("order");
				$arr = array(
					'user' => $this->getLoginUser(),
					'money' => $money,
					'months' => $month,
					'monthmoney' => ceil($order['huankuan']),
					'donemonth' => 0,
					'addtime' => time(),
					'status' => 1,
					'pid' => $status,
					'bank' => $info['bankname'],
					'banknum' => $info['bankcard'],
					'name' => $info['name'],
					'ordernum' => $ordernum,
					'lixi' => $rixi
				);
				$status = $Order->add($arr);
				if(!$status){
					$data['msg'] = '创建订单失败!';
				}else{
					$data['status'] = 1;
					$data['payurl'] = U('Pay/Index/shenhe',array('ordernum' => $ordernum));
				}
			}
			$this->ajaxReturn($data);
			exit;
		}else{
			$this->order = $order;
			$this->display();
		}
	}
	
	public function lists(){
		$Order = D("order");
		$user = $this->getLoginUser();
		if(!$user){
			$this->redirect('User/login');
		}
		$this->data = $Order->where(array('user' => $user))->order("addtime Desc")->select();
		$this->display();
	}
	
	public function info(){
		$oid = I("oid",0,"trim");
		if(!$oid){
			$this->redirect('Order/lists');
		}
		$user = $this->getLoginUser();
		if(!$user){
			$this->redirect('User/login');
		}
		$Order = D("order");
		$order = $Order->where(array('id' => $oid,'user' => $user))->find();
		if(!$order){
			$this->redirect('Order/lists');
		}
		$this->data = $order;
		$this->display();
	}
	
	//我的还款
	public function bills(){
		$user = $this->getLoginUser();
		if(!$user){
			$this->redirect('User/login');
		}
		$hkr = C("cfg_huankuanri");
		if(!$hkr) $hkr = 10;
		$data = array();
		//遍历已借款订单
		$Order = D("order");
		$tmp = $Order->where(array('user' => $user,'status' => 2))->select();
		for($i=0;$i<count($tmp);$i++){
			//判断是否已还清
			if($tmp[$i]['months'] != $tmp[$i]['donemonth']){
				$tmp_ordernum = $tmp[$i]['ordernum'];
				//从还款记录查找本月是否已还款
				$Bills = D("bills");
				$initval = false;
				$nowmonth = date("m");
				$tmp2 = $Bills->where(array('user' => $user,'jkorder' => $tmp_ordernum))->select();
				for($m=0;$m<count($tmp2);$m++){
					$tmp_time = date("m",$tmp[$m]['addtime']);
					if($nowmonth == $tmp_time){
						$initval = true;
						break;
					}
				}
				//不存在记录说明未还款
				if(!$initval){
					//判断是否为申请当月
					$tmp_time = date("m",$tmp[$i]['addtime']);
					if($nowmonth != $tmp_time){
						//需要还款
						$data[] = array(
							'ordernum' => $tmp_ordernum,
							'money'    => $tmp[$i]['monthmoney'],
							'days'	   => date("d",$tmp[$i]['addtime'])-date("d"),
							'qishu'	   => $tmp[$i]['donemonth'] + 1
						);
					}
				}
			}
		}
		$this->data = $data;
		$this->display();
	}

	//还款
	public function billinfo(){
		$user = $this->getLoginUser();
		if(!$user){
			$this->redirect('User/login');
		}
		$ordernum = I("ordernum",'','trim');
		if(!$ordernum){
			$this->redirect('Order/bills');
		}
		$Order = D("order");
		$order = $Order->where(array('ordernum' => $ordernum,'user' => $user))->find();
		//判断是否已还完
		if($order['months'] == $order['donemonth']){
			$this->redirect('Order/bills');
		}
		//创建支付订单
		$payordernum = neworderNum();
		$arr = array(
			'ordernum' => $payordernum,
			'user'     => $user,
			'type'	   => "还款费",
			'money'	   => $order['monthmoney'],
			'name'	   => $order['name'],
			'addtime'  => time(),
			'status'   => 0,
			'jkorder'  => $ordernum
		);
		$Payorder = D("payorder");
		$status = $Payorder->add($arr);
		if(!$status){
			$this->redirect('Order/bills');
		}
		//跳转支付
		$this->redirect('Pay/Index/index',array('ordernum' => $payordernum));
	}
	
}
