<?php

/**
 * 查看分类
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 26 Aug 2015 06:14:43 PM CST
 */

class Action_View extends App_Action{
	
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
		$info = $this->sPrize->getGroupInfoById($data['id']);
		//当前分类不存在
		if(!(intval($data['id'])>0 && intval($info['id'])>0)){
			return array('result'=>2);
		}
		return array('result'=>3,'info'=>$info);
	}
	
	/*
	 * 数据信息过滤
	 */
	private function __verify(){
		//参数信息判定
		if($this->getRequest()->isPost()){
			$data = array(
				'id' 			=> trim($_POST['id'])
			);
			$rule = array(
				'id' 			=> array('filterInt', array())
			);
			return Blue_Filter::filterArray($data, $rule);
		}
		return null;
	}
}