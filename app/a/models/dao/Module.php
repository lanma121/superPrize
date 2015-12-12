<?php

/**
 * 系统模块数据层
 * @author 1399871902@qq.com
 * @copyright 2015~ (c) @1399871902@qq.com
 * @Time: Wed 26 Aug 2015 09:56:43 PM CST
 */

class Dao_Module extends Blue_Dao{
	
	/*
	 * 数据信息初始化
	 */
	public function __construct(){
		parent::__construct('main', 'main', 'cms__modules');
	}
	
	/*
	 * 获取管理员数据信息
	 * 根据数组条件动态获取列表信息
	 * @param $cond 收集动态条件
	 */
	public function getInfoByCondition($cond){
		$opt = $this->collectField();
		$where = '1';
		if($cond['status']!=''){
			$where .= sprintf(' and status in (%s)',$cond['status']);
		}
		if(!empty($cond['module'])){
			$where .= sprintf(" and module = '%s'",$cond['module']);
		}
		return $this->selectOne($where, $opt, null);	
	}
	
	/*
	 * 获取管理员数据列表
	 * 根据数组条件动态获取列表信息
	 * @param $cond 收集动态条件
	 */
	public function getListByCondition($cond){
		$opt = $this->collectField();
		$where = '1';
		if($cond['status']!=''){
			$where .= sprintf(' and status in (%s)',$cond['status']);
		}
		if(!empty($cond['module'])){
			$where .= sprintf(" and module = '%s'",$cond['module']);
		}
		return $this->select($where, $opt, null);
	}
	
	/*
	 * 收集字段信息
	 */
	private function collectField(){
		$field = '*';
		return $field;
	}
	
}