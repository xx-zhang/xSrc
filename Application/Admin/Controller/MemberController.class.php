<?php
namespace Admin\Controller;
use Admin\Controller;

/**
 * @Author: Martin Zhou
 * @Version: 1.0.2
 * @Copyright Tencent Security Response Center (TSRC)
 * @Project  https://security.tencent.com/index.php/xsrc
*/

/**
 * 用户管理
 */
class MemberController extends BaseController
{
    public function index($key="")
    {
        if($key == ""){
            $model = M('member');  
        }else{
            $where['username'] = array('like',"%$key%");
            $where['email'] = array('like',"%$key%");
            $where['_logic'] = 'or';
            $model = M('member')->where($where); 
        } 
        
        $count  = $model->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Extend\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出
        $member = $model->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('id DESC')->select();
        $this->assign('member', $member);
        $this->assign('page',$show);
		$this->assign('search_key',$key);
        $this->display();     
    }

    /**
     * 添加用户
     */
    public function add()
    {
        if (!IS_POST) {
            $this->display();
        }
        if (IS_POST) {
			
            $model = M("Member");
			
			/**Start--校验CSRF TOKEN**/
			$token = I('post.token');
			$adminId = session('adminId');
			$manager = M('manager')-> where(array('id'=>$adminId)) -> find();
				
			if($token != $manager['token']){
				$this->error("非法请求");
			}
			/**End--校验CSRF TOKEN**/	
			
			$data['salt'] = "";
			$data['pid'] = "";
			$chars = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$pchars = '0123456789';
			for($num=0;$num<8;$num++){
				$RandNum = rand(0,strlen($chars)-1);  
				$data['salt'] .= $chars[$RandNum]; 
			}
			
			for($num=0;$num<32;$num++){
				$RandNum = rand(0,strlen($pchars)-1);  
				$data['pid'] .= $pchars[$RandNum]; 
			}         	
					
			$data['username'] = I('post.username');
			$data['email']= I('post.email','','email');
			$data['password'] = I('post.password');
			$repassword= I('post.repassword');
			
			if(strlen($data['password']) < 8){ $this->error("为了保证帐户安全，请输入大于八位数的密码!");}
			
			if($data['password'] != $repassword){ $this->error("两次密码不一致!");}
		
			$data['password'] = md5(md5(md5($data['salt']).md5($data['password'])."SR")."CMS");
			$data['create_at']=time();
			
			if ($model->where(array('username'=>$data['username']))->find()){
				 $this->error('用户名重复');
			}
			if ($model->where(array('email'=>$data['email']))->find()){
				 $this->error('邮箱重复');
			}
			
			if ($model->field('username,email,pid,salt,password,create_at')->data($data)->add()) {
	
				$user = $model->where(array('username'=>$data['username']))->find();		

				$date =array(
					'id' => $user['id'],
					'update_at' => time(),
					'login_ip' => get_client_ip(),
				);
        
				if($model->save($date)){
					$this->redirect('member/index');
				}	
		
            } else {
                $this->error("注册失败");
            }
        }
    }
	
    /**
     * 更新用户信息
     */
    public function update()
    {
        if (!IS_POST) {
            $model = M('member')->find(I('id'));
            $this->assign('model',$model);
            $this->display();
        }
        if (IS_POST) {
            $model = M("Member");

			/**Start--校验CSRF TOKEN**/
			$token = I('post.token');
			$adminId = session('adminId');
			$manager = M('manager')-> where(array('id'=>$adminId)) -> find();
				
			if($token != $manager['token']){
				$this->error("非法请求");
			}
			/**End--校验CSRF TOKEN**/	
			
			$data = I('post.');
			
            
			$user = $model->where(array('id'=>$data['id']))->find();
			
            if($data['password'] != ""){
				if(strlen($data['password']) < 8){ 
					$this->error("为了保证帐户安全，请输入大于八位数的密码!");
				}else{
					$data['password'] = md5(md5(md5($user['salt']).md5($data['password'])."SR")."CMS");
				}
            }else{
				$data['password'] = $user['password'];
			}
			
		
            if ($model->save($data)) {
                $this->success("用户信息更新成功", U('member/index'));
            } else {
                $this->error("用户信息更新失败");
            }        

        }
    }
    /**
     * 禁用用户
     */
    public function ban()
    {
		/**Start--校验CSRF TOKEN**/
		$token = I('get.token');
		$adminId = session('adminId');
		$manager = M('manager')-> where(array('id'=>$adminId)) -> find();
				
		if($token != $manager['token']){
			$this->error("非法请求");
		}
		/**End--校验CSRF TOKEN**/	

		$id = I('get.id',0,'intval'); 
        $model = M('member');
        $result = $model->find($id);
        $data['id']=$id;
        if($result['status'] == 1){
        	$data['status']=0;
        }
        if($result['status'] == 0){
        	$data['status']=1;
        }

        if($model->save($data)){
            $this->success("状态更新成功", U('member/index'));
        }else{
            $this->error("状态更新失败");
        }
    }
	
    /**
     * 删除用户
     */
    public function delete()
    {
		/**Start--校验CSRF TOKEN**/
		$token = I('get.token');
		$adminId = session('adminId');
		$manager = M('manager')-> where(array('id'=>$adminId)) -> find();
				
		if($token != $manager['token']){
			$this->error("非法请求");
		}
		/**End--校验CSRF TOKEN**/	

		$id = I('get.id',0,'intval'); 
        $model = M('member');
		$data['username'] = '[已删除]';
		$data['realname'] = '[已删除]';
		$data['email'] = '0';
		$data['salt'] = '0';
		$data['passwd'] = '0';
		$data['team'] = '[已删除]';
		$data['description'] = '[已删除]';
		$data['website'] = '[已删除]';
		$data['status'] = 0;
		if (!$model->autoCheckToken($_POST)){
			$this->error("表单令牌错误");
		}
		if($model->where('id='.$id)->save($data)){
            $this->success("用户删除成功", U('member/index'));
        }else{
            $this->error("用户删除失败");
        }
    }
}
