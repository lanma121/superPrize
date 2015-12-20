<?php

/**
 * 会员成就点信息
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 26 Aug 2015 09:56:43 PM CST
 */

class Dao_User_Note extends Blue_Dao{
	
	/*
	 * 数据信息初始化
	 */
	public function __construct(){
		parent::__construct('main', 'main', 'cms_users_notes');
	}
	
	/*
	 * 收集字段信息
	 */
	private function collectField(){
		$field  = '*';
		return $field;
	}
	
	/*
	 * 获取会员详细单条纪录信息
	 * @param $cond 会员参数集合
	 */
	public function getInfoByCondition($cond){
		$opt = $this->collectField();
		$where = '1';
		if($cond['id']>0){
			$where .= sprintf(' and id=%d',$cond['id']);
		}
		if($cond['mid']>0){
			$where .= sprintf(' and member_id=%d',$cond['mid']);
		}
		if($where!='1'){
			return $this->selectOne($where, $opt, null);
		}else{
			return null;
		}
	}
	
}