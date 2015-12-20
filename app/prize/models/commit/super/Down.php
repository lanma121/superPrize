<?php

/**
 * 启动超级大奖开始倒计时
 * 
 * @author 1399871902<@qq.com>
 * @copyright 2015~ (c) @qq.com
 * @Time: Wed 26 Aug 2015 09:56:43 PM CST
 */

class Commit_Super_Down extends Blue_Commit{
	
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
		//启动奖品信息
		$superPrizeData = array(
			'prize_start_time' 		=> intval($data['start']),
			'prize_phase'			=> intval($data['pahse']),
			'prize_start'			=> 1
		);
		if(intval($data['auto'])==2){
			$superPrizeData['prize_start'] = 2;
		}
		$this->startPrizeByPid($data['pid'],$superPrizeData);
	}
	
	/*
	 * 根据Pid启动奖品倒计时
	 * @param $pid 奖品ID
	 * @param $data 被更新的信息
	 */
	private function startPrizeByPid($pid,$data){
		$where = sprintf('id=%d', $pid);
		return $this->dSuperPrize->update($where, $data);
	}
}