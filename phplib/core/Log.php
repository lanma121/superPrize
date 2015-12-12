<?php
/**
 * 日志记录
 *
 * @author      胡峰 <hufeng@yunsupport.com>
 * @package     core
 * @copyright   Copyright (c) 2014, yunsupport.com
 */
class Core_Log
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
        'path' => '/home/work/pdp/log/',
        'file' => 'pdp.log',
        'level' => 15
    );

    private static $nhd, $whd;


    public static function init($opt = array()){
        self::$opt = array_merge(self::$opt, $opt);

        $filename = self::$opt['path'] . self::$opt['file'];

        if(is_dir(self::$opt['path']) == false){
            mkdir(self::$opt['path'], 0755, true);
        }

        self::$nhd = fopen($filename, 'a+');
        self::$whd = fopen($filename . '.wf', 'a+');
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
        
        $hd = ($level > 0x03)  ? self::$whd : self::$nhd;

        //[2014-03-12 12:33:12] [fatal] ...argv... MSG
        fwrite($hd, sprintf("[%s] [%s] %s %s\n", date('Y-m-d H:i:s'), self::$levels[$level], self::format($argv), $msg));
    }


    /**
     * 格式化数据输出
     *
     * @param array $argv
     *
     * @return string
     */
    private function format($argv){
		if(is_array($argv)){
			$str = array();
			foreach($argv as $k => $v){
				$str[] = sprintf('[%s:%s]', $k, str_replace(array('[', ']'), array('\\[', '\\]'), $v));
			}
			return implode(' ', $str);
		}
    }
}

