<?php
class FenxiaoAction extends CommonAction{
	
	
	//数据导入
	public function index(){
		$this->title = "数据导入";
		$keyword = I("keyword",'','trim');
		$this->keyword = $keyword;
		$keyword1 = I("keyword1",'','trim');
		$this->keyword1= $keyword1;
		$where = array();
		if($keyword){
			$where['phone'] = array('like',"%{$keyword}%");
		}
		if($keyword1){
			$where['yao_phone'] = array('like',"%{$keyword1}%");
		}
		$user = D("user");
		import('ORG.Util.Page');
		$count = $user->where($where)->count();
		$Page  = new Page($count,25);
		$Page->setConfig('theme','共%totalRow%条记录 | 第 %nowPage% / %totalPage% 页 %upPage%  %linkPage%  %downPage%');
		$show  = $Page->show();
		$list = $user->where($where)->order('addtime Desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->list = $list;
		$this->page = $show;
		$adminlogin = session('Admin_login');
		$this->assign('adminlogin',$adminlogin);
		$this->display();
	}
	
	
	
	//导入到数据库
	public function upload(){
		header("Content-type: text/html; charset=utf-8");       
       //引入ThinkPHP上传文件类
		import('ORG.Net.UploadFile');
		//实例化上传类
		$upload = new UploadFile();
		//设置附件上传文件大小400Kib
		$upload->mixSize = 4000000;
		//设置附件上传类型
		$upload->allowExts = array('xls', 'xlsx', 'csv');
		//设置附件上传目录在/Home下
		$upload->savePath = './Upload/';
		//保持上传文件名不变
		$upload->saveRule = '';
		//存在同名文件是否是覆盖
		$upload->uploadReplace = true;
		if (!$upload->upload()) {  //如果上传失败,提示错误信息
		  $this->error($upload->getErrorMsg());
		} else {  //上传成功
		  //获取上传文件信息
		  $info = $upload->getUploadFileInfo();
		  //获取上传保存文件名
		  $fileName = $info[0]['savename'];
		  //重定向,把$fileName文件名传给importExcel()方法
		  $this->redirect('Fenxiao/importExcel', array('fileName' => $fileName), 0);
		}
	}
	
	public function importExcel() {
		
		header("content-type:text/html;charset=utf-8");
		//引入PHPExcel类
		require_once 'PHPExcel-1.8/Classes/PHPExcel.php'; 
		
		
		//redirect传来的文件名
		$fileName = $_GET['fileName'];
	  
		//文件路径
		$filePath = './Upload/' . $fileName;
		//实例化PHPExcel类
		$PHPExcel = new PHPExcel();
		//默认用excel2007读取excel，若格式不对，则用之前的版本进行读取
		$PHPReader = new PHPExcel_Reader_Excel2007();
		if (!$PHPReader->canRead($filePath)) {
		  $PHPReader = new PHPExcel_Reader_Excel5();
		  if (!$PHPReader->canRead($filePath)) {
			echo 'no Excel';
			return;
		  }
		}
	  
		//读取Excel文件
		$PHPExcel = $PHPReader->load($filePath);
		//读取excel文件中的第一个工作表
		$sheet = $PHPExcel->getSheet(0);
		//取得最大的列号
		$allColumn = $sheet->getHighestColumn();
		//取得最大的行号
		$allRow = $sheet->getHighestRow();
		//从第二行开始插入,第一行是列名
		 $erp_orders_id = array();  //声明数组
		$i = 0;
		$difcount = 0;
		$succCount = 0;
		$num = 0;
		$namecount = 0;
		for ($currentRow = 2; $currentRow <= $allRow; $currentRow++) {
	
		  $name = $PHPExcel->getActiveSheet()->getCell("A" . $currentRow)->getValue();
		  
		  if(empty($name)){
			  $namecount++;
			  continue;
		  }
		  $phone_number = $PHPExcel->getActiveSheet()->getCell("B" . $currentRow)->getValue();
		  $wechat = $PHPExcel->getActiveSheet()->getCell("C" . $currentRow)->getValue();
		  $qq = $PHPExcel->getActiveSheet()->getCell("D" . $currentRow)->getValue();
		  $zhimafen = $PHPExcel->getActiveSheet()->getCell("E" . $currentRow)->getValue();
		  $age = $PHPExcel->getActiveSheet()->getCell("F" . $currentRow)->getValue();
		  $area = $PHPExcel->getActiveSheet()->getCell("G" . $currentRow)->getValue();
		  $create_date = date('Y-m-d H:i:s',time());
		  $data = array('area'=>$area,'process_user_name'=>'','name' => $name, 'phone_number' => $phone_number, 'wechat' => $wechat,'qq'=> $qq, 'zhimafen'=>$zhimafen, 'age' => $age, 'create_date' => $create_date,'process_states' => '待审核');
		 
		  
		  
		  $m = M('d_iou');
		   $dif = $m->add($data);  
		  // 不写入重复号码
		/*  $phone['phone_number'] = $phone_number;
		  $dif = $m->where($phone)->select();*/
		  if(!$dif){
			  $difcount++;
		  }else{
			   
			  $succCount++;
		  }
		
		}	
		$usercount = M("admin")->where()->select();
		for($i = 0; $i < count($usercount); $i ++){
			$date = date("Y年m月d日",time());
			$cont = "【借了没】尊敬的客户您好，{$date}的数据已更新，请登录后台查看";
			$number = $usercount[$i]['phone'];
			$url = $_SERVER['HTTP_HOST']."/cmssend.php?number=$number&cont=$cont";
			$cmsdata[$i] = $this->http_request($url);
		}
	
		if ($succCount > 0) {
		 $this->success("成功上传".$succCount."条,重复".$difcount."条"."姓名为空".$namecount,U('Daikuan/index'));
		} else {
		 $this->error("上传失败!重复".$difcount."条");
		}
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
	
}
