<?php

/**
 * 远程调用服务端
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 26 Aug 2015 06:14:43 PM CST
 */

class Action_Server extends App_Action{
	
	private $sOper;
	
	public function __prepare(){
		$this->sOper = new App_Soap_Oper();
	}
	
	public function __execute(){
		//开始发布远程服务
		$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA)?$HTTP_RAW_POST_DATA:'';
		$this->sOper->server->service($HTTP_RAW_POST_DATA);
	}
	
}