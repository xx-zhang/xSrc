<?php
namespace Admin\Model;
use Think\Model;
class SettingModel extends Model{
    protected $_validate = array(
        array('key','require','请填写站点名！'), 
        array('value','require','请填写字段值！'), 
        array('description','require','请填写字段描述！'), 
        array('key','','字段名已经存在！',0,'unique',self::MODEL_BOTH), 
    );
}