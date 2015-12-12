<?php
/**
 * 短网址生成工具
 * 
 * @author hufeng<@yunbix.com>
 * @copyright 2014~ (c) @yunbix.com
 * @Time: Mon 24 Nov 2014 03:13:56 PM CST
 */

class Arch_TinyUrl
{
    const API = 'http://dwz.cn/create.php';
    /**
     * 
     * @param type $url
     */
    static public function create($url){
        $http = new Arch_Http(self::API);
        $result = $http->post(array('url' => $url));
        
		if(empty($result)){
			throw new Blue_Exception("Bad Result");
		}

		$res = json_decode($result, true);

		if($res == false){
			throw new Blue_Exception("Bad result format", array('body' => $result));
		}

		if($res['status'] == 0){
			return $res['tinyurl'];
		}

		throw new Blue_Exception("Request fail", $res);
    }
}
