<?php
/**
 * 超级大奖的通知页面
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 26 Aug 2015 06:14:43 PM CST
 */

class Action_Notice extends App_Action{
	
	private $sPrize;	
	private $sLocation;
	private $sAgent;
	private $sMember;
	private $sEncty;
	
	public function __prepare(){
		$this->setView(Blue_Action::VIEW_SMARTY2);
		$this->sPrize = new Service_Prize();
		$this->sLocation = new Service_Location();
		$this->sAgent = new Service_Agent();
		$this->sMember = new Service_Member();
		$this->sEncty = new Service_Encty();
	}
	
	public function __execute(){
		$pid = $this->__verify();
		//获取奖品基本信息
		$prizeInfo = $this->sPrize->getPrizeInfoById($pid);
		//奖品没有结束需要跳转到DETAIL中做验证
		if(intval($prizeInfo['prize_status'])==1){
			$id = $this->sEncty->encrypt($pid,true);
			$this->redirect('/prize/index/detail?id='.$id);	
		}
		//奖品已经结束但未通过FLASH验证则需要跳转到FLASH中做验证
		if(intval($prizeInfo['prize_status'])==3 && intval($prizeInfo['prize_out'])<=0){
			$id = $this->sEncty->encrypt($pid,true);
			$this->redirect('/prize/index/flash?pid='.$id);	
		}
		//格式化奖冠名支持
		$prizeInfo['prize_fcompany'] = mb_substr($prizeInfo['prize_company'],0,6,'utf-8').'......';
		//获取中奖奖品信息
		$pwineInfo = $this->sPrize->getUserInfoById($prizeInfo['prize_win_id']);
		//格式化用户名
		if($pwineInfo['prize_user_name']==$pwineInfo['prize_user_mobile']){
			$pwineInfo['prize_user_name'] = '匿名';
		}
		//格式化手机号码
		if(!empty($pwineInfo['prize_user_mobile']) && strlen($pwineInfo['prize_user_mobile'])==11){
			$mobileF = substr($pwineInfo['prize_user_mobile'], 0, 3); 
			$mobileL = substr($pwineInfo['prize_user_mobile'], 7, strlen($pwineInfo['prize_user_mobile'])); 
			$pwineInfo['prize_user_mobile'] = $mobileF.'****'.$mobileL;
		}
		return array('item' => array_merge($prizeInfo,$pwineInfo));
	}
	
	/*
	 * 数据信息过滤
	 */
	private function __verify(){
		//参数信息判定
		if($this->getRequest()->isGet() && !empty($_GET['pid'])){
			$pid = $this->sEncty->decrypt($_GET['pid'],true);
			if(is_int(intval($pid)) && intval($pid)>0){
				return intval($pid);
			}else{
				$this->redirect('/prize/index/index');	
			}
		}else{
			$this->redirect('/prize/index/index');
		}
	}
}