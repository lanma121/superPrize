<?php

/**
 * 合作商的数据层
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 27 Aug 2015 09:56:43 PM CST
 */

class Dao_Agent_Agent extends Blue_Dao{
	
	/*
	 * 数据信息初始化
	 */
	public function __construct(){
		parent::__construct('main', 'main', 'cms_agent_agents');
	}	
	
	/*
	 * 根据条件筛选渠道商信息
	 * @param $cond 筛选的综合条件
	 * @param $field 指定输出的数据库字段
	 */
	public function loadByCondition($cond,$field){
		$opt = 'id, relation_id, agent_name';
		if(!empty($field)){
			$opt = $field;
		}
		if($field=='id'){
			$cond['id'] = $field;
		}
		if($cond['id']>0){
			$where = sprintf('id=%d', $cond['id']);
			return $this->selectOne($where, $opt, null);
		}else{
			$where = '';
			if($field != ''){
				$opt = $field;
			}
			if(intval($cond['tid'])>0){
				$where .= sprintf(' tid=%d', $cond['tid']);
			}
			if(!empty($cond['rid'])){
				$where .= sprintf(' and relation_id in (%s)', $cond['rid']);
			}
			if(!empty($where)){
				return $this->select($where, $opt, null);
			}
		}
	}
	
	/*
	 * 根据渠道商ID集合获取其信息集合[仅供超级大奖特用] 
	 * @param $ids 渠道商ID集合
	 */
	public function listAgentByIds($ids){
		$opt = 'id, relation_id, agent_name';
		$where = sprintf('id in (%s)',$ids);
		return $this->select($where, $opt, null);
	}
	
	
	
}