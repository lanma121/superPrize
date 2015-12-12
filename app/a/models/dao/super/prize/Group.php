<?php

/**
 * 奖品分类数据层
 * @author 1399871902@qq.com
 * @copyright 2015~ (c) @1399871902@qq.com
 * @Time: Wed 26 Aug 2015 09:56:43 PM CST
 */

class Dao_Super_Prize_Group extends Blue_Dao{
	
	/*
	 * 数据信息初始化
	 */
	public function __construct(){
		parent::__construct('main', 'main', 'cms_super_prize_group');
	}
	
	/*
	 * 获取奖品分类数据信息
	 * 根据数组条件动态获取列表信息
	 * @param $cond 收集动态条件
	 */
	public function getInfoByCondition($cond){
		$opt = $this->collectField();
		$where = '1';
		if($cond['gid']>0){
			$where .= sprintf(' and id in (%s)',$cond['gid']);
		}
		if(!empty($cond['name'])){
			$where .= sprintf(" and prize_group_name = '%s'",$cond['name']);
		}
		return $this->selectOne($where, $opt, null);	
	}
	
	/*
	 * 获取奖品分类数据列表
	 * 根据数组条件动态获取列表信息
	 * @param $cond 收集动态条件
	 */
	public function getListByCondition($cond){
		$opt = $this->collectField();
		$where = $this->getListSqlByCondition($cond);
		if($cond['pn']>0 && $cond['rn']>0){
			$limit = sprintf('order by id desc limit %d,%d', ($cond['pn']-1)*$cond['rn'], $cond['rn']);
		}else{
			$limit = null;
		}
		return $this->select($where, $opt, $limit);	
	}
	
	/*
	 * 分类分页,特殊情况
	 * 根据数组条件动态获取列表信息
	 * @param $cond 收集动态条件
	 */
	public function getCountByCondition($cond){
		$where = $this->getListSqlByCondition($cond);
		return $this->selectCount($where);
	}
	
	/*
	 * 收集字段信息
	 */
	private function collectField(){
		$field = '*';
		return $field;
	}
	
	/*
	 * 收集列表查询条件
	 * @param $cond
	 */
	private function getListSqlByCondition($cond){
		$where = '1';
		if(!empty($cond['name'])){
			$where .= sprintf(" and prize_group_name like '%s%'",$cond['name']);
		}
		return $where;
	}
}