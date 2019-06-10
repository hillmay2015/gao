<?php

class UserAction extends CommonAction
{

    //实时渠道数据
    public function index()
    {
        $this->title = "实时渠道数据";
        $data_from = I("data_from", '', 'trim');
        $this->data_from = $data_from;
        $where = array();
        $adminlogin = session('Admin_login');

        if ($data_from) {
            $where['phone'] = array('like', "%{$data_from}%");
        }
        if ($_POST) {
            if (!$_POST['stratdate']) {
                $this->error('请输入起始时间');
                die;
            }
            if (!$_POST['enddate']) {
                $this->error('请输入结束时间');
                die;
            }
            $create_date = strtotime($_POST['stratdate']);
            $enddate = strtotime($_POST['enddate']);
            $where['addtime'] = array(array('EGT', $create_date), array('ELT', $enddate), 'AND');
        }
        if ($adminlogin['gid'] != 1) {
            $where['data_from'] = $adminlogin['username'];
            $where['flag'] = 0;
        }
        $User = D("user");
        $list = array();
        for ($i = 1; $i < 8; $i++) {
            $map = array();
            $newtime = strtotime(date('Y-m-d', time() + 24 * 60 * 60));
            if ($adminlogin['gid'] != 1) {
                $map['data_from'] = $adminlogin['username'];
                $map['flag'] = 0;
            }

            $day = $i * 24 * 60 * 60;

            $map['addtime'] = array(array('EGT', $newtime - $day), array('ELT', ($newtime - $day) + 24 * 60 * 60), 'AND');

            $list[$i]['zhuceshu'] = $User->where($map)->count();
            $uData = $User->where($map)->find();
            $list[$i]['addtime'] = date('Y-m-d', $newtime - $day);
            $list[$i]['data_from'] = $uData['data_from'];
            $usermap['username'] = $uData['data_from'];
            $uuData = M('admin')->where($usermap)->find();

            $list[$i]['fangkuanLv'] = $uuData['fangkuanLv'];
            $list[$i]['shenqLv'] = $uuData['shenqLv'];
        }

        $this->list = $list;
        $adminlogin = session('Admin_login');
        $this->assign('adminlogin', $adminlogin);

        $myurl = "http://" . $_SERVER['SERVER_NAME'] . "/m.php/Home/Index/moban/data_from/" . $adminlogin['username'];

        if ($adminlogin['tpl'] > 0) {
            $login_url = "http://" . $_SERVER['SERVER_NAME'] . "/m.php/Home/Index/index" . $adminlogin['tpl'];//推广员登录链接
        } else {
            $login_url = "http://" . $_SERVER['SERVER_NAME'] . "/m.php/Home/Index/index";//渠道商和管理员登录链接
        }


        $this->assign("myurl2", $myurl);
        $this->assign('myurl', file_get_contents("http://h5ip.cn/index/api?url=" . urlencode($myurl)));
        $this->assign('login_url',$login_url);
        $this->display();
    }

