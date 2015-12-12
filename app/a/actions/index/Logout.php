<?php

/**
 * 管理员注销
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 26 Aug 2015 06:14:43 PM CST
 */

class Action_Logout extends App_Action{
	
	public function __prepare(){
		
	}
	
	public function __execute(){
		$this->setLogout();
		$this->redirect('/a/index/login');	
	}
	
}