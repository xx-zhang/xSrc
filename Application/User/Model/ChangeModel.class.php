<?php
namespace User\Model;
use Think\Model;
class ChangeModel extends Model{
    protected $_validate = array(
        array('oldpassword','require','请填写旧密码！'), 
		array('password','require','请填写密码！','','',self::MODEL_INSERT), 
     	array('repassword','password','确认密码不正确',0,'confirm'),
    );

}