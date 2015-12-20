<?php

/**
 * 超级大奖的flash页面
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 26 Aug 2015 06:14:43 PM CST
 */

class Action_Flash extends App_Action{
	
	private $loginInfo;
	private $sEncty;
	private $sPrize;
	
	public function __prepare(){
		$this->setView(Blue_Action::VIEW_SMARTY2);
		$this->loginInfo = $this->getLogined();
		$this->sEncty = new Service_Encty();	
		$this->sPrize = new Service_Prize();
	}
	
	public function __execute(){
		//接收参数信息
		$pid = $this->__verify();
		$uid = intval($this->loginInfo['user_info']['users_id']);
		//获取奖品基本信息
		$prizeInfo = $this->sPrize->getPrizeInfoById($pid);
		//奖品没有结束需要跳转到DETAIL中做验证
		if(intval($prizeInfo['prize_status'])==1){
			$id = $this->sEncty->encrypt($pid,true);
			$this->redirect('/prize/index/detail?id='.$id);	
		}
		//奖品已经结束并且通过FLASH验证则需要跳转到NOTICE中做验证
		if(intval($prizeInfo['prize_status'])==3 && intval($prizeInfo['prize_out'])>0){
			$id = $this->sEncty->encrypt($pid,true);
			$this->redirect('/prize/index/notice?pid='.$id);	
		}
		//获取抽奖数量
		$drwaCount = $this->sPrize->getPrizeUserDrawCountByPidAndUid($pid,$uid);
		//加载游戏规则
		$gameInfo = $this->sPrize->getPirzeGameRuleById(3);
		//获取中奖奖品信息
		$prizeList = $this->sPrize->getPrizeWinListByCondition(array('pid'=>$prizeInfo['id'],'pn'=>1,'rn'=>10));
		//读取中奖公告
		$noticeInfo = '';
		if($prizeList && count($prizeList)>0){
			foreach($prizeList as $prize){
				//查询中奖奖品信息
				$user_info = $this->sPrize->getUserInfoById($prize['prize_win_id']);
				//格式化手机号码
				if(!empty($user_info['prize_user_mobile']) && strlen($user_info['prize_user_mobile'])==11){
					$mobileFirst = substr($user_info['prize_user_mobile'], 0, 3); 
					$mobileLast = substr($user_info['prize_user_mobile'], 7, strlen($user_info['prize_user_mobile'])); 
					$mobileUser = $mobileFirst.'****'.$mobileLast;
					$noticeInfo .= '恭喜'.$mobileUser.'中得第'.$prize['prize_phase'].'期奖品'.$prize['prize_title'].' ; ';
				}
			}
		}
		//获取中奖会员信息
		$prizeWin = $this->sPrize->getPrizeWinUserByWid($prizeInfo['prize_win_id'],true);
		//获取抽奖会员信息
		$prizeDraw = $this->sPrize->getPrizeDrwUserByPid($pid,true);
		//格式化数据信息
		$prizeInfo['user_id'] = $uid;
		$prizeInfo['draw_count'] = $drwaCount;
		$prizeInfo['rule_content'] = $gameInfo['rule_content'];
		$prizeInfo['other_win'] = $noticeInfo;
		$prizeInfo['prize_win'] = $prizeWin;
		$prizeInfo['prize_draw'] = $prizeDraw;
		$prizeInfo['prize_id'] = $pid;
		$prizeInfo['prize_eid'] = $this->sEncty->encrypt($pid,true);
		return array(
			'item' => $prizeInfo
		);
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