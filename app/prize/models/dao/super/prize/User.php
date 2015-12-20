<?php

/**
 * 超级大奖的抽奖会员数据层
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 27 Aug 2015 09:56:43 PM CST
 */

class Dao_Super_Prize_User extends Blue_Dao{
	
	/*
	 * 数据信息初始化
	 */
	public function __construct(){
		parent::__construct('main', 'main', 'cms_super_prize_user');
	}
	
	/*
	 * 收集字段信息
	 */
	private function collectField(){
		$field  = 'id, prize_id, prize_user_uid, prize_user_name, prize_user_gc, prize_user_status,';
		$field .= 'prize_user_pdate, prize_user_gdate, prize_user_giving, prize_user_word,';
		$field .= 'prize_user_place, prize_user_ip, prize_user_card, prize_user_mobile,';
		$field .= 'prize_user_province, prize_user_city, prize_user_district, prize_user_publish,';
		$field .= 'prize_user_order';
		return $field;
	}
	
	/*
	 * 根据条件获取抽奖会员单条纪录信息
	 * @param $id 抽奖会员纪录ID
	 * @param $fields 奖品抽奖会员表字段
	 */
	public function getUserById($id,$fields=''){
		$opt = $this -> collectField();
		if(!empty($fields) && $fields!=null){
			$opt  = $fields;
		}
		$where = sprintf('id=%d', $id);
		return $this->selectOne($where, $opt, null);
	}
	
	/*
	 * 根据动态条件获取抽奖纪录集合
	 * @param $cond 动态查询条件集合
	 */
	public function loadByCondition($cond){
		$opt = $this -> collectField();
		if(!empty($cond['field'])){
			$opt = $cond['field'];
		}
		$where = ' 1 ';
		if($cond['uid']>0){
			$where .= sprintf(' and prize_user_id=%d', $cond['uid']);
		}
		if($cond['pid']>0){
			if($cond['not']==1){
				$where .= sprintf(' and prize_id!=%d', $cond['pid']);
			}else{
				$where .= sprintf(' and prize_id=%d', $cond['pid']);
			}
		}
		if($cond['status']>=-1){
			$where .= sprintf(' and prize_user_status=%d', $cond['status']);
		}
		if($cond['pn']>=0 && $cond['rn']>0){
			$limit = sprintf('order by id desc limit %d,%d', ($cond['pn']-1)*$cond['rn'], $cond['rn']);
		}else{
			$limit = null;
		}
		if(!empty($where)){
			return $this->select($where, $opt, $limit);
		}
	}
	
	/*
	 * 根据奖品id和会员id获取投注次数 
	 * @param $pid
	 * @param $uid
	 * @return int
	 */
	public function loadDrawCountByPidAndUid($pid,$uid){
		$opt  = 'count(id) as total';
		$where = sprintf('prize_id=%d and prize_user_uid=%d',$pid,$uid);
		return $this->selectOne($where, $opt, null);
	}
	
	/*
	 * 获取多条记录信息
	 * @param $cond 动态查询条件集合
	 */
	public function getListByCondition($cond){
		$opt = $this -> collectField();
		$where = '1';
		if($cond['pid']>0){
			$where .= sprintf(' and prize_id in (%s)', $cond['pid']);
		}
		if($cond['uid']>0){
			$where .= sprintf(' and prize_user_uid in (%s)', $cond['uid']);
		}
		if($cond['stu']>=-1){
			$where .= sprintf(' and prize_user_status in (%s)', $cond['stu']);
		}
		if($cond['pub']>=0){
			$where .= sprintf(' and prize_user_publish in (%s)', $cond['pub']);
		}
		if($cond['pn']>=0 && $cond['rn']>0){
			$limit = sprintf('order by prize_user_order desc limit %d,%d', ($cond['pn']-1)*$cond['rn'], $cond['rn']);
		}else{
			$limit = null;
		}
		return $this->select($where, $opt, $limit);
	}
	
	/*
	 * 获取单条记录信息
	 * @param $cond 动态查询条件集合
	 */
	public function getInfoByCondition($cond){
		$opt = $this -> collectField();
		$where = '1';
		if($cond['id']>0){
			$where .= sprintf(' and id in (%s)', $cond['id']);
		}
		if($cond['pid']>0){
			$where .= sprintf(' and prize_id in (%s)', $cond['pid']);
		}
		if($cond['uid']>0){
			$where .= sprintf(' and prize_user_uid in (%s)', $cond['uid']);
		}
		$limit = sprintf(' order by id desc limit 1');
		$list = $this->select($where, $opt, $limit);
		return $list[0];
	}
	
	/*
	 * 统计奖品抽奖记录信息
	 * @param $cond 动态查询条件
	 */
	public function getCountByCondition($cond){
		$where = '1';
		if($cond['pid']>0){
			$where .= sprintf(' and prize_id in (%s)', $cond['pid']);
		}
		if($cond['uid']>0){
			$where .= sprintf(' and prize_user_uid in (%s)', $cond['uid']);
		}
		return $this->selectCount($where);
	}
	
	/*
	 * 根据条件获取总求和总数
	 * @param $cond 动态查询条件
	 */
	public function getSumByCondition($cond){
		$opt = ' sum(prize_user_gc) as total ';
		$where = '1';
		if(!empty($cond['clm'])){
			$opt = ' sum('.$cond['clm'].') as total ';
		}
		if($cond['pid']>0){
			$where .= sprintf(' and prize_id in (%s)',$cond['pid']);
		}
		if($cond['uid']>0){
			$where .= sprintf(' and prize_user_uid in (%s)',$cond['uid']);
		}
		return $this->selectOne($where, $opt, null);
	}
	
	/*
	 * 获取中奖会员的最大排序号
	 */
	public function getMaxOrder(){
		$opt  = 'max(prize_user_order) as max_order';
		return $this->selectOne(null, $opt, null);
	}
}