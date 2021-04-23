<?php
namespace Admin\Controller;
use Admin\Controller;

/**
 * @Author: Martin Zhou
 * @Version: 1.0.2
 * @Copyright Tencent Security Response Center (TSRC)
 * @Project  https://security.tencent.com/index.php/xsrc
*/

class SettingController extends BaseController
{
	public function index()
    {
		$site_settings = M('setting') -> where(array('type'=>'front'))->select();
		foreach($site_settings as $single_site_settings){
			if($single_site_settings['name']=='site_name_cn'){
				$site_name_cn = $single_site_settings['value'];
			} elseif($single_site_settings['name']=='site_intro'){
				$site_intro = $single_site_settings['value'];
			} elseif($single_site_settings['name']=='site_analytics'){
				$site_analytics = $single_site_settings['value'];
			} elseif($single_site_settings['name']=='site_copyright'){
				$site_copyright = $single_site_settings['value'];
			} elseif($single_site_settings['name']=='site_qq'){
				$site_qq = $single_site_settings['value'];
			} elseif($single_site_settings['name']=='site_email'){
				$site_email = $single_site_settings['value'];
			} elseif($single_site_settings['name']=='site_about'){
				$site_about = $single_site_settings['value'];
			} elseif($single_site_settings['name']=='site_career'){
				$site_career = $single_site_settings['value'];
			} elseif($single_site_settings['name']=='site_wechat'){
				$site_wechat = $single_site_settings['value'];
			} elseif($single_site_settings['name']=='site_name_en'){
				$site_name_en = $single_site_settings['value'];
			} elseif($single_site_settings['name']=='site_abbrev'){
				$site_abbrev = $single_site_settings['value'];
			} elseif($single_site_settings['name']=='site_analytics'){
				$site_abbrev = $single_site_settings['value'];
			}
		}
		
		$this -> assign('site_name_cn',$site_name_cn);
		$this -> assign('site_intro',$site_intro);
		$this -> assign('site_analytics',$site_analytics);
		$this -> assign('site_copyright',$site_copyright);
		$this -> assign('site_qq',$site_qq);
		$this -> assign('site_email',$site_email);
		$this -> assign('site_about',$site_about);
		$this -> assign('site_career',$site_career);
		$this -> assign('site_wechat',$site_wechat);
		$this -> assign('site_name_en',$site_name_en);
		$this -> assign('site_abbrev',$site_abbrev);
		$this -> assign('site_analytics',$site_analytics);
        $this->display();     
    }
	

	public function notify()
    {
		$site_settings = M('setting') -> where(array('type'=>'notify'))->select();
		foreach($site_settings as $single_site_settings){
			if($single_site_settings['name']=='site_notify_method'){
				$site_notify_method = $single_site_settings['value'];
			} elseif($single_site_settings['name']=='site_notify_users'){
				$site_notify_users = $single_site_settings['value'];
			} elseif($single_site_settings['name']=='site_robot_callback'){
				$site_robot_callback = $single_site_settings['value'];
			} elseif($single_site_settings['name']=='site_notify_method'){
				$site_notify_method = $single_site_settings['value'];
			} 
		}
		
		$this -> assign('site_notify_method',$site_notify_method);
		$this -> assign('site_notify_users',$site_notify_users);
		$this -> assign('site_robot_callback',$site_robot_callback);
		$this -> assign('site_notify_method',$site_notify_method);

        $this->display();     
    }
	
    /**
     * 更新基础配置
     */
    public function update()
    {
        if (!IS_POST) {
            $this->display();
        }
        if (IS_POST) {
                $model = M("setting");
				$data = I('post.');
				
				/**Start--校验CSRF TOKEN**/
				$token = I('post.token');
				$adminId = session('adminId');
				$manager = M('manager')-> where(array('id'=>$adminId)) -> find();
						
				if($token != $manager['token']){
					$this->error("非法请求");
				}
				/**End--校验CSRF TOKEN**/
				
				$data_keys = array_keys($data);
				foreach ($data_keys as $data_keys_val){
					$data_val['value'] = $data[$data_keys_val];
					$model-> where(array('name'=>$data_keys_val))->save($data_val);
				}
				$this->redirect('setting/index');
        }
    }

    /**
     * 更新基础配置
     */
    public function update_noti()
    {
        if (!IS_POST) {
            $this->display();
        }
        if (IS_POST) {
                $model = M("setting");
				$data = I('post.');
				
				/**Start--校验CSRF TOKEN**/
				$token = I('post.token');
				$adminId = session('adminId');
				$manager = M('manager')-> where(array('id'=>$adminId)) -> find();
						
				if($token != $manager['token']){
					$this->error("非法请求");
				}
				/**End--校验CSRF TOKEN**/
				
				$data_keys = array_keys($data);
				foreach ($data_keys as $data_keys_val){
					$data_val['value'] = $data[$data_keys_val];
					$model-> where(array('name'=>$data_keys_val))->save($data_val);
				}
				$this->redirect('setting/notify');
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
		}else{
			$result['code'] = "200";
			$result['savepath'] = $info['savepath'].$info['savename'];
            $this->ajaxReturn($result,'JSON'); 
		}
	}

}
