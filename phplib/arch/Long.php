<?php
/**
 * 分布式环境下ID的分配
 * 
 * 满足：
 * 1. 分布式环境下ID唯一
 * 2. ID持续增长
 * 
 * 生成效率如下：
 * 1. 每秒理论最大产生ID个数：1000×256个
 * 2. 每个ID计算耗时：<1ms
 * 
 * 使用依赖：
 * 1. 依赖PDP环境存在
 * 2. 配置文件：conf/arch.ini需存在且有配置
 * 
 * 使用方法：
 *  $id = Arch_ID::alloc();
 *  
 */

/**
 * ID生成器，分布式安全
 * 
 * 使用系统flock作为生产锁，因此需要对/tmp目录有读写权限
 *
 * @author monkee
 */
class Arch_ID
{
	private static $conf = array();
    private $module = null;
    private $file = null;
    
    /**
     * 获取下一个长整数ID
     * 
     * @return long 64位的长整数
     */
    public static function alloc(){
        $sq = self::getSeqID();
        $time = self::getMsTime();
		$mq = self::getMq();
        $long = (($time) << 21) | $mq << 4 | $sq;
        return $long;
    }

	private static function getMq(){
		$conf = self::getConf();
		return (int) $conf['mq'];
	}
    
	/**
	 * 获取当前的毫秒数
	 * 
	 * @return int
	 */
    private static function getMsTime(){
        return (int) (microtime(TRUE) * 1000);
    }
    
	/**
	 * 获取下一个序列ID
	 * 
	 * @return int
	 * @throws Ym_Exception
	 */
    private static function getSeqID(){
		$conf = self::getConf();
		$file = $conf['file'];
		//创建目录
		$dir = dirname($file);
		if(is_dir($dir) == false){
			self::mkdir($dir);
		}
        $fp = fopen($file, "ab+");
        if(empty($fp)){
            throw new Core_Exception("can not open file {$file}");
        }
        flock($fp, LOCK_EX);
        $c = fread($fp, 2);
        
        if($c === false){
            throw new Core_Exception("can not read from file {$file}");
        }elseif(strlen($c) == 2){
            $qunce = unpack('n', $c);
            $qunce = intval($qunce[1]) + 1;
            $qunce > 0xF && $qunce = 0;
        }else{
            $qunce = 0;
        }
        
        $c = pack('n', $qunce);
        fseek($fp, 0);
        if(fwrite($fp, $c) == 0){
            throw new Core_Exception("can not write to file {$file}");
        }
        flock($fp, LOCK_UN);
        fclose($fp);
        return $qunce;
    }
	
    /**
     * 创建目录
     * 
     * @param string $dir
     * 
     * @throws Core_Exception
     */
    private static function mkdir($dir){
        if(mkdir($dir, 0755, true) == false){
			throw new Core_Exception(sprintf('mkdir %s fail', $dir));
		}
        chmod($dir, 0755);
    }

	/**
	 * 获取基础配置
	 *
	 * @return array
	 */
	private static function getConf(){
        return Core_Conf::getGlobalConf('arch:id');
	}
}
