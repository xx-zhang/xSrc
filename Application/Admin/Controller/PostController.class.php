<?php
namespace Admin\Controller;
use Admin\Controller;
 
/**
 * @Author: Martin Zhou
 * @Version: 1.0.2
 * @Copyright Tencent Security Response Center (TSRC)
 * @Project  https://security.tencent.com/index.php/xsrc
*/

class PostController extends BaseController
{
    /**
     * 漏洞报告列表
     * @return [type] [description]
     */
    public function index($key="")
    {
		
		$type_val = I('get.type','','int');
		
        if($key == ""){
            $model = D('PostView');  
        }else{
			$where['title'] = array('like',"%$key%");
            $where['name'] = array('like',"%$key%");
            $where['_logic'] = 'or';
            $model = D('PostView')->where($where); 
		}
		
		
		if($type_val!=NULL){
			$count  = $model->where($where)->where(array("post.type"=>$type_val))->count();
			$Page = new \Extend\Page($count,15);
			$show = $Page->show();
			$pages = $model->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('id DESC')->where(array("post.type"=>$type_val))->select();
			$this->assign('model', $pages);
			$this->assign('page',$show);
			$this->assign('search_key',$key);
			$this->display(); 
		} else{
			$count  = $model->where($where)->count();
			$Page = new \Extend\Page($count,15);
			$show = $Page->show();
			$pages = $model->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('id DESC')->select();
			$this->assign('model', $pages);
			$this->assign('page',$show);
			$this->assign('search_key',$key);
			$this->display(); 			
		}   
    }

    /**
     * 添加漏洞报告
    
    public function add()
    {

        if (!IS_POST) {
        	$this->assign("category",getSortedCategory(M('category')->select()));
            $this->display();
        }
        if (IS_POST) {
			
            $model = D("Post");
            $model->time = time();
            $model->user_id = 0;
			
			$token = I('post.token');
			$adminId = session('adminId');
			$manager = M('manager')-> where(array('id'=>$adminId)) -> find();
				
			if($token != $manager['token']){
				$this->error("非法请求");
			}
			
            if (!$model->create()) {
                $this->error($model->getError());
                exit();
            } else {
                if ($model->add()) {
                    $this->success("添加成功", U('post/index'));
                } else {
                    $this->error("添加失败");
                }
            }
        }
    }
	 */
	
