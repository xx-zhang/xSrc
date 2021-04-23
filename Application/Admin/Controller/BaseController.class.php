<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * @Author: Martin Zhou
 * @Version: 1.0.2
 * @Copyright Tencent Security Response Center (TSRC)
 * @Project  https://security.tencent.com/index.php/xsrc
*/

class BaseController extends Controller {
    public function _initialize(){
        $sid = session('adminId');
        
		if(empty($sid)) {
            redirect(U('Login/index'));
        }
		
		if(!empty($sid)) {
			$token = M('manager') -> where(array('id'=>$sid))-> field('token') -> find();
			session('token',$token['token']);
		}
		
		if (file_exists('install.php')){
			session('adminId',null);
			session('adminname',null);
			session('token',null);
			$this -> error("为保障安全，请删除或重命名install.php再登陆！");
		}
		
		if (time() - session('session_duration') > C('SESSION_OPTIONS')['expire']) {
			session_destroy();
            redirect(U('Login/index'));
		}

    }
}