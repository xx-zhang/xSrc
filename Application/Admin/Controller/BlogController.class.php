<?php
namespace Admin\Controller;
use Admin\Controller;

/**
 * @Author: Martin Zhou
 * @Version: 1.0.2
 * @Copyright Tencent Security Response Center (TSRC)
 * @Project  https://security.tencent.com/index.php/xsrc
*/

class BlogController extends BaseController
{
    /**
     * 博客列表
     */
    public function index($key="")
    {
        if($key == ""){
            $model = M('blog');  
        }else{
            $where['title'] = array('like',"%$key%");
            $where['name'] = array('like',"%$key%");
            $where['_logic'] = 'or';
            $model = M('blog')->where($where); 
        } 
        
        $count  = $model->where($where)->count();
        $Page = new \Extend\Page($count,15);
        $show = $Page->show();
        $pages = $model->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('id DESC')->select();
        $this->assign('model', $pages);
        $this->assign('page',$show);
		$this->assign('search_key',$key);
        $this->display();     
    }

    /**
     * 添加博客
     */
    public function add()
    {
        if (!IS_POST) {
            $this->display();
        }
        if (IS_POST) {
            $model = M("Blog");
			
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

			if(strlen($data['title'])<1){
				$this->error("博客标题不能为空");
			}
			
			if(strlen($data['abstract'])<1){
				$this->error("博客摘要不能为空");
			}
			
            if ($model->add($data)) {
                    $this->redirect('blog/index');
                } else {
                    $this->error("添加失败");
                }
        }
    }
    /**
     * 更新博客信息
     */
    public function update()
    {
        $id = I('get.id',0,'int');
        if (!IS_POST) {
            $model = M('blog')->where('id='.$id)->find();
            $this->assign('page',$model);
            $this->display();
        }
        if (IS_POST) {
            $model = M("Blog");
			
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
			
			if(strlen($data['title'])<1){
				$this->error("博客标题不能为空");
			}
			
			if(strlen($data['abstract'])<1){
				$this->error("博客摘要不能为空");
			}
			
            if (!$model->create()) {
                $this->error($model->getError());
            }else{
                if ($model->save($data)) {
                    $this->redirect('blog/index');
                } else {
                    $this->error("更新失败");
                }        
            }
        }
    }
	
    /**
     * 删除博客
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
		
		$result = M('blog')->where(array("id"=>$id))->delete();
        if($result){
            $this->success("删除成功", U('blog/index'));
        }else{
            $this->error("删除失败");
        }
    }
	
	public function upload(){
		$upload = new \Think\Upload();
		$upload->maxSize   =     3145728 ;
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');
		$upload->rootPath  =      './Public/Uploads/';
		$info   =   $upload->uploadOne($_FILES['photo']);
		if(!$info) {
			$this->error($upload->getError());
		}else{
			$result['code'] = "200";
			$result['savepath'] = $info['savepath'].$info['savename'];
            $this->ajaxReturn($result,'JSON'); 
		}
	}
}
