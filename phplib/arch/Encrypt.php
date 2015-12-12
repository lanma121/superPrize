<?php
/**
 * 加密算法
 *
 * 一种可逆加密的算法，实际算法模型为AES 
 *
 * 支持类型：
 *	AES
 * 
 * @author hufeng<@yunsupport.com>
 * @copyright 2014~ (c) @yunsupport.com
 * @Time: Mon 24 Nov 2014 03:09:35 PM CST
 */

class Arch_Encrypt
{
	public static function factory($type){
		$class = 'Arch_Encrypt_' . ucfirst($type);

		if(class_exists($class)){
			return new $class();
		}
		throw new Core_Exception("Class {$class}不存在");
	}
}
