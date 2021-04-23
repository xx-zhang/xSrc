<?php
namespace User\Controller;
use Think\Controller;

/**
 * @Author: Martin Zhou
 * @Version: 1.0.1
 * @Copyright Tencent Security Response Center (TSRC)
 * @Project  https://security.tencent.com/index.php/xsrc
*/

class GiftController extends BaseController{

    public function index(){
		
		$gift_model = M('gifts');
		$username = session('username');
		$uid = session('userId');
		$count  = $gift_model -> count();
        $Post = new \Extend\Page($count,20);
        $page_num = $Post->show();
		$gift = $gift_model -> limit($Post->firstRow.','.$Post->listRows) -> where('visible = 0') -> select();
		$tmodel= M('setting');
		$settings = $tmodel -> where('id=1') -> select();
		$account = M('member') -> field('jinbi') -> where(array('id'=>$uid)) -> find();
        $this->assign('settings', $settings);
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
		
        $gift_result = M('gifts') -> where($map) -> where('visible = 0') -> order($order_val) -> select();
		
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
	
	public function item(){
		
		$gift_model = M('gifts');
		$username = session('username');
		$gift_id = I('get.gid',0,'intval');
		$single_gift = $gift_model -> where(array('id'=>$gift_id)) -> find();
		$recommend_gift = $gift_model -> order('id desc') -> limit(4) -> select();
        $this->assign('gift',$single_gift);
		$this->assign('recommend',$recommend_gift);
		$this->assign('username',$username);
        $this->display();
		
    }
		
	 public function order(){
		$id = session('userId');
		$username = session('username');
        $db = M('order');
        $count  = $db -> count();
        $Page = new \Extend\Page($count,20);
		$show = $Page->show();
		$info = $db -> where(array('username'=>$username,'userid'=>$id)) -> limit($Page->firstRow.','.$Page->listRows) -> order('id desc') -> select();
		$order_num = $db -> where(array('username'=>$username,'userid'=>$id)) -> count();
		$this->assign('username',$username);
		$this->assign('info',$info);
        $this -> assign('page',$show);
		$this -> assign('order_num',$order_num);
        $this->display();
    }
	
	
    public function record(){
		$id = session('userId');
        $db = M('record');
		$username = session('username');
        $count  = $db -> count();
        $Page = new \Extend\Page($count,15);
		$show = $Page->show();           
		$record = $db -> where(array('user'=>$username,'userid'=>$id)) -> limit($Page->firstRow.','.$Page->listRows) -> order('time desc') -> select();
		$account = M('member') -> field('jinbi') -> where(array('id'=>$id)) -> find();
        $this->assign('username', $username);
		$this -> assign('record',$record);
        $this -> assign('page',$show);
		$this -> assign('account',$account);
        $this -> display();
    }
	
	
	public function add()
    {
		$id = session('userId');
		$gid = I('get.gid',0,'int');
		$post_gid = I('post.gid',0,'int');
		$number = I('post.number',0,'int');
		$address_id = I('post.address',0,'int');
		$token = I('post.token',0);
		
        if (!IS_POST) {
            $info = M('address') -> where(array('userid'=>$id)) -> select();
			$default_address = M('address') -> where(array('userid'=>$id)) -> where(array('default'=>1)) -> select();
			$gift = M('gifts') -> where(array('id'=>$gid)) -> find();
			$account = M('member') -> field('jinbi,token') -> where(array('id'=>$id)) -> find();
			$iniprice = $account['jinbi'] - $gift['price'];
			$username = session('username');
			$this->assign('username',$username);
            $this->assign('info',$info);
			$this->assign('gift',$gift);
			$this->assign('default',$default_address);
			$this->assign('account',$account);
			$this->assign('iniprice',$iniprice);
            $this->display();
        }
		
        if (IS_POST) {
			
            $model = M("order") -> lock(true);
			$record = M('record');
			$user = M('member') -> where(array('id'=>$id)) -> find();
			$gift = M('gifts') -> where(array('id'=>$post_gid)) -> find();
			$total_price = $number * $gift['price'];
			
			if($user['jinbi'] < $total_price){
				$json_result['status'] = '2';
				$this -> ajaxReturn ($json_result,'JSON');
				exit();
			}
			
            if($number <= 0){
				$json_result['status'] = '2';
                $this -> ajaxReturn ($json_result,'JSON');
                exit();
            }
			
			$address = M('address') -> where(array('id'=>$address_id,'userid'=>$id)) -> find();
			
			if ($address == NULL){
				$json_result['status'] = '2';
				$this -> ajaxReturn ($json_result,'JSON');
				exit();
			}
			
			$data['realname'] = $address['realname'];
			$data['tel'] = $address['mobile'];
			$data['address'] = $address['adetail'];
			$data['num'] = $number;
			$data['gid'] = $gift['title']; 
			$data['price'] = $gift['price']; 
			$data['username'] = session('username');
			$data['userid'] = session('userId');
			$data['update_time'] = time();
			
			//记录兑换安全币变动日志
			//type字段为2表示扣除积分
			$rdata['type'] = 2;  
			$rdata['name'] = '兑换'.$gift['title'];
            $rdata['num'] = '数量:'.$gift['num'];
			$rdata['content'] = '-安全币:'.$total_price;
			$rdata['time'] = time();
			$rdata['user'] = session('username');
			$rdata['userid'] = session('userId');
			$rdata['operator'] = session('username');
			
			$record_result = $record -> add($rdata);
						
			if($token != $user['token']){
				$json_result['status'] = '2';
				$this -> ajaxReturn ($json_result,'JSON');
				exit();
			}
						
            if (M('member') -> lock(true) -> where(array('id'=>$id)) -> setDec('jinbi',$total_price)) {
				
				$order_result = $model -> field('userid,username,gid,tel,realname,address,price,update_time,num') -> add($data);
				
				if($order_result){
					
					$json_result['status'] = '1';
					
					// 兑换成功后，扣除库存
					M('gifts') -> lock(true) -> where(array('id'=>$post_gid)) -> setDec('stock', 1);
					
					$this -> ajaxReturn ($json_result,'JSON');
					exit();
					
				} else{
					
					M('member') -> lock(true) -> where(array('id'=>$id)) -> setInc('jinbi',$total_price);
					$json_result['status'] = '2';
					$this -> ajaxReturn ($json_result,'JSON');
					exit();
				}
				
            } else {
					$json_result['status'] = '2';
					$this -> ajaxReturn ($json_result,'JSON');
					exit();
            }
		}
	}
    
    public function detail(){
        $id = session('userId');
		$oid = I('get.oid',0,'intval');
        $detail = M("order") -> where(array('id'=>$oid,'userid'=>$id)) -> find();
        $this -> assign('detail',$detail);
        $this -> display();
    }
	
	public function confirm(){
        $id = session('userId');
		$oid = I('post.oid',0,'int');
		$data['finish'] = '2';
        $confirm_result = M("order") -> where(array('id'=>$oid,'userid'=>$id)) -> save($data);
		if ($confirm_result){
			$json_result['status'] = '1';
			$this -> ajaxReturn ($json_result,'JSON');
		} else{
			$json_result['status'] = '2';
			$this -> ajaxReturn ($json_result,'JSON');
		}
    }
}