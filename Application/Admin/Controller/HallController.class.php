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
 * 贡献榜管理
 */
class HallController extends BaseController
{
    /**
     * 日志记录
     */
	public function record($key="")
    {
        if($key == ""){
            $model = M('record');  
        }else{
            $where['user'] = array('like',"%$key%");
            $where['operator'] = array('like',"%$key%");
            $where['_logic'] = 'or';
            $model = M('record')->where($where); 
        } 
        
        $count  = $model->where($where)->count();
        $Page = new \Extend\Page($count,25);
        $show = $Page->show();
        $record = $model->limit($Page->firstRow.','.$Page->listRows)->where('type=1')->where($where)->order('id DESC')->select();
        $this->assign('model', $record);
        $this->assign('page',$show);
		$this->assign('search_key',$key);
        $this->display();     
    }

}
