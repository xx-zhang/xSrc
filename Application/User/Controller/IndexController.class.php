<?php
namespace User\Controller;
use Think\Controller;

/**
 * @Author: Martin Zhou
 * @Version: 1.0.2
 * @Copyright Tencent Security Response Center (TSRC)
 * @Project  https://security.tencent.com/index.php/xsrc
*/

class IndexController extends BaseController {
    public function index(){
		$id = session('userId');
		$username = session('username');
		$pnum = M('post')->where('user_id='.$id)->count();
		$binfo = M('member')->where(array('id'=>$id))->find();
		$gift = M('order')->where(array('username'=>$username,'userid'=>$id))->count();
		$page = M('page')->select();
        $post = M('post')-> where(array('user_id'=>$id)) -> limit(5)-> order('post.id DESC') ->select();
		$message  = M('message') -> where(array('userid'=>$id, 'read'=>'0'))-> count();
		$username = session('username');
        $this->assign('username', $username);
        $this->assign('pnum',$pnum);
		$this->assign('binfo',$binfo);
		$this->assign('gift',$gift);
		$this->assign('page',$page);
        $this->assign('model',$post);
		$this->assign('message',$message);
        $this->display();
    }
}