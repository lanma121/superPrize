<?php

/**
 * 
 * 
 * @author name <@yunsupport.com>
 * @copyright 2014~ (c) @yunsupport.com
 * @Time: Mon 24 Nov 2014 02:45:35 PM CST
 */

class App_AdminAction extends Blue_Action
{
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


	/**
	 *  * 获取当前登录的管理员的信息
	 *   *
	 *    * @return array
	 *     */
	protected function getSession(){
		if(null === $this->session){
			$sess = Blue_Passport::getInfo();
			if(empty($sess)){
				$this->session = array();
			}else{

				$this->session = $sess;
			}
		}

		return $this->session;
	}

	/**
	 *  * 需要登录，如果没有登录，则自动跳转到登录页
	 *   */
	protected function needLogin(){
		$session = $this->getSession();

		if(empty($session)){
			throw new Blue_Exception_Redirect("/xidian/index/adminlogin");
		}

		$this->addRet('session', $session);
	}
}

