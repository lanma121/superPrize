<?php
/**
 * 配置解析
 *
 * @author      胡峰 <hufeng@yunsupport.com>
 * @package     core
 * @copyright   Copyright (c) 2014, yunsupport.com
 */
class Core_Conf
{
    private static $cache = array();
    private static $opt = array(
        'path' => '/home/work/pdp/conf/'
    );

	public static function init($opt = array()){
		self::$opt = array_merge(self::$opt, $opt);
	}

    public static function getConf($name){
        list($f, $k) = explode(':', $name);

		$f = PDP_APP . '/' . $f;
        $data = self::getFileValue($f);
        if(empty($k)){
            return $data;
        }
        return isset($data[$k]) ? $data[$k] : null;
    }

	public static function getGlobalConf($name){
        list($f, $k) = explode(':', $name);

        $data = self::getFileValue($f);
        if(empty($k)){
            return $data;
        }
        return isset($data[$k]) ? $data[$k] : null;
	}

    private static function getFileValue($f){
        if(empty($f)){
            throw new Core_Exception("Empty conf name");
        }
        if(false == isset(self::$cache[$f])){
			$file = self::$opt['path'] . $f . '.ini';
            if(false == is_file($file)){
                throw new Core_Exception("Conf {$file} is not exist");
            }

            self::$cache[$f] = parse_ini_file($file, true);
        }

        return self::$cache[$f];
    }
}

