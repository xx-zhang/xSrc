<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * @Author: Martin Zhou
 * @Version: 1.0.2
 * @Copyright Tencent Security Response Center (TSRC)
 * @Project  https://security.tencent.com/index.php/xsrc
*/

class LoginController extends Controller {

    public function index(){
        $this->display();
    }
	
    public function login(){
        if(!IS_POST)$this->error("非法请求");

        $manager_model = M('manager');
		$email =I('email','','email');
        $password =I('password','','md5');
        $code = I('verify','','strtolower');
		
		// 默认重命名安装程序
		if (file_exists('install.php')){
			rename('install.php','install.php.locked');
		}

        //验证验证码是否正确
        if(!($this->check_verify($code))){
            $this->error('验证码错误');
        }
        //验证账号密码是否正确
        $user = $manager_model -> where(array('email'=>$email,'password'=>$password))->find();
		
        if(!$user) {
            $this->error('账号或密码错误') ;
        }
        //验证账户是否被禁用
        //if($user['status'] == 0){
        //    $this->error('账号被禁用，请联系超级管理员 :(') ;
        //}
        
		//验证是否为管理员
		if($user['type'] == 1){
            $this->error('您没权限登陆后台') ;
        }
		
        //更新登陆信息
		$token = md5($user['email'].time().$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)]);
        $data =array(
            'id' => $user['id'],
			'token' => $token,
            'update_at' => time(),
            'login_ip' => get_client_ip(),
        );
        
        //如果数据更新成功  跳转到后台主页
        if($manager_model->save($data)){
			//发送验证码邮件
			session('token',$token);
			session('adminId',$user['id']);
			session('adminname',$user['username']);
			session('session_duration', time());
			$this->redirect(U('Index/index'));
        }
        
    }
	
    //验证码
    public function verify(){
		ob_clean();
        $Verify = new \Think\Verify();
        $Verify->codeSet = 'AECDEFGHIGJ123456';
        $Verify->fontSize = 16;
        $Verify->length = 4;
        $Verify->entry();
    }
    protected function check_verify($code){
        $verify = new \Think\Verify();
        return $verify->check($code);
    }

    public function logout(){
		
		$token = I('get.token');
		$adminId = session('adminId');
		$manager = M('manager')-> where(array('id'=>$adminId)) -> find();
				
		if($token != $manager['token']){
			$this->error("非法请求");
		}
		
        session('adminId',null);
        session('adminname',null);
		session('token',null);
		session('session_duration',null);
        redirect(U('Login/index'));
    }
}