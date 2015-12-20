<?php

/**
 * OpenSearch
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 26 Aug 2015 06:14:43 PM CST
 */

class Action_Open extends App_Action{
	
	private $sOpen;
	
	public function __prepare(){
		$this->sOpen = new App_Cloud_Search();
	}
	
	public function __execute(){
		$result = $this->sOpen->cloudSearch();
		print_r($result);
	}
}