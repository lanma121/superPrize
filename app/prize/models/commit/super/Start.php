<?php

/**
 * 启动超级大奖信息
 * 
 * @author 1399871902<@qq.com>
 * @copyright 2015~ (c) @qq.com
 * @Time: Wed 26 Aug 2015 09:56:43 PM CST
 */

class Commit_Super_Start extends Blue_Commit{
	
	private $dSuperPrize;
	
	private $dSuperprizeuser;
	
	protected function __register(){
		$this->transDB = array('main');
	}
	
	protected function __prepare(){
		$this->dSuperPrize = new Dao_Super_Prize();
		$this->dSuperprizeuser = new Dao_Super_Prize_User();
	}
	
	protected function __execute(){
		//接收参数信息
		$data = $this->getRequest();
		
		//更新会员中奖状态
		$superPrizeUserData = array(
			'prize_user_status' 	=> -1,
			'prize_user_gdate' 		=> time(),
			'prize_user_order'		=> $data['ord']
		);
		$this->updatePrizeUserInfoByIdAndPid($data['id'],$data['pid'],$superPrizeUserData);
		
		//更新奖品信息
		$superPrizeData = array(
			'prize_status'			=> 3,
			'prize_win_id'			=> intval($data['id']),
			'prize_order'			=> -1,
			'prize_end_time'		=> intval($data['end'])
		);
		$this->updatePrizeInfoByPid($data['pid'],$superPrizeData);
	}
	
	/*
	 * 更新会员中奖纪录信息
	 * @param $id 抽奖会员纪录ID
	 * @param $pid 奖品ID
	 * @param $data 被更新的信息
	 */
	private function updatePrizeUserInfoByIdAndPid($id,$pid,$data){
		$where = sprintf('id=%d and prize_id=%d', $id, $pid);
		return $this->dSuperprizeuser->update($where, $data);
	}
	
	/*
	 * 更新奖品信息 
	 * @param $pid 奖品ID
	 * @param $data 被更新的信息
	 */
	private function updatePrizeInfoByPid($pid,$data){
		$where = sprintf('id=%d', $pid);
		return $this->dSuperPrize->update($where, $data);
	}
	
}