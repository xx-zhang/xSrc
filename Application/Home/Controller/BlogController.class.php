<?php

namespace Home\Controller;

use Think\Controller;

/**
 * @Author: Martin Zhou
 * @Version: 1.0.2
 * @Copyright Tencent Security Response Center (TSRC)
 * @Project  https://security.tencent.com/index.php/xsrc
*/

class BlogController extends PublicController{

    public function index()
    {
		$type = I('get.type');
		$blog_model = M('blog');
		$tmodel= M('setting');

		if($type != NULL){		
			$count  = $blog_model->where(array('name'=>$type))->count();	
			$Post = new \Extend\Page($count,15);
			$show = $Post->show();
			$pages = $blog_model->where(array('name'=>$type))->limit($Post->firstRow.','.$Post->listRows)->order('update_time DESC')->select();
		} else{
			$count  = $blog_model->count();	
			$Post = new \Extend\Page($count,15);
			$show = $Post->show();
			$pages = $blog_model->limit($Post->firstRow.','.$Post->listRows)->order('update_time DESC')->select();		
		}	
		
		$cates = $blog_model->group('name')->field('name')->select();
		$recommend = $blog_model->limit(10)->order('update_time desc')->select();
		$banner = $blog_model->limit(3)->order('update_time desc')->select();
		
        $username = session('username');
		
        $this->assign('model', $pages);
		$this->assign('banner', $banner);
		$this->assign('page',$show);
		$this->assign('recommend',$recommend);
		$this->assign('cates', $cates);
		$this->assign('type_val', $type);
        $this->assign('username', $username);
        $this->display();
		
    }


    public function view(){
		$id = I('get.id',0,'int');
        $model = M('blog')->where(array('id'=>$id))->find();
        $username = session('username');
        $this->assign('model',$model);
        $this->assign('username', $username);
        $this->display();
    }
}
