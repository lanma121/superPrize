<?php

/**
 * 验证分类名称
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 26 Aug 2015 06:14:43 PM CST
 */

class Action_Check extends App_Action{
	
	private $sPrize;
	
	public function __prepare(){
		$this->setView(Blue_Action::VIEW_JSON);	
		$this->sPrize = new Service_Prize();
	}
	
	public function __execute(){
		//参数信息过滤
		$data = $this->__verify();
		//数据信息不完整
		if(!($data && count($data)>0)){
			return array('result'=>1);
		}
		//获取分类信息
		$groupInfo = $this->sPrize->getGroupInfoByName($data['name']);
		//当前奖品已存在
		if(intval($groupInfo['id'])>0){
			return array('result'=>2,'name'=>$data['name']);
		}
		//当前奖品不存在
		return array('result'=>3);
	}
	
	/*
	 * 数据信息过滤
	 */
	private function __verify(){
		//参数信息判定
		if($this->getRequest()->isPost()){
			$data = array(
				'name' 			=> trim($_POST['name']), 
			);
			$rule = array(
				'name' 			=> array('filterStrlen', array(0, 30), '', true),
			);
			return Blue_Filter::filterArray($data, $rule);
		}
		return null;
	}
}