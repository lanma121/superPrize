<?php

/**
 * 检查超级大奖启动
 * @author 1399871902 <@qq.com>
 * @copyright 2015~ (c) @qq.com
 * @Time: Mon 07 Sep 2015 04:18:30 PM CST
 */

class Action_CheckStart extends App_Action{
	
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
		//数据信息正确
		if(!empty($data) && intval($data['pid'])>0){
			$prizeInfo = $this->sPrize->getPrizeStatusAndStartById($data['pid']);
			return array('result' => intval($prizeInfo['prize_start']));
		}
		return array('result' => 0);
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