<?php

/**
 * 会员信息的服务层
 * 
 * @author zhurongqiang<@qq.com>
 * @copyright 2015~ (c) @qq.com
 * @Time: Wed 26 Aug 2015 09:56:43 PM CST
 */

class Service_User{
	
	//会员信息对象
	private $dUser;
	
	private $dNote;
	
	/*
	 * 服务信息初始化
	 */
	public function __construct(){
		$this->dUser = new Dao_User();
		$this->dNote = new Dao_User_Note();
	}
	
	/*
	 * 根据手机号码获取会员基本信息 
	 * @param $mobile
	 * @return array
	 */
	public function getUserInfoByMobile($mobile){
		$cond = array(
			'mobile'	=> $mobile,
			'field'		=> 'users_id,relation_id,status,users_pass,users_points'
		);
		return $this->dUser->getByCondition($cond);
	}
	
	/*
	 * 根据ID获取会员基本信息 
	 * @param $id users_id
	 */
	public function getUserInfoById($id){
		$cond = array(
			'uid'	=> $id,
			'field'	=> 'relation_id,users_points,status'
		);
		return $this->dUser->getByCondition($cond);
	}
	
	/*
	 * 根据member_id获取用户等级信息 
	 * @param $mid 会员member_id
	 */
	public function getUserNoteByMid($mid){
		$cond = array('mid'	=> $mid);
		return $this->dNote->getInfoByCondition($cond);
	}
	
}