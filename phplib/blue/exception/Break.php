<?php
/**
 * 用于跳出的异常
 *
 * 这种用法仅仅为了逻辑上的方便
 * 但不适用大量适用
 * 
 * @author hufeng<@yunsupport.com>
 * @copyright 2014~ (c) @yunsupport.com
 * @Time: Fri 07 Nov 2014 11:06:45 PM CST
 */

class Blue_Exception_Break extends Blue_Exception
{
	public function __construct($msg = '', $argv = null){
		parent::__construct($msg, $argv);
	}
}

