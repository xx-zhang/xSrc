<?php
namespace Home\Controller;
use Think\Controller;

/**
 * @Author: Martin Zhou
 * @Version: 1.0.2
 * @Copyright Tencent Security Response Center (TSRC)
 * @Project  https://security.tencent.com/index.php/xsrc
*/

class LoginController extends Controller {
    /**
    退出登录
    **/
    public function logout(){
        session('userId',null);
        session('username',null);
		session('avatar',null);
        redirect(U('index/index'));
    }
}