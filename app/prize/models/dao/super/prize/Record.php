<?php

/**
 * 超级大奖的抽奖会员数据层
 * 
 * @author 1399871902<@qq.com>
 * @copyright 2015~ (c) @qq.com
 * @Time: Wed 27 Aug 2015 09:56:43 PM CST
 */

class Dao_Super_Prize_Record extends Blue_Dao{
	
	/*
	 * 数据信息初始化
	 */
	public function __construct(){
		parent::__construct('main', 'main', 'cms_super_prize_record');
	}
	
}