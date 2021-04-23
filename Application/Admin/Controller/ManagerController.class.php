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
 * 后台用户管理
 */
class ManagerController extends BaseController
{
    /**
     * 用户列表
     * @return [type] [description]
     */
    public function index($key="")
    {
        if($key == ""){
            $model = M('manager');  
        }else{
            $where['username'] = array('like',"%$key%");
            $where['email'] = array('like',"%$key%");
            $where['_logic'] = 'or';
            $model = M('manager')->where($where); 
        } 
        
        $count  = $model->where($where)->count();
        $Page = new \Extend\Page($count,15);
        $show = $Page->show();
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
        //默认显示添加表单
        if (!IS_POST) {
            $this->display();
        }
        if (IS_POST) {
			
			/**Start--校验CSRF TOKEN**/
			$token = I('post.token');
			$adminId = session('adminId');
			$manager = D('Manager')-> where(array('id'=>$adminId)) -> find();
				
			if($token != $manager['token']){
				$this->error("非法请求");
			}
			/**End--校验CSRF TOKEN**/	

            //如果用户提交数据
            $model = D("Manager");
            if (!$model->field('username,email,password,repassword')->create()) {
                // 如果创建失败 表示验证没有通过 输出错误提示信息
                $this->error($model->getError());
                exit();
            } else {
                if ($model->add()) {
                    $this->success("后台用户添加成功", U('manager/index'));
                } else {
                    $this->error("后台用户添加失败");
                }
            }
        }
    }
    /**
     * 更新后台用户信息
     * @param  [type] $id [管理员ID]
     * @return [type]     [description]
     */
    public function update()
    {
        //默认显示添加表单
        if (!IS_POST) {
            $model = M('manager')->find(I('id',0,'int'));
            $this->assign('model',$model);
            $this->display();
        }
        if (IS_POST) {

			/**Start--校验CSRF TOKEN**/
			$token = I('post.token');
			$adminId = session('adminId');
			$manager = D('Manager')-> where(array('id'=>$adminId)) -> find();
				
			if($token != $manager['token']){
				$this->error("非法请求");
			}
			/**End--校验CSRF TOKEN**/	
			
            $model = M("manager");
            if (!$model->field('username,email,password')->create()) {
                $this->error($model->getError());
            }else{
                $data = I('post.');
                unset($data['password']);
                if(I('password') != ""){
                    $data['password'] = md5(I('password'));
                }
                //更新
                if ($model->save($data)) {
					if($data['id']==session('adminId')){
						session('adminId',null);
						session('adminname',null);
						$this->success("用户信息更新成功", U('Login/index'));
					} else{
						$this->redirect('manager/index');
					}
                } else {
                    $this->error("未做任何修改,用户信息更新失败");
                }        
            }
        }
    }
	
    /**
     * 删除后台用户
     * @param  [type] $id [description]
     * @return [type]     [description]
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

		$id = I('get.id',0,'int'); 
    	if($id=='1') $this->error("超级管理员不可删除!");
		
        $manager_model = M('manager');
		$result = $manager_model -> where(array("id"=>$id)) -> delete();
		
        if($result){
            $this->redirect('manager/index');
        }else{
            $this->error("状态更新失败");
        }
    }
}
