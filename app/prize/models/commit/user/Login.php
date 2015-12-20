<?php

/**
 * 更新会员登录信息
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 26 Aug 2015 09:56:43 PM CST
 */

class Commit_User_Login extends Blue_Commit{
	
	private $dUser;
	private $dMember;
	private $dRecord;
	
	protected function __register(){
		$this->transDB = array('main');
	}

	protected function __prepare(){
		$this->dUsers = new Dao_User();
		$this->dMember = new Dao_Point_Member();
		$this->dRecord = new Dao_Point_Record();
	}
	
	protected function __execute(){
		$data = $this->getRequest();
		$this->updateUserPointByUid($data['uid']);
		$this->updateMemberPointByMid($data['mid']);
		$this->addPointRecord($data);
	}
	
	/*
	 * 更新会员登录信息
	 * @param $uid 会员users_id
	 * @return boolean
	 */
	private function updateUserPointByUid($uid){
		$field  = "date_last_logon='%s', number_of_logons=number_of_logons+1,";
		$field .= 'users_points=users_points+2';
		$cond = sprintf($field, date('Y-m-d H:i:s', time()));
		return $this->dUsers->update(sprintf('users_id=%d', $uid), $cond);
	}
	
	/*
	 * 更新会员登录积分信息
	 * @param $mid 会员member_id
	 * @return boolean
	 */
	private function updateMemberPointByMid($mid){
		$field  = 'account_modified_time=%d, member_points=member_points+2';
		$cond = sprintf($field, time());
		return $this->dMember->update(sprintf('member_id=%d', $mid), $cond);
	}
	
	/*
	 * 新增一条积分纪录 
	 * @param $param 需要新增的内容信息
	 */
	private function addPointRecord($param){
		$data = array(
			'member_id'			=> $param['mid'],
			'referral_id'		=> $param['rid'],
			'points'			=> 2,
			'rate'				=> 1,
			'money'				=> 0,
			'direct'			=> 0,
			'type'				=> 16,
			'data_added_time'	=> time(),
			'comment'			=> '会员登录赠送积分'
		);
		return $this->dRecord->insert($data);
	}
}

