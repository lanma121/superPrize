<?php

/**
 * 系统随机码服务层
 * @author 1399871902@qq.com
 * @copyright 2015~ (c) @1399871902@qq.com
 * @Time: Wed 26 Aug 2015 09:56:43 PM CST
 */

class Service_Random{
	
	/*
	 * 创建随机码
	 * @param $type
	 */
	public function createRandom($length, $type='mixed'){
		$randValue = '';
		if(($type != 'mixed') && ($type != 'chars') && ($type != 'digits')){
			return false;
		}
		while(strlen($randValue) < $length){
		 	if($type == 'digits'){
        		$char = $this->createRand(0,9);
      		}else{
        		$char = chr($this->createRand(0,255));
      		}
      		switch($type){
      			case 'mixed':
      				if(preg_match('/^[a-z0-9]$/i', $char)){
      					$randValue .= $char;
      				}
      			break;
      			case 'chars':
      				if(preg_match('/^[a-z]$/i', $char)){
      					$randValue .= $char;
      				}
      			break;
      			case 'digits':
      				if(preg_match('/^[0-9]$/i', $char)){
      					$randValue .= $char;
      				}
      			break;	
      		}
		}
		return $randValue;
	}
	
	/*
	 * 创建随机因子
	 * @param $min
	 * @param $max
	 */
	private function createRand($min = null, $max = null){
	 	static $seeded;
		if(!$seeded){
     	 	mt_srand(time()+(double)microtime()*1000000);
      		$seeded = true;
    	}
		if(isset($min) && isset($max)){
	      	if($min >= $max){
	        	return $min;
	      	}else{
	        	return mt_rand($min, $max);
	      	}
    	}else{
      		return mt_rand();
   	 	}
	}
}