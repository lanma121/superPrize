<?php
/**
 * 获取登录信息
 * 
 * @author hufeng<@yunsupport.com>
 * @copyright 2014~ (c) @yunsupport.com
 * @Time: Mon 24 Nov 2014 01:30:40 PM CST
 */
class Blue_Passport
{
	/**
	 * 获取当前登录后的用户的信息
	 *
	 * 仅获取从解密后的字符串的信息
	 *
	 * 如果不存在或者用户未登录，返回信息为NULL
	 *
	 * @return array
	 */
	public static function getInfo(){
		$ini = self::getConf();
		$str = self::getCookie($ini['cookie']);

		if(empty($str)){
			return null;
		}

		return self::decrypt($str, $ini['key']);
	}

	/**
	 * 设置账户的信息
	 *
	 * 当用户登录后，自动设置信息
	 *
	 * @param array $data 需要设置的用户信息
	 * @param int $timeout 超时时间，如果不设置，默认为当前浏览器进程
	 *
	 * @return
	 */
	public static function setInfo($data, $timeout = null){
		$ini = self::getConf();
		self::setCookie($ini['cookie'], self::encrypt($data, $ini['key']), $timeout);
	}

	private static function encrypt($data, $key){
		$obj = Arch_Encrypt::factory('aes');
		$str = $obj->encode($data, $key);

		return $str;
	}

	private static function decrypt($str, $key){
		$obj = Arch_Encrypt::factory('aes');
		$data = $obj->decode($str, $key);

		return $data;
	}

	private static function getCookie($name){
		return $_COOKIE[$name];
	}

	public static function setCookie($name, $str, $timeout = null){
		if(empty($timeout)){
			$timeout = 0;
		}else{
			$timeout = time() + $timeout;
		}
		setcookie($name, $str, $timeout, '/');
	}

	private static function getConf(){
		if(Arch_Yaml::isExist('blue')){
			$ini = Arch_Yaml::get('blue', 'passport');
		}else{
			$ini = Core_Conf::getConf('blue:passport');
		}
		if(empty($ini)){
			throw new Blue_Exception_Fatal("配置blue.ini=>passport不存在");
		}
		return $ini;
	}
}

