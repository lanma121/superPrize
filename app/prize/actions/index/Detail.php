<?php

/**
 * 超级大奖的详细页面
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 26 Aug 2015 06:14:43 PM CST
 */

class Action_Detail extends App_Action{
	
	private $loginInfo;
	private $sEncty;
	private $sPrize;
	private $sAgent;
	private $sLocation;
	
	/*
	 * 业务的准备工作
	 * 初始化对象 变量等
	 */
	public function __prepare(){
		$this->setView(Blue_Action::VIEW_SMARTY2);
		$this->loginInfo = $this->getLogined();
		$this->sEncty = new Service_Encty();	
		$this->sPrize = new Service_Prize();
		$this->sAgent = new Service_Agent();
		$this->sLocation = new Service_Location();
	}
	
	/*
	 * 实际执行业务逻辑的函数
	 * @return array
	 */
	public function __execute(){
		//是否需要重新启动
		$reStart = false;
		//参数格式化
		$data = array(
			'id' 	=> $this->__verify()
		);
		//获取奖品详细信息
		$prizeInfo = $this->sPrize->prizeGetByCondition($data);
		//奖品已经结束但未通过FLASH验证则需要跳转到FLASH中做验证
		if(intval($prizeInfo['prize_status'])==3 && intval($prizeInfo['prize_out'])<=0){
			$pid = $this->sEncty->encrypt($data['id'],true);
			$this->redirect('/prize/index/flash?pid='.$pid);	
		}
		//最低人数满足实际人数则启动抽奖(倒计时)自动开奖[系统异常自动处理]
		if(intval($prizeInfo['prize_fact_num']) >= intval($prizeInfo['prize_min_num']) && 
		   (intval($prizeInfo['prize_auto'])==1 || (intval($prizeInfo['prize_auto'])==2 && 
		    intval($prizeInfo['prize_start'])==2)) && intval($prizeInfo['prize_fact_num'])>0){
			//最后一次投注异常
   		   	if(intval($prizeInfo['prize_start_time'])<=0){
   		   		$reStart = true;
   		   	}
   		   	//倒计时中突然关闭浏览器[倒计时未结束]
			if(intval($prizeInfo['prize_start_time'])>0 && 
			   intval($prizeInfo['prize_end_time'])<=0 &&
			   intval($prizeInfo['prize_status'])!=3 && 
			   intval($prizeInfo['prize_start_time'])<time()){
				$reStart = true;
			}
   		}
   		//重新启动倒计时开奖
   		if($reStart){
   			if(intval($prizeInfo['prize_phase'])>0){
   				$pahse = intval($prizeInfo['prize_phase']);
   			}else{
	   			$pahse = $this->sPrize->getPrizeMaxPhaseById($data['id']);
	   			$pahse = $pahse+1;
   			}
   			//参数格式化
   		   	$param = array(
   		   		'pid'		=> $data['id'],
   		   		'start'		=> intval(time()+$prizeInfo['prize_wait_time']),
   		   		'pahse'		=> intval($pahse)
   		   	);
   		   	//自动开奖异常处理
   		   	if(intval($prizeInfo['prize_auto'])==1 && intval($prizeInfo['prize_start'])==1){
   		   		$param['auto'] = 1;
   		   	}
   		   	//手动开奖异常处理
   		   	if(intval($prizeInfo['prize_auto'])==2 && intval($prizeInfo['prize_start'])==2){
   		   		$param['auto'] = 2;
   		   	}
			//异常处理
   		   	try{
   		   		//回滚到初始状态,重新开始倒计时]
				Blue_Commit::call('Super_Back', $param);
				//开始执行倒计时
				Blue_Commit::call('Super_Down', $param);
			}catch(Exception $e){
				//启动失败 [需要手动添加回滚到初始状态,重新开始倒计时]
				Blue_Commit::call('Super_Back', $param);
			}
			$prizeInfo['start_again'] = 1;
   		}
		//根据店铺抽奖限制条件
		if($prizeInfo && !empty($prizeInfo['prize_agents']) && $prizeInfo['prize_agents']!=0){
			//获取相关店铺信息
			$agentList = $this->sAgent->listAgentByIds($prizeInfo['prize_agents']);
			$agentName = '';
			if($agentList && count($agentList)>0){
				foreach($agentList as $agent){
					$agentName .= $agent['agent_name'].',';
				}
			}
			if(!empty($agentName)){
				$agentName = substr($agentName,0,strlen($agentName)-1);
				//$agentName = mb_substr($agentName,0,20,'utf-8').'......';
				$prizeInfo['limit_info'] = '本奖品仅限'.$agentName.'的消费会员参与';
			}
		}
		//根据地区抽奖限制条件
		else if($prizeInfo && !empty($prizeInfo['prize_locats']) && intval($prizeInfo['prize_locats'])>0){
			if(intval($prizeInfo['prize_zone'])>0){
				$zoneInfo = $this->sLocation->listByCondition(array('id'=>intval($prizeInfo['prize_zone'])));
			}
			if(intval($prizeInfo['prize_city'])>0){
				$cityInfo = $this->sLocation->listByCondition(array('id'=>intval($prizeInfo['prize_city'])));
			}
			if(intval($prizeInfo['prize_disc'])>0){
				$discInfo = $this->sLocation->listByCondition(array('id'=>intval($prizeInfo['prize_disc'])));
			}
			$prizeInfo['limit_info'] = '本奖品仅限'.$zoneInfo['title'].''.$cityInfo['title'].''.$discInfo['title'].'的消费会员参与';
		}
		//默认判定
		else{
			$prizeInfo['limit_info'] = '本奖品由'.$prizeInfo['prize_company'].'冠名支持';
		}
		//获取中奖公告信息
		$noticeMsg = '';
		//获取中奖奖品信息
		$recordList = $this->sPrize->getRecordListByStuAndPub(-1,0,1,10);
		if($recordList && count($recordList)>0){
			foreach($recordList as $record){
				//获取奖品信息
				$prizeDetail = $this->sPrize->getPrizeInfoByCondition(array('pid'=>$record['prize_id']));
				//格式化手机号码
				if(!empty($record['prize_user_mobile']) && strlen($record['prize_user_mobile'])==11){
					$userMobile = substr($record['prize_user_mobile'],0,3)."****".substr($record['prize_user_mobile'],7,4);
					$user['user_mobile'] = $userMobile;
					$noticeMsg .= '恭喜'.$userMobile.'中得第'.$prizeDetail['prize_phase'].'期奖品'.$prizeDetail['prize_title'].' ; ';
				}
			}
		}
		//加载中奖人员信息
		$prizeWin  = $this->sPrize->getUserInfoById($prizeInfo['prize_win_id']);
		$mobileF = substr($prizeWin['prize_user_mobile'], 0, 3); 
		$mobileE = substr($prizeWin['prize_user_mobile'], 7, strlen($prizeWin['prize_user_mobile'])); 
		$mobileU = $mobileF.'****'.$mobileE;
		$prizeInfo['prize_winmsg'] = '恭喜'.$mobileU.'中得第'.$prizeInfo['prize_phase'].'期奖品'.$prizeInfo['prize_title'];
		$prizeInfo['notice_info'] = $noticeMsg;
		$prizeInfo['curret_time'] = time();
		$prizeInfo['cstart_time'] = date('Y-m-d H:i:s',$prizeInfo['prize_start_time']);
		$prizeInfo['uid'] = $this->loginInfo['user_info']['users_id'];
		$prizeInfo['rid'] = $this->loginInfo['user_info']['relation_id'];
		$prizeInfo['mid'] = $this->loginInfo['user_info']['member_id'];
		$prizeInfo['pid'] = $this->sEncty->encrypt($data['id'],true);
		$prizeInfo['url'] = 'http://www.xabaili.com/includes/phpqrcode.php?url='.urlencode('http://m.xabaili.com/prize/index.php?pid='.$data['id'].'&size=8');
		//返回并输出结果信息
		return array(
			'id'	=> intval(trim($_GET['id'])),
			'item' 	=> $prizeInfo
		);
	}
	
	/*
	 * 数据信息过滤
	 */
	private function __verify(){
		//参数信息判定
		if($this->getRequest()->isGet() && !empty($_GET['id'])){
			$id = $this->sEncty->decrypt($_GET['id'],true);
			if(is_int(intval($id)) && intval($id)>0){
				return intval($id);
			}else{
				$this->redirect('/prize/index/index');	
			}
		}else{
			$this->redirect('/prize/index/index');
		}
	}
	
}