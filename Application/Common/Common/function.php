<?php 
function dd($data)
{
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}


function getSortedCategory($data,$pid=0,$html="|---",$level=0)
{
	$temp = array();
	foreach ($data as $k => $v) {
		if($v['pid'] == $pid){
	
			$str = str_repeat($html, $level);
			$v['html'] = $str;
			$temp[] = $v;

			$temp = array_merge($temp,getSortedCategory($data,$v['id'],'|---',$level+1));
		}
		
	}
	return $temp;
}


function getSettingValueDataByKey($key)
{
	return M('setting')->getByKey($key);
}


function getSettingValueFieldByKey($key,$field)
{
	return M('setting')->getFieldByKey($key,$field);
}

function get_last_day($y = "", $m = ""){
	if ($y == "") $y = date("Y");
	if ($m == "") $m = date("m");
	$m = sprintf("%02d", intval($m));
	$y = str_pad(intval($y), 4, "0", STR_PAD_RIGHT); 
	$m>12 || $m<1 ? $m=1 : $m=$m;
	$firstday = strtotime($y . $m . "01000000");
	$firstdaystr = date("Y-m-01", $firstday);
	$lastday = strtotime(date('Y-m-d 23:59:59', strtotime("$firstdaystr +1 month -1 day")));

	return array(
		"firstday" => $firstday,
		"lastday" => $lastday
	);
}

function notify_by_wxrobot($callback_url, $noti_content)
{

	$post_data = array("msgtype" => "text", "text" => array("content"=>$noti_content));
	// $post_data = array("chatid" => $user_arr, "msgtype" => "text", "text" => array("content"=>$noti_content));
	$post_data = json_encode($post_data);
	
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $callback_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=utf-8'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $data = curl_exec($ch);
    curl_close($ch);

	return $data;
	
}