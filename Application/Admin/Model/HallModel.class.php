<?php
namespace Admin\Model;
use Think\Model;
class LinksModel extends Model{
    protected $_validate = array(
        array('name','require','请填写链接标题！'), 
        array('url','require','请填写链接！'), 
    );
}