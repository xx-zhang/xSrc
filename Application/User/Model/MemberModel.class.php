<?php
namespace User\Model;
use Think\Model;
class MemberModel extends Model{
    protected $_validate = array(
        array('username','require','请填写用户名！'), 
        array('email','require','请填写邮箱！'), 
        array('email','email','邮箱格式错误！'), 
        array('password','require','请填写密码！','','',self::MODEL_INSERT), 
     	array('repassword','password','确认密码不正确',0,'confirm'), 
        array('username','','该用户名已存在',0,'unique',self::MODEL_BOTH), 
        array('email','','该邮箱已存在',0,'unique',self::MODEL_BOTH),
    );

    protected $_auto = array(
    	array('password','md5',1,'function') , 
        array('update_at','time',2,'function'), 
        array('create_at','time',1,'function'), 
        array('login_ip','get_client_ip',3,'function'), 
    );


}
