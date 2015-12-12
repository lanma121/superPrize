<?php
/**
 * 变量的验证
 * 
 * 用于用户输入、或者从第三方来的数据的验证和过滤
 * 内部方法全部为静态方法，算法会尽量获取期望得到的值
 * 如果获取不到，则返回NULL
 *
 * @author 		hufeng<@yunbix.com>
 * @copyright	Copyright (c) 2014 Yunsupport.com
 */

class Arch_Filter
{
	/**
	 * 过滤整数
	 * 
	 * 如果传入的是NULL，则直接返回NULL
     * 如果是其它的，如：空字符串、false等，都会返回0
	 * 
	 * @param mixed $var
	 * @return int
	 */
	static public function filterInt($var){
		if(null === $var){
			return null;
		}
		return intval($var);
	}
    
    /**
     * 过滤小数，支持按位数过滤
     * 
     * 保留几位，取决于第二个参数
     * 如果第二个参数为整数，且大于0，则会进行过滤
     * 如：Blue_Filter::filterFloat(1.30034, 2)
     * 结果为：1.3 （注意：不是1.30）
     * 
     * @param mixed $var
     * @param int $length
     * 
     * @return float
     */
    static public function filterFloat($var, $length = null){
		if(null === $var){
            return null;
        }
        $lStr = '';
        if(null !== $length && $length > 0){
            $lStr = '.' . $length;
        }
        
        return floatval(sprintf("%{$lStr}f", $var));
    }
    
    /**
     * 判断整数知否在某个区间
     * 
     * 如果不在某个区间，则返回null
     * 如果$var本身不是整数，也会返回null
     * 如果要区别错误类型，请配合filterInt使用
     * 
     * 如果$var == $min 或者 $var == $max，也会返回int
     * 
     * @param mixed $var
     * @param int $min
     * @param int $max
     * 
     * @return int
     */
    static public function filterIntBetweenWithEqual($var, $min = null, $max = null){
        $var = self::filterInt($var);
		if(null === $var){
            return null;
        }
        if(null !== $min && $var < $min){
            return null;
        }
        if(null !== $max && $var > $max){
            return null;
        }
        return $var;
    }
    
    /**
     * 判断整数知否在某个区间
     * 
     * 如果不在某个区间，则返回null
     * 如果$var本身不是整数，也会返回null
     * 如果要区别错误类型，请配合filterInt使用
     * 
     * 如果$var == $min 或者 $var == $max，会返回null
     * 
     * @param mixed $var
     * @param int $min
     * @param int $max
     * 
     * @return int
     */
    static public function filterIntBetweenWithoutEqual($var, $min = null, $max = null){
        $var = self::filterInt($var);
		if(null === $var){
            return null;
        }
        if(null !== $min && $var <= $min){
            return null;
        }
        if(null !== $max && $var >= $max){
            return null;
        }
        return $var;
    }
    
    /**
     * 过滤有效的Email
     * 
     * @param string $var
     * @return string
     */
    static public function filterEmail($var){

        $var = filter_var($var, FILTER_VALIDATE_EMAIL);
        if(empty($var)){
            return null;
        }
        return $var;
        /*
        $regex = '/^([\w-]+\.?)*\w+@[\w-]+\.[a-z]{2,6}$/i';
        if (preg_match($regex, $var, $match)){
            return $var;
        }
        return null;
        */
    }
    
