<?php
/**
 * 细分的异常,阻断类的异常
 * 
 * @author hufeng<@yunsupport.com>
 * @copyright 2014~ (c) @yunsupport.com
 * @Time: Fri 07 Nov 2014 11:06:45 PM CST
 */

class Blue_Exception_Fatal extends Blue_Exception
{
	public function __construct($msg, $argv = null){
		parent::__construct($msg, $argv);
		Core_Log::fatal($msg, $argv);
	}
}