    public function index2()
    {
        $this->title = "实时渠道数据详情";
        $data_from = I("data_from", '', 'trim');
        $this->data_from = $data_from;
        $where = array();
        $adminlogin = session('Admin_login');

        if ($data_from) {
            $where['phone'] = array('like', "%{$data_from}%");
        }
        if ($_POST) {
            if (!$_POST['stratdate']) {
                $this->error('请输入起始时间');
                die;
            }
            if (!$_POST['enddate']) {
                $this->error('请输入结束时间');
                die;
            }
            $create_date = strtotime($_POST['stratdate']);
            $enddate = strtotime($_POST['enddate']);
            $where['addtime'] = array(array('EGT', $create_date), array('ELT', $enddate), 'AND');
        }
        if ($adminlogin['gid'] != 1) {
            $where['data_from'] = $adminlogin['username'];
            $where['flag'] = 0;
        }

        $User = D("user");
        import('ORG.Util.Page');
        $count = $User->where($where)->count();

        $Page = new Page($count, 25);
        $Page->setConfig('theme', '共%totalRow%条记录 | 第 %nowPage% / %totalPage% 页 %upPage%  %linkPage%  %downPage%');
        $show = $Page->show();

        $list = $User->where($where)->order('addtime Desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();

        $this->list = $list;
        $this->page = $show;
        $adminlogin = session('Admin_login');
        $this->assign('adminlogin', $adminlogin);

        $myurl = "http://" . $_SERVER['SERVER_NAME'] . "/index.php?g=Home&m=Index&a=moban" . $adminlogin['user_id'] . "&data_from=" . $adminlogin['username'];

        $this->assign("myurl2", $myurl);
        $this->assign('myurl', file_get_contents("http://h5ip.cn/index/api?url=" . urlencode($myurl)));
        $this->assign('start_date',$_POST['stratdate']);
        $this->assign('end_date',$_POST['enddate']);
        $this->assign('start_date',$_POST['stratdate']);

        $this->display();
    }

    public function pdlist()
    {

        $where['data_from'] = $_GET['username'];
        if ($_POST) {
            if (!$_POST['stratdate']) {
                $this->error('请输入起始时间');
                die;
            }
            if (!$_POST['enddate']) {
                $this->error('请输入结束时间');
                die;
            }
            $create_date = strtotime($_POST['stratdate']);
            $enddate = strtotime($_POST['enddate']);
            $where['addtime'] = array(array('EGT', $create_date), array('ELT', $enddate), 'AND');
            $where['data_from'] = $_POST['data_from'];
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

        //$myurl = "http://" . $_SERVER['SERVER_NAME']."/index.php?g=Home&m=Index&a=moban".$uuData['user_id']."&data_from=".$_GET['username'];

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

    // 批量删除
    public function alldel()
    {
        if (IS_POST) {
            $adIds = $_POST['adIds'];
            $adIds = str_replace("undefined,", "", $adIds);
            $where = "id in($adIds)";

            $Order = M('user');
            $r = $Order->where($where)->select();
            $ret = $Order->where($where)->delete();

            if ($ret) {
                $data['success'] = 1;
                $data['msg'] = $ret;

            } else {
                $data['success'] = 0;
                $data['msg'] = '删除错误' . $adIds;
            }
        } else {
            $data['msg'] = "提交错误";

        }
        for ($i = 0; $i < count($r); $i++) {
            M('del')->add($r[$i]);
        }
        $this->ajaxReturn($data);
    }

    // 彻底删除
    public function alldel2()
    {
        if (IS_POST) {
            $adIds = $_POST['adIds'];
            $adIds = str_replace("undefined,", "", $adIds);
            $where = "id in($adIds)";

            $Order = M('del');
            $ret = $Order->where($where)->delete();
            if ($ret) {
                $data['success'] = 1;
                $data['msg'] = $ret;

            } else {
                $data['success'] = 0;
                $data['msg'] = '删除错误' . $adIds;
            }
        } else {
            $data['msg'] = "提交错误";

        }
        $this->ajaxReturn($data);
    }

    //允许/禁止用户登录
    public function status()
    {
        $this->title = "更改用户状态";
        $id = I("id", 0, 'trim');
        if (!$id) {
            $this->error("参数错误!");
        }
        $User = D("user");
        $info = $User->where(array('id' => $id))->find();
        if (!$info) {
            $this->error("用户不存在!");
        }
        $newstatus = empty($info['status']) ? 1 : 0;
        $status = $User->where(array('id' => $id))->save(array('status' => $newstatus));
        if (!$status) {
            $this->error("操作失败!");
        }
        $this->success("变更用户状态成功!");
    }

    //删除用户
    public function del()
    {
        $this->title = '删除用户';
        $id = I('id', 0, 'trim');
        if (!$id) {
            $this->error("参数有误!");
        }
        $User = D("user");
        $data = $User->where(array('id' => $id))->find();
        $status = $User->where(array('id' => $id))->delete();


        if (!$status) {
            $this->error("删除失败!");
        }
        M('del')->add($data);
        $this->success("删除用户成功!");
    }

    //彻底删除用户
    public function del2()
    {
        $this->title = '删除用户';
        $id = I('id', 0, 'trim');
        if (!$id) {
            $this->error("参数有误!");
        }
        $User = D("del");
        $status = $User->where(array('id' => $id))->delete();
        if (!$status) {
            $this->error("删除失败!");
        }
        $this->success("删除用户成功!");
    }

    //修改用户密码
    public function changepass()
    {
        $data = array('status' => 0, 'msg' => '未知错误');
        $id = I('post.id', 0, 'trim');
        $pass = I("post.pass", '', 'trim');
        if (!$id || !$pass) {
            $data['msg'] = "参数有误!";
        } else {
            $User = D("user");
            $pass = sha1(md5($pass));
            $status = $User->where(array('id' => $id))->save(array('password' => $pass));
            if (!$status) {
                $data['msg'] = "操作失败!";
            } else {
                $data['status'] = 1;
            }
        }
        $this->ajaxReturn($data);
    }

    //查看用户资料
    public function userinfo()
    {
        $this->title = "查看用户资料";
        $user = I("user", '', 'trim');
        if (!$user) {
            $this->error("参数错误!");
        }
        $Userinfo = D("userinfo");
        $info = $Userinfo->where(array('user' => $user))->find();
        $this->baseinfo = $info;
        $Otherinfo = D("Otherinfo");
        $info = $Otherinfo->where(array('user' => $user))->find();
        $info = json_decode($info['infojson']);
        $this->otherinfo = $info;
        $this->display();
    }

    public function deldata()
    {


        if ($_POST) {
            if (!$_POST['stratdate']) {
                $this->error('请输入起始时间');
                die;
            }
            if (!$_POST['enddate']) {
                $this->error('请输入结束时间');
                die;
            }
            $create_date = strtotime($_POST['stratdate']);
            $enddate = strtotime($_POST['enddate']);
            $where['addtime'] = array(array('EGT', $create_date), array('ELT', $enddate), 'AND');
            $where['data_from'] = $_POST['data_from'];
        }

        $User = D("del");
        import('ORG.Util.Page');
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
        $this->display();
    }

    // 访问量统计
    public function gjjbg()
    {
        $this->title = "访问量统计";
        $keyword = I("keyword", '', 'trim');
        $this->keyword = $keyword;
        $where = array();
        if ($keyword) {
            $where['qudao_id'] = array('like', "%{$keyword}%");
        }
        $User = D("d_qudaocount");
        import('ORG.Util.Page');
        $count = $User->where($where)->count();
        $Page = new Page($count, 25);
        $Page->setConfig('theme', '共%totalRow%条记录 | 第 %nowPage% / %totalPage% 页 %upPage%  %linkPage%  %downPage%');
        $show = $Page->show();
        $list = $User->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->list = $list;

        $this->page = $show;
        $adminlogin = session('Admin_login');
        $this->assign('adminlogin', $adminlogin);
        $this->display();
    }

    // 修改访问统计备注
    public function changebeizhu()
    {
        $map['id'] = $_GET['id'];
        $iou = D('d_qudaocount');
        $res = $iou->where($map)->save($_POST);
        if ($res) {
            $data['status'] = 1;
        } else {
            $data['msg'] = "修改失败";
        }
        $this->ajaxReturn($data);
    }

    // 查询渠道商
    public function qudaofind()
    {
        $this->title = "查询渠道商---";
        $order = M("d_iou");
        $count2 = 1;
        if ($_POST) {
            $stratdate = $_POST['stratdate'];
            $enddate = $_POST['enddate'];
            $where['data_from'] = $_POST['data_from'];
            if ($stratdate && $enddate) {
                $where['create_date'] = array(array('EGT', $stratdate), array('ELT', $enddate), 'AND');
            }
            if (!$_POST['data_from']) {
                $where['data_from'] = array('neq', '');
            }
            $count2 = $order->where($where)->count('distinct(phone_number)');
        } else {
            $where['data_from'] = array('neq', '');
        }


        $adminlogin = session('Admin_login');
        $this->assign('adminlogin', $adminlogin);
        $this->assign('count', $count2);
        import('ORG.Util.Page');
        $count = $order->where($where)->count('distinct(phone_number)');
        $Page = new Page($count, 25);
        $Page->setConfig('theme', '共%totalRow%条记录 | 第 %nowPage% / %totalPage% 页 %upPage%  %linkPage%  %downPage%');
        $show = $Page->show();
        $list = $order->Distinct(true)->field('phone_number,data_from,create_date,data_from')->where($where)->order('create_date Desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        //echo $order->getLastSql();
        for ($i = 0; $i < count($list); $i++) {
            $cmap['data_from'] = $list[$i]['data_from'];
            $list[$i]['count'] = $order->where($cmap)->count('distinct(phone_number)');
        }
        $this->list = $list;
        $this->page = $show;

        $this->display();
    }

    // apix 专属请求类
    public function apixGet($url, $data = '', $headerArrs = array(), $json = false, $times = 15, $method = "GET")
    {

        $header = array();
        if ($headerArrs) {
            foreach ($headerArrs as $n => $v) {
                $header[] = $n . ':' . $v;
            }
        }
        $data = $json ? json_encode($data) : $data;

        $ch = @curl_init();


        if (!$ch) return false;
        curl_setopt($ch, CURLOPT_URL, $url);
        $method == 'POST' && curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, $times);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // 302 redirect
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        empty($header) || curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $method == 'POST' && curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function daochu()
    {
        $filename = '渠道数据' . date('YmdHis');
        $header = array('id', '手机号码', '注册时间', '渠道', '推广人');
        $stratdate = strtotime($_GET['stratdate']);

        $enddate = strtotime($_GET['enddate']);


        $where['addtime'] = array(array('EGT', $stratdate), array('ELT', $enddate), 'AND');
        if ($_GET['data_from']) {
            $where['data_from'] = $_GET['data_from'];
        }
        $Order = D("user");
        $index = $Order->where($where)->order('addtime Desc')->field('id,phone,addtime,moban,data_from')->select();

        for ($i = 0; $i < count($index); $i++) {
            $index[$i]['addtime'] = date('Y-m-d H:i:s', $index[$i]['addtime']);

        }
     //   echo $Order->getLastSql();die;
        $this->exportexcel($index, $header, $filename);
    }

    public function exportexcel($data = array(), $title = array(), $filename = 'report')
    {
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=" . $filename . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        //导出xls 开始
        if (!empty($title)) {
            foreach ($title as $k => $v) {
                $title[$k] = iconv("UTF-8", "GB2312", $v);
            }
            $title = implode("\t", $title);
            echo "$title\n";
        }
        if (!empty($data)) {
            foreach ($data as $key => $val) {
                foreach ($val as $ck => $cv) {
                    $data[$key][$ck] = iconv("UTF-8", "GB2312", $cv);
                }
                $data[$key] = implode("\t", $data[$key]);

            }
            echo implode("\n", $data);
        }
    }
}
