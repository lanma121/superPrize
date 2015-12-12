<?php

/**
 * 
 * 
 * @author name <@yunsupport.com>
 * @copyright 2014~ (c) @yunsupport.com
 * @Time: Tue 11 Nov 2014 07:45:13 PM CST
 */
require __DIR__ . '/smarty/Smarty.class.php';
class Blue_View_Smarty implements Blue_View_Ins
{
	private $tpl = '';
	private $header = array();
	private $redirect = null;

	/**
	 * 设置模板
	 */
	public function setTpl($tpl){
		$this->tpl = $tpl;
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
	}

	/**
	 * 渲染模板数据
	 *
	 * @param array $data
	 *
	 * @return string 渲染后的数据
	 */
	public function fetch($data){
		$ins = $this->getSmartyIns($data);
		return $ins->fetch($this->tpl);
	}

	/**
	 * 输出渲染后的数据
	 *
	 * 会产生输出内容
	 *
	 * @param array $data
	 */
	public function display($data){
		//设置输出头
		foreach($this->header as $h){
			header($h);
		}
		$ins = $this->getSmartyIns($data['data']);
		//输出内容
		$ins->display($this->tpl);
	}

	private function getSmartyIns($data){
		$ins = new Smarty();
		$ins->setTemplateDir(PDP_APP_VIEW);//views
		$ins->setCompileDir(PDP_APP_DATA . '/smarty');

		//判断是否有smarty常量需要写入
		$ini = Core_Conf::getConf('smarty');
		if(is_array($ini) && isset($ini['const'])){
			$data['CONST'] = $ini['const'];
		}
		if(!empty($data)){
			if(isset($ini['config']) && $ini['config']['debug']){
				$data['SMARTY_DEBUG'] = $data;
			}
			$ins->assign($data);
		}

		return $ins;
	}
}
