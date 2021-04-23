<?php
namespace User\Controller;
use Think\Controller;

/**
 * @Author: Martin Zhou
 * @Version: 1.0.2
 * @Copyright Tencent Security Response Center (TSRC)
 * @Project  https://security.tencent.com/index.php/xsrc
*/

class InfoController extends BaseController{

	/**
     * 更新联系方式
     */
	public function index()
    {
		$id = session('userId');
        $info = M('member')->where(array('id'=>$id))->select();
		$adress_info = M('address')->where(array('userid'=>$id))->select();
		$username = session('username');
        $this->assign('username', $username);
        $this->assign('info',$info);
		$this->assign('adress_info',$adress_info);
        $this->display();
    }
	
	/**
     * 功能：更细个人信息
     */
	public function update()
    {
		$id = session('userId');
		
        if (!IS_POST) {
            $info = M('member')->where(array('id'=>$id))->select();
            $this->assign('info',$info);
            $this->display();
        }
		
        if (IS_POST) {
			
            $model = M("member");
			
			$code = I('post.verify','','strtolower');
		    $alipay = I('post.alipay');
			$tel = I('post.tel','暂无','/^1[34578]\d{9}$/');
			$team = I('post.team');
			$website = I('post.website','暂无' ,'trim, validate_url, htmlspecialchars');
			$qqnumber = I('post.qqnumber','暂无' ,'/^\d+$/');
			$description = I('post.description');
			$wechat = I('post.wechat');
			$avatar = I('post.avatar');

			if(!($this->check_verify($code))){
				$this->error('验证码错误',U('post/index'));
			}
			
			$data['alipay'] = $alipay;
			$data['tel'] = $tel;
			$data['team'] = $team;
			$data['website'] = $website;
			$data['qqnumber'] = $qqnumber;
			$data['description'] = $description;
			$data['wechat'] = $wechat;
			$data['avatar'] = $avatar;
			
			if(strlen($data['team']) < 1 || strlen($data['qqnumber']) < 1 || strlen($data['wechat']) < 1 || strlen($data['description']) < 1){
				$this->error("个人信息字段不能为空", U('info/index'));
			}
									
            if ($model->where(array('id'=>$id))->field('alipay,tel,team,website,qqnumber,description,wechat,avatar')->save($data)) {
					session('avatar',$data['avatar']);                  
					$this->success("个人信息更新成功", U('info/index'));
            } else {
                    $this->error("个人信息更新失败", U('info/index'));
            }
        }
    }
	
	public function add_address(){
		
		$uid = session('userId');
		
        if (!IS_POST) {
            $this->error('非法操作!',U('info/index'));
        }
		
        if (IS_POST) {
            $model = M("address");
		    $data = I('post.');
			$data['userid'] = $uid;

			/**Start--校验CSRF TOKEN**/
			$token = $data['token'];
			$member = M('member')-> where(array('id'=>$uid)) -> find();
				
			if($token != $member['token']){
				$this->error("CSRF Token校验失败");
			}
			/**End--校验CSRF TOKEN**/	
			
			if(strlen($data['realname']) < 1 || strlen($data['adetail']) < 3){
				$this->error("姓名信息填写不正确", U('info/index'));
				exit();
			}

			if(!preg_match("/^1[34578]\d{9}$/", $data['mobile'])){
				$this->error("移动电话/长度格式不正确", U('info/index'));
				exit();
			}
			
			if(!preg_match("/^\d{6}$/", $data['zipcode']))
			{
				$this->error("邮编填写不正确", U('info/index'));
				exit();
			}

			$default_num = $model -> where(array('userid'=>$uid,'default'=>1))->count();
						
			if($data['default'] == '1' && $default_num >= 1)
			{
				$default_data['default'] = 0;
				$change_default = $model -> where(array('userid'=>$uid,'default'=>1)) -> save($default_data);
			}
			
            if ($model->field('zipcode,realname,mobile,adetail,default,userid')->add($data)) {
                    $this->success("地址添加成功", U('info/index'));
                } else {
                    $this->error("地址添加失败", U('info/index'));
            }
        }
	}
	
