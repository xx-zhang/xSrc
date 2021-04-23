<?php
namespace Admin\Controller;
use Admin\Controller;
 
/**
 * @Author: Martin Zhou
 * @Version: 1.0.2
 * @Copyright Tencent Security Response Center (TSRC)
 * @Project  https://security.tencent.com/index.php/xsrc
*/

class OrderController extends BaseController
{
    public function index($key="")
    {
        if($key == ""){
            $model = M('order');  
        }else{
            $where['gid'] = array('like',"%$key%");
			$where['username'] = array('like',"%$key%");
            $where['realname'] = array('like',"%$key%");
			$where['finish'] = array('like',"%$key%");
            $where['_logic'] = 'or';
            $model = M('order')->where($where); 
        } 
        
        $count  = $model->where($where)->count();
        $Page = new \Extend\Page($count,20);
        $show = $Page->show();
        $pages = $model->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('id DESC')->select();
        $this->assign('model', $pages);
        $this->assign('page',$show);
		$this->assign('search_key',$key);
        $this->display();     
    }
	
    public function update()
    {
        if (!IS_POST) {
            $id = I('get.id',0,'intval');
            $model = M('order')->where(array('id'=>$id))->find();
			$uid = $model['userid'];
			$finfo = M('member')->where(array('id'=>$uid))->field('bankcode,idcode,wechat,jinbi')->find();
            $this->assign('model',$model);
			$this->assign('finfo',$finfo);
            $this->display();
        }
        if (IS_POST) {
            $model = D("order");
			
			/**Start--校验CSRF TOKEN**/
			$token = I('post.token');
			$adminId = session('adminId');
			$manager = M('manager')-> where(array('id'=>$adminId)) -> find();
				
			if($token != $manager['token']){
				$this->error("非法请求");
			}
			/**End--校验CSRF TOKEN**/	
			
            if (!$model->create()) {
                $this->error($model->getError());
            }else{
                if ($model->save()) {
                    $this->success("订单更新成功", U('order/index'));
                } else {
                    $this->error("订单更新失败");
                }        
            }
        }
    }
    
    /**
    订单发货
    **/
    public function ship()
    {
        if (IS_POST) {
            $model = D("order");
			$data = I('post.');
			
			/**Start--校验CSRF TOKEN**/
			$token = I('post.token');
			$adminId = session('adminId');
			$manager = M('manager')-> where(array('id'=>$adminId)) -> find();
				
			if($token != $manager['token']){
				$this->error("非法请求");
			}
			/**End--校验CSRF TOKEN**/	

			if($data['finish']=='1'){
				$message_content['userid'] = $data['userid'];
				$message_content['sender'] = session('adminname');
				$message_content['content'] = '您兑换的【'.$data['gid'].'】已发货，请注意查收。';
				$message_content['type'] = '系统消息';
			} else {
				$message_content['userid'] = $data['userid'];
				$message_content['sender'] = session('adminname');
				$message_content['content'] = '关于【'.$data['gid'].'】的订单近期有变动，请注意查看。';
				$message_content['type'] = '系统消息';
			}
            if (!$model->create()) {
                $this->error($model->getError());
            }else{
                if ($model->save()) {
					$add_message_result = M('message') -> add($message_content);
					if ($add_message_result){
						$this->success("订单状态更新成功", U('order/index'));
					} else{
						$this->error("订单状态更新失败", U('order/index'));
					}
                } else {
                    $this->error("订单状态更新失败", U('order/index'));
                }        
            }
        }
    }

    public function delete()
    {
		$id = I('get.id',0,'intval');
		$order = M('order');

		/**Start--校验CSRF TOKEN**/
		$token = I('get.token');
		$adminId = session('adminId');
		$manager = M('manager')-> where(array('id'=>$adminId)) -> find();
				
		if($token != $manager['token']){
			$this->error("非法请求");
		}
		/**End--校验CSRF TOKEN**/	
		$order_detail = $order->where(array("id"=>$id))->select();
        $del_result = $order->where(array("id"=>$id))->delete();
		
        if($del_result){
			$total_price = $order_detail[0]['price'] * $order_detail[0]['num'];
			$set_result = M('member')->where(array('id'=>$order_detail[0]['userid']))->setInc('jinbi',$total_price);
            if($set_result){
				$this->success("订单删除成功", U('order/index'));
			} else{
				$this->error("订单删除失败");
			}
        }else{
            $this->error("订单删除失败");
        }
    }
	

    /**
	* 导出记录
	**/ 
	
	public function portall($type=""){

			/**Start--校验CSRF TOKEN**/
			$token = I('get.token');
			$adminId = session('adminId');
			$manager = M('manager')-> where(array('id'=>$adminId)) -> find();
				
			if($token != $manager['token']){
				$this->error("非法请求");
			}
			/**End--校验CSRF TOKEN**/	
		
			if($type!=""){
				$model = M('order')->field('id,finish,username,realname,address,tel,gid,price,num,trackingno,update_time')->where(array("finish"=>$type))->limit(100)->select();
				set_time_limit(0);  
				ini_set('memory_limit', '512M');  
				$output = fopen('php://output', 'w') or die("can't open php://output");  
				$filename = "安全应急响应中心礼品兑换记录" . date('Y-m-d', time());  
				header("Content-type:application/vnd.ms-excel;charset=UTF-8");
				header("Content-Disposition: attachment; filename=$filename.csv");  
				$table_head = array('记录编号','订单状态','用户名','真实姓名','邮寄地址','联系电话','礼品内容','兑换价格','兑换数量','快递编号','兑换时间'); 
				fputcsv($output, $table_head);  
				foreach ($model as $e) {
					
					$finish_status = $e['finish'];
					if ($finish_status=='0'){
						$e['finish'] = '未处理';
					} elseif($finish_status=='1'){
						$e['finish'] = '已发货';
					} elseif($finish_status=='2'){
						$e['finish'] = '已完成';
					}
										
					$e['update_time'] = date("Y-m-d H:i:s",$e['update_time']);
					
					fputcsv($output, array_values($e));  
				}  
				fclose($output) or die("can't close php://output");  
				exit();  
			} else{
				$model = M('order')->field('id,finish,username,realname,address,tel,gid,price,num,trackingno,update_time')->where(array("finish"=>$type))->limit(100)->select();
				set_time_limit(0);  
				ini_set('memory_limit', '512M');  
				$output = fopen('php://output', 'w') or die("can't open php://output");  
				$filename = "安全应急响应中心礼品兑换记录" . date('Y-m-d', time());  
				header("Content-type:application/vnd.ms-excel;charset=UTF-8");
				header("Content-Disposition: attachment; filename=$filename.csv");  
				$table_head = array('记录编号','订单状态','用户名','真实姓名','邮寄地址','联系电话','礼品内容','兑换价格','兑换数量','快递编号','兑换时间'); 
				fputcsv($output, $table_head);  
				foreach ($model as $e) {
					
					$finish_status = $e['finish'];
					if ($finish_status=='0'){
						$e['finish'] = '未处理';
					} elseif($finish_status=='1'){
						$e['finish'] = '已发货';
					} elseif($finish_status=='2'){
						$e['finish'] = '已完成';
					}
					
					$e['update_time'] = date("Y-m-d H:i:s",$e['update_time']);
					
					fputcsv($output, array_values($e));  
				}  
				fclose($output) or die("can't close php://output");  
				exit(); 				
			}
    }		
	
}
