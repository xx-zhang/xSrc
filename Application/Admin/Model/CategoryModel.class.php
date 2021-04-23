<?php
namespace Admin\Model;
use Think\Model;
class CategoryModel extends Model{
    protected $_validate = array(
        array('title','require','请填写分类标题'), 
        array('name','require','请填写分类别名'), 
		array('title','require','请填写分类名称'), 
        array('name','','分类别名重复',0,'unique',self::MODEL_BOTH),
		array('title','','分类名称重复',0,'unique',self::MODEL_BOTH),
    );
}