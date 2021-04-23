<?php
namespace Admin\Model;
use Think\Model;
class CommentModel extends Model{
    protected $_validate = array(
        array('content','require','请填写评论内容'), 
	);
	
    protected $_auto = array ( 
	    array('admin_name','getUid',1,'callback'), 
        array('update_time','time',1,'function'), 
    );
	
    protected function getUid(){
    	return session('adminname');
    }
}