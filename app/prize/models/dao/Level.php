<?php

/**
 * 会员成就点表数据层
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 26 Aug 2015 09:56:43 PM CST
 */

class Dao_Level extends Blue_Dao{
	
	/*
	 * 数据信息初始化
	 */
	public function __construct(){
		parent::__construct('main', 'main', 'cms_level');
	}
	
	/*
	 * 收集字段信息
	 */
	private function collectField(){
		$field = '*';
		return $field;
	}
	
	/*
	 * 奖品详细,特殊情况
	 * 根据数组条件动态获取列表信息
	 * @param $cond 收集动态条件
	 */
	public function getListByCondition($cond){
		$opt = $this->collectField();
		$where = '1';
		if($cond['lid']>0){
			$where .= sprintf(' and id in (%s)',$cond['lid']);
		}
		if($cond['tid']>0){
			$where .= sprintf(' and type_id in (%s)',$cond['tid']);
		}
		if($cond['pn']>0 && $cond['rn']>0){
			$limit = sprintf(' order by id desc limit %d,%d', ($cond['pn']-1)*$cond['rn'], $cond['rn']);
		}else{
			$limit = sprintf(' order by points desc');
		}
		return $this->select($where, $opt, $limit);	
	}
}