<?php

/**
 * 系统管理员服务层
 * @author 1399871902@qq.com
 * @copyright 2015~ (c) @1399871902@qq.com
 * @Time: Wed 26 Aug 2015 09:56:43 PM CST
 */

class Service_Admin{
	
	private $dAdmin;
	private $dModule;
	
	public function __construct(){
		$this->dAdmin = new Dao_Admin();
		$this->dModule = new Dao_Module();
		
	}
	
	/*
	 * 根据ID获取管理员基本信息 
	 * @param $name
	 */
	public function getAdminInfoById($aid){
		$cond = array(
			'aid'	=> $aid
		);
		return $this->dAdmin->getInfoByCondition($cond);
	}
	
	/*
	 * 根据名称获取管理员基本信息 
	 * @param $name
	 */
	public function getAdminInfoByLogin($login){
		$cond = array(
			'login'	=> $login
		);
		return $this->dAdmin->getInfoByCondition($cond);
	}
	
	/*
	 * 根据状态查询模块信息 
	 * @param $status
	 */
	public function getModuleListByStatus($status){
		$cond = array(
			'status'	=> $status
		);
		return $this->dModule->getListByCondition($cond);
	}
	
	/*
	 * 根据名称查询模块信息 
	 * @param $status
	 */
	public function getModuleInfoByName($name){
		$cond = array(
			'module'	=> $name
		);
		return $this->dModule->getInfoByCondition($cond);
	}
}