<?php

namespace Home\Controller;

use Think\Controller;

/**
 * @Author: Martin Zhou
 * @Version: 1.0.2
 * @Copyright Tencent Security Response Center (TSRC)
 * @Project  https://security.tencent.com/index.php/xsrc
*/

class GiftController extends PublicController{

    public function index(){
		
		$gift_model = M('gifts');
		$username = session('username');
		$uid = session('userId');
		$count  = $gift_model -> count();// 查询满足要求的总记录数
        $Post = new \Extend\Page($count,12);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $page_num = $Post->show();// 分页显示输出
		$gift = $gift_model -> limit($Post->firstRow.','.$Post->listRows) -> where('visible = 0') -> select();
		$account = M('member') -> field('jinbi') -> where(array('id'=>$uid)) -> find();
        $this->assign('gift',$gift);
		$this->assign('page',$page_num);
		$this->assign('username',$username);
		$this->assign('account',$account);
        $this->display();
		
    }


    public function sortdata()
    {
        $operation = I('post.operation');
        $category = I('post.category',0,'magic_quotes');
		$price_start = I('post.start',0,'int');
		$price_end = I('post.end',0,'int');
		$raw_order_val = I('post.order',0,'magic_quotes');
		$user_id = session('userId');
		$order_val = 'id desc';
        switch ($operation){
            case "category":
                $map['category']  = array('LIKE',$category);
                break;
            case "price":
                $map['price']  = array('BETWEEN',array($price_start,$price_end));
                break;
            case "redeem":
				$user_score = M('member') -> field('jinbi') -> where(array("id"=>$user_id)) -> find();
                $map['price']  = array('BETWEEN',array(0,$user_score['jinbi']));
                break;   
			case "order":
				if ($raw_order_val == "asc"){
					$order_val = 'price asc';
				} else{
					$order_val = 'price desc';
				}
                break;   
        }
        //通过field函数，在其中使用sum()对score字段相加。
		//var_dump($map);
		//exit();
        $gift_result = M('gifts') -> field('id,category,price,redeemed,stock,title,url,visible') -> where($map) -> where('visible = 0') -> order($order_val) -> select();
		if (!empty($gift_result)){
			$final_gift_result['status'] = '1';
			$final_gift_result['result'] = $gift_result;
			$this -> ajaxReturn ($final_gift_result,'JSON');
		} else {
			$final_gift_result['status'] = '2';
			$final_gift_result['result'] = $gift_result;
			$this -> ajaxReturn ($final_gift_result,'JSON');
		}
    }
	
}