<?php

/**
 * 管理员管理入口
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 26 Aug 2015 06:14:43 PM CST
 */

class Action_Index extends App_Action{

	public function __prepare(){
		$this->setView(Blue_Action::VIEW_SMARTY2);
	}
	
	public function __execute(){
		return array();
	}
	
}