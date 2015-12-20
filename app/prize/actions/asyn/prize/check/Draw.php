<?php

/**
 * 检查抽奖条件
 * @author 1399871902 <@qq.com>
 * @copyright 2015~ (c) @qq.com
 * @Time: Mon 07 Sep 2015 04:18:30 PM CST
 */

class Action_CheckDraw extends App_Action{
	
	private $sPrize;
	private $sUser;
	private $sMember;
	private $Record;
	private $sAgent;
	private $sLocation;
	
	/*
	 * 业务的准备工作
	 * 初始化对象 变量等
	 */
	public function __prepare(){
		$this->setView(App_Action::VIEW_JSON);
		$this->sPrize = new Service_Prize();
		$this->sUser = new Service_User();
		$this->sMember = new Service_Member();
		$this->sRecord = new Service_Record();
		$this->sAgent = new Service_Agent();
		$this->sLocation = new Service_Location();
	}
	
	/*
	 * 实际执行业务逻辑的函数
	 * @return array
	 */
	public function __execute(){
		//验证数据信息
		$data = $this->__verify();
		//数据信息有误
		if(empty($data)){
			return array('result' => 1);
		}
		//获取会员信息
		$usersInfo = $this->sUser->getUserInfoById($data['uid']);
		//会员基本信息异常
		if(!(intval($usersInfo['relation_id'])>0)){
			return array('result' => 2);
		}
		//获取积分信息
		$memberInfo = $this->sMember->getMemberInfoByRid($usersInfo['relation_id']);
		//会员积分账号异常
		if(!(intval($memberInfo['member_id'])>0)){
			return array('result' => 3);
		}
		//获取奖品信息
		$prizeInfo = $this->sPrize->getPrizeInfoById($data['pid']);
		//奖品状态异常
		if(intval($prizeInfo['prize_status']) != 1){
			return array('result' => 4);
		}
		//会员积分异常
		if(intval($usersInfo['users_points']) != intval($memberInfo['member_points'])){
			return array('result' => 5);
		}
		//需要身份认证
		if(intval($prizeInfo['prize_auth']) == 0 && empty($memberInfo['id_card'])){
			return array('result' => 6);
		}
		//冠名店铺认证[获取店铺信息]
		if(!empty($prizeInfo['prize_agents']) && $prizeInfo['prize_agents']!='0'){
			$rids = $this->sAgent->getAgentRidsByAids($prizeInfo['prize_agents']);
			//获取店铺积分信息
			if(!empty($rids)){
				$mids = $this->sMember->getMemeberMidsByRids($rids);
			}
			//获取会员在店铺的消费记录信息
			if(!empty($mids)){
				$cids = $this->sRecord->getRecotdCidsByUmidAndAids($memberInfo['member_id'],$mids);
			}
			//未在该店铺消费过
			if(empty($cids)){
				return array('result' => 7);
			}
		}
		//消费地区认证认证[获取该地区旗下所有店铺信息]
		if(!empty($prizeInfo['prize_locats']) && intval($prizeInfo['prize_locats']>0)){
			//变量初始化
			$zoneId = $cityId = $discId = 0;
			//消费地区认证认证[获取该地区旗下所有店铺信息]
			if(intval($prizeInfo['prize_zone'])>0){
				$zoneId = intval($prizeInfo['prize_zone']);
			}
			if(intval($prizeInfo['prize_city'])>0){
				$cityId = intval($prizeInfo['prize_city']);
			}
			if(intval($prizeInfo['prize_disc'])>0){
				$discId = intval($prizeInfo['prize_disc']);
			}
			//获取店铺积分信息
			$mids = $this->sMember->getMemberMidsByArea($zoneId,$cityId,$discId);
			//获取会员在店铺的消费记录信息
			if(!empty($mids)){
				$cids = $this->sRecord->getRecotdCidsByUmidAndAids($memberInfo['member_id'],$mids);
			}
			//未在该地区消费过 
			if(empty($cids)){
				return array('result' => 8);
			}
		}
		//会员积分不足
		if(intval($usersInfo['users_points']) < intval($prizeInfo['prize_draw_currency'])){
			return array('result' => 9);
		}
		//验证码错误
		if(!empty($data['cod'])){
			$image = new Arch_ValidImage();
			if($image->check($data['cod']) == false){
				return array('result' => 10);
			}
		}
		//验证当前会员是否连续投注
		$recordInfo = $this->sPrize->getRecordInfoLastByPid($data['pid']);
		if(empty($data['cod']) && intval($recordInfo['prize_user_uid'])==intval($data['uid'])){
			return array('result' => 11);
		}
		//验证通过可以进行投注
		return array('result' => 12);
	}
	
	/*
	 * 数据信息过滤
	 */
	private function __verify(){
		//参数信息判定
		if($this->getRequest()->isPost()){
			$data = array(
				'pid'	=> trim($_POST['pid']),
				'uid'	=> trim($_POST['uid']),
				'cod'	=> trim($_POST['cod'])
			);
			$rule = array(
				'pid' 	=> array('filterInt', array()),
				'uid' 	=> array('filterInt', array()),
				'cod' 	=> array('filterStrlen', array(0, 6), '', true)
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