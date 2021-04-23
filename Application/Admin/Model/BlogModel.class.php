<?php
namespace Admin\Model;
use Think\Model;
class PageModel extends Model{
    protected $_validate = array(
        array('title','require','请填写博客标题'), 
        array('name','require','请填写博客别名'), 
        array('name','','单页别名已经存在！',0,'unique',self::MODEL_BOTH), 
    );
}