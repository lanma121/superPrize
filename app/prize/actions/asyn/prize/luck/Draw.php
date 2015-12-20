<?php

/**
 * 开始抽奖
 * @author 1399871902 <@qq.com>
 * @copyright 2015~ (c) @qq.com
 * @Time: Mon 07 Sep 2015 04:18:30 PM CST
 */

class Action_LuckDraw extends App_Action{
	
	private $sPrize;
	private $sUser;
	private $sMember;
	private $sAgent;
	private $sLocation;
	private $sSoap;
	
	/*
	 * 业务的准备工作
	 * 初始化对象 变量等
	 */
	public function __prepare(){
		$this->setView(App_Action::VIEW_JSON);
		$this->sPrize = new Service_Prize();
		$this->sUser = new Service_User();
		$this->sMember = new Service_Member();
		$this->sAgent = new Service_Agent();
		$this->sLocation = new Service_Location();
		$this->sSoap = new App_Soap_Soap();
	}
	
	/*
	 * 实际执行业务逻辑的函数
	 * @return array
	 */
	public function __execute(){
		//验证数据信息
		$data = $this->__verify();
		//通信异常
		$opt = Arch_Yaml::get('prize/soap', 'link', true);
		if(!(!empty($opt['url']) && @fopen($opt['url'],'r'))){
			return array('result' => 0);
		}
		//数据信息有误
		if(empty($data)){
			return array('result' => 1);
		}
		//获取会员基本信息
		$usersInfo = $this->sUser->getUserInfoById($data['uid']);
		//会员基本信息异常
		if(!(intval($usersInfo['relation_id'])>0) && intval($usersInfo['users_points'])>0){
			return array('result' => 2);
		}
		//获取会员积分账号信息
		$memberInfo = $this->sMember->getMemberInfoByRid($usersInfo['relation_id']);
		//会员基积分账号异常
		if(!(intval($memberInfo['member_id'])>0) && !empty($memberInfo['mobile'])){
			return array('result' => 3);
		}
		//获取会员地理位置 
		$locationInfo = $this->sLocation->getLocationByArea($memberInfo['zone_id'],$memberInfo['city_id'],$memberInfo['district_id']);
		//会员地理位置异常
		if(!(!empty($locationInfo['zone']) && !empty($locationInfo['city']) && !empty($locationInfo['disc']))){
		   	return array('result' => 4);
		}
		//获取奖品信息
		$prizeInfo = $this->sPrize->getPrizeInfoById($data['pid']);
		//获取投注记录总数
		$recordCount = $this->sPrize->getRecordCountByPid($data['pid']);
		//奖品信息异常
		if(!(intval($prizeInfo['id'])>0 && intval($recordCount)>=0 && 
		    intval($prizeInfo['prize_fact_num'])==intval($recordCount))){
			return array('result' => 5);
		}
		//判断会员积分是否充足
	   	if(intval($usersInfo['users_points']) < intval($prizeInfo['prize_draw_currency'])){
		   	return array('result' => 6);
	   	}
	   	//获取会员等级信息
		$noteInfo = $this->sUser->getUserNoteByMid($memberInfo['member_id']);
		//会员等级异常
		if(!(intval($noteInfo['id'])>0)){
			return array('result' => 7);
		}
	   	//格式化处理参数
   		$param = array(
   			'pid'		=> 	Blue_Filter::filterInt($data['pid']),
   			'uid'		=>	Blue_Filter::filterInt($data['uid']),
   			'mid'		=>  Blue_Filter::filterInt($memberInfo['member_id']),
   			'draw'		=> 	Blue_Filter::filterInt($prizeInfo['prize_draw_currency']),
   			'point'		=>  Blue_Filter::filterInt($usersInfo['users_points']),
   			'card'		=>  $memberInfo['id_card'],
   			'name'		=>  $memberInfo['name'],
   			'mobile'	=> 	$memberInfo['mobile'],
   			'zone'		=> 	$locationInfo['zone'],
   			'city'		=>  $locationInfo['city'],
   			'disc'		=>  $locationInfo['disc'],
   			'title'		=>  $prizeInfo['prize_short_title'],
   			'fact'		=>  Blue_Filter::filterInt($recordCount+1),
   			'pot18'		=>  Blue_Filter::filterInt($noteInfo['use_points_18'])
   		);
   		//更新抽奖信息启用事物支持
		try{
			Blue_Commit::call('Super_Draw', $param);
			$this->sSoap->updateLevel($param['mid'],3);
		}catch(Exception $e){
			//数据信息异常
			return array('result' => 8);
		}
		//再次获取奖品基本信息
   		$prizeInfoAgain = $this->sPrize->getPrizeInfoById($data['pid']);
		//奖品信息异常
		if(empty($prizeInfoAgain['prize_code'])){
			return array('result' => 5);
		}
   		//投注人数是否已满
		if(intval($prizeInfoAgain['prize_fact_num']) > intval($prizeInfoAgain['prize_min_num'])){
		   	return array('result' => 9);
   		}
		//最低人数满足实际人数则启动抽奖(倒计时)自动开奖
   		if(intval($prizeInfoAgain['prize_fact_num']) >= intval($prizeInfoAgain['prize_min_num']) &&
   		   intval($prizeInfoAgain['prize_auto'])==1 && intval($prizeInfoAgain['prize_start'])==1 &&
   		   intval($prizeInfoAgain['prize_fact_num']) > 0){
   			//获取奖品的最大期数
   		   	if(intval($prizeInfoAgain['prize_phase'])>0){
   		   		$pahse = intval($prizeInfoAgain['prize_phase']);
   		   	}else{
	   			$pahse = $this->sPrize->getPrizeMaxPhaseById($data['pid']);
	   			$pahse = $pahse+1;
   		   	}
   			//开始执行倒计时
   		   	try{
   		   		$param = array(
   		   			'pid'		=> intval($data['pid']),
   		   			'start'		=> intval(time()+$prizeInfoAgain['prize_wait_time']),
   		   			'pahse'		=> intval($pahse)
   		   		);
				Blue_Commit::call('Super_Down', $param);
			}catch(Exception $e){
				//启动失败 [需要手动添加回滚到初始状态,重新开始倒计时]
				Blue_Commit::call('Super_Back', $param);
			}
   		}
   		//投注成功
	   	return array('result' => 10,'factnum' => intval($prizeInfoAgain['prize_fact_num']));
	}
	
	/*
	 * 数据信息过滤
	 */
	private function __verify(){
		//参数信息判定
		if($this->getRequest()->isPost()){
			$data = array(
				'pid'	=> trim($_POST['pid']),
				'uid'	=> trim($_POST['uid'])
			);
			$rule = array(
				'pid' 	=> array('filterInt', array()),
				'uid' 	=> array('filterInt', array())
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
