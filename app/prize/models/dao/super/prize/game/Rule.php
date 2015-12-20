<?php

/**
 * 超级大奖的游戏规则数据层
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 26 Aug 2015 09:56:43 PM CST
 */

class Dao_Super_Prize_Game_Rule extends Blue_Dao{
	
	/*
	 * 数据信息初始化
	 */
	public function __construct(){
		parent::__construct('main', 'main', 'cms_super_game_rule');
	}
	
	/*
	 * 根据ID加载游戏规则
	 * @param $id 游戏规则ID
	 */
	public function getRuleById($id){
		$opt  = 'id,rule_content,rule_add_date,rule_mod_date';
		$where = sprintf('id=%d', $id);
		return $this->selectOne($where, $opt, null);
	}
	
}