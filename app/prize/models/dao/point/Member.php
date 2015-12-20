<?php

/**
 * 会员积分的数据层
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 27 Aug 2015 15:07:07 PM CST
 */

class Dao_Point_Member extends Blue_Dao{
	
	/*
	 * 数据信息初始化
	 */
	public function __construct(){
		parent::__construct('main', 'main', 'cms_points_member');
	}	
	
	/*
	 * 根据条件筛选会员积分信息
	 * @param $cond 筛选的综合条件
	 */
	public function loadByCondition($cond){
		$opt = 'member_id, relation_id, member_points, mobile, zone_id, city_id, district_id, status';
		if(!empty($cond['field'])){
			$opt = $cond['field'];
		}
		if(intval($cond['mid']>0)){
			$where = sprintf('member_id=%d', $cond['mid']);
			return $this->selectOne($where, $opt, null);
		}else if(intval($cond['rid'])>0){
			$where = sprintf('relation_id=%d', $cond['rid']);
			return $this->selectOne($where, $opt, null);
		}else{
			$where = '1';
			if(intval($cond['zone_id'])>0){
				$where .= sprintf(' and zone_id=%d', intval($cond['zone_id']));
			}
			if(intval($cond['city_id'])>0){
				$where .= sprintf(' and city_id=%d', intval($cond['city_id']));
			}
			if(intval($cond['disc_id'])>0){
				$where .= sprintf(' and district_id=%d', intval($cond['disc_id']));
			}
			if(!empty($cond['rids'])){
				$where .= sprintf(' and relation_id in (%s)', $cond['rids']);
			}
			if($where!='1'){
				return $this->select($where, $opt, null);
			}else{
				return null;
			}
		}
	}
	
}