<?php

/**
 * 
 * 
 * @author name <@yunsupport.com>
 * @copyright 2014~ (c) @yunsupport.com
 * @Time: Mon 24 Nov 2014 02:45:35 PM CST
 */

class App_Action extends Blue_Action{

	const SESSION_TOKEN = 'djcisu&*%$3df';

	protected $hookNeedLogin = false;

	protected function __before(){
		if($this->hookNeedLogin){
			$this->needLogin();
		}
	}

	protected function parseToken($token, $needLogin = false){
		if(empty($token)){
			return null;
		}
		$aes = Arch_Encrypt::factory('aes');
		$ret = $aes->decode($token, self::SESSION_TOKEN);

		if($needLogin && (empty($ret) || empty($ret['id']))){
			throw new Blue_Exception_Warning("用户需要登录");
		}

		return $ret;
	}
	
}

