<?php 
namespace User\Model;
use Think\Model\ViewModel;
class CommentViewModel extends ViewModel {
   public $viewFields = array(
     'comment'=>array('id','user_id','post_id','content','update_time'),
	 'manager'=>array('id','username','avatar'),
     'member'=>array('id','username','avatar','_on'=>'comment.user_id=member.id'),
   );
 }

?>