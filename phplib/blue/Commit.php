<?php
/**
 * 具体执行操作的业务
 * 
 * 使用：
 * class Commit_TOPIC_SERVICE extends Blue_Commit
 * {
 *      //... your code
 * }
 * 
 * 如果过程中出现错误，则直接抛出异常即可
 * 如：DB连接不畅、下游服务出现中断等
 * 
 * Copyright (c) 2006 - 2014 PHPExcel
 *
 * @author hufeng<@yunsupport.com>
 * @copyright  Copyright (c) 2014 - 2015
 * @version    1.0
 */

class Blue_Commit
{
    protected $request;
	protected $transDB = array();
	private $dbins = array();
	static public function call($topic, $data){
		$service = 'Commit_' . ucfirst($topic);
		if(class_exists($service) == false){
			throw new Blue_Exception_Fatal("{$service} is not exist");
		}

		$commit = new $service($data);
		$commit->execute();
	}
    
	/**
	 * 构造函数
	 *
	 * 无法重载
	 *
	 * @param array $request
	 */
    final public function __construct($request){
        $this->request = $request;
    }

    /**
     * 执行具体事务的钩子函数
     * 
     * 这个钩子会被Action层调用，从而执行具体事务操作
     * 
     * 如果执行失败，则抛出异常：Commit_Exception
     */
    final public function execute(){
		$this->__register();	//注册事务对象
		$this->load();
        $this->__prepare();
		$this->startTrans();
        $this->__execute();
		$this->endTrans();
        $this->__complete();
    }

    protected function __register(){}//注册事务
    protected function __prepare(){}
    protected function __execute(){}
    protected function __complete(){}
	
	/**
	 * 获取请求的数组
	 */
	protected function getRequest(){
		return $this->request;
	}

	/**
	 * 载入数据库事务DB对象
	 */
	private function load(){
		foreach($this->transDB as $db){
			$this->dbins[$db] = Blue_DB::instance($db);
		}
	}

	/**
	 * 开始事务
	 */
	private function startTrans(){
		foreach($this->dbins as $k => $i){
			$i->startTrans();
		}
	}

	/**
	 * 结束事务
	 */
	private function endTrans(){
		foreach($this->dbins as $k => $i){
			$i->endTrans();
		}
	}
}
