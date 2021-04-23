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
 * 礼品管理
 */
class GiftsController extends BaseController
{
    /**
     * 礼品列表
     */
    public function index($key="")
    {
        if($key == ""){
            $model = M('gifts');  
        }else{
            $where['title'] = array('like',"%$key%");
            $model = M('gifts')->where($where); 
        } 
        
        $count  = $model->where($where)->count();
        $Page = new \Extend\Page($count,15);
        $show = $Page->show();
        $gifts = $model->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('id DESC')->select();
        $this->assign('model', $gifts);
        $this->assign('page',$show);
		$this->assign('search_key',$key);
        $this->display();     
    }

    /**
     * 添加礼品
     */
    public function add()
    {
        if (!IS_POST) {
            $this->display();
        }
        if (IS_POST) {
            $model = D("Gifts");
			
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
                    $this->success("礼品添加成功", U('gifts/index'));
                } else {
                    $this->error("礼品添加失败");
                }
            }
        }
    }
    /**
     * 更新礼品信息
     */
    public function update()
    {
		$id = I('get.id',0,'intval');
        if (!IS_POST) {
            $model = M('gifts')->where(array('id'=>$id))->find();
            $this->assign('model',$model);
            $this->display();
        }
        if (IS_POST) {
            $model = D("Gifts");
			
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
                    $this->success("礼品更新成功", U('gifts/index'));
                } else {
                    $this->error("礼品更新失败");
                }        
            }
        }
    }
    /**
     * 删除礼品
     */
    public function delete()
    {
		$id = I('get.id',0,'int');
        
		/**Start--校验CSRF TOKEN**/
		$token = I('get.token');
		$adminId = session('adminId');
		$manager = M('manager')-> where(array('id'=>$adminId)) -> find();
				
		if($token != $manager['token']){
			$this->error("非法请求");
		}
		/**End--校验CSRF TOKEN**/	
        
		$result = M('gifts')->delete($id);
		
		if($result){
            $this->success("礼品删除成功", U('gifts/index'));
        }else{
            $this->error("礼品删除失败");
        }
    }

	public function upload(){
		$upload = new \Think\Upload();
		$upload->maxSize   =     3145728 ;
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');
		$upload->rootPath  =      './Public/Uploads/';
		$info   =   $upload -> uploadOne($_FILES['photo']);
		if(!$info) {
			$this->error($upload->getError());
		}else{
			$result['code'] = "200";
			$result['savepath'] = $info['savepath'].$info['savename'];
            $this->ajaxReturn($result,'JSON'); 
		}
	}
	
}
