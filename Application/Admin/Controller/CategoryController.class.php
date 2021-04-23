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
 * 漏洞分类管理
 */
class CategoryController extends BaseController
{

    public function index($key="")
    {
        if($key == ""){
            $model = M('category');  
        }else{
            $where['title'] = array('like',"%$key%");
            $where['name'] = array('like',"%$key%");
            $where['_logic'] = 'or';
            $model = M('category')->where($where); 
        } 
        
        $category = $model->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('id ASC')->select();
        $this->assign('model',getSortedCategory($category));
		$this->assign('search_key',$key);
        $this->display();   
    }

    public function add()
    {

        if (!IS_POST) {
            $model = M('category')->select();
            $cate = getSortedCategory($model);

            $this->assign('cate',$cate);
            $this->display();
        }
		
        if (IS_POST) {
            $model = D("Category");

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
                exit();
            } else {

                if ($model->add()) {
                    $this->redirect(U('category/index'));
                } else {
                    $this->error("分类添加失败");
                }
            }
        }
    }

    public function update()
    {

        if (!IS_POST) {
            $model = M('category')->find(I('id'));
          
            $this->assign('cate',getSortedCategory(M('category')->select()));
            $this->assign('model',$model);
            $this->display();
        }
        if (IS_POST) {
            $model = D("Category");
			
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
                    $this->success("分类更新成功", U('category/index'));
                } else {
                    $this->error("分类更新失败");
                }        
            }
        }
    }

    public function delete()
    {
		$id = I('get.id',0,'intval');
        $model = M('category');
        $posts = M('post')->where(array('cate_id'=>$id))->select();
        if($posts){
            $this->error("该分类下存在漏洞报告，禁止删除");
        }

        $hasChild = $model->where(array('pid'=>$id))->select();
        if($hasChild){
            $this->error("该分类含子分类，禁止删除");
        }
			
		/**Start--校验CSRF TOKEN**/
		$token = I('get.token');
		$adminId = session('adminId');
		$manager = M('manager')-> where(array('id'=>$adminId)) -> find();
				
		if($token != $manager['token']){
			$this->error("非法请求");
		}
		/**End--校验CSRF TOKEN**/	

        $result = $model->delete($id);
        if($result){
            $this->redirect(U('category/index'));
        }else{
            $this->error("分类删除失败");
        }
    }
}
