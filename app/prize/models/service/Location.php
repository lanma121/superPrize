<?php

/**
 * 系统地址的服务层
 * @author 1399871902<@qq.com>
 * @copyright 2015~ (c) @qq.com
 * @Time: Monday 26 October 2015 13:31:13 PM CST
 */

class Service_Location{
	
	//区域信息对象
	private $dLocation;
	
	/*
	 * 服务信息初始化
	 */
	public function __construct(){
		$this->dLocation = new Dao_Cms_Location();
	}
	
	/**
	 * 根据条件获取区域信息
	 * @param $cond
	 */
	public function getLocationListByCondition($cond){
		return $this->dLocation->getListByCondition($cond);
	}
	
	/*
	 * 根据ZoneId获取Disc集合信息
	 * @param $zid 系统省份ID
	 * @param $type 获取类型
	 * @return string
	 */
	public function loadDiscByZone1($zid,$type){
		$string = '';
		$cond = array('zone'=>$zid,'type'=>$type);
		$list = $this->listByCondition($cond);
		if($list && count($list)>0){
			foreach($list as $item){
				$string .= $item['id'].',';
			}
		}
		if(!empty($string)){
			$string = substr($string,0,strlen($string)-1);
		}
		return $string;
	}
	
	/*
	 * 根据动态条件查询区域信息
	 * @param $cond 收集的动态信息
	 * @return string
	 */
	public function loadDiscByCondition($cond){
		$string = '';
		$list = $this->listByCondition($cond);
		if($list && count($list)>0){
			foreach($list as $item){
				$string .= $item['id'].',';
			}
		}
		if(!empty($string)){
			$string = substr($string,0,strlen($string)-1);
		}
		return $string;
	}
	
	/*
	 * 获取地址信息
	 * @param $cond 地址参数集合
	 * @return array
	 */
	public function listByCondition($cond){
		return $this->dLocation->listByCondition($cond);
	}
	
	/*
	 * 根据区域获取地理位置信息 
	 * @param $zoneId 省份ID
	 * @param $cityId 城市ID
	 * @param $discId 区县ID
	 * @return array
	 */
	public function getLocationByArea($zoneId,$cityId,$discId){
		$array = array();
		$cond = array(
			'ids'		=> $zoneId.','.$cityId.','.$discId,
			'field'		=> 'title'
		);
		$list = $this->dLocation->listByCondition($cond);
		if($list && count($list)>0){
			$array['zone'] = $list[0]['title'];
			$array['city'] = $list[1]['title'];
			$array['disc'] = $list[2]['title'];
		}
		return $array;
	}
}