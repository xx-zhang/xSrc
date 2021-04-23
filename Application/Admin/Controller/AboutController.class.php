<?php
namespace Admin\Controller;
use Admin\Controller;

/**
 * @Author: Martin Zhou
 * @Version: 1.0.2
 * @Copyright Tencent Security Response Center (TSRC)
 * @Project  https://security.tencent.com/index.php/xsrc
 */

class AboutController extends BaseController
{
    /**
     * 漏洞报告列表
     */
    public function index()
    {
	$this -> display();
	}
}