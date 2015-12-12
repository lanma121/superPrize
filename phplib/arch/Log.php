<?php
/**
 * 日志记录
 *
 * 从最新的版本开始，将迁移到这个类包中来
 *
 * @author      胡峰 <hufeng@yunbix.com>
 * @package     arch
 * @copyright   Copyright (c) 2014, yunbix.com
 */
class Arch_Log
{
    /**
     * log levels
     * @var array
     */
    private static $levels = array(
        1 => 'debug',
        2 => 'notice',
        4 => 'warning',
        8 => 'fatal',
    );

    private static $opt = array(
        'level' => 15
    );

    public static function set($opt = array()){
        self::$opt = array_merge(self::$opt, $opt);
    }

    public static function debug($msg, $argv = null){
        self::log($msg, $argv, 1);
    }

    public static function notice($msg, $argv = null){
        self::log($msg, $argv, 2);
    }

    public static function warning($msg, $argv = null){
        self::log($msg, $argv, 4);
    }

    public static function fatal($msg, $argv = null){
        self::log($msg, $argv, 8);
    }

    private static function log($msg, $argv, $level){
        if(($level & self::$opt['level']) == false){
            return;
        }
        
		$file = self::file($level);

        //[2014-03-12 12:33:12] [fatal] ...argv... MSG
        //fwrite($hd, sprintf("[%s] [%s] %s %s\n", date('Y-m-d H:i:s'), self::$levels[$level], self::format($argv), $msg));
        file_put_contents($file, sprintf("[%s] [%s] %s %s\n", date('Y-m-d H:i:s'), self::$levels[$level], self::format($argv), $msg), FILE_APPEND);
    }

	private static function file($level){
		if($level > 0x03){
			return DIR_LOG . Arch_Env::get(Arch_Env::NS) . '.log.wf';
		}else{
			return DIR_LOG . Arch_Env::get(Arch_Env::NS) . '.log';
		}
	}


    /**
     * 格式化数据输出
     *
     * @param array $argv
     *
     * @return string
     */
    static private function format($argv){
		if(is_array($argv)){
			$str = array();
			foreach($argv as $k => $v){
				$str[] = sprintf('[%s:%s]', $k, str_replace(array('[', ']'), array('\\[', '\\]'), $v));
			}
			return implode(' ', $str);
		}
    }
}

