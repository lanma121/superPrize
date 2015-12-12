<?php

/**
 * 系统权限服务层
 * @author 1399871902@qq.com
 * @copyright 2015~ (c) @1399871902@qq.com
 * @Time: Wed 26 Aug 2015 09:56:43 PM CST
 */

class Service_Manager{
	
	private $dAdmin;
	
	public function __construct(){
		$this->dAdmin = new Dao_Admin();
	}
	
	/*
	 * 根据ID获取管理员基本权限信息 
	 * @param $name
	 */
	public function getAdminManagerById($aid){
		$cond = array(
			'aid'	=> $aid
		);
		return $this->dAdmin->getInfoByCondition($cond);
	}
}