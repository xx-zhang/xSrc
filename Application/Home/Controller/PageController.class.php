<?php

namespace Home\Controller;

use Think\Controller;

/**
 * @Author: Martin Zhou
 * @Version: 1.0.2
 * @Copyright Tencent Security Response Center (TSRC)
 * @Project  https://security.tencent.com/index.php/xsrc
*/

class PageController extends PublicController{

    public function index()
    {
        $model = M('page');
		$count  = $model->count();	
		$Post = new \Extend\Page($count,15);
		$show = $Post->show();
		$pages = $model->limit($Post->firstRow.','.$Post->listRows)->order('id DESC')->select();
        $username = session('username');
        $this->assign('username', $username);
        $this->assign('model', $pages);
		$this->assign('page',$show);
        $this->display();     
    }


    public function view(){
		$id = I('get.id',0,'int');
        $model = M('page')->where(array('id'=>$id))->find();
        $username = session('username');
        $this->assign('username', $username);
        $this->assign('model',$model);
        $this->display();
    }
}
