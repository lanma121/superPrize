<?php
/**
 * DB对象的工厂类
 *
 * 用于分配DB对象,避免同一对象的过多调用
 * 
 * @author hufeng<@yunsupport.com>
 * @copyright 2014~ (c) @yunsupport.com
 * @Time: Fri 07 Nov 2014 10:50:27 PM CST
 */

class Blue_DB
{
	static private $ins = array();

	/**
	 * 进行实例化对象
	 *
	 * 对象的名称和配置文件db.ini绑定,需要在自己的配置文件中加着一项
	 *
	 * @param string $name 数据库对应的名称
	 *
	 * @return Blue_DBIns
	 */
	static public function instance($name){
		if(isset(self::$ins[$name]) == false){
			$opt = self::getOpt($name);
			$db = new Blue_DBIns($opt['host'], $opt['user'], $opt['pw'], $opt['db'], $opt['port']);
			$db->setConnectTimeout($opt['cTimeout']);
			$db->connect();
			$db->setCharset($opt['charset']);
			//var_dump($opt['charset']);exit;
			self::$ins[$name] = $db;
		}
		return self::$ins[$name];
	}

	static private function getOpt($name){
		//$opt = Core_Conf::getConf('db:' . $name);
		$opt = Arch_Yaml::get('db', $name, true);
		if(empty($opt)){

			throw new Blue_Exception_Fatal("db.{$name} is empty");
		}
		return $opt;
	}

	private function __construct($name){
		$this->opt = $this->getOpt($name);
	}
}
