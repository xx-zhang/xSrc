<?php
namespace User\Controller;
use Think\Controller;

/**
 * @Author: Martin Zhou
 * @Version: 1.0.2
 * @Copyright Tencent Security Response Center (TSRC)
 * @Project  https://security.tencent.com/index.php/xsrc
*/


class LoginController extends Controller {
    /**
    登陆页面
    **/
    public function index(){
		$tmodel= M('setting');
		$title = $tmodel->where('id=1')->select();
		$this->assign('title', $title);
        $this->display();
    }
	
    /**
    登陆验证
    **/
    public function login(){
        if(!IS_POST){$this->error("非法请求");}
        $member = M('member');
		$email = I('email','','email');
        $password = I('password');
		$code = I('verify','','strtolower');
		
		if(!($this->check_verify($code))){
		   session('userId',null);
		   session('username',null);
           $this->error('验证码错误',U('Login/index'));
        }
		
        $user = $member->where(array('email'=>$email))->find();

		if($user['password'] != md5(md5(md5($user['salt']).md5($password)."SR")."CMS")) {
		   $this->error('账户或密码错误',U('Login/index'));
        }
		
        if($user['status'] == 0){
            $this->error('账号被删除或禁用，请联系管理员 :(') ;
        }
		$token = md5(md5($user['email'].time()).time());
        //更新登陆信息
        $data =array(
            'id' => $user['id'],
            'update_at' => time(),
            'login_ip' => get_client_ip(),
			'token' => $token 
            //2017-07-02 fix bug: token can't be inserted into databease. By. yuyang
        );
        //登陆成功
		$message_num = M('message') -> where(array('userid'=>$user['id'],'read'=>0)) -> count();
		
        if($member->save($data)){
		    /**session('token',$token);
            $this->success("请先完成验证",U('Login/svalid?email=').$user['email']);
			**/
			session('token',$token);
			session('userId',$user['id']);
            session('username',$user['username']);
			session('avatar',$user['avatar']);
			session('mnum',$message_num);
			redirect('./index.php');
        }   

    }
	
	//验证码
    public function verify(){
		ob_clean();
        $Verify = new \Think\Verify();
        $Verify->codeSet = '123456789abcdefg';
        $Verify->fontSize = 16;
        $Verify->length = 4;
        $Verify->entry();
    }
	
    protected function check_verify($code){
        $verify = new \Think\Verify();
        return $verify->check($code);
    }

	
    //退出登录
    public function logout(){
        session('userId',null);
        session('username',null);
		session('avatar',null);
		session('mnum',null);
        redirect(U('Login/index'));
    }
}