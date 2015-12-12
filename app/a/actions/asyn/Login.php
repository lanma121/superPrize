<?php

/**
 * 管理员登录
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 26 Aug 2015 06:14:43 PM CST
 */

class Action_Login extends App_Action{
	
	private $loginInfo;
	
	public function __prepare(){
		$this->setView(Blue_Action::VIEW_JSON);
		$this->loginInfo = $this->getLogined();
	}
	
	public function __execute(){
		//参数信息过滤
		$data = $this->_verify();
		//数据信息不完整
		if(!($data && count($data)>0)){
			return array('result'=>1);
		}
		//验证码错误
		if(strtolower($this->loginInfo['adminInfo']['authNumber'])!=strtolower($data['authInput'])){
			return array('result'=>2);
		}
		//验证通过
		return array('result'=>3);
	}
	
/*
	 * 数据信息过滤
	 */
	private function _verify(){
		//参数信息判定
		if($this->getRequest()->isPost()){
			$data = array(
				'authInput' 		=> trim($_POST['authInput']),
			);
			$rule = array(
				'authInput' 		=> array('filterStrlen', array(0, 30), '', true)
			);
			return Blue_Filter::filterArray($data, $rule);
		}
		return null;
	}
	
}