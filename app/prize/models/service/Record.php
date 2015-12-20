<?php

/**
 * 积分纪录的服务层
 * 
 * @author zhurongqiang<@qq.com>
 * @copyright 2015~ (c) @qq.com
 * @Time: Wed 26 Aug 2015 09:56:43 PM CST
 */

class Service_Record{
	
	//会员信息对象
	private $dRecord;
	
	/*
	 * 服务信息初始化
	 */
	public function __construct(){
		$this->dRecord = new Dao_Point_Record();
	}
	
	/*
	 * 根据MID检查会员当天是否首次登录
	 * @param $cond
	 * $return int
	 */
	public function checkFirstLoginToDayByMid($mid){
		//时期格式化
		$beg = strtotime(date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d'),date('Y'))));
		$end = strtotime(date('Y-m-d H:i:s',mktime(23,59,59,date('m'),date('d'),date('Y'))));
		$cond = array(
			'mid'		=> $mid,
			'direct'	=> 0,
			'type'		=> 16,
			'beg'		=> $beg,
			'end'		=> $end
		);
		return $this->dRecord->countByCondition($cond);
	}
	
	/*
	 * 根据店铺member_id集合和会员member_id获取record_id集合 
	 * @param $users_mid 会员member_id
	 * @param $agent_mids 店铺member_id集合
	 */
	public function getRecotdCidsByUmidAndAids($users_mid,$agent_mids){
		$string = '';
		$cond = array(
			'mid'		=> $users_mid,
			'refe'		=> $agent_mids,
			'field'		=> 'record_id'
		);
		$list = $this->dRecord->loadByCondition($cond);
		if($list && count($list)>0){
			foreach($list as $item){
				$string .= $item['record_id'].',';
			}
		}
		if(!empty($string)){
			$string = substr($string,0,strlen($string)-1);
		}
		return $string;
	}

}