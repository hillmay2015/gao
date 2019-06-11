<?php

class IndexAction extends CommonAction
{


    // app登录入库
    public function applogin()
    {
        $this->assign('sitecfg', C('cfg_sitename'));

        $this->assign("majia", '001');
        $this->display();
    }

    // app登录验证
    public function checkapplogin()
    {
        $data['success'] = 0;
        if ($_POST) {
            $phone = $_POST['phoneNumber'];
            $password = $_POST['password'];

            $password = md5($password);
            $data['msg'] = $password;

            $map['phone'] = $phone;
            $map['password'] = $password;
            $info = M("user")->where($map)->find();

            if (!$info) {
                $data['msg'] = "帐户名或密码错误";
            } else {
                $data['success'] = 1;
                session('userinfo', $info);
            }

        }
        $this->ajaxReturn($data);
    }

    public function index()
    {

        $imgmoban = C("cfg_imgmoban");
        $this->assign("imgmoban", $imgmoban);
        $this->display();


    }


    public function index1()
    {
        $username=$_GET['data_from'];
        $where['username']=$username;
        $Admin = D("admin");
        $user= $Admin->where($where)->find();
        $this->assign('user',$user);
        $this->display();

    }

    public function index2()
    {
        $username=$_GET['data_from'];
        $where['username']=$username;
        $Admin = D("admin");
        $user= $Admin->where($where)->find();
        $this->assign('user',$user);
        $this->display();
    }


