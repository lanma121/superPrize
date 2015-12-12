<?php
/**
 * * 标准异常
 * *
 * * 异常会自动记录日志
 * *
 * * @author hufeng<@yunsupport.com>
 * * @copyright 2014-2015 @ yunsupport.com
 * */
class Core_Exception extends Exception
{
	public function __construct($message, $argv = null){
		parent::__construct($message, 0, null);
	}
}


