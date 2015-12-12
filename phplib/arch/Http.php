<?php

/**
 * 
 * 
 * @author name <@yunsupport.com>
 * @copyright 2014~ (c) @yunsupport.com
 * @Time: Thu 18 Dec 2014 12:13:14 PM CST
 */

class Arch_Http
{
	private $ch;
	private $cTimeout = 3;
	private $timeout = 10;

	public function __construct($url){
		$this->ch = curl_init();
		$this->setOpt(CURLOPT_URL, $url);
	}

	/**
	 * 执行GET请求
	 *
	 * @param array $data
	 *
	 * @return string
	 */
	public function get($data = array()){
		return $this->exec();
	}

	/**
	 * 执行post请求
	 *
	 * @param string $url
	 * @param array $data
	 *
	 * @return array
	 */
	public function post($data = array()){
		$this->setOpt(CURLOPT_POST, true);
		$this->setOpt(CURLOPT_POSTFIELDS, $this->buildParam($data));

		return $this->exec();
	}

	/**
	 * 执行最终的请求
	 *
	 * @return string
	 */
	public function exec(){
		$this->setOpt(CURLOPT_RETURNTRANSFER, true);

		/*
		$this->setOpt(CURLOPT_SSL_VERIFYPEER, FALSE);
		$this->setOpt(CURLOPT_SSL_VERIFYHOST, FALSE);
		 */

		$this->setOpt(CURLOPT_CONNECTTIMEOUT, $this->cTimeout);
		$this->setOpt(CURLOPT_TIMEOUT, $this->timeout);
		$body = curl_exec($this->ch);

		if($body === false){
			$info = curl_getinfo($this->ch);
			throw new Blue_Exception_Warning('curl请求失败', $info);
		}

		curl_close($this->ch);
		return $body;
	}

	public function setOpt($k, $v){
		curl_setopt($this->ch, $k, $v);
	}

	/**
	 * 组建请求的字符串
	 *
	 * @param array $data
	 *
	 * @return string
	 */
	public function buildParam($data){
		$ret = array();
		foreach($data as $k => $v){
			$ret[] = urlencode($k) . '=' . urlencode($v);
		}
		return implode('&', $ret);
	}
}
