<?php
namespace User\Controller;
use Think\Controller;

/**
 * @Author: Martin Zhou
 * @Version: 1.0.2
 * @Copyright Tencent Security Response Center (TSRC)
 * @Project  https://security.tencent.com/index.php/xsrc
*/

class RegController extends Controller{
	
    public function index()
    {
		$tmodel= M('setting');
		$title = $tmodel->where('id=1')->select();
		$this->assign('title', $title);
		$this->display();
    }
  
    /**
     * 用户注册
     */
    public function add(){
        if (!IS_POST) {
            $this->display();
        }
		
        if (IS_POST) {
			$data['salt'] = "";
			$data['pid'] = "";
			$chars = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$pchars = '0123456789';
			for($num=0;$num<8;$num++){
				$RandNum = rand(0,strlen($chars)-1);  
				$data['salt'] .= $chars[$RandNum]; 
			}
			
			for($num=0;$num<32;$num++){
				$RandNum = rand(0,strlen($pchars)-1);  
				$data['pid'] .= $pchars[$RandNum]; 
			}         	
					
			$data['username'] = I('username');
			$data['email']= I('email','','validate_email');
			$data['password'] = I('password');
			$repassword= I('repassword');
			
			if(strlen($data['username']) > 20){ $this->error("用户名长度超过20个字符"); }
			
			if(strlen($data['password']) < 8){ $this->error("为了保证帐户安全，请输入大于八位数的密码!");}
			
			if($data['password'] != $repassword){ $this->error("两次密码不一致");}
		
			$code = I('verify','','strtolower');
		
			if(!($this->check_verify($code))){
				$this->error('验证码错误');
			}

			$data['password'] = md5(md5(md5($data['salt']).md5($data['password'])."SR")."CMS"); //“SR”和“CMS”可修改
			$data['create_at']=time();
			$model = M("Member");
		
			if ($model->where(array('username'=>$data['username']))->find()){
				 $this->error('用户名重复');
			}
			if ($model->where(array('email'=>$data['email']))->find()){
				 $this->error('邮箱重复');
			}
			
			if ($model->field('username,email,pid,salt,password,create_at')->data($data)->add()) {
	
				$user = $model->where(array('username'=>$data['username']))->find();		

				$date =array(
					'id' => $user['id'],
					'update_at' => time(),
					'login_ip' => get_client_ip(),
				);
        
				if($model->save($date)){
					$this->redirect('index/index');
				}	
		
            } else {
                $this->error("注册失败");
            }
        }
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
}
