<?php

/**
 * 会员积分的的奖品服务层
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 27 Aug 2015 15:07:07 PM CST
 */

class Service_Member{
	
	//会员积分对象
	private $dMember;

	/*
	 * 服务信息初始化
	 */
	public function __construct(){
		$this->dMember = new Dao_Point_Member();
	}
	
	/*
	 * 根据reltion_id查询会员积分信息
	 * @param $rid relation_id
	 */
	public function getMemberInfoByRid($rid){
		$cond = array(
			'rid'		=> $rid,
			'field'		=> 'member_id,member_points,id_card,status,
							name,mobile,telephone,zone_id,city_id,
							district_id'
		);
		return $this->dMember->loadByCondition($cond);
	}
	
	/*
	 * 根据relation_id集合获取member_id集合 
	 * @param $rids relation_id集合
	 * @reture string
	 */
	public function getMemeberMidsByRids($rids){
		$string = '';
		$cond = array(
			'rids'		=> $rids,
			'field'		=> 'member_id'
		);
		$list = $this->dMember->loadByCondition($cond);
		if($list && count($list)>0){
			foreach($list as $item){
				$string .= $item['member_id'].',';
			}
		}
		if(!empty($string)){
			$string = substr($string,0,strlen($string)-1);
		}
		return $string;
	}
	
	/*
	 * 根据地理位置获取获取member_id集合 
	 * @param $zoneId 省份Id
	 * @param $cityId 城市Id
	 * @param $discId 区县Id
	 * @reture string
	 */
	public function getMemberMidsByArea($zoneId,$cityId,$discId){
		$string = '';
		$cond = array(
			'zone_id'	=> $zoneId,
			'city_id'	=> $cityId,
			'disc_id'	=> $discId,	
			'field'		=> 'member_id'
		);
		$list = $this->dMember->loadByCondition($cond);
		if($list && count($list)>0){
			foreach($list as $item){
				$string .= $item['member_id'].',';
			}
		}
		if(!empty($string)){
			$string = substr($string,0,strlen($string)-1);
		}
		return $string;
	}
	
}