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
class InfoController extends BaseController
{
    /**
     * 单页列表
     * @return [type] [description]
     */
    public function index($key="")
    {
        if($key == ""){
            $model = M('info');  
        }else{
            $where['title'] = array('like',"%$key%");
            $where['name'] = array('like',"%$key%");
            $where['_logic'] = 'or';
            $model = M('info')->where($where); 
        } 
        
        $count  = $model->where($where)->count();
        $Page = new \Extend\Page($count,15);
        $show = $Page->show();
        $pages = $model->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('user_id DESC')->select();
        $this->assign('model', $pages);
        $this->assign('page',$show);
		$this->assign('search_key',$key);
        $this->display();     
    }

    public function delete()
    {
		$id = I('get.id',0,'intval');
        $model = M('info');
        $result = $model->where("user_id=".$id)->delete();
        if($result){
            $this->success("删除成功", U('info/index'));
        }else{
            $this->error("删除失败");
        }
    }
}
