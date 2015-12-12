<?php

/**
 * 
 * 
 * @author name <@yunsupport.com>
 * @copyright 2014~ (c) @yunsupport.com
 * @Time: Tue 16 Dec 2014 01:17:46 PM CST
 */

class Blue_Array
{
	/**
	 * 从二维数组中获取某个key或者多个key的值，返回一个一维数组
	 *
	 * @param array $res 二维数组
	 * @param array|string $keys 键
	 *
	 * @return array
	 */
	static public function getIds($res, $keys, $type = NULL){
		if(is_string($keys)){
			$keys = array($keys);
		}

		if($type){
			$func = $type . 'val';
		}

		$ret = array();

		foreach($res as $row){
			foreach($keys as $k){
				if($type){
					$ret[$func($row[$k])] = 1;
				}else{
					$ret[$row[$k]] = 1;
				}
			}
		}

		return array_keys($ret);
	}

	/**
	 * 转换INDEX
	 *
	 * @param array $array
	 * @param int $key
	 *
	 * @return array
	 */
	static public function changeIndex($array, $key){
		$res = array();

		foreach($array as $row){
			$res[$row[$key]] = $row;
		}

		return $res;
	}

	/**
	 * 用于数组的重排序
	 *
	 * $array 需要是:key-value结构的数组
	 * $sortSeed 需要是 一个数组,它描述了排序的策略
	 *
	 * @return array
	 */
	static public function resort($array, $sortSeed){
		$newArray = array();
		foreach($sortSeed as $k){
			if(isset($array[$k])){
				$newArray[] = $array[$k];
			}
		}
		return $newArray;
	}

	static public function getLastId($array, $key = 'id'){
		$last = array_pop($array);

		if($last){
			return $last[$key];
		}

		return 1;
	}
}

