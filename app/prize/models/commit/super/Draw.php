<?php

/**
 * 更新超级大奖信息
 * 
 * @author 1399871902<@qq.com>
 * @copyright 2015~ (c) @qq.com
 * @Time: Wed 26 Aug 2015 09:56:43 PM CST
 */

class Commit_Super_Draw extends Blue_Commit{
	
	private $dSuperPrize;
	private $dSuperprizeuser;
	private $dSuperPrizeRecord;
	private $dPointRecord;
	private $dPointMember;
	private $dUser;
	private $dUserNote;
	
	protected function __register(){
		$this->transDB = array('main');
	}
	
	protected function __prepare(){
		$this->dSuperPrize = new Dao_Super_Prize();
		$this->dSuperprizeuser = new Dao_Super_Prize_User();
		$this->dSuperPrizeRecord = new Dao_Super_Prize_Record();
		$this->dPointRecord = new Dao_Point_Record();
		$this->dPointMember = new Dao_Point_Member();
		$this->dUser = new Dao_user();
		$this->dUserNote = new Dao_User_Note();
	}
	
	protected function __execute(){
		//接受请求参数
		$data = $this->getRequest();
		//添加抽奖会员
		$superPrizeUserData = array(
			'prize_id' 				=> $data['pid'],
			'prize_user_uid' 		=> $data['uid'],
			'prize_user_gc' 		=> $data['draw'],
			'prize_user_status' 	=> 0,
			'prize_user_pdate' 		=> time(),
			'prize_user_gdate' 		=> 0,
			'prize_user_ip' 		=> Core_Tool::getClientIP(),
			'prize_user_card'		=> !empty($data['card'])?trim($data['card']):0,
			'prize_user_publish' 	=> 0,
			'prize_user_name' 		=> (!empty($data['name']))?$data['name']:'匿名',
			'prize_user_mobile' 	=> $data['mobile'],
			'prize_user_province' 	=> $data['zone'],
			'prize_user_city' 		=> $data['city'],
			'prize_user_district' 	=> $data['disc'],
			'prize_user_publish' 	=> 1
		);
		$this->addSuperPrizeUser($superPrizeUserData);
		
		//添加大奖积分消耗记录[出账记录]
		$superPrizeRecordData = array(
			'prize_record_uid' 		=> $data['uid'],
			'prize_record_currency' => $data['draw'],
			'prize_record_point' 	=> 0,
			'prize_record_reason' 	=> trim('用户抽奖:'.$data['title']),
			'prize_record_direct' 	=> 0,
			'prize_record_date' 	=> time()
		);
		$this->addSuperPrizeRecord($superPrizeRecordData);
		
		//添加游戏币积分消耗记录
		$pointsRecordData = array(
			'member_id' 			=> $data['mid'],
			'referral_id' 			=> 0,
			'points' 				=> $data['draw'],
			'rate'  				=> 1,
			'money' 				=> 0,
			'direct' 				=> 1,
			'type' 					=> 18,
			'data_added_time' 		=> time(),
			'comment' 				=> trim('用户抽奖'),
			'status'				=> 1
		);
		$this->addPointsRecord($pointsRecordData);
		
		//修改会员积分信息
		$userData = array(
			'users_points'			=> intval($data['point']-$data['draw'])
		);
		$this->updateUserById($data['uid'],$userData);
		
		//修改会员积分信息
		$pointMemberData = array(
			'member_points'			=> intval($data['point']-$data['draw'])
		);
		$this->updatePointMember($data['mid'],$pointMemberData);
		
		//修改奖品的实际参与人数
		$superPrizeFactNumData = array(
			'prize_fact_num'		=> intval($data['fact']),
			'prize_mod_date'		=> time()
		);
		$this->updateSuperPrizeFactNumById($data['pid'],$superPrizeFactNumData);
		
		//更新会员成就点
		$userNotePointData = array(
			'use_points_18'			=> intval($data['pot18']+$data['draw'])
		);
		$this->updateUserNotePointByMid($data['mid'],$userNotePointData);
		
	}
	
	/*
	 * 添加抽奖会员
	 * @param $data 需要新增的内容信息
	 */
	private function addSuperPrizeUser($data){
		return $this->dSuperprizeuser->insert($data);
	}
	
	/*
	 * 添加大奖积分消耗记录
	 * @param $data 需要新增的内容信息
	 */
	private function addSuperPrizeRecord($data){
		return $this->dSuperPrizeRecord->insert($data);
	}
	
	/*
	 * 添加会员积分消耗记录
	 * @param $data 需要新增的内容信息
	 */
	private function addPointsRecord($data){
		return $this->dPointRecord->insert($data);
	}
	
	/*
	 * 根据users_id修改会员信息
	 * @param $uid 会员users_id
	 * @param $data 需要修改的内容信息
	 */
	private function updateUserById($uid,$data){
		$where = sprintf('users_id=%d', $uid);
		return $this->dUser->update($where, $data);
	}
	
	/*
	 * 根据member_id修改会员积分信息
	 * @param $mid 会员member_id
	 * @param $data 需要修改的内容信息
	 */
	private function updatePointMember($mid,$data){
		$where = sprintf('member_id=%d', $mid);
		return $this->dPointMember->update($where, $data);
	}
	
	/*
	 * 根据id修改奖品的实际参与人数
	 * @param $pid 奖品ID
	 * @param $data 需要修改的内容信息
	 */
	private function updateSuperPrizeFactNumById($pid,$data){
		$where = sprintf('id=%d', $pid);
		return $this->dSuperPrize->update($where, $data);
	}
	
	/* 
	 * 根据member_id更新会员成就点
	 * @param $mid
	 * @param $data
	 */
	private function updateUserNotePointByMid($mid,$data){
		$where = sprintf('member_id=%d', $mid);
		$this->dUserNote->update($where, $data);
	}
}

