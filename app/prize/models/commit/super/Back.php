<?php

/**
 * 回滚超级大奖信息
 * 
 * @author 1399871902<@qq.com>
 * @copyright 2015~ (c) @qq.com
 * @Time: Wed 26 Aug 2015 09:56:43 PM CST
 */

class Commit_Super_Back extends Blue_Commit{
	
	private $dSuperPrize;
	
	protected function __register(){
		$this->transDB = array('main');
	}
	
	protected function __prepare(){
		$this->dSuperPrize = new Dao_Super_Prize();
	}
	
	protected function __execute(){
		//接收参数信息
		$data = $this->getRequest();
		//回滚奖品信息
		$superPrizeData = array(
			'prize_start_time' 		=> 0,
			'prize_end_time'		=> 0,
			'prize_order' 			=> 1,
			'prize_start'			=> 1,
			'prize_out'				=> 0
		);
		$this->backPrizeByPid($data['pid'],$superPrizeData);
	}
	
	/*
	 * 根据Pid回滚奖品信息
	 * @param $pid 奖品ID
	 * @param $data 被更新的信息
	 */
	private function backPrizeByPid($pid,$data){
		$where = sprintf('id=%d', $pid);
		return $this->dSuperPrize->update($where, $data);
	}
	
}