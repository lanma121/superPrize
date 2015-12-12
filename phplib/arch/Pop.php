<?php
/**
 * 处理POP3收件程序的类
 * 
 * @author hufeng<@yunsupport.com>
 * @copyright 2014~ (c) @yunsupport.com
 * @Time: Thu 22 Jan 2015 04:08:26 PM CST
 */

class Arch_Pop
{
	private $fp = null;
	private $error = '';
	private $errno = 0;

	private $readTimeout = 2;

	public function __construct($host, $port, $cntTimeout = 10, $readTimeout = 30){
		$this->fp = fsockopen($host, $port, $this->errno, $this->error, $cntTimeout);
		if(empty($this->fp)){
			throw new Core_Exception("POP3 error", array('error' => $this->error, 'errno' => $this->errno));
		}
		$this->readTimeout = $readTimeout;

		//抛出登录信息
		$this->read();
	}

	/**
	 * 设置用户登录信息
	 *
	 * @param string $user
	 * @param string $pw
	 *
	 * @throws Arch_Pop_Exception
	 */
	public function login($user, $pw){
		$this->write('USER ' . $user);
		$this->read();
		$this->write('PASS ' . $pw);
		$this->read();
	}

	/**
	 * 获取所有邮件列表
	 *
	 * @param int $id 
	 *
	 * @return array
	 */
	public function getList($id = null){
		if($id){
			$this->write('LIST ' .  $id);
		}else{
			$this->write('LIST');
		}
		return $this->read(false);
	}

	/**
	 * 获取信息的前几行数据
	 *
	 * @param int $id 对应的ID
	 * @param int $top 前几行
	 *
	 * @return array
	 */
	public function top($id, $top = 0){
		$this->write(sprintf('TOP %d %d', $id, $top));
		return $this->read(false);
	}

	public function stat(){
		$this->write('STAT');
		return $this->read();
	}

	/**
	 * 获取当前数据的所有数据
	 *
	 * @param int $id
	 */
	public function get($id){
		$this->write('RETR ' . $id);
		return $this->read(false);
	}

	/**
	 * 读取返回数据
	 *
	 * @param boolean $singleLine 是否单行
	 * 
	 * @return mixed
	 */
	private function read($singleLine = true){
		$res = array();
		stream_set_timeout($this->fp, $this->readTimeout);
		$line = @fgets($this->fp);
		$line = trim($line);
		$sData = stream_get_meta_data($this->fp);

		if($sData['time_out']){
			throw new Arch_Pop_Exception("Read time out", $sData);
		}

		$this->isError($line);

		if($singleLine){
			return $line;
		}

		while(!feof($this->fp)){
			stream_set_timeout($this->fp, $this->readTimeout);
			$line = @fgets($this->fp);
			$sData = stream_get_meta_data($this->fp);

			if($sData['time_out']){
				throw new Arch_Pop_Exception("Read time out", $sData);
			}
			$line = trim($line);

			if('.' === $line){
				return $res;
			}
			$res[] = $line;
		}
	}

	/**
	 * 发送命令到远端服务器
	 *
	 * @param string $cmd 发送的命令
	 */
	private function write($cmd){
		if(fwrite($this->fp, $cmd . "\n") < 1){
			throw new Arch_Pop_Exception('send cmd fail', array('cmd' => $cmd));
		}
	}

	/**
	 * 判断返回是否有误
	 *
	 * @param string $line
	 */
	private function isError($line){
		if(stripos($line, '+ok') === 0){
			return;
		}

		throw new Arch_Pop_Exception("Socket Fail", array('msg' => $line));
	}

	/**
	 * 初始化并进行链接
	 *
	 * @param string $type 类型
	 *
	 * @return Arch_Pop Object
	 */
	public static function instance($type){
		$ini = Arch_Yaml::get('pop3', $type);

		return new Arch_Pop($ini['host'], $ini['port'], $ini['connect_timeout'], $ini['read_timeout']);
	}
}

class Arch_Pop_Exception extends Blue_Exception
{
}

