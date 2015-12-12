<?php

/**
 * 
 * 
 * @author name <@yunsupport.com>
 * @copyright 2014~ (c) @yunsupport.com
 * @Time: Tue 11 Nov 2014 07:44:01 PM CST
 */

Interface Blue_View_Ins
{
	/**
	 * 设置HTTP输出头
	 */
	public function setHeader($header);

	/**
	 * 设置模板
	 */
	public function setTpl($tpl);

	/**
	 * 直接跳转
	 */
	public function redirect($url);

	/**
	 * 解析并返回字符串数据
	 */
	public function fetch($data);

	/**
	 * 直接输出数据
	 */
	public function display($data);
}
