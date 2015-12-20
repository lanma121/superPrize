<?php

/**
 * 超级大奖的奖品数据层
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 26 Aug 2015 09:56:43 PM CST
 */

class Dao_User extends Blue_Dao{
	
	/*
	 * 数据信息初始化
	 */
	public function __construct(){
		parent::__construct('main', 'main', 'cms_users');
	}
	
	/*
	 * 收集字段信息
	 */
	private function collectField(){
		$field  = 'users_id, relation_id, users_email_address, users_name, users_pass, name, ';
		$field .= 'users_points ,users_posts, unemail, portrait, ip_registered, ip_logon,';
		$field .= 'date_last_logon, number_of_logons, date_account_created, date_account_last_modified,'; 
		$field .= 'status, address_id, activecode, onlinetime, source, types, mobile, old_phone,';
		$field .= 'email_checked, mobile_checked, mobile_activecode, activetime, unsms, bailitong,';
		$field .= 'rating_level, quench_num, rating_id, valid_rating, weixin_no, valid_no, reg_type,';
		$field .= 'month_logins, logins, month_time, is_checked, first_chance, total_chance';
		return $field;
	}
	
	/*
	 * 获取会员详细单条纪录信息
	 * @param $cond 会员参数集合
	 */
	public function getByCondition($cond){
		$opt = $this->collectField();
		if(!empty($cond['field'])){
			$opt = $cond['field'];
		}
		$where = '1';
		if($cond['uid']>0){
			$where .= sprintf(' and users_id=%d',$cond['uid']);
		}
		if($cond['rid']>0){
			$where .= sprintf(' and relation_id=%d',$cond['rid']);
		}
		if(!empty($cond['name'])){
			$where .= sprintf(" and name='%s'",$cond['name']);
		}
		if(!empty($cond['mobile'])){
			$where .= sprintf(" and mobile='%s'",$cond['mobile']);
		}
		if($where!='1'){
			return $this->selectOne($where, $opt, null);
		}else{
			return null;
		}
	}
	
}