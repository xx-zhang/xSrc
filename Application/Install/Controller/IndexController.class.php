<?php
namespace Install\Controller;
use Think\Controller;

/**
 * @Author: Martin Zhou
 * @Version: 1.0.2
 * @Copyright Tencent Security Response Center (TSRC)
 * @Project  https://security.tencent.com/index.php/xsrc
*/

class IndexController extends Controller{

    public function index(){
        $this->display();
    }
	
	public function setup_mysql(){
		$host = I('post.host');
		$host = urldecode($host);
		$db = I('post.db');
		$db_user = I('post.user');
		$db_pwd = I('post.pwd');

		if (file_exists('install.lock')){
			$this -> error("请删除install.lock重新开始安装。");
		}
		
		if(!preg_match("/^([a-zA-Z0-9]+\.*)+:+[0-9]+$/",$host)){
			$this -> error("服务器地址格式错误");
		}
		
		if(!preg_match("/^[a-zA-Z0-9_-]+$/",$db)){
			$this -> error("数据库名格式错误");
		}

		if(!preg_match("/^[a-zA-Z0-9_-]+$/",$db_user)){
			$this -> error("数据库用户格式错误");
		}

		if(!preg_match("/^[a-zA-Z0-9_!@-^]+$/",$db_pwd)){
			$this -> error("数据库密码格式错误");
		}

		if(try_mysql($host,$db,$db_user,$db_pwd)){
			$ip = explode(":", $host)[0];
			$port = explode(":", $host)[1];
			$trace_file = fopen("./Application/Common/Conf/db.php", "w");
			$setup_content = "<?php\nreturn array('DB_TYPE'               =>  'mysql',\n'DB_HOST'               =>  '".$ip."',\n'DB_NAME'               =>  '".$db."',\n'DB_USER'               =>  '".$db_user."',\n'DB_PWD'                =>  '".$db_pwd."',\n'DB_PORT'               =>  '".$port."',\n'DB_FIELDS_CACHE'       =>  true,\n'DB_CHARSET'            =>  'utf8',\n);";
			fwrite($trace_file, $setup_content);
			fclose($trace_file);
		};
		
		$lock_file = fopen("./install.lock", "w") or die("Unable to open file!");
		fwrite($lock_file, "2");
		fclose($lock_file);
		
		$install_key = sha1(time().mt_rand(0,9).mt_rand(0,9).mt_rand(0,9));
		session('install_key',$install_key);
		cookie('install_key',$install_key);
		
		$result['code'] = '200'; 
		$this->ajaxReturn($result,'JSON'); 
			
	}
	
	public function setup_account(){
		
		$username = I('post.username');
		$email = I('post.email',0,'email');
		$password = I('post.password');
		$password = md5($password);

		$lock_file = fopen("./install.lock", "r") or die("Unable to open file!");
		$file_content = fread($lock_file,filesize("./install.lock"));
		fclose($lock_file);
				
		if($file_content!="2"){
			$this -> error("非法安装请求");
		}
		
		$cookie_install_key = cookie('install_key');
		$session_install_key = session('install_key');
		
		if($cookie_install_key!=$session_install_key){
			$this -> error("非法安装请求");
		}
		
		if(!preg_match("/^[a-zA-Z0-9_-]+$/",$username)){
			$this -> error("用户名格式错误");
		}

		if(!preg_match("/^[a-zA-Z0-9]+$/",$password)){
			$this -> error("用户密码格式错误");
		}
		
		$user['username'] = $username;
		$user['password'] = $password;
		$user['email'] = $email;
		$user['create_at'] = time();
		$mysql_result = M('manager') -> add($user);
		
		if($mysql_result){
			$lock_file = fopen("./install.lock", "w") or die("Unable to open file!");
			fwrite($lock_file, "3");
			fclose($lock_file);
			$result['code'] = '200'; 
			$this->ajaxReturn($result,'JSON'); 
		}
		
	}
	
	public function setup_smtp(){
		
		$smtp_server = I('post.server');
		$smtp_email = I('post.email',0,'email');
		$smtp_password = I('post.password');
		$smtp_port= I('post.port');

		$lock_file = fopen("./install.lock", "r") or die("Unable to open file!");
		$file_content = fread($lock_file,filesize("./install.lock"));
		fclose($lock_file);
		
		if($file_content!="3"){
			$this -> error("非法安装请求");
		}

		$cookie_install_key = cookie('install_key');
		$session_install_key = session('install_key');
		
		if($cookie_install_key!=$session_install_key){
			$this -> error("非法安装请求");
		}
		
		if(!preg_match("/^([a-zA-Z0-9]+\.*)+$/",$smtp_server)){
			$this -> error("SMTP服务器格式错误");
		}
		
		if(!preg_match("/^[a-zA-Z0-9]+$/",$smtp_password)){
			$this -> error("SMTP密码错误");
		}

		if(!preg_match("/^[a-zA-Z0-9]+$/",$smtp_port)){
			$this -> error("SMTP端口错误");
		}
		
		$notify_email = M('manager') -> where('id=1') -> find();
		
		$ip = explode(":", $host)[0];
		$port = explode(":", $host)[1];
		$trace_file = fopen("./Application/Common/Conf/config.php", "w");
		$setup_content = "<?php\nreturn array(\n'MODULE_ALLOW_LIST' => array('Home','Admin',),\n'LOAD_EXT_CONFIG'   => 'db',\n'URL_CASE_INSENSITIVE'  =>  true,\n'URL_MODEL'   =>0,\n'URL_HTML_SUFFIX'  =>'html',\n'SHOW_ERROR_MSG' =>  true,\n'MAIL_ADDRESS'=>'".$smtp_email."',\n'MAIL_SMTP'=>'".$smtp_server."',\n'MAIL_LOGINNAME'=>'".$smtp_email."',\n'MAIL_PASSWORD'=>'".$smtp_password."',\n'MAIL_CHARSET'=>'UTF-8',\n'MAIL_AUTH'=>true,\n'MAIL_HTML'=>true,\n'NOTIFY_EMAIL'=>'".$notify_email['email']."',\n'COOKIE_HTTPONLY'  =>  1,\n'REQUEST_VARS_FILTER' => true,\n'MAIL_PORT'=>'". $smtp_port ."',\n'MAIL_SMTPSECURE'=>'ssl','\nLOG_RECORD' => false,\n'LOG_EXCEPTION_RECORD'  => false,\n);";
		fwrite($trace_file, $setup_content);
		fclose($trace_file);
		
		$lock_file = fopen("./install.lock", "w") or die("Unable to open file!");
		fwrite($lock_file, "4");
		fclose($lock_file);
		remove_dir('./Application/Runtime/');
		
		session('install_key',null);
		
		$result['code'] = '200'; 
		$this->ajaxReturn($result,'JSON'); 

	}
	
	public function check_installed(){
		if (file_exists("install.lock")){
			$result['code'] = '500'; 
			$this->ajaxReturn($result,'JSON'); 
		} else{
			$result['code'] = '200'; 
			$this->ajaxReturn($result,'JSON'); 
		}
	}
	
}
