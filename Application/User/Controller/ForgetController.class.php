<?php
namespace User\Controller;
use Think\Controller;

/**
 * @Author: Martin Zhou
 * @Version: 1.0.2
 * @Copyright Tencent Security Response Center (TSRC)
 * @Project  https://security.tencent.com/index.php/xsrc
*/

class ForgetController extends Controller {
    //显示找回密码页面
    public function index(){
        $this->display();
    }
	//验证码
    public function verify(){
		ob_clean();
        $Verify = new \Think\Verify();
        $Verify->codeSet = '123456789abcdefghijklmnopqrst';
        $Verify->fontSize = 20;
        $Verify->length = 4;
        $Verify->entry();
    }
    protected function check_verify($code){
        $verify = new \Think\Verify();
        return $verify->check($code);
    }
    //找回密码逻辑
    public function find(){
        if(!IS_POST)$this->error("非法请求");
        $member = M('member');
        $email =I('post.email','','email');
		$username =I('post.username');
        $code = I('verify','','strtolower');
        //验证验证码是否正确
        if(!($this->check_verify($code))){
            $this->error('验证码错误');
        }
        //验证输入邮箱是否存在
        $user = $member->where(array('username'=>$username,'email'=>$email))->find();
		$salt = $member->where(array('email'=>$email,'username'=>$username))->find();
		
        if(!$user) {
            $this->error('邮箱不存在 :(') ;
        }
        //验证账户是否被禁用
        if($user['status'] == 0){
            $this->error('账号被禁用，无法找回密码 :(') ;
        }
         
		if($user['type'] == 2){
            $this->error('前台无法重置管理员密码 :(') ;
        }
		
		//发送验证码邮件
        $str = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		mt_srand();
        $passwd=$str[mt_rand(0,61)].$str[mt_rand(0,61)].$str[mt_rand(0,61)].$str[mt_rand(0,61)].$str[mt_rand(0,61)].$str[mt_rand(0,61)].$str[mt_rand(0,61)].$str[mt_rand(0,61)].$str[mt_rand(0,61)].$str[mt_rand(0,61)];
        $content = md5(md5(md5($salt['salt']).md5($passwd)."SR")."CMS");
		$member = M('member');
		$member-> password=$content;
		$member ->where(array('username'=>$username,'email'=>$email))->save();
        $con='尊敬的'.$username.':<br/>您正在找回密码，您的临时新密码为 <b>'.$passwd.'</b> 请妥善保管，登陆平台后请及时修改密码。';  
        if(SendMail($email,'找回密码',$con,'应急响应中心')){
			$this->success("发送成功",U('login/index'));
        }else{  
			$this->error('密码找回邮件发送失败，请重试 :(') ;
        }  

    }
	
}