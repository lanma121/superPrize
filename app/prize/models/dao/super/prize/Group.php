<?php

/**
 * 超级大奖的奖品分类数据层
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
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
	 * 根据ID获取奖品分类信息
	 * @param $id 奖品分类ID
	 * @param $key 奖品分类表字段
	 */
	public function getGroupById($id,$key=''){
		if(!empty($key)){
			$opt = $key;
		}else{
			$opt = 'id, prize_group_name, prize_group_remark, prize_group_adate, prize_group_edate';
		}
		$where = sprintf('id=%d', $id);
		return $this->selectOne($where, $opt, null);
	}
}