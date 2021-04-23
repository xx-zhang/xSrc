<?php
namespace Admin\Controller;
use Admin\Controller;

/**
 * @Author: Martin Zhou
 * @Version: 1.0.2
 * @Copyright Tencent Security Response Center (TSRC)
 * @Project  https://security.tencent.com/index.php/xsrc
*/


class IndexController extends BaseController{

    public function index(){
		$page = M('page')->count();
		$user = M('member')->count();
		$post = M('post')->count();
		$detail = M('page')->order('update_time desc')->select();
		$order = M('order')->count();
        $week_start = strtotime(date("Y-m-d H:i:s", mktime(0, 0, 0, date("m"), date("d") - date("w") + 1, date("Y"))));
        $week_end = strtotime(date("Y-m-d H:i:s", mktime(23, 59, 59, date("m"), date("d") - date("w") + 7, date("Y"))));
        $map['time']  = array('BETWEEN',array($week_start,$week_end));
        $postnum = M('post')->where($map)->count();
        $this->assign('page',$page);
		$this->assign('user',$user);
		$this->assign('post',$post);
		$this->assign('order',$order);
        $this->assign('postnum',$postnum);
		$this->assign('detail',$detail);
        $this->display();
    }
	
	public function chart(){
		$chart_result = M('post') -> query('SELECT FROM_UNIXTIME(time,\'%Y-%m-%d\') as date_val,count(*) from post GROUP BY date_val ORDER BY date_val LIMIT 7;');
		
		$days['1'] = date('Y-m-d', strtotime('-6 days'));
		$days['2'] = date('Y-m-d', strtotime('-5 days'));
		$days['3'] = date('Y-m-d', strtotime('-4 days'));
		$days['4'] = date('Y-m-d', strtotime('-3 days'));
		$days['5'] = date('Y-m-d', strtotime('-2 days'));
		$days['6'] = date('Y-m-d', strtotime('-1 days'));
		$days['7'] = date('Y-m-d', strtotime('now'));
		
		foreach ($chart_result as $single_result){
			if($single_result['date_val']==$days['7']){
				$output_result['7'] = $single_result['count(*)'];
			}elseif($single_result['date_val']==$days['6']){
				$output_result['6'] = $single_result['count(*)'];
			}elseif($single_result['date_val']==$days['5']){
				$output_result['5'] = $single_result['count(*)'];
			}elseif($single_result['date_val']==$days['4']){
				$output_result['4'] = $single_result['count(*)'];
			}elseif($single_result['date_val']==$days['3']){
				$output_result['3'] = $single_result['count(*)'];
			}elseif($single_result['date_val']==$days['2']){
				$output_result['2'] = $single_result['count(*)'];
			}elseif($single_result['date_val']==$days['1']){
				$output_result['1'] = $single_result['count(*)'];
			}
		}
		
		$this -> ajaxReturn ($output_result,'JSON');
	}
}