    public function doApply()
    {
        $ret['success'] = 0;
        if ($_POST) {
            // 验证是否提交过
            $ioumap['phone_number'] = $_POST['phoneNumber'];
            $count2 = M('d_iou')->where($ioumap)->count();

            $usermap['phone'] = $_POST['phoneNumber'];
            $count3 = M('user')->where($usermap)->count();
            if ($count2 || $count3) {
                $ret['msg'] = "请勿重复提交";
                $this->ajaxReturn($ret);
                die;
            }

            $Code = M('smscode');
            $info = $Code->where(array('phone' => $_POST['phoneNumber']))->order("sendtime desc")->find();
            if ((time() - 30 * 60) > $info['sendtime']) {
                $ret['msg'] = "验证码已过期,请重新获取!";
                $this->ajaxReturn($ret);
                die;
            }
            if ($info['code'] == $_POST['code']) {

                $userdata['phone'] = $_POST['phoneNumber'];
                $userdata['password'] = md5($_POST['password']);
                $userdata['truename'] = $_POST['truename'];
                $userdata['addtime'] = time();
                $userdata['card'] = $_POST['card'];
                $userdata['data_from'] = $_POST['data_from'];
                M('user')->add($userdata);
            } else {
                $ret['success'] = 0;
                $ret['msg'] = "验证码错误!";
                $this->ajaxReturn($ret);
                die;
            }

            //$this->tongdunbaogao($_POST['truename'],$_POST['card'],$_POST['phoneNumber']);
            $data['iou_ip'] = $_SERVER['REMOTE_ADDR'];
            $data['process_states'] = "待审核";
            $data['data_from'] = $_POST['data_from'];
            $data['create_date'] = date("Y-m-d H:i:s");
            $data['name'] = $_POST['truename'];
            $data['zhimafen'] = $_POST['zhimafen'];
            $data['phone_number'] = $_POST['phoneNumber'];
            $data['mobileType'] = $_POST['mobileType'];
            $data['card'] = $_POST['card'];

            $data['wechat'] = $_POST['wechat'];
            $data['age'] = $_POST['age'];
            $data['area'] = getiparea($data['iou_ip']);
            $randnum = rand(1, 2);
            if ($randnum == 1) {
                $jine = C('cfg_sitedescription');
                $paydata['money'] = $jine;
                $paydata['addtime'] = time();
                $paydata['status'] = 1;

                $process_user_name = $this->getusername();
                $process_user_name2 = $this->getusername2();
                $process_user_name3 = $this->getusername3();
                if ($process_user_name == $process_user_name2 && $process_user_name == $process_user_name3 && $process_user_name2 == $process_user_name3) {
                    if ($process_user_name) {
                        $data['process_user_name'] = $process_user_name;
                        $flag = M('d_iou')->add($data);
                        $paydata['user'] = $process_user_name;
                        M('payorder')->add($paydata);
                        $map['username'] = $process_user_name;
                        M('admin')->where($map)->setDec('qianbao', $jine);
                    }
                } else if ($process_user_name == $process_user_name2 && $process_user_name == $process_user_name3) {
                    if ($process_user_name2) {
                        $data['process_user_name'] = $process_user_name2;
                        $flag = M('d_iou')->add($data);
                        $paydata['user'] = $process_user_name2;
                        M('payorder')->add($paydata);
                        $map['username'] = $process_user_name2;
                        M('admin')->where($map)->setDec('qianbao', $jine);
                    }
                    if ($process_user_name3) {
                        $data['process_user_name'] = $process_user_name3;
                        $flag = M('d_iou')->add($data);
                        $paydata['user'] = $process_user_name3;
                        M('payorder')->add($paydata);
                        $map['username'] = $process_user_name3;
                        M('admin')->where($map)->setDec('qianbao', $jine);
                    }
                } else {
                    if ($process_user_name) {
                        $data['process_user_name'] = $process_user_name;
                        $flag = M('d_iou')->add($data);
                        $paydata['user'] = $process_user_name;

                        M('payorder')->add($paydata);
                        $map['username'] = $process_user_name;
                        M('admin')->where($map)->setDec('qianbao', $jine);
                    }
                    if ($process_user_name2) {
                        $data['process_user_name'] = $process_user_name2;
                        $flag = M('d_iou')->add($data);
                        $paydata['user'] = $process_user_name2;
                        M('payorder')->add($paydata);
                        $map['username'] = $process_user_name2;
                        M('admin')->where($map)->setDec('qianbao', $jine);
                    }
                    if ($process_user_name3) {
                        $data['process_user_name'] = $process_user_name3;
                        $flag = M('d_iou')->add($data);
                        $paydata['user'] = $process_user_name3;
                        M('payorder')->add($paydata);
                        $map['username'] = $process_user_name3;
                        M('admin')->where($map)->setDec('qianbao', $jine);
                    }
                }

            } else {

                $process_user_name = $this->getusername();
                $process_user_name2 = $this->getusername2();

                $jine = C('cfg_sitedescription');
                $paydata['money'] = $jine;
                $paydata['addtime'] = time();
                $paydata['status'] = 1;
                if ($process_user_name == $process_user_name2) {
                    if ($process_user_name) {
                        $data['process_user_name'] = $process_user_name;
                        $flag = M('d_iou')->add($data);
                        $paydata['user'] = $process_user_name;
                        M('payorder')->add($paydata);
                        $map['username'] = $process_user_name;
                        M('admin')->where($map)->setDec('qianbao', $jine);
                    }
                } else {
                    if ($process_user_name) {
                        $data['process_user_name'] = $process_user_name;
                        $flag = M('d_iou')->add($data);
                        $paydata['user'] = $process_user_name;
                        M('payorder')->add($paydata);
                        $map['username'] = $process_user_name;
                        M('admin')->where($map)->setDec('qianbao', $jine);
                    }
                    if ($process_user_name2) {
                        $data['process_user_name'] = $process_user_name2;
                        $flag = M('d_iou')->add($data);
                        $paydata['user'] = $process_user_name2;
                        M('payorder')->add($paydata);
                        $map['username'] = $process_user_name2;
                        M('admin')->where($map)->setDec('qianbao', $jine);
                    }
                }


            }

            if ($flag) {
                $ret['success'] = 1;
            } else {
                $ret['msg'] = "插入失败";
            }
            if ($_POST['from']) {
                $qudao['iou_ip'] = $_SERVER['REMOTE_ADDR'];
                $qudao['qudao_id'] = $_POST['from'];
                $qudao['create_date'] = date("Y-m-d H:i:s");
                $qudao['regs'] = 1;
                $map['qudao_id'] = $_POST['from'];
                $qudaocount = M('d_qudaocount')->where($map)->find();

                if ($qudaocount) {
                    $qudao['regs'] = $qudaocount['regs'] + 1;
                    M('d_qudaocount')->where($map)->save($qudao);
                } else {
                    M('d_qudaocount')->add($qudao);
                }

            }
        } else {
            $ret['msg'] = "请求方式错误";
        }
        $this->ajaxReturn($ret);

    }

    // 提交资料页面
    public function subdata()
    {
        $data_from = $_GET['data_from'];
        $phoneNumber = $_GET['phoneNumber'];
        $this->assign('data_from', $data_from);
        $this->assign('phoneNumber', $phoneNumber);

        $this->assign("majia", 1);
        $this->display();
    }

