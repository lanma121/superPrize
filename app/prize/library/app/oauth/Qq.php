<?php

/**
 * 
 * 
 * @author name <@yunbix.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Sat 22 Aug 2015 08:08:27 AM CST
 */
// 引入qq登录API
require_once(__DIR__."/qq/qqConnectAPI.php");

class App_Oauth_Qq
{
	/**
	 * 执行qq登录
	 */
	static public function qqLogin(){
		$qq = new QC();
		$qq->qq_login();
	}

	/**
	 * 得到一个QC实例
	 */
	static public function getInstance($acs='', $oid=''){
		$qq = new QC($acs, $oid);
		return $qq;
	}
}