    /**
     * 过滤有效的IP地址
     * 
     * @param string $var
     * @return string
     */
    static public function filterIP($var){
        return filter_var($var, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }
    
    /**
     * 判断选项是否在有限集内
     * 
     * 使用方法：
     * Blue_Filter::filterEnum('apple', array('apple', 'pear', 'banana'));
     * 
     * @param string $var
     * @param array $enum
     * @return string
     */
    static public function filterEnum($var, $enum = array()){
        if(in_array($var, $enum)){
            return $var;
        }
        return null;
    }
    
    
    /**
     * 是否匹配正则表达式，并返回匹配的部分
     * 
     * 这里建议使用简单正则匹配，使用贪婪模式来实现
     * 
     * @param string $var
     * @param string $exp
     * @return string
     */
    static public function filterRegexp($var, $exp){
        if(preg_match($exp, $var, $m)){
			if($m[1] == $var){
				return $var;
			}
        }
        return null;
    }
    
    /**
     * 过滤字符长度
     * 
     * 如果长度大于$maxLen或小于$minLen，则返回null
     * 正常情况下，返回$var本身
     * 
     * @param type $var
     * @param type $minLen
     * @param type $maxLen
     */
    static public function filterStrlen($var, $minLen = null, $maxLen = null){
        $l = strlen($var);
        if(null !== $minLen && $l < $minLen){
            return null;
        }
        if(null !== $maxLen && $l > $maxLen){
            return null;
        }
        return $var;
    }

    /**
     * 过滤URL地址
     * 
     * @param string $var
     * @return string
     */
    static public function filterUrl($var){
        return $var;
    }
    
    /**
     * 过滤电话号码
     * 
     * @param string $var
     * @return string
     */
    static public function filterPhone($var){
        return $var;
    }
    
    /**
     * 过滤手机号码
     * 
     * @param string $var
     * @return string
     */
    static public function filterTel($var, $allowEmpty = true){
		if(empty($var) && $allowEmpty){
			return '';
		}
		if(preg_match('/^1[3-8]{1}[0-9]{9}$/', $var)){
			return $var;
		}
		return null;
	}

    /**
     * 过滤日期
     * 
     * @param string $var yyyy-mm-dd
     * @return string
     */
    static public function filterDate($var, $allowNull = false, $sp = '-'){
		if($allowNull && empty($var)){
			return '';
		}

		if('0000-00-00' == $var){
			return $var;
		}

		list($y, $m, $d) = explode($sp, $var);
		$y = intval($y);
		$m = intval($m);
		$d = intval($d);
		if(checkdate($m, $d, $y)){
			return $var;
		}
		return NULL;
    }

	/**
	 * 检测日期时间
	 *
	 * @param string $var yyyy-mm-dd HH:ii:ss
	 * @return string
	 */
	static public function filterDateTime($var, $allowNull = false){
		if($allowNull && empty($var)){
			return '';
		}

		$r = date_parse($var);
		if($r['error_count'] > 0){
			return null;
		}

		return $var;
	}
    
    /**
     * 过滤日期，并转化为时间戳
     * 
     * @param string $var
     * @return int
     */
    static public function filterDateToTimestamp($var){
        return $var;
    }
    
    /**
     * 过滤IP并转化为数字
     * 
     * @param string $var
     * @return int
     */
    static public function filterIPToNumber($var){
        return $var;
    }

	/**
	 * 验证身份证号码
	 *
	 * 支持15位和18位标准验证
	 * 支持最后一位为x
	 *
	 * @param string $var
	 *
	 * @return string
	 */
	static public function filterIDNO($var){
		$var = strtolower($var);
		if(preg_match('/(^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|x)$)/', $var, $m)){
			return $m[0];
		}elseif(preg_match('/(^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$)/', $var, $m)){
			return $m[0];
		}

		return NULL;
	}
    
    /**
     * 过滤数组内容
     * 
     * $var只能是一维数组，并且严格使用K=>V来表达
     * $filter的格式如下：
     * $filter = array(
     *  'key' => array(
     *      'filterName', //过滤的方法名，如：filterStrlen
     *      array(),    //参数，可以为空，默认为空
     *      true,       //可否为空，设置为true，如果该key不存在，则跳过，而不返回异常，默认为false
     *  )
     * )
     * 如果过滤成功，则返回数组；如果失败，则抛出异常，并标明哪些字段不符合要求
     * 一旦有匹配不通过，直接抛出异常，不会继续往下过滤
     * 
     * @param array $var
	 * @param array $filter 一个数组，格式为：
	 *	0 => 过滤方法
	 *	1 => 方法参数
	 *	2 => 是否允许不存在
	 *	3 => 错误提示消息
     * 
     * @return array
     * @throws Blue_Exception_Warning验证失败；Blue_Exception_Fatal $filter这个参数有误
     */
    static public function filterArray($var, $filter){
        $ret = array();
        foreach($filter as $k => $v){
            if(isset($var[$k]) == false){
                if($v[3] === true){
                    continue;
                }else{
                    throw new Arch_Exception($v[2] ? $v[2] : "参数错误", array('k' => $k));
                }
            }
            if(!is_array($v[1])){
                $v[1] = array();
            }
            if(method_exists(__CLASS__, $v[0]) == false){
                throw new Arch_Exception("filter {$v[0]} is not exist");
            }
            array_unshift($v[1], $var[$k]);
            $rv = call_user_func_array(array(__CLASS__, $v[0]), $v[1]);
            if(null === $rv){
				if(empty($v[2])){
					$msg = "参数错误";
				}else{
					$msg = $v[2];
				}
                throw new Arch_Exception($msg, array('k' => $k, 'v' => $var[$k]));
            }
            $ret[$k] = $rv;
        }
        return $ret;
    }
    
    /**
     * 过滤纯索引的数组，并使用同样一种过滤的函数
     * 
     * @param string $filterMethod
     * @param type $var
     * @param type $isIgnore
     * @return type
     * @throws Blue_Exception_Warning
     */
    public static function filterIndexedArray($filterMethod, $var, $isIgnore = false){
        if(empty($var)){
            return array();
        }
        if(!is_array($var)){
            return array();
        }
        if(method_exists(__CLASS__, $filterMethod) == false){
            throw new Arch_Exception("filter {$filterMethod} is not exist");
        }
        $ret = array();
        foreach($var as $v){
            $rv = call_user_func_array(array(__CLASS__, $filterMethod), array($v));
            if(null === $rv){
                if($isIgnore == false){
                    throw new Arch_Exception("value:{$v} is not match");
                }
            }else{
                $ret[] = $rv;
            }
        }
        return $ret;
    }
}

