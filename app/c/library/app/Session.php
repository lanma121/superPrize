<?php

/**
 * 
 * 
 * @author name <@yunbix.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Sat 22 Aug 2015 08:08:27 AM CST
 */


class App_Session
{
	/**
	 * 获取1.0版本的Session信息
	 *
	 * 这里的方式对全局有影响 使用谨慎
	 *
	 * @return mixed 若不存在，则返回null
	 */
	static public function sess1(){
		$mc = Arch_Memcache::factory('default');
		$k = $_COOKIE['PHPSESSID'];

		$r = $mc->getOrigin($k);

		if(empty($r)){
			return null;
		}

		//反序列化Session
		if(session_status() == PHP_SESSION_NONE){
			session_start();
			$last = $_SESSION;
		}
		session_decode($r);
		$r = $_SESSION;
		$_SESSION = $last;

		return $r;
	}
}