    /**
     * 编辑漏洞报告
     */
    public function update()
    {
		$id = I('get.id',0,'int');
        if (!IS_POST) {
            $model = M('post')->where(array('id'=>$id))->find();
            $this->assign("category",getSortedCategory(M('category')->select()));
            $this->assign('post',$model);
            $this->display();
        }
        if (IS_POST) {
            $model = D("Post");
			$model->time = time();
			
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
                    $this->success("更新成功", U('post/index'));
                } else {
                    $this->error("更新失败");
                }        
            }
        }
    }
	 /**
     * 审核漏洞报告
     */
    public function review()
    {
		$id = I('get.id',0,'int');
		
        if (!IS_POST) {
            $model = M('post')->where(array('id'=>$id))->find();
			$comment = M('Comment')->where(array('post_id'=>$id))->select();
            $this->assign("category",getSortedCategory(M('category')->select()));
            $this->assign('post',$model);
			$this->assign('comment',$comment);
            $this->display();
        }
		
        if (IS_POST) {
            $model = D("Post");
			$model->time = time();
			$data = I('post.');
            $poststat = M('poststat');
            $stat['type'] = $data['type'];
            $stat['postid'] = $id;
            $stat['content'] = '管理员变更了报告状态，如有疑问请及时联系。';
            $stat['operator'] = session('adminname');
			
			/**Start--校验CSRF TOKEN**/
			$token = $data['token'];
			$adminId = session('adminId');
			$manager = M('manager')-> where(array('id'=>$adminId)) -> find();
				
			if($token != $manager['token']){
				$this->error("非法请求");
			}
			/**End--校验CSRF TOKEN**/			
			
            if ($model->where(array('id'=>$id))->field('day,rank,type')->save($data)) {
                    if ($poststat->add($stat)){
                        $this-> redirect('post/review', array('id' => $id));}
                    else{
                        $this->error("记录失败");
                    }
            } 
            else {
                    $this->error("审核失败");
            }        
        }
    }
    /**
     * 删除漏洞报告
     */
    public function delete()
    {
		$id = I('get.id',0,'int');
		$post_model = M('post');
		$member_model = M('member');
		$token = I('get.token');
		
		/**Start--校验CSRF TOKEN**/
		$adminId = session('adminId');
		$manager = M('manager')-> where(array('id'=>$adminId)) -> find();	
	    if($token != $manager['token']){
			$this->error("非法请求");
		}
		/**End--校验CSRF TOKEN**/
		
		$user_id = $post_model -> where(array("id"=>$id)) -> find();
		$del_result =  $post_model -> where(array("id"=>$id)) -> delete();
		
		$sum_score = $post_model -> where(array("user_id"=>$user_id['user_id'])) -> field('sum(score),sum(points)') -> group('user_id') -> select();
		$mdata['jinbi'] = intval($sum_score[0]['sum(score)']);
		$mdata['jifen'] = intval($sum_score[0]['sum(points)']);
		$update_score_result = $member_model -> where(array('id'=>$user_id['user_id'])) -> field('jinbi,jifen') -> save($mdata);

		$data['type'] = 1;
		$data['name'] = '积分/安全币变动';
		$data['content'] = '-积分:'.$user_id['points'].' -安全币:'.$user_id['score'];
		$data['time'] = time();
		$user = $member_model->where(array('id'=>$user_id['user_id']))-> select();
		$data['user'] = $user[0]['username'];
		$data['userid'] = $user_id['user_id'];
		$data['operator'] = session('adminname');
			
        if($del_result){
			if($update_score_result){
				if(M('record') -> add($data)){
					$this -> redirect(U('post/index'));
				} else{
					$this->error("积分变动记录失败");
				}
			} else {
				$this->error("报告无积分/金币奖励记录，相关数据不做更新");
			}
        }else{
            $this->error("删除失败");
        }
    }
	
	/**
     * 添加积分
     */
    public function jifen()
    {
		$member = M('member');
		$record = M('record');
		$post = M('post');
		$adminId = session('adminId');
		
		$user_id = I('get.uid',0,'int');
		$jifen = I('post.jifen',0,'int');
		$jinbi = I('post.jinbi',0,'int');
		$pid = I('post.pid',0,'int');
		$token = I('post.token');
		
		if(!preg_match("/^\d+$/", $jifen))
		{
			$this->error("积分填写错误", U('post/review', array('id' => $pid)));
		}

		if(!preg_match("/^\d+$/", $jinbi))
		{
			$this->error("金币填写错误", U('post/review', array('id' => $pid)));
		}
		
		if($jifen=='')
		{
			$jifen = 0;
		}
		
		if($jinbi=='')
		{
			$jinbi = 0;
		}
				
		//单个报告奖励详情
		//pdata数组内容写入post表
		$pdata['bounty'] = '+积分:'.$jifen.' +安全币:'.$jinbi;
		$pdata['score'] = $jinbi;
		$pdata['points'] = $jifen;
		
		//校验CSRF TOKEN
		$manager = M('manager')-> where(array('id'=>$adminId)) -> find();
			
	    if($token != $manager['token']){
			$this->error("非法请求");
		}
		
		$check_reward = $post -> where(array('id'=>$pid)) -> field('bounty,score,points') -> find();
		
		$score_val = $check_reward['score'];
		$points_val = $check_reward['points'];
		
		
		if($score_val=='0' && $points_val=='0'){
			
			//添加积分记录
			$data['type'] = 1;
			$data['name'] = '积分/安全币变动';
			$data['content'] = '+积分:'.$jifen.' +安全币:'.$jinbi;
			$data['time'] = time();
			$user = $member->where(array('id'=>$user_id))-> select();
			$data['user'] = $user[0]['username'];
			$data['userid'] = $user_id;
			$data['operator'] = session('adminname');

			$result1 = $post -> where(array('id'=>$pid)) -> field('bounty,score,points') -> save($pdata);		
						
			$jinbi_result = $member -> where(array('id'=>$user_id)) -> setInc('jinbi',$jinbi);
			$jifen_result = $member -> where(array('id'=>$user_id)) -> setInc('jifen',$jifen);
						
			$result3 = $record -> add($data);
			
			if($result3){
				$message_content['userid'] = $user_id;
				$message_content['sender'] = session('adminname');
				$message_content['content'] = '报告奖励调整/变动【'.$data['content'].'】';
				$message_content['type'] = '系统消息';
				$add_message_result = M('message') -> add($message_content);
				if($add_message_result){
					$this -> redirect('post/review', array('id' => $pid));
				}else{
					$this -> error("变更积分/安全币失败", U('post/review', array('id' => $pid)));
				}
			} else{
				$this -> error("变更积分/安全币失败", U('post/review', array('id' => $pid)));
			}
		}elseif($score_val=='0' && $points_val!='0'){

			$result1 = $post -> where(array('id'=>$pid)) -> field('bounty,score,points') -> save($pdata);		
			
			$points_val = intval($points_val);
			$score_val = intval($score_val);
			$jifen = intval($jifen);
			$jinbi = intval($jinbi);
			
			$jinbi_result = $member -> where(array('id'=>$user_id)) -> setInc('jinbi',$jinbi);
			
			if($points_val > $jifen){
				
				$op_val = intval($points_val) - intval($jifen);
				
				//添加积分记录
				$data['type'] = 1;
				$data['name'] = '积分/安全币变动';
				$data['content'] = '-积分:'.$op_val.' +安全币:'.$jinbi;
				$data['time'] = time();
				$user = $member->where(array('id'=>$user_id))-> select();
				$data['user'] = $user[0]['username'];
				$data['userid'] = $user_id;
				$data['operator'] = session('adminname');

				$jifen_result = $member -> where(array('id'=>$user_id)) -> setDec('jifen',$op_val);
			}elseif($jifen > $points_val){
				
				$op_val = intval($jifen) - intval($points_val);
				//添加积分记录
				$data['type'] = 1;
				$data['name'] = '积分/安全币变动';
				$data['content'] = '+积分:'.$op_val.' +安全币:'.$jinbi;
				$data['time'] = time();
				$user = $member->where(array('id'=>$user_id))-> select();
				$data['user'] = $user[0]['username'];
				$data['userid'] = $user_id;
				$data['operator'] = session('adminname');
				
				$jifen_result = $member -> where(array('id'=>$user_id)) -> setInc('jifen',$op_val);
			}else{
				$op_val = intval($jifen) - intval($points_val);
				//添加积分记录
				$data['type'] = 1;
				$data['name'] = '积分/安全币变动';
				$data['content'] = '+积分:0'.' +安全币:'.$jinbi;
				$data['time'] = time();
				$user = $member->where(array('id'=>$user_id))-> select();
				$data['user'] = $user[0]['username'];
				$data['userid'] = $user_id;
				$data['operator'] = session('adminname');
				
				$jifen_result = $member -> where(array('id'=>$user_id)) -> setInc('jifen','0');
			}
						
			$result3 = $record -> add($data);
			
			if($result3){
				$message_content['userid'] = $user_id;
				$message_content['sender'] = session('adminname');
				$message_content['content'] = '报告奖励调整/变动【'.$data['content'].'】';
				$message_content['type'] = '系统消息';
				$add_message_result = M('message') -> add($message_content);
				if($add_message_result){
					$this -> redirect('post/review', array('id' => $pid));
				}else{
					$this -> error("变更积分/安全币失败", U('post/review', array('id' => $pid)));
				}
			} else{
				$this -> error("变更积分/安全币失败", U('post/review', array('id' => $pid)));
			}
			
		} elseif($score_val!='0' && $points_val=='0'){
			
			$result1 = $post -> where(array('id'=>$pid)) -> field('bounty,score,points') -> save($pdata);		

			$points_val = intval($points_val);
			$score_val = intval($score_val);
			$jifen = intval($jifen);
			$jinbi = intval($jinbi);
			
			$jifen_result = $member -> where(array('id'=>$user_id)) -> setInc('jifen',$jifen);
			
			if($score_val > $jinbi){
				$op_val = intval($score_val) - intval($jinbi);
				
				//添加积分记录
				$data['type'] = 1;
				$data['name'] = '积分/安全币变动';
				$data['content'] = '+积分:'.$jifen.' -安全币:'.$op_val;
				$data['time'] = time();
				$user = $member->where(array('id'=>$user_id))-> select();
				$data['user'] = $user[0]['username'];
				$data['userid'] = $user_id;
				$data['operator'] = session('adminname');
				
				$jinbi_result = $member -> where(array('id'=>$user_id)) -> setDec('jinbi',$op_val);
			}elseif($jinbi > $score_val){
				$op_val = intval($jinbi) - intval($score_val);
				
				//添加积分记录
				$data['type'] = 1;
				$data['name'] = '积分/安全币变动';
				$data['content'] = '+积分:'.$jifen.' +安全币:'.$op_val;
				$data['time'] = time();
				$user = $member->where(array('id'=>$user_id))-> select();
				$data['user'] = $user[0]['username'];
				$data['userid'] = $user_id;
				$data['operator'] = session('adminname');
				
				$jinbi_result = $member -> where(array('id'=>$user_id)) -> setInc('jinbi',$op_val);
			} else{
				
				//添加积分记录
				$data['type'] = 1;
				$data['name'] = '积分/安全币变动';
				$data['content'] = '+积分:'.$jifen.' +安全币:0';
				$data['time'] = time();
				$user = $member->where(array('id'=>$user_id))-> select();
				$data['user'] = $user[0]['username'];
				$data['userid'] = $user_id;
				$data['operator'] = session('adminname');
				
				$jinbi_result = $member -> where(array('id'=>$user_id)) -> setInc('jinbi','0');
			}

			$result3 = $record -> add($data);
			
			if($result3){
				$message_content['userid'] = $user_id;
				$message_content['sender'] = session('adminname');
				$message_content['content'] = '报告奖励调整/变动【'.$data['content'].'】';
				$message_content['type'] = '系统消息';
				$add_message_result = M('message') -> add($message_content);
				if($add_message_result){
					$this -> redirect('post/review', array('id' => $pid));
				}else{
					$this -> error("变更积分/安全币失败", U('post/review', array('id' => $pid)));
				}
			} else{
				$this -> error("变更积分/安全币失败", U('post/review', array('id' => $pid)));
			}
			
		}else{
			
			$result1 = $post -> where(array('id'=>$pid)) -> save($pdata);		
		
			$data['type'] = 1;
			$data['name'] = '积分/安全币变动';
			$data['time'] = time();
			$user = $member->where(array('id'=>$user_id))-> select();
			$data['user'] = $user[0]['username'];
			$data['userid'] = $user_id;
			$data['operator'] = session('adminname');
			
			$points_val = intval($points_val);
			$score_val = intval($score_val);
			$jifen = intval($jifen);
			$jinbi = intval($jinbi);
			
			if($points_val > $jifen){
				$op_val = intval($points_val) - intval($jifen);
				$data['content'] = '-积分:'.$op_val;
				$jifen_result = $member -> where(array('id'=>$user_id)) -> setDec('jifen',$op_val);
			}elseif($jifen > $points_val){
				$op_val = intval($jifen) - intval($points_val);
				$data['content'] = '+积分:'.$op_val;
				$jifen_result = $member -> where(array('id'=>$user_id)) -> setInc('jifen',$op_val);
			}else{
				$data['content'] = '+积分:0';
				$jifen_result = $member -> where(array('id'=>$user_id)) -> setInc('jifen','0');
			}
			
						
			if($score_val > $jinbi){
				$op_val = intval($score_val) - intval($jinbi);			
				$data['content'] = $data['content'].' -安全币:'.$op_val;
				$jinbi_result = $member -> where(array('id'=>$user_id)) -> setDec('jinbi',$op_val);
			}elseif($jinbi > $score_val){
				$op_val = intval($jinbi) - intval($score_val);
				$data['content'] = $data['content'].' +安全币:'.$op_val;
				$jinbi_result = $member -> where(array('id'=>$user_id)) -> setInc('jinbi',$op_val);
			} else{
				$data['content'] = $data['content'].' +安全币:0';
				$jinbi_result = $member -> where(array('id'=>$user_id)) -> setInc('jinbi','0');
			}
															
			$result3 = $record -> add($data);
			
			if($result3){
				$message_content['userid'] = $user_id;
				$message_content['sender'] = session('adminname');
				$message_content['content'] = '报告奖励调整/变动【'.$data['content'].'】';
				$message_content['type'] = '系统消息';
				$add_message_result = M('message') -> add($message_content);
				if($add_message_result){
					$this -> redirect('post/review', array('id' => $pid));
				}else{
					$this -> error("变更积分/安全币失败", U('post/review', array('id' => $pid)));
				}
			} else{
				$this -> error("变更积分/安全币失败", U('post/review', array('id' => $pid)));
			}
			
		}

    }
	
	/**
     * 生成session key
	**/ 

    public function session(){
		$id = I('get.id');
		$str = '1234567890abcdefg';
        $session = $str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)].$str[rand(0,17)];
		$visible = 1;
        $model = M('post');
        $model->session = $session;
		$model->visible = $visible;
		$result = $model->where(array('id'=>$id))->save();
		if($result){
            $this->redirect('check/htmlview',array('session_id'=>$session));
        }else{
            $this->error("授权失败");
        }
	   }
	   
	   
	/**
	* 取消导出
	**/ 
	   
	 public function cancel(){
		$id = I('get.id',0,'int');
		$visible = 0;
        $model = M('post');
		$model->visible = $visible;
		
		/**Start--校验CSRF TOKEN**/
		$token = I('get.token');
		$adminId = session('adminId');
		$manager = M('manager')-> where(array('id'=>$adminId)) -> find();
				
		if($token != $manager['token']){
			$this->error("非法请求");
		}
		/**End--校验CSRF TOKEN**/				
		
		$result = $model->where(array('id'=>$id))->save();
		if($result){
            $this->redirect('post/index');
        }else{
            $this->error("取消失败");
        }
	   }
			
	
    /**
	* 导出全部
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
				$model = M('post')->field('id,title,time,type,rank,bounty')->where(array("type"=>$type))->limit(100)->select();
				set_time_limit(0);  
				ini_set('memory_limit', '512M');  
				$output = fopen('php://output', 'w') or die("can't open php://output");  
				$filename = "安全应急响应中心外部漏洞报告统计表" . date('Y-m-d', time());  
				header("Content-type:application/vnd.ms-excel;charset=UTF-8");
				header("Content-Disposition: attachment; filename=$filename.csv");  
				$table_head = array('报告编号','报告名称','提交时间','报告状态','漏洞危害','漏洞奖励');  
				fputcsv($output, $table_head);  
				foreach ($model as $e) {
					
					$report_type = $e['type'];
					if ($report_type=='1'){
						$e['type'] = '审核中';
					} elseif($report_type=='2'){
						$e['type'] = '已忽略';
					} elseif($report_type=='3'){
						$e['type'] = '已确认';
					}elseif($report_type=='4'){
						$e['type'] = '已修复';
					}elseif($report_type=='5'){
						$e['type'] = '已完成';
					}
					
					$report_rank = $e['rank'];
					if ($report_type=='1'){
						$e['rank'] = '无影响';
					} elseif($report_type=='2'){
						$e['rank'] = '低危';
					} elseif($report_type=='3'){
						$e['rank'] = '中危';
					}elseif($report_type=='4'){
						$e['rank'] = '高危';
					}
					
					$e['time'] = date("Y-m-d H:i:s",$e['time']);
					
					fputcsv($output, array_values($e));  
				}  
				fclose($output) or die("can't close php://output");  
				exit();  
			} else{
				$model = M('post')->field('id,title,time,type,rank,bounty')->limit(100)->select();
				set_time_limit(0);  
				ini_set('memory_limit', '512M');  
				$output = fopen('php://output', 'w') or die("can't open php://output");  
				$filename = "安全应急响应中心外部漏洞报告统计表" . date('Y-m-d', time());  
				header("Content-type:application/vnd.ms-excel;charset=UTF-8");
				header("Content-Disposition: attachment; filename=$filename.csv");  
				$table_head = array('报告编号','报告名称','提交时间','报告状态','漏洞危害','漏洞奖励');  
				fputcsv($output, $table_head);  
				foreach ($model as $e) {
					
					$report_type = $e['type'];
					if ($report_type=='1'){
						$e['type'] = '审核中';
					} elseif($report_type=='2'){
						$e['type'] = '已忽略';
					} elseif($report_type=='3'){
						$e['type'] = '已确认';
					}elseif($report_type=='4'){
						$e['type'] = '已修复';
					}elseif($report_type=='5'){
						$e['type'] = '已完成';
					}
					
					$report_rank = $e['rank'];
					if ($report_type=='1'){
						$e['rank'] = '无影响';
					} elseif($report_type=='2'){
						$e['rank'] = '低危';
					} elseif($report_type=='3'){
						$e['rank'] = '中危';
					}elseif($report_type=='4'){
						$e['rank'] = '高危';
					}
					
					$e['time'] = date("Y-m-d H:i:s",$e['time']);
					
					fputcsv($output, array_values($e));  
				}  
				fclose($output) or die("can't close php://output");  
				exit(); 				
			}
    }		

    /**
	添加报告评论
	**/
	public function comment()
    {
        if (!IS_POST) {
        	$this->error("非法请求");
        }
        if (IS_POST) {
            $model = D("Comment");
			$token = I('post.token');
			
			/**Start--校验CSRF TOKEN**/
			$adminId = session('adminId');
			$manager = M('manager')-> where(array('id'=>$adminId)) -> find();
				
			if($token != $manager['token']){
				$this->error("非法请求");
			}
			/**End--校验CSRF TOKEN**/		
			
            if (!$model->create()) {
                $this->error($model->getError());
                exit();
            } else {
                if ($model->add()) {			
                    $this->success("添加成功", U('post/index'));
                } else {
                    $this->error("添加失败");
                }
            }
        }
    }
}