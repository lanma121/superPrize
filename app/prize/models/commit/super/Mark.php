<?php

/**
 * 标记超级大奖信息
 * 
 * @author 1399871902<@qq.com>
 * @copyright 2015~ (c) @qq.com
 * @Time: Wed 26 Aug 2015 09:56:43 PM CST
 */

class Commit_Super_Mark extends Blue_Commit{
	
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
		//更新奖品标记状态
		$superPrizeData = array(
			'prize_out' 			=> intval($data['pid'])
		);
		$this->updatePrizeOutByPid($data['pid'],$superPrizeData);
	}
	
	/*
	 * 标记奖品的flash状态
	 * @param $pid 奖品ID
	 * @param $data 被更新的信息
	 */
	private function updatePrizeOutByPid($pid,$data){
		$where = sprintf('id=%d', $pid);
		return $this->dSuperPrize->update($where, $data);
	}
	
}