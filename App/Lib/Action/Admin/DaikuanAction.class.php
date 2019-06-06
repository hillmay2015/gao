<?php
class DaikuanAction extends CommonAction{
	
	
	//借款列表
	public function index(){
		
		$keyword = I("keyword",'','trim');
		$stratdate = I("stratdate",'','trim');
		$enddate = I("enddate",'','trim');
		$adminlogin = session('Admin_login');
		// 限时用户查询时间为开启账号的时间
		$create_date = date("Y-m-d",$adminlogin['addtime']);
		if(empty($adminlogin)){
			echo "登陆出现问题，请联系管理员";
			die;
		}
		
		$endtime = strtotime($enddate);
		$enddate = date("Y-m-d",$endtime+83200);
		if($stratdate > $create_date){
			$create_date = $stratdate;
		}
		
		$this->keyword = $keyword;
		$where = array();
		
		if($keyword && !$stratdate){
			$where['name'] = array('like',"%{$keyword}%");
			$where['create_date'] = array(array('EGT',$create_date));
		}else if($stratdate && $enddate){
			
			$where['create_date'] = array(array('EGT',$create_date),array('ELT',$enddate),'AND');
			$where['data_from'] = $_POST['data_from'];
			
		}else if($keyword && $stratdate && $enddate){
			$where['create_date'] = array(array('EGT',$create_date),array('ELT',$enddate),'AND');
			$where['name'] = $keyword;
			$where['data_from'] = $_POST['data_from'];
		}else{
			
			$where['create_date'] = array(array('EGT',$create_date));
		}
		if($adminlogin['gid'] != 1){
			$where['process_user_name'] = $adminlogin['username'];
			//$date = date('Y-m-d')."%";
			//$where['create_date'] = array('like',$date);
			//$where['process_states'] = "待审核";
		}
		if($_POST['data_from']){
			$where['data_from'] = $_POST['data_from'];
		}
		if($_POST['phone_number']){
			$where['phone_number'] = $_POST['phone_number'];
		}
		if($_GET['stratdate'] && $_GET['enddate']){
			$create_date = $_GET['stratdate'];
			$enddate = $_GET['enddate'];
			$where['create_date'] = array(array('EGT',$create_date),array('ELT',$enddate),'AND');
		}
		if($_GET['phone_number']){
			$where['phone_number'] = $_GET['phone_number'];
		}
		if($_GET['data_from']){
			$where['data_from'] = $_GET['data_from'];
		}
		session('stratdate',$stratdate); 
		session('enddate',$enddate);
		session('keyword',$keyword);
		session('data_from',$_POST['data_from']);
		$Order = D("d_iou");
		import('ORG.Util.Page');
		$count = $Order->where($where)->count('distinct(phone_number)');
		$Page  = new Page($count,25);
		$Page->setConfig('theme','共%totalRow%条记录 | 第 %nowPage% / %totalPage% 页 %upPage%  %linkPage%  %downPage%');
		$show  = $Page->show();
		$list = $Order->Distinct(true)->field('phone_number,name,zhimafen,wechat,age,card,create_date,process_states,process_content')->where($where)->order('create_date Desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		//echo $Order->getLastSql();
		for($i = 0 ; $i < count($list); $i ++){
			$pymap['phone_number'] = $list[$i]['phone_number'];
			$tdinfo = M('d_iou')->where($pymap)->find();
			$list[$i]['tongdun'] = $tdinfo['tongdun'];
			$list[$i]['sort_num'] = $tdinfo['sort_num'];
			$list[$i]['name'] = $tdinfo['name'];
		}
		$this->list = $list;
		$this->page = $show;
		$this->assign('adminlogin',$adminlogin);
		
		$qbmap['username'] = $adminlogin['username'];
		$qianbao = M('admin')->where($qbmap)->find();
		
		$this->assign('qianbao',$qianbao['qianbao']);
		$this->display();
	}
	// 我得订单通过审核员+状态查询
	public function indexfind(){
		$adminlogin = session('Admin_login');
		$where['process_user_name'] = $_POST['process_user_name'];
		$where['process_states'] = $_POST['process_states'];
		$Order = D("d_iou");
		import('ORG.Util.Page');
		$count = $Order->where($where)->count();
		$Page  = new Page($count,25);
		$Page->setConfig('theme','共%totalRow%条记录 | 第 %nowPage% / %totalPage% 页 %upPage%  %linkPage%  %downPage%');
		$show  = $Page->show();
		$list = $Order->where($where)->order('create_date Desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		//echo $Order->getLastSql();
		$this->list = $list;
		$this->page = $show;
		$this->assign('adminlogin',$adminlogin);
		$userlist = M('admin')->where()->select();
		$this->assign('userlist',$userlist);
		$this->display('index');
	}
	// 今日借款列表
	public function todaydata(){
		$Order = D("d_iou");
		
		$adminlogin = session('Admin_login');
		
		$this->assign('adminlogin',$adminlogin);
		$qbmap['username'] = $adminlogin['username'];
		$qianbao = M('admin')->where($qbmap)->find();
		$this->assign('qianbao',$qianbao['qianbao']);
		
		$paydata['user'] = $adminlogin['username'];
		$count = M('payorder')->where($paydata)->count();
		$this->assign('count',$count);
		$this->assign('feiyong',C('cfg_sitedescription'));
		$this->display();
	}
	// 认领信息
	public function renling(){
		$map['sort_num'] = $_GET['sort_num'];
		$iou = D('d_iou');
		$adminlogin = session('Admin_login');
		$data['process_user_name'] = $adminlogin['username'];
		$data['create_date'] = date('Y-m-d H:i:s');
		$res = $iou->where($map)->save($data);
		if($res){
			
			$jine = C('cfg_sitedescription');
			$paydata['user'] = $adminlogin['username'];
			$paydata['money'] = $jine;
			$paydata['addtime'] = time();
			$paydata['status'] = 1;
			M('payorder')->add($paydata);
			M('admin')->where($map)->setDec('qianbao', $jine);
			$this->success('购买成功，请及时审核',U('Daikuan/todaydata'));
		}else{
			$this->error('购买失败');
		}
		
	}
	//修改信息
	public function changestatus(){
		$map['sort_num'] = $_POST['oid'];
		$res = M('d_iou')->where($map)->find();
		
		if($res){
			$data['data'] = $res;
			$this->ajaxReturn($res);
		}
		
	}
	// 保存修改信息 
	public function savestatus(){
		$map['sort_num'] = $_GET['sort_num'];
		$iou = D('d_iou');
		$res = $iou->where($map)->save($_POST);
		if($res){
			$data['status'] = 1;
		}else{
			$data['msg'] = "修改失败";
		}
		$this->ajaxReturn($data);
	}
	//保存审核信息
	public function savestatus2(){
		$map['sort_num'] = $_GET['sort_num'];
		$iou = D('d_iou');
		$_POST['process_date'] = date('Y-m-d H:i:s');
		$res = $iou->where($map)->save($_POST);
		if($res){
			$data['status'] = 1;
		}else{
			$data['msg'] = "修改失败";
		}
		$this->ajaxReturn($data);
	}
	
	//删除订单
	public function del(){
        $this->title='删除信息订单';
        $sort_num = I('sort_num',0,'trim');
        if(!$sort_num){
            $this->error("参数有误!");
        }
        $Order = D("d_iou");
        $status = $Order->where(array('sort_num' => $sort_num))->delete();
        if(!$status){
            $this->error("删除失败!");
        }
        $this->success("删除信息成功!");
	}
	// 批量删除
	public function alldel(){
		if(IS_POST){
			$adIds = $_POST['adIds'];
			$adIds = str_replace("undefined,","",$adIds);
			$where = "sort_num in($adIds)";
			
			$Order = M('d_iou');	
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
		$this->ajaxReturn($data);
	}
	//批量认领
	public function plrenling(){
		if(IS_POST){
			$adminlogin = session('Admin_login');
			$adIds = $_POST['adIds'];
			$adIds = str_replace("undefined,","",$adIds);
			$where = "sort_num in($adIds)";
			
			$Order = M('d_iou');	
			$data['process_user_name'] = $adminlogin['username'];
			$ret = $Order->where($where)->save($data);
			if($ret){
				$data['success'] = 1;
				$data['msg'] = $ret;
				
			}else{
				$data['success'] = 0;
				$data['msg'] = '认领错误'.$adIds;
			}
		}else{
			$data['msg'] = "批量认领成功";
			
		}
		$this->ajaxReturn($data);
	}
	

	public function http_request($url,$data=array()){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		// 我们在POST数据哦！
		curl_setopt($ch, CURLOPT_POST, 1);
		// 把post的变量加上
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}
	
	public function daochu(){
		$filename = '查询记录'.date('YmdHis');  
		$header = array('id','用户名','查询用户','创建日期','状态');  
		$stratdate = session('stratdate');
		
		$enddate = session('enddate');
		
		$user = session('user');
		
		$adminlogin = session('Admin_login');
		if(!$user){
			if($adminlogin['username'] != 'admin'){
				$where['user'] = $adminlogin['username'];
			}
		}else{
			$where['user'] = $user;
		}
		
		$where['addtime'] = array(array('EGT',$stratdate),array('ELT',$enddate),'AND');
		$Order = D("payorder");
		$index = $Order->where($where)->order('addtime Desc')->field('id,user,name,addtime,status')->select();
		
		for($i = 0 ; $i < count($index); $i ++){
			$index[$i]['addtime'] = date('Y-m-d H:i:s',$index[$i]['addtime'] );
			$index[$i]['status'] = "支付";
		}
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
	}
	// 查看附件
	public function fujian(){
		$this->title = "查看附件";
		$map['sort_num'] = $_GET['sort_num'];
		$fjdata = M('d_iou')->where($map)->find();
		$map['mobile'] = $fjdata['phone_number'];
		$message = M('xybg')->where($map)->find();
		$this->assign('fjdata',$fjdata);
		$this->assign('message',$message['message']);
		$this->display();
	}
	
	// 查看通过的数量
	public function tongguo(){
		$adminlogin = session('Admin_login');
		$where = array();
		if($adminlogin['gid'] != 1)
			$where['process_user_name'] = $adminlogin['username'];
		$where['process_states'] = '通过';
		if($_POST['stratdate'] && $_POST['enddate']){
			$stratdate = I("stratdate",'','trim');
			$enddate = I("enddate",'','trim');
			$where['create_date'] = array(array('EGT',$stratdate),array('ELT',$enddate),'AND');
		}
		if($_POST['data_from']){
			$where['data_from'] = $_POST['data_from'];
		}
		if($_POST['phone_number']){
			$where['phone_number'] = $_POST['phone_number'];
		}
		if($_POST['todaycount'] == 1){
 			$stratdate = date('Y-m-d');
			$enddate = date('Y-m-d',strtotime('+1 day'));
			$where['create_date'] = array(array('EGT',$stratdate),array('ELT',$enddate),'AND');
		}
		$Order = D("d_iou");
		import('ORG.Util.Page');
		$count = $Order->where($where)->count();
		$Page  = new Page($count,25);
		$Page->setConfig('theme','共%totalRow%条记录 | 第 %nowPage% / %totalPage% 页 %upPage%  %linkPage%  %downPage%');
		$show  = $Page->show();
		$list = $Order->where($where)->order('create_date Desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		//echo $Order->getLastSql();
		$this->list = $list;
		$this->page = $show;
		$userlist = M('admin')->where()->select();
		$this->assign('userlist',$userlist);
		$this->assign('adminlogin',$adminlogin);
		$this->display();
	}
	// 查看取消的数量
	public function quxiao(){
		$adminlogin = session('Admin_login');
		$where = array();
		if($adminlogin['gid'] != 1)
			$where['process_user_name'] = $adminlogin['username'];
		$where['process_states'] = '取消';
		if($_POST['stratdate'] && $_POST['enddate']){
			$stratdate = I("stratdate",'','trim');
			$enddate = I("enddate",'','trim');
			$where['create_date'] = array(array('EGT',$stratdate),array('ELT',$enddate),'AND');
		}
		if($_POST['data_from']){
			$where['data_from'] = $_POST['data_from'];
		}
		if($_POST['phone_number']){
			$where['phone_number'] = $_POST['phone_number'];
		}
		$Order = D("d_iou");
		import('ORG.Util.Page');
		$count = $Order->where($where)->count();
		$Page  = new Page($count,25);
		$Page->setConfig('theme','共%totalRow%条记录 | 第 %nowPage% / %totalPage% 页 %upPage%  %linkPage%  %downPage%');
		$show  = $Page->show();
		$list = $Order->where($where)->order('create_date Desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		//echo $Order->getLastSql();
		$this->list = $list;
		$this->page = $show;
		$userlist = M('admin')->where()->select();
		$this->assign('userlist',$userlist);
		$this->assign('adminlogin',$adminlogin);
		$this->display();
	}
	// 查看拒绝的数量
	public function jujue(){
		$adminlogin = session('Admin_login');
		$where = array();
		if($adminlogin['gid'] != 1)
			$where['process_user_name'] = $adminlogin['username'];
		$where['process_states'] = '拒绝';
		if($_POST['stratdate'] && $_POST['enddate']){
			$stratdate = I("stratdate",'','trim');
			$enddate = I("enddate",'','trim');
			$where['create_date'] = array(array('EGT',$stratdate),array('ELT',$enddate),'AND');
		}
		if($_POST['data_from']){
			$where['data_from'] = $_POST['data_from'];
		}
		if($_POST['phone_number']){
			$where['phone_number'] = $_POST['phone_number'];
		}
		$Order = D("d_iou");
		import('ORG.Util.Page');
		$count = $Order->where($where)->count();
		$Page  = new Page($count,25);
		$Page->setConfig('theme','共%totalRow%条记录 | 第 %nowPage% / %totalPage% 页 %upPage%  %linkPage%  %downPage%');
		$show  = $Page->show();
		$list = $Order->where($where)->order('create_date Desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		//echo $Order->getLastSql();
		$this->list = $list;
		$this->page = $show;
		$userlist = M('admin')->where()->select();
		$this->assign('userlist',$userlist);
		$this->assign('adminlogin',$adminlogin);
		$this->display();
	}
	// 查看未接数量
	public function weijie(){
		$adminlogin = session('Admin_login');
		$where = array();
		if($adminlogin['gid'] != 1)
			$where['process_user_name'] = $adminlogin['username'];
		$where['process_states'] = '未接';
		if($_POST['stratdate'] && $_POST['enddate']){
			$stratdate = I("stratdate",'','trim');
			$enddate = I("enddate",'','trim');
			$where['create_date'] = array(array('EGT',$stratdate),array('ELT',$enddate),'AND');
		}
		if($_POST['data_from']){
			$where['data_from'] = $_POST['data_from'];
		}
		if($_POST['phone_number']){
			$where['phone_number'] = $_POST['phone_number'];
		}
		$Order = D("d_iou");
		import('ORG.Util.Page');
		$count = $Order->where($where)->count();
		$Page  = new Page($count,25);
		$Page->setConfig('theme','共%totalRow%条记录 | 第 %nowPage% / %totalPage% 页 %upPage%  %linkPage%  %downPage%');
		$show  = $Page->show();
		$list = $Order->where($where)->order('create_date Desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		//echo $Order->getLastSql();
		$this->list = $list;
		$this->page = $show;
		$userlist = M('admin')->where()->select();
		$this->assign('userlist',$userlist);
		$this->assign('adminlogin',$adminlogin);
		$this->display();
	}
	// 查询加微信数量
	public function jiawechat(){
		$adminlogin = session('Admin_login');
		$where = array();
		if($adminlogin['gid'] != 1)
			$where['process_user_name'] = $adminlogin['username'];
		$where['process_states'] = '加微信';
		if($_POST['stratdate'] && $_POST['enddate']){
			$stratdate = I("stratdate",'','trim');
			$enddate = I("enddate",'','trim');
			$where['create_date'] = array(array('EGT',$stratdate),array('ELT',$enddate),'AND');
		}
		if($_POST['data_from']){
			$where['data_from'] = $_POST['data_from'];
		}
		if($_POST['phone_number']){
			$where['phone_number'] = $_POST['phone_number'];
		}
		$Order = D("d_iou");
		import('ORG.Util.Page');
		$count = $Order->where($where)->count();
		$Page  = new Page($count,25);
		$Page->setConfig('theme','共%totalRow%条记录 | 第 %nowPage% / %totalPage% 页 %upPage%  %linkPage%  %downPage%');
		$show  = $Page->show();
		$list = $Order->where($where)->order('create_date Desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		//echo $Order->getLastSql();
		$this->list = $list;
		$this->page = $show;
		$userlist = M('admin')->where()->select();
		$this->assign('userlist',$userlist);
		$this->assign('adminlogin',$adminlogin);
		$this->display();
	}
	// 查询客户菜单
	public function findall(){
		$where = array();
		$list = array();
		$Order = D("d_iou");
		if($_POST['name']){
			$where['name'] = $_POST['name'];
		}
		if($_POST['phone_number']){
			$where['phone_number'] = $_POST['phone_number'];
		}
		if($_POST['qq']){
			$where['qq'] = $_POST['qq'];
		}
		if($_POST){
			$list = $Order->where($where)->select();
		}
		$this->title = "查询客户菜单";
		$adminlogin = session('Admin_login');
		$this->assign('adminlogin',$adminlogin);
		$this->list = $list;
		$this->display();
	}
	// 加入终极审核
	public function zhongshendata(){
		
		$map['sort_num'] = $_GET['sort_num'];
		
		$data['process_states'] = '终审';
		$ret = M('d_iou')->where($map)->save($data);
		if($ret){
			$this->success('操作成功',U('Daikuan/jiawechat'),1);
		}else{
			$this->error('操作失败');
		}
	}
	// 终审通过
	public function zhongshentongguodata(){
		
		$map['sort_num'] = $_GET['sort_num'];
		
		$data['process_states'] = '终审通过';
		$ret = M('d_iou')->where($map)->save($data);
		if($ret){
			$this->success('操作成功',U('Daikuan/zhongshen'),1);
		}else{
			$this->error('操作失败');
		}
	}
	// 终审列表
	public function zhongshen(){
		$this->title = "终审列表";
		$adminlogin = session('Admin_login');
		$where = array();
		if($adminlogin['gid'] != 1)
			$where['process_user_name'] = $adminlogin['username'];
		$where['process_states'] = '终审';
		$Order = D("d_iou");
		import('ORG.Util.Page');
		$count = $Order->where($where)->count();
		$Page  = new Page($count,25);
		$Page->setConfig('theme','共%totalRow%条记录 | 第 %nowPage% / %totalPage% 页 %upPage%  %linkPage%  %downPage%');
		$show  = $Page->show();
		$list = $Order->where($where)->order('create_date Desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		//echo $Order->getLastSql();
		$this->list = $list;
		$this->page = $show;
		$userlist = M('admin')->where()->select();
		$this->display();
	}
	// 终审通过列表
	public function zhongshentongguo(){
		$this->title = "终审列表";
		$adminlogin = session('Admin_login');
		$where = array();
		if($adminlogin['gid'] != 1)
			$where['process_user_name'] = $adminlogin['username'];
		$where['process_states'] = '终审通过';
		$Order = D("d_iou");
		import('ORG.Util.Page');
		$count = $Order->where($where)->count();
		$Page  = new Page($count,25);
		$Page->setConfig('theme','共%totalRow%条记录 | 第 %nowPage% / %totalPage% 页 %upPage%  %linkPage%  %downPage%');
		$show  = $Page->show();
		$list = $Order->where($where)->order('create_date Desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		//echo $Order->getLastSql();
		$this->list = $list;
		$this->page = $show;
		$userlist = M('admin')->where()->select();
		$this->display();
	}
	// 购买记录
	public function payorder(){
		$adminlogin = session('Admin_login');
		$map['username'] = $adminlogin['username'];
	}
	// 查看同盾报告
	public function tongdun(){
		header("Content-type: text/html; charset=utf-8"); 
		if($_GET['tongdun']){
			$file = 'http://'.$_SERVER['SERVER_NAME'].'/'.$_GET['tongdun'];
			
			$res =  file_get_contents($file);
			
			header("Location:tongdun-v4//index.php?resultMsg=".$res);
		}else{
			echo "获取报告中.....";
			$map['sort_num'] = $_GET['sort_num'];
			$info = M('d_iou')->where($map)->find();
			
			$this->tongdunbaogao($info['name'],$info['card'],$info['phone_number']);
			
			
			
		}
	}
	// 同盾报告获取
	public function tongdunbaogao($name,$card,$phone){
		header("Content-type: text/html; charset=utf-8"); 
		$data = array(
            'account_mobile' => $phone,//18628337024,
            'account_name' => $name,
            'id_number' => $card,
            'card_number' => ''
        );
		
		$url = 'https://apitest.tongdun.cn/bodyguard/apply/v4.1?';
		$partner_code = 'nbqf';
		$partner_key = '138d552ee3894061828e22f2acb8202f';
		$app_name = 'nbqf_web';
        $param = 'partner_code=' . $partner_code . '&partner_key=' . $partner_key . '&app_name=' . $app_name;
        $postUrl = $url . $param;
        $result = $this->request_post($postUrl, $data, 1);

       
		
        if ($result && $result['success'] == 1) {
			
			$filepath = 'Upload/tongdun/' .$phone.'.log';
           
			
			file_put_contents($filepath, json_encode($result) . "\r\n", FILE_APPEND);
			
		
			$updata['tongdun'] = $filepath;
			$map['phone_number'] = $phone;
			if($phone){
				M('d_iou')->where($map)->save($updata);
			}
			
			$this->success('获取报告成功，请再次打开同盾报告',U('Daikuan/index'));
        }else{
			print_r($result);
		}
		
	}
	 function request_post($url = '', $data = '', $fag = false)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "application/x-www-form-urlencoded;charset=utf-8",
        ));

        $postdata = '';
        if ($fag) {
            foreach ($data as $key => $value) {
                $postdata .= ($key . '=' . $value . '&');
            }
        } else {
            $postdata = $data;
        }

        if ($data)
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        // 设置HTTPS支持
        date_default_timezone_set('PRC');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

        $rtn = curl_exec($ch);    // 执行
        if (curl_errno($ch)) {
            return 'PostError: ' . curl_error($ch);
        }
        curl_close($ch);
        if ($rtn) {
            $rtn = json_decode($rtn, 1);
        }
        return $rtn;
    }
	// 渠道查询
	public function qudaofind(){
		$Order = D("d_qudaocount");
		import('ORG.Util.Page');
		$count = $Order->where($where)->count();
		$Page  = new Page($count,25);
		$Page->setConfig('theme','共%totalRow%条记录 | 第 %nowPage% / %totalPage% 页 %upPage%  %linkPage%  %downPage%');
		$show  = $Page->show();
		$list = $Order->where($where)->order('create_date Desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		//echo $Order->getLastSql();
		$this->list = $list;
		$this->page = $show;
		$adminlogin = session('Admin_login');
		$this->assign('adminlogin',$adminlogin);
		$this->display();
		
	}
	// 模拟登陆
	public function webLoginGet(){
		
       $httpurl = C('cfg_wgurl');
       $user = C('cfg_wguser');
       $pass = C('cfg_wgpass');
      
		// 扣费
		$adminlogin = session('Admin_login');
		$map['username'] = $adminlogin['username'];
		$userdata = M('admin')->where($map)->find();
		
		if($userdata['qianbao'] < (float)C('cfg_sitedescription') ){
			
			$data['res'] = '{"code":2,"msg":"余额不足"}';
			$this->ajaxReturn($data);
			die;
		}
	
     /* 
		header("Content-type: text/html; charset=utf-8");    
		$curl = curl_init();
		$cookie_jar = tempnam('./tmp','cookie');
		curl_setopt($curl, CURLOPT_URL,$httpurl.'/Home/Login/submit');//这里写上处理登录的界面
		curl_setopt($curl, CURLOPT_POST, 1);

		$request = 'account='.$user.'&password='.$pass.'&action=login&Submit=提交';
		curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
		curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_jar);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_NOBODY, false);
		curl_exec($curl);
	
		curl_close($curl);
		*/
		$phone = $_POST['phone'];
		$detail = $this->apigetData($phone);
		$data['res'] = $detail;
		// 产生计费订单
		$order['ordernum'] = time();
			// 同一天同一个手机号查询不扣费用
      	$todaymap['user'] =  $adminlogin['username'];
        $todaytime = strtotime(date('Y-m-d'));
        $todaymap['name'] = $_POST['phone'];
        $todaymap['addtime'] = array(array('EGT', $todaytime), array('ELT', $todaytime+60*60*24), 'AND');
        $dif = M('payorder')->where($todaymap)->find();
      	if(!$dif){
        		$order['user'] = $adminlogin['username'];
                $order['money'] = C('cfg_sitedescription');
                $order['addtime'] = time();
                $order['datares'] = $detail;
                $order['status'] = 1;
                $order['name'] = $phone;
                M("payorder")->add($order);

                M('admin')->where($map)->setDec('qianbao',(float)C('cfg_sitedescription'));
		
        }
	
		$this->ajaxReturn($data);
	
	}
	function curl_get_contents($url, $postData = array() , $cookie_jar) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);
		if ($postData) {
			$postData = http_build_query($postData);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		}
		
		$r = curl_exec($ch);
		curl_close($ch);
		
		return $r;
	}
	
	// API请求数据
	function apigetData($phone){
		$url = "http://www.chenghe15.com/api/uget";
	
		$sign_data['mer_no'] = '201811011055282996';
		$sign_data['date'] = time();
		$sign_data['phone'] = $phone;
		
		ksort($sign_data);
		//1.拼接成字符串
		$sign_str = "";
		foreach ($sign_data as $k => $v) {
		$sign_str .= $k . "=" . $v . "&";
		}
		$sign_str = substr($sign_str, 0, strlen($sign_str) - 1);
		//2.md5加密 转成大写
		$data = strtoupper(md5($sign_str));
		//3.进行私钥加密
		$rsaPrivateKeyPem = "-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQC3+rZ7VJA8xD5gd0vpsrNtkr2izZ89+Ktnrk2iwSCp2jwtzAZr
q1LpiEHMQ00uAkEBtWflTXNXSNFl93TQI6rLRkuOnET1Fs2rL0agRflOKeFWIlha
xXVqJLcWvdTGGAyfD/1IFBo/FhqexgbW2xiSwKcaaM2p+DS521UPnmAJFwIDAQAB
AoGAeCJECiBb1vIl8QO1FDLWKxSIs8gk1WiNNDSDCWWmmIKijR0OjDvg9hE9Nc40
lXhvTlhQMVDzoekwoq6FHmxL1zij2DEIW1KkMW9vkhW04eSGlFEs+Pi+l05yxVn1
fAXLCa7pbCs/ABMFy6vuGahJNssLNok4Ljovj3p7LjEziEECQQDPP1BedDxmepdG
RATfVf+uqJA67C9e3EQbhPdz1dWIaanPKJ4LfXy6jImwUPUd1sh8hKZZEpaOlCMi
zANFwReHAkEA40IsVm8/B6SQ7WUix/9fzBXqgRWPIwbKABcq+UqsfRLW2i6zdR8a
L/hJBgCybh60T2SYMOdJhmD28wx74xLF8QJBAJZfmjDupeS1jo2tTNu/yoUwSXZ3
aOerar+M+v9RaF5STKPDFOnBY373+e+0ziWYcl/m38xBcHyDf/r/jGBQeoECQHKX
bW/wDGI4MvPhaVZbiNyJuIN6cYCB7d150St+4db3ZusBXXATTMsfcQLb2xz30oet
+6e9GC/wONV5WAa58qECQG5NkEDPrxeMN8bdD1w5E5K/UUJMIuCIsvQpzYE1QaCX
zxLBHDihbCL5GsutMZhL5CXF2/TfDSOtcj+8FmuMZ9k=
-----END RSA PRIVATE KEY-----";
		$key = openssl_pkey_get_private($rsaPrivateKeyPem);
		openssl_sign($data,$sign,$key,OPENSSL_ALGO_SHA1);
		$sign = base64_encode($sign);

		$sign_data['mer_sign'] = $sign;
		
		header("Content-type: text/html; charset=utf-8");
		$curl = curl_init();
		//设置抓取的url
		curl_setopt($curl, CURLOPT_URL, $url);
		//设置头文件的信息作为数据流输出
		curl_setopt($curl, CURLOPT_HEADER, 0);
		//设置获取的信息以文件流的形式返回，而不是直接输出。
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		//设置post方式提交
		curl_setopt($curl, CURLOPT_POST, 1);
	
		curl_setopt($curl, CURLOPT_POSTFIELDS, $sign_data);
		//执行命令
		$data = curl_exec($curl);
		//关闭URL请求
		curl_close($curl);
		//显示获得的数据
		return $data;
		
	}
	


}
