<?php

/**
 * 使用msgpack打包
 * 
 * @author hufeng<@yunbix.com>
 * @copyright 2014~ (c) @yunbix.com
 * @Time: Tue 11 Nov 2014 07:45:13 PM CST
 */
class Blue_View_MsgPack implements Blue_View_Ins
{
	private $header = array();
	private $redirect = null;

	/**
	 * 设置模板
	 *
	 * Json实际无效
	 */
	public function setTpl($tpl){
	}

	/**
	 * 设置HEADER
	 */
	public function setHeader($header){
	}

	/**
	 * 设置跳转
	 *
	 * 一旦设置后,后面的模板输出将无效
	 *
	 * @param string $url 要跳转到的URL
	 */
	public function redirect($url){
		header("Location: {$url}");
	}

	/**
	 * 渲染模板数据
	 *
	 * @param array $data
	 *
	 * @return string 渲染后的数据
	 */
	public function fetch($data){
		$cnt = msgpack_pack($data);

		return $cnt;
	}

	/**
	 * 输出渲染后的数据
	 *
	 * 会产生输出内容
	 *
	 * @param array $data
	 */
	public function display($data){
		header('Content-type: application/object');
		//输出内容
		echo $this->fetch($data);
	}
}
