<?php
/**
 * 命名空间
 *
 * 主要描述了当前运行环境下的一些环境变量
 *
 * 多进程场景下有效 多线程场景不适用
 * 
 * @author hufeng<@yunbix.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Tue 18 Aug 2015 10:14:18 PM CST
 */

class Arch_Env
{
	const NS = 'ns';	//当前系统的命名空间 主要应用于多APP\SYSTEM\TOPIC等场景下的切换

	static private $env = array();

	/**
	 * 设置当前环境的某个变量
	 *
	 * @param string $k
	 * @param mixed $v
	 */
	static public function set($k, $v){
		self::$env[$k] = $v;
	}

	/**
	 * 获取当前某个变量
	 *
	 * @param string $k
	 *
	 * @return mixed
	 */
	static public function get($k){
		return isset(self::$env[$k]) ? self::$env[$k] : null;
	}
}
