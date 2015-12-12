<?php

/**
 * 
 * 
 * @author name <@yunbix.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Fri 21 Aug 2015 07:33:02 PM CST
 */


class Service_Passport
{
	/**
	 * 密码的生成函数
	 *
	 * @param string $pw 密码
	 *
	 * @return string
	 */
	public function password($pw){
		$salt = $this->randSeed();
		$password = md5($salt . $pw) . ':' . $salt;
		return $password;
	}

	/**
	 * 检查密码是否正确
	 *
	 * @param string $pw 密码原文
	 * @param string $enc 加密后的字符串
	 *
	 * @return bool
	 */
	public function checkPw($pw, $enc){
		list($m, $salt) = explode(':', $enc);
		return ($m == md5($salt . $pw)) ? true : false;
	}

	/**
	 * 生成随机的加密种子
	 *
	 * 主要是避免生成加密后的密码重复 从而导致密码泄露
	 *
	 * @return string
	 */
	private function randSeed(){
		return mt_rand(10, 99);
	}
}
