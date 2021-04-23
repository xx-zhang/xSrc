<?php
namespace Admin\Model;
use Think\Model;
class GiftsModel extends Model{
    protected $_validate = array(
        array('title','require','请填写礼品名称'),
        array('price','require','请填写礼品价格'), 
        array('stock','require','请填写礼品库存'),
		array('price','require','请填写礼品价格'),
    );
}