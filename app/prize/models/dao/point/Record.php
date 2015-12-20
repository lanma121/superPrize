<?php

/**
 * 会员积分的数据层
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 27 Aug 2015 15:07:07 PM CST
 */

class Dao_Point_Record extends Blue_Dao{
	
	/*
	 * 数据信息初始化
	 */
	public function __construct(){
		parent::__construct('main', 'main', 'cms_points_record');
	}
	
	/*
	 * 收集字段信息
	 */
	private function collectField(){
		$field  = 'record_id, member_id, referral_id, points, rate, money, ';
		$field .= 'direct ,type, data_added_time, comment, status, manager_id';
		return $field;
	}
	
	/*
	 * 根据条件筛选积分纪录信息
	 * @param $cond 筛选的综合条件
	 */
	public function loadByCondition($cond){
		$opt = $this->collectField();
		if(!empty($cond['field'])){
			$opt = $cond['field'];
		}
		if(intval($cond['cid']>0)){
			$where = sprintf('record_id=%d', $cond['cid']);
			return $this->selectOne($where, $opt, null);
		}else{
			$where = '1';
			if(intval($cond['mid'])>0){
				$where .= sprintf(' and member_id=%d', intval($cond['mid']));
			}
			if(intval($cond['direct'])>-1){
				$where .= sprintf(' and direct=%d', intval($cond['direct']));
			}
			if(($cond['refe'])!=''){
				$where .= sprintf(' and referral_id in (%s)', $cond['refe']);
			}
			if(!empty($cond['type'])){
				$where .= sprintf(' and type in (%s)', $cond['type']);
			}
			if(intval($cond['beg'])>0 && intval($cond['end'])>0){
				$where .= sprintf(' and data_added_time between %d and %d', intval($cond['beg']), intval($cond['end']));
			}
			if($where!='1'){
				return $this->select($where, $opt, null);
			}else{
				return null;
			}
		}
	}
	
	/*
	 * 根据条件获取积分纪录数量信息
	 * @param $cond
	 */
	public function countByCondition($cond){
		$where = '1';
		if(intval($cond['mid'])>0){
			$where .= sprintf(' and member_id=%d', intval($cond['mid']));
		}
		if(intval($cond['direct'])>-1){
			$where .= sprintf(' and direct=%d', intval($cond['direct']));
		}
		if(($cond['type'])!=''){
			$where .= sprintf(' and type in (%s)', $cond['type']);
		}
		if(intval($cond['beg'])>0 && intval($cond['end'])>0){
			$where .= sprintf(' and data_added_time between %d and %d', intval($cond['beg']), intval($cond['end']));
		}
		if($where!='1'){
			return $this->selectCount($where);
		}else{
			return 0;
		}
	}
}