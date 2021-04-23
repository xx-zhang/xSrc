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
 * 链接管理
 */
class LinksController extends BaseController
{
    /**
     * 链接列表
     * @return [type] [description]
     */
    public function index($key="")
    {
        if($key == ""){
            $model = M('links');  
        }else{
            $where['title'] = array('like',"%$key%");
            $where['url'] = array('like',"%$key%");
            $where['_logic'] = 'or';
            $model = M('links')->where($where); 
        } 
        
        $count  = $model->where($where)->count();
        $Page = new \Extend\Page($count,15);
        $show = $Page->show();
        $links = $model->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('id DESC')->select();
        $this->assign('model', $links);
        $this->assign('page',$show);
		$this->assign('search_key',$key);
        $this->display();     
    }

    /**
     * 添加链接
     */
    public function add()
    {

        if (!IS_POST) {
            $this->display();
        }
        if (IS_POST) {
            $model = D("links");
            if (!$model->create()) {
                $this->error($model->getError());
                exit();
            } else {
                if ($model->add()) {
                    $this->success("链接添加成功", U('links/index'));
                } else {
                    $this->error("链接添加失败");
                }
            }
        }
    }
    /**
     * 更新链接信息
     */
    public function update()
    {
		$id = I('get.id',0,'intval');
        if (!IS_POST) {
            $model = M('links')->where('id='.$id)->find();
            $this->assign('model',$model);
            $this->display();
        }
        if (IS_POST) {
            $model = D("links");
            if (!$model->create()) {
                $this->error($model->getError());
            }else{
                if ($model->save()) {
                    $this->success("更新成功", U('links/index'));
                } else {
                    $this->error("更新失败");
                }        
            }
        }
    }
    /**
     * 删除链接
     */
    public function delete()
    {
		$id = I('get.id',0,'intval');
        $model = M('links');
        $result = $model->delete($id);
        if($result){
            $this->success("链接删除成功", U('links/index'));
        }else{
            $this->error("链接删除失败");
        }
    }
}
