<?php
/**
 * 用于连接PAF的Client类
 * 
 * 依赖全局配置文件：paf.yaml
 *
 * @author hufeng<@yunbix.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Thu 20 Aug 2015 02:52:35 PM CST
 */

class Arch_Paf
{
	static private $_ins = array();

	private $ip = '';	//连接的IP地址
	private $port = 0;	//连接的端口
	private $cto = 100;	//连接超时 ms
	private $rto = 3000;	//读超时 ms
	private $topic = '';

	/**
	 * 单例实例化Paf连接对象
	 *
	 * @param string $mod
	 *
	 * @return instance
	 */
	static public function instance($mod){
		if(isset(self::$_ins[$mod]) == false){
			self::$_ins[$mod] = new Arch_paf($mod);
		}
		return self::$_ins[$mod];
	}

	private function __construct($mod){
		$this->_initConf($mod);
	}

	public function call($cmd, $data){
		$conn = @fsockopen($this->ip, $this->port, $eno, $err, intval($this->cto / 1000));
		$string = $this->ip.'---'.$this->port.'---'.$eno.'---'.intval($this->cto / 1000);
		print_r($conn);
		/**
		if(empty($conn)){
			throw new Arch_Exception(sprintf('Paf connect fail, error=%s errno=%d', $err, $eno));
		}
		//写入传输的数据
		$data = Arch_Pack::pack(array('topic' => $this->topic, 'cmd' => $cmd, 'data' => $data));
		$l = strlen($data);

		if($l > 1024 * 1024 * 10){
			throw new Arch_Exception('Request content size too large');
		}
		stream_set_write_buffer($conn, 0);
		$r = fwrite($conn, $data, $l);
		if($r === false){
			throw new Arch_Exception('Paf error, write fail', array('r' => $r, 'l' => $l));
		}

		//设置读取的超时时间
		stream_set_timeout($conn, intval($this->rto / 1000));
		//读取返回
		$res = fread($conn, 4);	//读取需要获取数据的长度
		if(strlen($res) < 4){
			throw new Arch_Exception('Response error', array('r' => strlen($res), 'l' => $l));
		}
		$l = Arch_Pack::unpackLength($res);
		$res = '';
		if($l > 0){
			$res = fread($conn, $l);
		}
		//返回通知消息
		fwrite($conn, 0x00);
		@fclose($conn);
		$res = Arch_Pack::unpack($res, false);
		**/
		return $res;
	}

	/**
	 * 初始化Mod的配置文件
	 *
	 * @param string $mod
	 */
	private function _initConf($mod){
		$ini = Arch_Yaml::get('paf', $mod, true);
		if(empty($ini)){
			throw new Arch_Exception("Need paf.yaml");
		}
		$this->ip = $ini['ip'];
		$this->port = $ini['port'];
		$this->cto = $ini['conn_timeout'];
		$this->rto = $ini['read_timeout'];
		$this->topic = $ini['topic'];
	}
}

