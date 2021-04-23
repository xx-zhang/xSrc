<?php

namespace Home\Controller;

use Think\Controller;

/**
 * @Author: Martin Zhou
 * @Version: 1.0.2
 * @Copyright Tencent Security Response Center (TSRC)
 * @Project  https://security.tencent.com/index.php/xsrc
*/

class HallController extends PublicController{

    public function index()
    {
		$model = D('HallView');
        $user = $model -> field('username,team,sum(points) as sum_points,pid,avatar,create_at') -> where('score > 0 and email <> \'0\'') -> order("sum_points desc") -> group('user_id') -> select();
		$username = session('username');
		$raw_year_hub = array();
        foreach ($user as $raw_date_arr) {
		   $year_val = date('Y',$raw_date_arr['create_at']);
		   array_push($raw_year_hub,$year_val);
		}
		$year_hub = array_unique($raw_year_hub);
		$this->assign('username', $username);
		$this ->assign('year_hub',$year_hub);
        $this->assign('user',$user);
        $this->display();   
    }
    
    public function sortdata()
    {
        $range = I('post.range');
        $month = I('post.month',0,'int');
		$year = I('post.year',0,'int');
		$day = get_last_day($year,$month);
        $model = D('HallView');
        switch ($range){
            case "year":
                $beginThisyear = strtotime(date('Y-01-01'));
                $endThisyear = strtotime(date('Y-12-31'));
                $map['time']  = array('BETWEEN',array($beginThisyear,$endThisyear));
                break;
            case "month":
                $beginThismonth= mktime(0,0,0,date('m'),1,date('Y'));
                $endThismonth = mktime(23,59,59,date('m'),date('t'),date('Y'));
                $map['time']  = array('BETWEEN',array($beginThismonth,$endThismonth));
                break;
            case "custom":
                $beginCustommonth = $day['firstday'];
                $endCustommonth = $day['lastday'];
                $map['time']  = array('BETWEEN',array($beginCustommonth,$endCustommonth));
                break;
            
        }
        //通过field函数，在其中使用sum()对score字段相加。
        $hallResult = $model -> where($map) -> where('score > 0 and email <> \'0\'') -> field('username,team,sum(points) as sum_points,pid,avatar') -> order("sum_points desc") -> group('user_id') -> select();
		if (!empty($hallResult)){
			$final_hallResult['status'] = '1';
			$final_hallResult['result'] = $hallResult;
			$this -> ajaxReturn ($final_hallResult,'JSON');
		} else {
			$final_hallResult['status'] = '2';
			$final_hallResult['result'] = $hallResult;
			$this -> ajaxReturn ($final_hallResult,'JSON');
		}
    }
	
    public function view(){
		$pid = I('get.pid',0,'number_int');
		$username = session('username');
		$model = M('member');
		$report = M('post');
		$user = $model -> where(array('pid'=>$pid)) -> select();
		$uid = $user[0]['id'];
		if ($uid != null){
			$reportnum = $report->where(array('user_id'=>$uid))->count();
			$highranknum = $report->where(array('user_id'=>$uid))->where('rank=4')->count();
			$this->assign('num',$reportnum);
			$this->assign('highranknum',$highranknum);
		};
		$redeem_count = M('order') -> where(array('userid'=>$uid)) -> count();
        $this->assign('username', $username);
		$this->assign('binfo',$user[0]);
		$this->assign('redeem_count',$redeem_count);
        $this->display();   
    }
	
}