<?php

/**
 * 删除分类
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 26 Aug 2015 06:14:43 PM CST
 */

class Action_Dele extends App_Action{
	
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
		$numb = $this->sPrize->getGroupCountByGid($data['id']);
		//当前分类已被使用
		if(intval($numb)>0){
			return array('result'=>2);
		}
		//删除分类
		try{
			$param = array(
				'id'		=> intval($data['id'])
			);
			Blue_Commit::call('Super_Prize_Group_Dele', $param);
			return array('result'=>3);
		}catch(Exception $e){
			//操作失败
			return array('result'=>4);
		}
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