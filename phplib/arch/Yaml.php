<?php
/**
 * Yaml格式的配置文件的解析类
 *
 * @author      胡峰 <hufeng@yunbix.com>
 * @package     core
 * @copyright   Copyright (c) 2014, yunsupport.com
 */

class Arch_Yaml
{
    private static $cache = array();
    private static $opt = array(
		'path' => DIR_CONF
    );

    public static function get($file, $name = null, $isGlobal = false){
		$ns = Arch_Env::get(Arch_Env::NS);
		if(false === $isGlobal && $ns){
			$file = $ns . '/' . $file;
		}
        $data = self::getFileValue($file);

        if(empty($name)){
            return $data;
        }

		foreach(explode('.', $name) as $mk){
			if(is_array($data) && isset($data[$mk])){
				$data = $data[$mk];
			}else{
				return null;
			}
		}

		return $data;
    }

	/**
	 * 判断配置文件是否存在
	 *
	 * @param string $file
	 * @param boolean $isGlobal
	 *
	 * @return bool
	 */
	public static function isExist($file, $name = null, $isGlobal = false){
		$ns = Arch_Env::get(Arch_Env::NS);
		if(false === $isGlobal && $ns){
			$file = $ns . '/' . $file;
		}

		$fv = null;
		if(isset(self::$cache[$file]) == false){
            $f = self::$opt['path'] . $file . '.yaml';
            if(false == is_file($f)){
				return false;
			}
            self::$cache[$file] = yaml_parse_file($f);
		}
		$fv = self::$cache[$file];

		if($name === null){
			return true;
		}

		return isset($fv[$name]);
	}

    private static function getFileValue($f){
        if(empty($f)){
            throw new Arch_Exception("Empty conf name");
        }
        if(false == isset(self::$cache[$f])){
            $file = self::$opt['path'] . $f . '.yaml';
            if(false == is_file($file)){
                throw new Arch_Exception("Conf {$file} is not exist");
            }

            self::$cache[$f] = yaml_parse_file($file);
        }

        return self::$cache[$f];
    }
}

