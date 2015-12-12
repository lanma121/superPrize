<?php
/**
  * 初始化文件
  *
  * 所有文件的入口调用
  * 1. 初始化app相关数据，包括：
  *    配置常量
  *    yaf实例
  *    loader注册
  * 2. 注册退出时的事件 以及 事件的回调函数
  *
  * @author 胡峰 <hufeng@yunsupport.com>
  * @version 1.0.0
  * @package core
  * @copyright 2014-2015 yunsupport.com
 */

class Core_Init
{
	static private $instance = null;    //单例的实例化载体
	static private $app = null;         //当前app的实例
	static private $modelsPrefix = array('Service', 'Dao', 'Commit');   //不适用models做前缀的model层代码
	private function __construct(){}    //单例

	/**
	 * * 这里主要指对app的run规则的调用
	 * *
	 * * 实际上，仅在指定了app的情况下，下面的逻辑才实际有效
	 * * run会调用yaf的application::run
	 * * 执行yaf的实际逻辑
	 * */
	public function run(){
		if(self::$app){
		//	try{
				self::$app->bootstrap()->run();
		//	}catch(Exception $e){
		//		Core_Log::warning("网址错误：".$e->getMessage());
		//		echo 'error';  	
		//	}
		 
		}
	}
	/**
	 * * 用户脚本使用，处理BootStracp
	 * *
	 * * 无返回值
	 * */
	public function bootstrap(){
		if(self::$app){
			self::$app->bootstrap();
		}
	}
	/**
	 * * 使用Ym框架时的初始化
	 * * 
	 * * 这里需要指定app的名称，若不指定，则抛弃与app有关的初始化
	 * * 届时，与app有关的常量，也都不会定义                                                               
	 * * 
	 * * 1. 初始化Yaf对象
	 * * 2. 注册autoloader以及shutdown事件
	 * * 
	 * * @param string $app app的名称，与目录名一致
	 * * 
	 * * @return Core_Init
	 * */
	static public function init($app){
		Core_Timer::startRecord();
		if(empty(self::$instance)){
			self::initApp($app);
			self::initRegisterAutoloader();
			self::initRegisterShutdownEvent();
			       
			self::$instance = new Core_Init();
		}
		return self::$instance;
	}

	/**
	 * * 初始化APP的数据
	 * * 
	 * * @param string $app 启用的app的名称，如：test
	 * */
	static private function initApp($app){
		if(empty($app)){
			exit('App must not be empty');                                                               
		}

		define('PDP_APP', $app);
		define('PDP_APP_ROOT', DIR_APP . '/' . PDP_APP);
		define('PDP_APP_LIB', PDP_APP_ROOT . '/library');
		define('PDP_APP_VIEW', PDP_APP_ROOT . '/views');
		define('PDP_APP_DATA', PDP_ROOT . '/data/app/' . PDP_APP);
		//声明loader
		Yaf_Loader::getInstance(PDP_APP_LIB, PDP_ROOT_PHPLIB);
		Arch_Env::set(Arch_Env::NS, PDP_APP);

		$config = array(
			"application" => array(
				"directory" => PDP_APP_ROOT,
				'library' => PDP_APP_LIB,
				'baseUri' => '/' . $app
			)
		);

		self::$app = new Yaf_Application($config);

		//增加日志初始化
		Core_Conf::init(array(
			'path' => PDP_DIR_CONF . '/'
		));
		//增加日志的初始化
		Core_Log::init(array(
			'path' => PDP_DIR_LOG . '/' . PDP_APP . '/',
			'file' => PDP_APP . '.log',
			//'level' => intval(Core_Conf::getConf('core:lo^g'))
		));
	}

	/**
	 * * 定义新的自己的命名空间
	 * *
	 * * 将models目录加入到autoload中去
	 * */
	static private function initRegisterAutoloader(){
		if(!defined('PDP_APP_ROOT')){
			return;
		}
		spl_autoload_register(function($classname){
			$classItems = explode('_', $classname);

			if(!in_array($classItems[0], self::$modelsPrefix)){
				return false;
			}

			$filename = array_pop($classItems) . '.php';
			array_unshift($classItems, 'models');
			$filepath = implode('/', $classItems);
			$filepath = strtolower($filepath);

			$realFilepath = PDP_APP_ROOT . '/' . $filepath . '/'. $filename;
			if(is_file($realFilepath)){
				Yaf_Loader::import($realFilepath);
				return true;
			}
			return false;
		});
	}

	/**
	 * * 注册运行结束时的
	 * */
	static private function initRegisterShutdownEvent(){
		register_shutdown_function(__CLASS__ . '::execShutdownCallback');
	}

	/************************************************
	 * * CALLBACKS
	 * ************************************************
	 * */

	/**
	 * * 运行完成后的回调
	 * *
	 * * 1. log中增加 时间消耗、内存消耗 统计
	 * * 2. 输出日志
	 * */
	static public function execShutdownCallback(){
		Core_Timer::endRecord();
		Core_Log::debug('php status', array('cost' => Core_Timer::getResult(), 'mem' => memory_get_peak_usage(TRUE)));
	}
} 
