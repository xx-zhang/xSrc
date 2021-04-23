<?php
namespace Install\Controller;
use Think\Controller;

/**
 * @Author: Martin Zhou
 * @Version: 1.0.2
 * @Copyright Tencent Security Response Center (TSRC)
 * @Project  https://security.tencent.com/index.php/xsrc
*/

class PublicController extends Controller{
    
    public function _initialize(){
		
		if (time() - session('install_key') > 600000) {
			session_destroy();
		}
		
    }
}
?>