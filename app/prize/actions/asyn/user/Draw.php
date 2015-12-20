<?php

/**
 * 加载会员抽奖会员
 * @author 1399871902 <@qq.com>
 * @copyright 2015~ (c) @qq.com
 * @Time: Mon 07 Sep 2015 04:18:30 PM CST
 */

class Action_UserDraw extends App_Action{
	
	private $sPrize;
	
	public function __prepare(){
		$this->setView(App_Action::VIEW_JSON);
		$this->sPrize = new Service_Prize();
	}
	
	public function __execute(){
		$array = array();
		$data = $this->__verify();
		//数据格参数
		$param = array('pid'=>$data['id'],'pn'=>$data['pn'],'rn'=>$data['rn']);
		//获取抽奖会员列表
		$drawObject = $this->sPrize->prizeUserByCondition($param);
		//获取投注记录总数
		$drawCount = $this->sPrize->getRecordCountByPid($data['id']);
		//保存处理结果
		$drawList = array();
		//格式化数据
		if($drawObject && count($drawObject)>0){
			foreach($drawObject as $draw){
				if(!empty($draw['prize_user_name']) && trim($draw['prize_user_name'])!='匿名' && 
				    trim($draw['prize_user_name'])==trim($draw['prize_user_mobile'])){
				    $draw['prize_user_name'] = '匿名';
				}else{
					$draw['prize_user_name'] = mb_substr($draw['prize_user_name'],0,1,'utf-8').'**';
				}
				if(!empty($draw['prize_user_mobile']) && strlen($draw['prize_user_mobile'])==11){
					$first = substr($draw['prize_user_mobile'], 0, 3);
					$last = substr($draw['prize_user_mobile'], 7, strlen($draw['prize_user_mobile']));
					$draw['prize_user_mobile'] = $first.'****'.$last;
				}
				$draw['prize_user_pdate'] = date('Y-m-d H:i:s',$draw['prize_user_pdate']);
				$draw['prize_user_locat'] = $draw['prize_user_province'].$draw['prize_user_city'].$draw['prize_user_district'];
				$drawList[] = $draw;
			}
		}
		//返回并输出结果信息
		return array(
			'coun'  => $drawCount,
			'list'	=> $drawList,
			'page' 	=> Blue_Page::pageInfo($drawCount,$data['pn'],$data['rn'],5)
		);
	}
	
	/*
	 * 数据信息过滤
	 */
	private function __verify(){
		if($this->getRequest()->isPost()){
			$data = array(
				'id'			=> isset($_POST['id'])?trim($_POST['id']):0,
				'pn'			=> isset($_POST['pn'])?trim($_POST['pn']):1,
				'rn'			=> isset($_POST['rn'])?trim($_POST['rn']):20
			);
			$rule = array(
				'id' 			=> array('filterInt', array()),
				'pn' 			=> array('filterInt', array()),
				'rn' 			=> array('filterInt', array())
			);
		}
		try{
			$data = Blue_Filter::filterArray($data, $rule);
		}catch(Exception $e){
			$data = null;
		}
		return $data;
	}
	
}