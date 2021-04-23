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
 * 单页管理
 */
class PageController extends BaseController
{
    /**
     * 单页列表
     * @return [type] [description]
     */
    public function index($key="")
    {
        if($key == ""){
            $model = M('page');  
        }else{
            $where['title'] = array('like',"%$key%");
            $where['name'] = array('like',"%$key%");
            $where['_logic'] = 'or';
            $model = M('page')->where($where); 
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

    /**
     * 添加公告
     */
    public function add()
    {
        //默认显示添加表单
        if (!IS_POST) {
            $this->display();
        }
        if (IS_POST) {
            $model = M("Page");
			
			/**Start--校验CSRF TOKEN**/
			$token = I('post.token');
			$adminId = session('adminId');
			$manager = M('manager')-> where(array('id'=>$adminId)) -> find();
				
			if($token != $manager['token']){
				$this->error("非法请求");
			}
			/**End--校验CSRF TOKEN**/	
			
			$data = I('post.');
			$data['update_time'] = time();
            if ($model->add($data)) {
                    $this->success("添加成功", U('page/index'));
                } else {
                    $this->error("添加失败");
                }
        }
    }
    /**
     * 更新公告
     */
    public function update()
    {
        $id = I('get.id',0,'intval');
        if (!IS_POST) {
            $model = M('page')->where('id='.$id)->find();
            $this->assign('page',$model);
            $this->display();
        }
        if (IS_POST) {
            $model = M("Page");
			
			/**Start--校验CSRF TOKEN**/
			$token = I('post.token');
			$adminId = session('adminId');
			$manager = M('manager')-> where(array('id'=>$adminId)) -> find();
				
			if($token != $manager['token']){
				$this->error("非法请求");
			}
			/**End--校验CSRF TOKEN**/	
			
			$data = I('post.');
			$data['update_time'] = time();
            if ($model->save($data)) {
                    $this->success("更新成功", U('page/index'));
                } else {
                    $this->error("更新失败");
                }        
        }
    }

    /**
     * 删除单页
     */
    public function delete()
    {
		$id = I('get.id',0,'intval');
		
		/**Start--校验CSRF TOKEN**/
		$token = I('get.token');
		$adminId = session('adminId');
		$manager = M('manager')-> where(array('id'=>$adminId)) -> find();
				
		if($token != $manager['token']){
			$this->error("非法请求");
		}
		/**End--校验CSRF TOKEN**/	
		
        $result = M('page')->where("id=".$id)->delete();
        if($result){
            $this->success("删除成功", U('page/index'));
        }else{
            $this->error("删除失败");
        }
    }
}