	public function edit_address(){
		
		$uid = session('userId');
		
        if (!IS_POST) {
            $this->error('非法操作!',U('info/index'));
        }
		
        if (IS_POST) {
            $model = M("address");
		    $data = I('post.');
			$data['userid'] = $uid;
			
			/**Start--校验CSRF TOKEN**/
			$token = $data['token'];
			$member = M('member')-> where(array('id'=>$uid)) -> find();
				
			if($token != $member['token']){
				$this->error("CSRF Token校验失败");
			}
			/**End--校验CSRF TOKEN**/	
			
			if(strlen($data['realname'])<1 || strlen($data['adetail'])<5){
				$this->error("信息填写不正确", U('info/index'));
				exit();
			}
			
			if(!preg_match("/^1[34578]\d{9}$/", $data['mobile'])){
				$this->error("移动电话填写不正确", U('info/index'));
				exit();
			}
			
			if(!preg_match("/^\d{6}$/", $data['zipcode']))
			{
				$this->error("邮编填写不正确", U('info/index'));
				exit();
			}
			
			$default_num = $model -> where(array('userid'=>$uid,'default'=>1))->count();
						
			if($data['default'] == '1' && $default_num >= 1)
			{
				$default_data['default'] = 0;
				$change_default = $model -> where(array('userid'=>$uid,'default'=>1)) -> save($default_data);
			}
			
            if ($model->where(array('id'=>$data['id'],'userid'=>$uid))->field('zipcode,realname,mobile,adetail,default')->save($data)) {
                    $this->success("地址添加成功", U('info/index'));
            } else {
                    $this->error("地址修改失败", U('info/index'));
            }
        }
    }
	
	public function query_address(){
		
		$uid = session('userId');
		
        if (!IS_POST) {
            $this->error('非法操作!',U('info/index'));
        }
		
        if (IS_POST) {
            $model = M("address");
		    $data = I('post.');
			$result = $model->where(array('id'=>$data['id'],'userid'=>$uid))->field('zipcode,realname,mobile,adetail,default')->find();
			if($result){
				$result['status'] = "1";
				$this->ajaxReturn($result,'JSON'); 
			}else{
				$this->error('非法操作!',U('info/index'));
			}
        }
    }

	public function query_bank(){
		
		$uid = session('userId');
		
        if (!IS_POST) {
            $this->error('非法操作!',U('info/index'));
        }
		
        if (IS_POST) {
            $model = M("member");
		    $data = I('post.');
			$result = $model->where(array('id'=>$uid))->field('bankcode,realname,idcode')->find();
			if($result){
				$result['status'] = "1";
				$this->ajaxReturn($result,'JSON'); 
			}else{
				$this->error('非法操作!',U('info/index'));
			}
        }
    }
	
	public function delete_address(){
		
		$uid = session('userId');
		
        if (!IS_POST) {
            $this->error('非法操作!',U('info/index'));
        }
		
        if (IS_POST) {
            $model = M("address");
		    $data = I('post.');
			
			$result = $model->where(array('id'=>$data['id'],'userid'=>$uid))->delete();
			if($result){
				$response['status'] = "1";
				$this->ajaxReturn($response,'JSON'); 
			}else{
				$response['status'] = "0";
				$this->ajaxReturn($response,'JSON'); 
			}
        }
    }

	public function edit_bank(){
		
		$uid = session('userId');
		
        if (!IS_POST) {
            $this->error('非法操作!',U('info/index'));
        }
		
        if (IS_POST) {
            $model = M("member");
		    $data = I('post.');
			
			if(strlen($data['realname'])<1){
				$this->error("姓名填写不正确", U('info/index'));
				exit();
			}
			
			if(!preg_match("/^\d{15,22}$/", $data['bankcode'])){
				$this->error("银行卡号填写不正确", U('info/index'));
				exit();
			}

			if(!preg_match("/^(^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$)|(^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])((\d{4})|\d{3}[Xx])$)$/", $data['idcode'])){
				$this->error("身份证号填写不正确", U('info/index'));
				exit();
			}			
			
			/**Start--校验CSRF TOKEN**/
			$token = $data['token'];
			$member = M('member')-> where(array('id'=>$uid)) -> find();
				
			if($token != $member['token']){
				$this->error("CSRF Token校验失败");
			}
			/**End--校验CSRF TOKEN**/	
			
            if ($model->where(array('id'=>$uid))->field('realname,bankcode,idcode')->save($data)) {
                    $this->success("财务信息修改成功", U('info/index'));
            } else {
                    $this->error("财务信息修改失败", U('info/index'));
            }
        }
    }
	
	public function upload(){
		$upload = new \Think\Upload();
		$upload->maxSize   =     3145728 ;
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');
		$upload->rootPath  =      './Public/Uploads/';
		$info   =   $upload->uploadOne($_FILES['photo']);
		if(!$info) {
			$this->error($upload->getError());
		} else{
			$result['code'] = "200";
			$result['savepath'] = $info['savepath'].$info['savename'];
			$this->ajaxReturn($result,'JSON'); 
		}
	}
	
	//验证码
    public function verify(){
		ob_clean();
        $Verify = new \Think\Verify();
        $Verify->codeSet = '123456789abcdefg';
        $Verify->fontSize = 16;
        $Verify->length = 4;
        $Verify->entry();
    }
	
    protected function check_verify($code){
        $verify = new \Think\Verify();
        return $verify->check($code);
    }
	
}
