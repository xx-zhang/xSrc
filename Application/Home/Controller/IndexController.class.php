<?php

namespace Home\Controller;

use Think\Controller;

/**
 * @Author: Martin Zhou
 * @Version: 1.0.2
 * @Copyright Tencent Security Response Center (TSRC)
 * @Project  https://security.tencent.com/index.php/xsrc
*/

class IndexController extends PublicController{

    public function index(){
		$model = D('HallView');
		$amodel = M('page');
		$beginThismonth= mktime(0,0,0,date('m'),1,date('Y'));
        $endThismonth = mktime(23,59,59,date('m'),date('t'),date('Y'));
        $map['time']  = array('BETWEEN',array($beginThismonth,$endThismonth));
		$hall = $model -> where($map) -> field('username,team,sum(points),pid,avatar,create_at') -> group('user_id') -> where('score > 0 and email <> \'0\'') -> order("score desc") -> limit(3) -> select();
		$gift = M('gifts') -> where('visible = 0') -> order("id desc") -> limit(4) -> select();
		$advisories = $amodel ->  order("id desc") -> limit(2) ->select();
        $username = session('username');
        $this->assign('username', $username);
        $this->assign('hall', $hall);
		$this->assign('advisories', $advisories);
		$this->assign('gift', $gift);
        $this->display();
    }
	
	
}
