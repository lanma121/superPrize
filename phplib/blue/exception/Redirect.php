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

class Blue_Exception_Redirect extends Blue_Exception
{
	private $url;

	/**
	 * 构造函数
	 *
	 * @param string $url 要跳转的地址
	 * @param string $msg 记录的信息
	 * @param string $argv 上下文
	 */
	public function __construct($url, $msg = '', $argv = null){
		parent::__construct($msg, $argv);
		$this->url = $url;
	}

	/**
	 * 返回要跳转的URL
	 *
	 * @return string
	 */
	public function getUrl(){
		return $this->url;
	}
}

