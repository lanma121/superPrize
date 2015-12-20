<?php

/**
 * 超级大奖的奖品关系数据层
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 26 Aug 2015 09:56:43 PM CST
 */

class Dao_Super_Prize_Group_Relation extends Blue_Dao{
	
	/*
	 * 数据信息初始化
	 */
	public function __construct(){
		parent::__construct('main', 'main', 'cms_super_prize_group_relation');
	}
	
	/*
	 * 获取奖品分类ID查询奖品ID集合
	 * @param $gid 查询条件集合
	 */
	public function loadPidByGid($gid){
		$opt  = 'prize_rel_prize_id';
		$where = sprintf('prize_rel_group_id=%d', $gid);
		return $this->select($where, $opt, null);
	}
	
	/*
	 * 获取奖品分类信息
	 */
	public function relationList(){
		$opt  = 'prize_rel_group_id, count(prize_rel_group_id) as total';
		$group = sprintf('group by prize_rel_group_id');
		return $this->select(null, $opt, $group);
	}
	
	/*
	 * 根据GID获取奖品PID集合
	 * @param $gid 奖品分类ID
	 */
	public function relationPidByGid($gid){
		$opt = 'prize_rel_prize_id';
		$where = sprintf('prize_rel_group_id=%d', $gid);
		return $this->select($where, $opt, null);
	}
}