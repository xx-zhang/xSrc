<?php
namespace Admin\Model;
use Think\Model;
class PostModel extends Model{
    protected $_validate = array(
        array('title','require','请填写报告标题！'), 
        array('type',array(1,2,3,4),'请勿恶意修改字段',3,'in'), 
    );
    protected $_auto = array ( 
        array('time','time',1,'function'), 
        array('user_id','getUid',1,'callback'), 
    );
    protected function getUid(){
    	return session('adminId');
    }
}