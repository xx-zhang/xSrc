<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * @Author: Martin Zhou
 * @Version: 1.0.2
 * @Copyright Tencent Security Response Center (TSRC)
 * @Project  https://security.tencent.com/index.php/xsrc
*/

class CheckController extends Controller
{

    public function htmlview(){
		$id = I('get.session_id');
		$restriction['visible'] = array('EQ','1');
		$restriction['session'] = array('NEQ','0');
        $model = M('post')->where($restriction)->where(array('session'=>$id))->find();
        $this->assign('model',$model);
		$this->display();
    }
	
}