<?php
namespace User\Model;
use Think\Model;
class PostModel extends Model{

    protected $_validate = array(
        array('title','require','请填写报告标题'), 
		array('content','require','请填写报告内容'),
		array('cate_id','require','请选择报告分类'),
    );
    protected $_auto = array ( 
        array('time','time',1,'function'),
        array('user_id','getUid',1,'callback'),
    );
    protected function getUid(){
    	return session('userId');
    }
}