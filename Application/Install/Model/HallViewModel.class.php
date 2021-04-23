<?php 
namespace Home\Model;
use Think\Model\ViewModel;
class HallViewModel extends ViewModel {
   public $viewFields = array(
     'post'=>array('user_id','score'),
     'member'=>array('username', 'team', 'pid','avatar','create_at', '_on'=>'post.user_id = member.id'),
   );
 }

?>