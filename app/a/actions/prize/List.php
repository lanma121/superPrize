<?php

/**
 * 管理员奖品列表
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 26 Aug 2015 06:14:43 PM CST
 */

class Action_List extends App_AdminAction{
	
	private $sPrize;
	
	public function __prepare(){
		$this->setView(Blue_Action::VIEW_SMARTY2);
		$this->sPrize = new Service_Prize();
	}
	
	public function __execute(){
		//参数信息过滤
		$data = $this->_verify();
		//获取奖品列表
		$list = $this->sPrize->getPrizeListByCondition($data);
		$numb = $this->sPrize->getPrizeCountByCondition($data);
		$page = Blue_Page::pageInfo($numb,$data['pn'],$data['rn'],5);
		$statusList = array(-1=>'不限制',0=>'待开放',1=>'进行中',2=>'缓冲中',3=>'已结束',4=>'已隐藏');
		$autoList = array(0=>'全部',1=>'自动',2=>'手动');
		$array = array(
			'list'			=> $list,
			'page'			=> $page,
			'statusList'	=> $statusList,
			'autoList'		=> $autoList,
			'status'		=> $data['status'],
			'auto'			=> $data['auto'],
			'code'			=> $data['code']
		);
		return array_merge($this->result,$array);
	}
	
	/*
	 * 数据信息过滤
	 */
	private function _verify(){
		//参数信息判定
		if($this->getRequest()->isGet() || $this->getRequest()->isPost()){
			$data = array(
				'code' 			=> isset($_GET['code'])?trim($_GET['code']):null,
				'status'		=> isset($_GET['status'])?intval(trim($_GET['status'])):-1,
				'auto'			=> isset($_GET['auto'])?intval(trim($_GET['auto'])):0,
				'pn'			=> isset($_GET['pn'])?intval(trim($_GET['pn'])):1,
				'rn'			=> isset($_GET['rn'])?intval(trim($_GET['rn'])):25
			);
			$rule = array(
				'code' 			=> array('filterStrlen', array(0, 30), '', true),
				'status' 		=> array('filterInt', array()),
				'auto' 			=> array('filterInt', array()),
				'pn' 			=> array('filterInt', array()),
				'rn' 			=> array('filterInt', array())
			);
			return Blue_Filter::filterArray($data, $rule);
		}
	}
}