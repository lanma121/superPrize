<?php

/**
 * 奖品服务层
 * @author 1399871902@qq.com
 * @copyright 2015~ (c) @1399871902@qq.com
 * @Time: Wed 26 Aug 2015 09:56:43 PM CST
 */

class Service_Prize{
	
	private $dPrize;
	private $dGroup;
	
	public function __construct(){
		$this->dPrize = new Dao_Super_Prize();
		$this->dGroup = new Dao_Super_Prize_Group();
	}
	
	/*
	 * 根据ID获取奖品分类数据信息
	 * @param $cond
	 */
	public function getGroupInfoById($id){
		$cond = array(
			'gid'	=> $id
		);
		return $this->dGroup->getInfoByCondition($cond);
	}
	
	/*
	 * 根据名称获取奖品分类数据信息
	 * @param $cond
	 */
	public function getGroupInfoByName($name){
		$cond = array(
			'name'	=> $name
		);
		return $this->dGroup->getInfoByCondition($cond);
	}
	
	/*
	 * 根据名称获取奖品分类数据信息
	 * @param $cond
	 */
	public function getGroupListAll($pn,$rn){
		$cond = array(
			'pn'	=> $pn,
			'rn'	=> $rn
		);
		return $this->dGroup->getListByCondition($cond);
	}
	
	/*
	 * 分类总数
	 */
	public function getGroupCountAll(){
		$cond = array();
		return $this->dGroup->getCountByCondition($cond);
	}
	
	/*
	 * 根据gid查询奖品总数
	 * @param $gid
	 */
	public function getGroupCountByGid($gid){
		$cond = array(
			'gid'	=> $gid
		);
		return $this->dPrize->getCountByCondition($cond);
	}
	
	/*
	 * 根据编号获取奖品列表 
	 * @param $pn
	 * @param $rn
	 * @param $code
	 */
	public function getPrizeListByCondition($cond){
		return $this->dPrize->getListByCondition($cond);
	}
	
	/*
	 * 根据code编号查询奖品总数
	 * @param $gid
	 */
	public function getPrizeCountByCondition($cond){
		return $this->dPrize->getCountByCondition($cond);
	}
}