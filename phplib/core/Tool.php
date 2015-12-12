<?php
/**
 * 常用的系统工具类
 *
 * @author 		monkee <monkee.hu@yeahmobi.com>
 * @package		yeahmobi
 * @version		2.0.2
 * @copyright	Copyright (c) 2014 Yeahmobi, Inc.
 */

class Core_Tool
{
    /**
     * 获取当前访问的用户的IP
     * 
     * @return string
     */
    public static function getClientIP($isInt = false){
        //实现
		$sip = '';
        foreach(array('HTTP_X_FORWARDED_FOR', 'HTTP_CLIENT_IP', 'REMOTE_ADDR') as $k){
            if(isset($_SERVER[$k])){
                $ip = Blue_Filter::filterIP($_SERVER[$k]);
                if(!empty($ip)){
					$sip = $ip;
					break;
                }
            }
        }

		if($isInt){
			if(empty($sip)){
				return 0;
			}
			return ip2long($sip);
		}
		return $sip;
    }

	public static function getAgent(){
		$ua = strtolower($_SERVER['HTTP_USER_AGENT']);

		//判断是否是移动设备
		if(preg_match('/mobile/', $ua)){
			//判断是否是IPAD
			if(preg_match('/ipad/', $ua)){
				return 'ipad';
			}
			return 'mobile';
		}
		return 'pc';
	}
}

