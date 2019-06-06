<?php
/*
/url:http://www.sucaihuo.com/php/165.html
*/

class ConfigAction extends CommonAction {

		

    public function dbbak(){
            $DataDir = "databak/";
            mkdir($DataDir);

            if (!empty($_GET['Action'])) {
                // import("Common.Org.MySQLReback");
				  import("@.Class.MySQLReback");
                  $config = array(
                       'host' => C('DB_HOST'),
                       'port' => C('DB_PORT'),
                       'userName' => C('DB_USER'),
                       'userPassword' => C('DB_PWD'),
                       'dbprefix' => C('DB_PREFIX'),
                       'charset' => 'UTF8',
                       'path' => $DataDir,
                       'isCompress' => 0, //是否开启gzip压缩
                       'isDownload' => 0
                        );

                $mr = new MySQLReback($config);
                $mr->setDBName(C('DB_NAME'));
                if ($_GET['Action'] == 'backup') {
                      $mr->backup();
                      $this->success( '数据库备份成功！',U("Config/dbbak"),1);
                } elseif ($_GET['Action'] == 'RL') {
                      $mr->recover($_GET['File']);
                      $this->success( '数据库还原成功！',U("Config/dbbak"),1);
                } elseif ($_GET['Action'] == 'Del') {
                      if (@unlink($DataDir . $_GET['File'])) {
                          $this->success('删除成功！',U("Config/dbbak"));
                      } else {
                          $this->error('删除失败！',U("Config/dbbak"));
                      }
                }

                if ($_GET['Action'] == 'download') {
                    function DownloadFile($fileName) {
                            ob_end_clean();
                            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                            header('Content-Description: File Transfer');
                            header('Content-Type: application/octet-stream');
                            header('Content-Length: ' . filesize($fileName));
                            header('Content-Disposition: attachment; filename=' . basename($fileName));
                            readfile($fileName);
                    }
                    DownloadFile($DataDir . $_GET['file']);
                    exit();
                }
            }
			$adminlogin = session('Admin_login');
			$this->assign('adminlogin',$adminlogin);
            $file_list= $this->MyScandir('databak/');
            $this->assign("datadir",$DataDir);
            $this->assign("file_list", $file_list);
            $this->assign("title"," 备份数据库-借贷管理系统");
            $this->display();
    }

    private function MyScandir($FilePath = './', $Order = 0) {
        $FilePath = opendir($FilePath);
        while (false !== ($filename = readdir($FilePath))) {
            $FileAndFolderAyy[] = $filename;
        }

        $Order == 0 ? sort($FileAndFolderAyy) : rsort($FileAndFolderAyy);
        return $FileAndFolderAyy;
    }
}

