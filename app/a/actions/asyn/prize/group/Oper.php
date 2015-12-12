<?php

/**
 * 添加/编辑分类
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 26 Aug 2015 06:14:43 PM CST
 */

class Action_Oper extends App_Action{
	
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
		$groupInfo = $this->sPrize->getGroupInfoById($data['id']);
		//当前分类已存在
		if(intval($data['id'])>0 && intval($groupInfo['id'])>0){
			//编辑奖品
			try{
				$param = array(
					'name'		=> $data['name'],
					'mark'		=> $data['mark'],
					'id'		=> intval($data['id'])
				);
				Blue_Commit::call('Super_Prize_Group_Edit', $param);
				return array('result'=>2);
			}catch(Exception $e){
				//操作失败
				return array('result'=>4);
			}
		}else{
			//新增奖品
			try{
				$param = array(
					'name'		=> $data['name'],
					'mark'		=> $data['mark']
				);
				Blue_Commit::call('Super_Prize_Group_Add', $param);
				return array('result'=>3);
			}catch(Exception $e){
				//操作失败
				return array('result'=>4);
			}
		}
	}
	
	/*
	 * 数据信息过滤
	 */
	private function __verify(){
		//参数信息判定
		if($this->getRequest()->isPost()){
			$data = array(
				'name' 			=> trim($_POST['name']), 
				'mark' 			=> trim($_POST['mark']), 
				'id' 			=> trim($_POST['id'])
			);
			$rule = array(
				'name' 			=> array('filterStrlen', array(0, 30), '', true),
				'mark' 			=> array('filterStrlen', array(0, 150), '', true),
				'id' 			=> array('filterInt', array())
			);
			return Blue_Filter::filterArray($data, $rule);
		}
		return null;
	}
	
}