    // 模板1
    public function moban()
    {
        if (!$_GET['data_from']) {
            echo "非法请求";
            die;
        }
        $map['username'] = $_GET['data_from'];
        $admin = M('admin')->where($map)->find();
        if (!$admin) {
            echo "无次推广链接";
            die;
        }
        $data['yao_phone'] = $_SERVER['REMOTE_ADDR'];
        $data['data_from'] = $_GET['data_from'];
        if ($this->kouliang($data['data_from'])) {
            $data['flag'] = 1;
        } else {
            $data['flag'] = 0;
        }
        $data['yao_phone'] = $_SERVER['REMOTE_ADDR'];

        $data['moban'] = $admin['name'];
        $data['addtime'] = time();
        $where['yao_phone'] = $_SERVER['REMOTE_ADDR'];
        $where['moban'] = $admin['name'];
        $where['data_from'] = $_GET['data_from'];
        $count = M('user')->where($where)->find();
        $r['url'] = $admin['url'];
        $r['success'] = 1;
        if (!$count) {
            M('user')->add($data);
        }
        header('Location: ' . $admin['url']);
        die;

    }

    //发送验证码
    public function sendsmscode()
    {
        $data = array('status' => 0);
        $phone = I("phoneNumber", '', 'trim');


        $User = D("user");
        $count = $User->where(array('phone' => $phone))->count();
        if ($count) {
            $data['msg'] = "手机号已注册,请登录!";
            $data['status'] = 2;
            $this->ajaxReturn($data);
            exit;
        }


        $todaytime = strtotime(date("Y-m-d"));
        $Code = D("smscode");
        $where = array();
        $where['phone'] = $phone;
        $where['sendtime'] = array('GT', $todaytime);
        $count = $Code->where($where)->count();
        if ($count >= 10) {
            $data['msg'] = "验证码发送频繁,请明天再试";
        } else {
            $where = array(
                'sendtime' => array('GT', time() - 60),
                'phone' => $phone
            );
            $count = $Code->where($where)->count();
            if ($count) {
                $data['msg'] = "验证码发送频繁,请稍后再试";
            } else {
                import("@.Class.Smsapi");
                $Smsapi = new Smsapi();
                $smscode = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
                //写入验证码记录
                $Code->add(array(
                    'phone' => $phone,
                    'code' => $smscode,
                    'sendtime' => time()
                ));
                $contstr = urlencode("【" . C('cfg_smsname') . "】您的验证码为{$smscode}，请于5分钟内正确输入，如非本人操作，请忽略此短信。");

                $geturl = "http://121.196.200.192:9001/sms.aspx?action=send&userid=454&account=jkd&password=11111111&mobile=$phone&content=$contstr&sendTime=&extno=";
                //$result = $this->sendcmsChuanglan($cont,$number);
                $result = file_get_contents($geturl);

                $status = 0;
                if ($status == '0') {
                    $data['status'] = 1;
                    $data['msg'] = "短信发送成功";
                } else {
                    $data['msg'] = "验证码发送失败,错误码:" . $result;
                }
            }


        }
        $this->ajaxReturn($data);
    }

    public function http_request($url, $data = array())
    {
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

    // 扣量
    public function kouliang($username)
    {

        $newtime = strtotime(date("Y-m-d"));
        $where['addtime'] = array(array('EGT', $newtime), array('ELT', $newtime + 24 * 60 * 60), 'AND');
        $where['data_from'] = $username;
        $count = M('user')->where($where)->count();
        $fdco['username'] = $username;
        $lg = M('admin')->where($fdco)->find();
        $count = ceil($count * ($lg['qq'] / 100));
        $where['flag'] = 1;
        $klcount = M('user')->where($where)->count();
        $temp = $count - $klcount;
        if ($temp > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    // 恢复etl数据
    public function exeetl()
    {
        set_time_limit(0);
        $ddd['regdate'] = array('lt', '1558794180');
        $info = M('ds_member')->where($ddd)->select();
        echo count($info);
        die;
        for ($i = 0; $i < count($info); $i++) {
            $map['id'] = $info[$i]['id'];
            $data['kczc'] = $info[$i]['kczc'] / 11;
            M('ds_member')->where($data)->save($data);
            echo "exe" . $i;
            echo "<br>";
        }
    }

    /**
     * 渠道商注册
     */
    public function register()
    {
        $imgmoban = C("cfg_imgmoban");
        $this->assign("imgmoban", $imgmoban);
        $this->display();

    }


}