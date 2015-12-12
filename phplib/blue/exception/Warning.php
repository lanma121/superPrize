<?php
/**
 * 警告的异常
 *
 * 异常被做了细化的分类
 * 
 * @author hufeng<@yunsupport.com>
 * @copyright 2014~ (c) @yunsupport.com
 * @Time: Fri 07 Nov 2014 11:06:45 PM CST
 */

class Blue_Exception_Warning extends Blue_Exception
{
	public function __construct($msg, $argv = null){
		parent::__construct($msg, $argv);
		Core_Log::warning($msg, $argv);
	}
}

