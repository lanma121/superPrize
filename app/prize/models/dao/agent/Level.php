<?php

/**
 * 渠道商级别的数据层
 * @author 1399871902<@qq.com>
 * @copyright 2015~ (c) @qq.com
 * @Time: Monday 26 October 2015 17:57:17 PM CST
 */

class Dao_Agent_Level extends Blue_Dao{
	
	/*
	 * 数据信息初始化
	 */
	public function __construct(){
		parent::__construct('main', 'main', 'cms_agent_level');
	}
	
	/*
	 * 获取地址信息
	 * @param $cond 地址参数集合
	 */
	public function loadByCondition($cond){
		//获取全部字段值信息
		$opt = 'level_id,level,agent_id,parent_id,location_id';
		//获取被选定字段信息
		if(!empty($cond['field'])){
			$opt = $cond['field'];
		}
		//根据ID获取单条数据
		if(intval($cond['level_id'])>0){
			$where = sprintf('level_id=%d',intval($cond['id']));
			return $this->selectOne($where, $opt, null);
		}
		//根据其它条件获取集合信息
		else{
			$where = '1';
			if($cond['level']){
				$where .= sprintf(' and level=%d',$cond['level']);
			}
			if($cond['agent_id']){
				$where .= sprintf(' and agent_id in (%s)',$cond['agent_id']);
			}
			if($cond['parent_id']){
				$where .= sprintf(' and parent_id=%d',$cond['parent_id']);
			}
			if($cond['location_id']){
				$where .= sprintf(' and location_id=%d',$cond['location_id']);
			}
			if($cond['location_ids']){
				$where .= sprintf(' and location_id in (%s)',$cond['location_ids']);
			}
			if(!empty($where)){
				return $this->select($where, $opt, null);
			}
		}
	}
	
}