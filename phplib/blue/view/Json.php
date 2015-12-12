<?php

/**
 * 
 * 
 * @author name <@yunsupport.com>
 * @copyright 2014~ (c) @yunsupport.com
 * @Time: Tue 11 Nov 2014 07:45:13 PM CST
 */
class Blue_View_Json implements Blue_View_Ins
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
		$this->header = $header;
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
		$this->display(array(
			'redirect' => $url,
		));
	}

	/**
	 * 渲染模板数据
	 *
	 * @param array $data
	 *
	 * @return string 渲染后的数据
	 */
	public function fetch($data){
		$cnt = json_encode($data);
		$cb = $this->getCB();
		if(!empty($cb)){
			$cnt = sprintf('%s(%s);', $cb, $cnt);
		}

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
		$cb = $this->getCB();
		//设置Json的Content输出头
		if(empty($cb)){
			header('Content-type: application/json');
		}else{
			header('Content-type: application/javascript');
		}
		//设置输出头
		foreach($this->header as $h){
			header($h);
		}
		//输出内容
		echo $this->fetch($data);
	}

	/**
	 * 获取callback
	 *
	 * 如果不存在,则返回null
	 *
	 * @param mixed
	 */
	public function getCB(){
		if(isset($_GET['_cb']) && preg_match('/^[0-9a-z]+$/i', $_GET['_cb'])){
			return $_GET['_cb'];
		}
		return NULL;
	}
}
