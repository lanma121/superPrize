<?php

/**
 * 系统验证码
 * @1399871902@qq.com
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 16 Sep 2015 12:56:54 PM CST
 */

class Action_Valid extends App_Action{
		
	public function __prepare(){
		$this->hookNeedLogin = false;
	}

	public function __execute(){
		$image = new Arch_ValidImage();
		$image->display();
	}
}