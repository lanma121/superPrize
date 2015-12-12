<?php

/**
 * 管理员奖品分类
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 26 Aug 2015 06:14:43 PM CST
 */

class Action_Group extends App_AdminAction{
	
	private $sPrize;
	
	public function __prepare(){
		$this->setView(Blue_Action::VIEW_SMARTY2);
		$this->sPrize = new Service_Prize();
	}
	
	public function __execute(){
		//数据过滤
		$list = array();
		$data = $this->_verify();
		$obje = $this->sPrize->getGroupListAll($data['pn'],$data['rn']);
		$numb = $this->sPrize->getGroupCountAll();
		$page = Blue_Page::pageInfo($numb,$data['pn'],$data['rn'],5);
		foreach($obje as $item){
			$item['prize_group_remark'] = mb_substr($item['prize_group_remark'],0,20,'utf-8').'......';
			$item['prize_group_adate'] = date('Y-m-d H:i:s',$item['prize_group_adate']);
			if(intval($item['prize_group_edate'])>0){
				$item['prize_group_edate'] = date('Y-m-d H:i:s',$item['prize_group_edate']);
			}else{
				$item['prize_group_edate'] = '无';
			}
			$list[] = $item;
		}
		$array = array('list'=>$list,'page'=>$page);
		return array_merge($this->result,$array);
	}
	
	/*
	 * 数据信息过滤
	 */
	private function _verify(){
		//参数信息判定
		if($this->getRequest()->isGet() || $this->getRequest()->isPost()){
			$data = array(
				'pn'			=> isset($_GET['pn'])?intval(trim($_GET['pn'])):1,
				'rn'			=> isset($_GET['rn'])?intval(trim($_GET['rn'])):5
			);
			$rule = array(
				'pn' 			=> array('filterInt', array()),
				'rn' 			=> array('filterInt', array()),
			);
			return Blue_Filter::filterArray($data, $rule);
		}
	}
}