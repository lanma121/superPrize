<?php
/**
 * 异常,该框架使用的异常
 * 
 * 该框架默认做了日志的记录
 * 框架上下文已经被剔除
 * 
 * @author hufeng<@yunsupport.com>
 * @copyright 2014~ (c) @yunsupport.com
 * @Time: Fri 07 Nov 2014 11:01:05 PM CST
 */
class Blue_Exception extends Exception
{
	protected $argv = array();
	/**
	 * 初始化异常
	 *
	 * @param string $msg 异常信息描述
	 * @param array $argv 异常上下文信息
	 */
	public function __construct($msg, $argv = null){
		parent::__construct($msg, 0, null);
		$this->argv = $argv;
	}

	/**
	 * 获取上下文信息
	 *
	 * @return array
	 */
	public function getArgv(){
		return $this->argv;
	}
}

