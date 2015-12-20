<?php

/**
 * 启动超级大奖
 * @author 1399871902 <@qq.com>
 * @copyright 2015~ (c) @qq.com
 * @Time: Mon 07 Sep 2015 04:18:30 PM CST
 */

class Action_StartPrize extends App_Action{
	
	private $sPrize;
	
	/*
	 * 业务的准备工作
	 * 初始化对象 变量等
	 */
	public function __prepare(){
		$this->setView(App_Action::VIEW_JSON);
		$this->sPrize = new Service_Prize();
	}
	
	/*
	 * 实际执行业务逻辑的函数
	 * @return array
	 */
	public function __execute(){
		//验证数据信息
		$data = $this->__verify();
		//数据信息有误
		if(!(intval($data['pid'])>0)){
			return array('result' => 0);
		}
		//统计同一款奖品的中奖用户信息
		$prizeInfo = $this->sPrize->getPrizeInfoById($data['pid']);
		//奖品信息异常
		if(!(intval($prizeInfo['id'])>0)){
			return array('result' => 1);
		}
		//判断是否已经产生中奖会员id
		if(intval($prizeInfo['prize_win_id'])>0){
			$wid = intval($prizeInfo['prize_win_id']);
		}else{
			//获取当前奖品抽奖人员列表
			$wid = $this->sPrize->getPrizeUserWidByPid($data['pid']);
		}
		//进到倒计时摇奖
		if(!(intval($prizeInfo['prize_start_time'])>0 && intval($data['pid'])>0 && intval($wid)>0)){
			return array('result' => 2);
		}
		//结束时间
		$end = intval($prizeInfo['prize_start_time']+$prizeInfo['prize_wait_time']+$prizeInfo['prize_buffer_time']);
		//进到倒计时摇奖
		if(intval($prizeInfo['prize_start_time'])>0 && intval($data['pid'])>0 && 
		   intval($end)>0 && intval($wid)>0){
		   	//获取中奖会员信息
			$recordInfo = $this->sPrize->getRecordInfoById($wid);
			//获取中奖会员最大期数
			if(intval($recordInfo['id'])>0 && intval($recordInfo['prize_user_order'])>0){
				$order = intval($recordInfo['prize_user_order']);
			}else{
				$order = $this->sPrize->getPrizeUserMaxOrder(true);
			}
			//启动倒计时
			$param = array(
				'id'		=> intval($wid),
				'pid'		=> intval($data['pid']),
				'end'		=> intval($end),
				'ord'		=> intval($order)
			);
			try{
				Blue_Commit::call('Super_Start', $param);
			}catch(Exception $e){
				//启动失败 [需要手动添加回滚到初始状态,重新开始倒计时]
				Blue_Commit::call('Super_Back', $param);
				return array('result' => 3);
			}
		}
		//启动成功
		return array('result' => 4);
	}
	
	/*
	 * 数据信息过滤
	 */
	private function __verify(){
		//参数信息判定
		if($this->getRequest()->isPost()){
			$data = array(
				'pid'	=> trim($_POST['pid'])
			);
			$rule = array(
				'pid' 	=> array('filterInt', array())
			);
			try{
				return Blue_Filter::filterArray($data, $rule);
			}catch(Exception $e){
				return null;
			}
		}
		return null;
	}
	
}