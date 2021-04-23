<?php
namespace Home\Controller;
use Think\Controller;

/**
 * @Author: Martin Zhou
 * @Version: 1.0.2
 * @Copyright Tencent Security Response Center (TSRC)
 * @Project  https://security.tencent.com/index.php/xsrc
*/

class PublicController extends Controller{
    
    public function _initialize(){
        if (ismobile()) {
            C('DEFAULT_V_LAYER','Mobile');
        }
		
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
		
    }
}
?>