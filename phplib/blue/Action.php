<?php

/**
 * Action的基类
 *
 * 处理了基本的逻辑
 * 如果需要集成业务的一些活动,比如:用户Session,需要继承该类
 * 
 * 已经做了基本的初始化 view对象
 * 
 * @author name <@yunsupport.com>
 * @copyright 2014~ (c) @yunsupport.com
 * @Time: Fri 07 Nov 2014 11:13:57 PM CST
 */

class Blue_Action extends Yaf_Action_Abstract
{
	const VIEW_SMARTY = 'smarty';	//适用Smarty模板来进行渲染
	const VIEW_SMARTY2 = 'smarty2';	//适用Smarty模板来进行渲染
	const VIEW_JSON = 'json';	//使用Json来进行渲染
	const VIEW_OBJECT = 'object';	//使用Object来进行渲染,适用于下载或者自定义的场景
	const VIEW_MSGPACK = 'msgPack';	//使用MsgPack打包

	const SUCC = 0;
	const FAIL = 1;

	/**
	 * 选项
	 */
	private $opt = array(
		'view' => 'smarty'
	);

	/**
	 * 核心逻辑
	 */
	final public function execute(){	
		$this->ret['data'] = array();
		try{
			$this->_init();	//初始化基本环境
			$this->__prepare();	//针对下游的支持函数
			$this->__before();	//针对执行之前的钩子,这个钩子提供个具体的框架通用逻辑使用,如用户登陆判断 权限验证等
			$data = $this->__execute();	//实际执行业务逻辑,并返回数据的函数
			empty($data) && $data = array();
			$this->ret['data'] = array_merge($this->ret['data'], $data);
			$this->__after();	//针对执行之后的钩子,这个钩子是提供给具体框架实现通用业务逻辑使用
			$this->__complete();	//完成基本的收尾工作
			$this->ret['flag'] = self::SUCC;
		}catch(Blue_Exception_Break $e){
			//啥都不干
			//只是用于跳出逻辑
		}catch(Blue_Exception_Redirect $e){
			$this->ret['redirect'] = $e->getUrl();
			Core_Log::debug($e->getMessage(), $e->getArgv());
			$this->ret['flag'] = self::SUCC;
		}catch(Blue_Exception_Fatal $e){
			$this->ret['msg'] = 'system error';
			$this->ret['flag'] = self::FAIL;
			$this->_message('系统错误');
		}catch(Blue_Exception_Warning $e){
			$this->ret['msg'] = $e->getMessage();
			$this->ret['data'] = $e->getArgv();
			$this->ret['flag'] = self::FAIL;
			$this->_message($e->getMessage());
		}catch(Blue_Exception $e){
			$this->ret['msg'] = 'system error';
			$this->ret['flag'] = self::FAIL;
			$this->_message('系统错误');
			//$this->ret['msg'] = $e->getMessage();
			//$this->ret['data'] = $e->getArgv();
		}
		//过滤掉NULL为空字符串
		$this->_filterNullToString();

		//输出
		$this->_output();
	}

	/**
	 * 实际执行业务逻辑的函数
	 *
	 * @return array
	 */
	public function __execute(){
		return array();
	}

	/**
	 * 业务的收尾工作
	 */
	public function __complete(){
	}

	/**
	 * 业务的准备工作
	 *
	 * 初始化对象 变量等
	 */
	public function __prepare(){
	}

	/**
	 * 提供给具体业务通用逻辑的钩子函数
	 */
	protected function __before(){
	}
	/**
	 * 提供给具体业务通用逻辑的钩子函数
	 */
	protected function __after(){
	}

	/**
	 * 获取当前对登录的用户的信息
	 *
	 * @return array
	 */
	public function getLogined(){
		return Blue_Passport::getInfo();
	}

	/**
	 * 设置用户登录信息
	 *
	 * @param array $data
	 * @param int $timeout
	 *
	 */
	public function setLogin($data, $timeout = 86400){
		return Blue_Passport::setInfo($data, $timeout);
	}

	/**
	 * 设置登录退出
	 */
	public function setLogout(){
		return Blue_Passport::setInfo(null, -1);
	}

	/**
	 * 增加输出变量
	 *
	 * @param string $k 变量名称
	 * @param mixed $v 变量值,可以是任何类型
	 *
	 * @return 
	 */
	public function addRet($k, $v){
		$this->ret['data'][$k] = $v;
	}
	/**
	 * 提示信息
	 *
	 * 提供了一种可以默认输出提示消息的方式
	 * 一旦调用了该函数,将会中断当前逻辑,直接输出
	 *
	 * @param string $msg
	 * @param string $jump 提示消息后是否会跳转,默认为:后退
	 * @param int $timeout 定时跳转,如果为空,则不自动跳转
	 * @param string $style 样式名称,用于支撑view层的页面样式
	 */
	protected function message($msg, $jump = null, $timeout = 5, $style = 'default'){
		$this->_message($msg, $jump, $timeout, $style);
		throw new Blue_Exception_Break();	//仅仅为了中断
	}

	private function _message($msg, $jump = null, $timeout = 5, $style = 'default'){
		$this->setTpl('core/message');
		if(!is_array($this->ret['data'])){
			$this->ret['data'] = array();
		}

		$this->ret['data'] = array_merge($this->ret['data'], array(
			'jump' => $jump,
			'msg' => $msg,
			'timeout' => $timeout,
			'style' => $style,
			'argv' => $this->ret['data'],
		));
	}

	/**
	 * 设置输出的头信息
	 *
	 * @param array $header 字符串组成的数组
	 */
	protected function setHeader($header){
		$this->ret['header'] = $header;
	}

	/**
	 * 设置模板
	 *
	 * @param string $tpl 模板路径,相对于:views目录,省略后缀名
	 */
	protected function setTpl($tpl){
		$this->ret['tpl'] = $tpl;
	}

	/**
	 * 设置展示的对象类型
	 *
	 * @param string $view 参考:VIEW_*常量
	 */
	protected function setView($view){
		$this->opt['view'] = $view;
	}

	/**
	 * 初始化各种变量
	 */
	private function _init(){
		//初始化基本模板
		$req = $this->getRequest();
		$this->ret['tpl'] = lcfirst($req->getControllerName() . '/' . $req->getActionName());
	}

	/**
	 * 过滤掉NULL
	 */
	private function _filterNullToString(){
		$this->ret['data'] = $this->_filterNullToStringItem($this->ret['data']);
	}

	private function _filterNullToStringItem($data){
		if(is_array($data)){
			foreach($data as $k => $d){
				$data[$k] = $this->_filterNullToStringItem($d);
			}
		}elseif(NULL === $data){
			$data = '';
		}

		return $data;
	}

	/**
	 * 输出
	 */
	private function _output(){
		//初始化输出对象
		$view = Blue_View::factory($this->opt['view']);

		//判断是否有输出头
		if(!empty($this->ret['header'])){
			$view->setHeader($this->ret['header']);
			unset($this->ret['header']);
		}
		//判断是否需要跳转
		if(!empty($this->ret['redirect'])){
			$view->redirect($this->ret['redirect']);
			return;
		}

		//是否需要选择模板
		if(!empty($this->ret['tpl'])){
			if(self::VIEW_SMARTY2 == $this->opt['view']){
				$view->setTpl($this->ret['tpl'] . '/main.tpl');
			}else{
				$view->setTpl($this->ret['tpl'] . '.tpl');
			}
			unset($this->ret['tpl']);
		}
		//输出最终的数据
		$view->display($this->ret);
	}
}

