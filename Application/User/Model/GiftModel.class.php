<?php
namespace User\Model;
use Think\Model;
class GiftModel extends Model{
	
    protected $_validate = array(
	    array('username','require','用户名缺失'), 
        array('realname','require','请填写真实姓名'), 
        array('zipcode','require','请填写邮编'), 
        array('location','require','请填写地址'),
		array('tel','require','请填写联系电话'), 
		array('alipay','require','请填写支付宝账号，方便发放现金奖励'), 
		array('gid','require','请填写礼品名称'), 
    );
	
	protected $_auto = array ( 
        array('user_id','getUid',1,'callback'), 
		array('username','getUsername',1,'callback'), 
    );
	
	protected function getUid(){
    	return session('userId');
    }
	
	protected function getUsername(){
    	return session('username');
    }
}