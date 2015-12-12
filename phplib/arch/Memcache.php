<?php

/**
 * 
 * 
 * @author name <@yunbix.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Mon 11 May 2015 04:04:44 PM CST
 */

class Arch_Memcache
{
	static private $inses;
	private $ins = null;
	private function __construct($ins){
		$this->ins = new Memcached();
		try{
			$ini = Arch_Yaml::get('mc', $ins, true);
		}catch(Core_Exception $e){
			$ini = Core_Conf::getConf('memcache:' . $ins);
		}
		$this->ins->addServer($ini['host'], $ini['port']);
		$this->ins->setOption(Memcached::OPT_BINARY_PROTOCOL, true);
		//$this->ins->setSaslAuthData('53359429868211e4', 'd1ef_6f86');
	}

	public static function factory($name){
		if(empty(self::$inses[$name])){
			self::$inses[$name] = new Arch_Memcache($name);
		}

		return self::$inses[$name];
	}

/**
 * * 设置数据
 * *
 * * @param string $k
 * * @param mixed $v
 * * @param int $expire 过期时间,单位:秒
 * *
 * * @return
 * */
	public function set($k, $v, $expire = 600){
		if($this->ins->set($k, $this->encode($v), $expire + time()) == false){
			throw new Blue_Exception_Fatal("MC写入失败", array('code' => $this->ins->getResultCode()));
		}
	}

/**
 * * 获取数据
 * *
 * * @param string $k
 * *
 * * @return mixed
 * */
	public function get($k){
		$r = $this->ins->get($k);
		return $this->decode($r);
	}

	/**
	 * 获取存储的原始数据，不经过反序列化操作
	 *
	 * @param string $k
	 *
	 * @return string
	 */
	public function getOrigin($k){
		return $this->ins->get($k);
	}

	public function encode($v){
		return serialize($v);
	}

	public function decode($v){
		if(empty($v)){
			return NULL;
		}

		return unserialize($v);
	}

}	
