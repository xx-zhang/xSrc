<?php
namespace User\Controller;
use Think\Controller;

/**
 * @Author: Martin Zhou
 * @Version: 1.0.2
 * @Copyright Tencent Security Response Center (TSRC)
 * @Project  https://security.tencent.com/index.php/xsrc
*/

class MessageController extends BaseController {
    public function index(){
		$message_model = M('message');
		$username = session('username');
		$userid = session('userId');
		$count  = $message_model -> where(array('userid'=>$userid, 'read'=>'0'))-> count();
        $Post = new \Extend\Page($count,20);
        $page_num = $Post->show();
		$message = $message_model -> limit($Post->firstRow.','.$Post->listRows) -> where(array('userid'=>$userid)) ->order('time desc')-> select();
		$tmodel= M('setting');
		$settings = $tmodel -> where('id=1') -> select();
        $this->assign('settings', $settings);
        $this->assign('message',$message);
		$this->assign('page',$page_num);
		$this->assign('username',$username);
		$this->assign('count',$count);
        $this->display();
    }
	
	public function readed(){
		$messgae_id = I('post.mid',0,'int');
		$userid = session('userId');
		$change['read'] = '1';
		$message_result = M('message') -> where(array('userid'=>$userid,'id'=>$messgae_id)) -> save($change);
		$message_num = M('message') -> where(array('userid'=>$user['id'],'read'=>0)) -> count();
		if($message_result){
			$json_result['status'] = '1';
			session('mnum',$message_num);
			$this -> ajaxReturn ($json_result,'JSON');
		} else{
			$json_result['status'] = '2';
			$this -> ajaxReturn ($json_result,'JSON');
		}
    }
}