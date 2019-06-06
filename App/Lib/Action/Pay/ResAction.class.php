<?php
class ResAction extends Action{

	//判断订单是否支付
	public function ispay(){
		$data = array('status' => 0);
		$ordernum = I("get.ordernum",'','trim');
		if(!$ordernum){
			$data['status'] = 1;
		}else{
			$Payorder = D("payorder");
			$info = $Payorder->where(array('ordernum' => $ordernum))->find();
			if(!$info){
				$data['status'] = 1;
			}else{
				if($info['status']){
					$data['status'] = 1;
				}else{
					$data['status'] = 0;
				}
			}
		}
		$this->ajaxReturn($data);
	}


	//支付返回异步通知
	public function notifyurl(){
		$this->paydo(false);
	}

	//支付返回同步通知
	public function returnurl(){
		$this->paydo();
	}

	//支付成功处理
	function paydo($jump = true){
		$out_trade_no = $_REQUEST['order_no'];
		$money = $_REQUEST['amount'];
		$Payorder = D("payorder");
		$info = $Payorder->where(array('ordernum' => $out_trade_no))->find();
		if(!$info){
			//订单不存在
			if($jump) $this->redirect('Home/Index/index');
		}else{
			if($info['status'] == 1){
				//已经处理，跳过
				if($jump) $this->redirect('Home/Index/index');
			}
			$Payorder->where(array('ordernum' => $out_trade_no))->save(array('status' => 1));
			if($info['type'] == "审核费"){
				$Order = D("order");
				$order = $Order->where(array('pid' => $info['id']))->find();
				//将借款订单设置为已支付
				if($order && $order['status'] == 0){
					$Order->where(array('pid' => $info['id']))->save(array('status' => 1));
				}
				if($jump) $this->redirect('Home/Order/info',array('oid' => $order['id']));
			}elseif($info['type'] == "还款费"){
				//写入还款记录
				$Bills = D("bills");
				$arr = array(
					'user'     => $info['user'],
					'addtime'  => time(),
					'money'    => $money,
					'ordernum' => $out_trade_no
				);
				$Bills->add($arr);
				//订单信息更改已还款期数
				$Order = D("order");
				$Order->where(array('ordernum' => $info['jkorder'],'user' => $info['user']))->setInc('donemonth',1);
				if($jump) $this->redirect('Home/Order/bills');
			}else{
				//未知类型支付
				if($jump) $this->redirect('Home/Index/index');
			}
		}
	}


}