<?php

/**
 * 获取会员登录信息
 * @author 1399871902 <@qq.com>
 * @copyright 2015~ (c) @qq.com
 * @Time: Mon 07 Sep 2015 04:18:30 PM CST
 */

class Action_UserInfo extends App_Action{
	
	private $loginInfo;
	
	public function __prepare(){
		$this->setView(App_Action::VIEW_JSON);
		$this->loginInfo = $this->getLogined();
	}
	
	public function __execute(){
		$array = array();
		$array['uid'] = $this->loginInfo['user_info']['users_id'];
		$array['rid'] = $this->loginInfo['user_info']['relation_id'];
		$array['mid'] = $this->loginInfo['user_info']['member_id'];
		return $array;
	}
}