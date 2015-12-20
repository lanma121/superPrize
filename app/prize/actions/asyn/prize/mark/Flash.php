<?php

/**
 * 启动超级大奖Flash
 * @author 1399871902 <@qq.com>
 * @copyright 2015~ (c) @qq.com
 * @Time: Mon 07 Sep 2015 04:18:30 PM CST
 */

class Action_MarkFlash extends App_Action{
	
	private $aEmial;
	private $sPrize;
	private $sAgent;
	
	/*
	 * 业务的准备工作
	 * 初始化对象 变量等
	 */
	public function __prepare(){
		$this->setView(App_Action::VIEW_JSON);
		$this->aEmial = new App_Email_Email();
		$this->sPrize = new Service_Prize();
		$this->sAgent = new Service_Agent();
	}
	
	/*
	 * 实际执行业务逻辑的函数
	 * @return array
	 */
	public function __execute(){
		//验证数据信息
		$data = $this->__verify();
		//数据信息有误
		if(intval($data['pid'])>0){
			//获取超级大奖信息
			$prizeInfo = $this->sPrize->getPrizeInfoById($data['pid']);
			$usersInfo = $this->sPrize->getUserInfoById($prizeInfo['prize_win_id']);
			$endTime = intval($prizeInfo['prize_start_time']+$prizeInfo['prize_wait_time']+$prizeInfo['prize_buffer_time']);
			try{
				//启动倒计时
				$param = array(
					'pid'		=> $data['pid']
				);
				Blue_Commit::call('Super_Mark', $param);
				//消息信息
				$string = '';
				if($prizeInfo && !empty($prizeInfo['prize_code'])){
					switch(intval($prizeInfo['prize_status'])){
						case 0:
							$prizeStatus = '待开放';
						break;
						case 1:
							$prizeStatus = '进行中';
						break;
						case 3:
							$prizeStatus = '已结束';
						break;
						case 4:
							$prizeStatus = '已隐藏';
						break;
						default:
							$prize_status = '未知态';
						break;	
					}
					switch(intval($prizeInfo['prize_auto'])){
						case 1:
							$prizeAuto = '自动';
						break;
						case 2:
							$prizeAuto = '手动';
						break;
					}
					$string .= '<div style="margin-left:auto;margin-right:auto;font-size:12px;color:green;">';
					$string .= '<p>===来自'.$usersInfo['prize_user_ip'].'的中奖信息===</p>';
					$string .= '<p><img src="'.$prizeInfo['prize_picture'].'" width="225px" height="225px"/></p>';
					$string .= '<p>===奖品编号:'.$prizeInfo['prize_code'].'===</p>';
					$string .= '<p>===奖品名称:'.$prizeInfo['prize_title'].'===</p>';
					$string .= '<p>===奖品期数:'.$prizeInfo['prize_phase'].'===</p>';
					$string .= '<p>===奖品价格:'.$prizeInfo['prize_price'].'===</p>';
					$string .= '<p>===奖品积分:'.$prizeInfo['prize_currency'].'===</p>';
					$string .= '<p>===投注积分:'.$prizeInfo['prize_draw_currency'].'===</p>';
					$string .= '<p>===启动人数:'.$prizeInfo['prize_min_num'].'===</p>';
					$string .= '<p>===实际人数:'.$prizeInfo['prize_fact_num'].'===</p>';
					$string .= '<p>===奖品状态:'.$prizeStatus.'===</p>';
					$string .= '<p>===开奖模式:'.$prizeAuto.'===</p>';
					if($prizeInfo['prize_agents']!=0 && !empty($prizeInfo['prize_agents'])){
						$pid = $this->sAgent->getPidByAid($prizeInfo['prize_agents']);
						$agentName = $this->sAgent->getNameByPid($pid);
						$storeName = $this->sAgent->getAgentNamesByAids($prizeInfo['prize_agents']);
						$string .= '<p>===冠名店铺:'.$storeName.'===</p>';
						$string .= '<p>===启动商家:'.$agentName.'===</p>';
						
					}else if($prizeInfo['prize_aid']>=0 && !empty($prizeInfo['prize_aid'])){
						$agentName = $this->sAgent->getNameByPid($prizeInfo['prize_aid']);
						$string .= '<p>===启动商家:'.$agentName+'===</p>';
					}else{
						$string .= '<p>===冠名企业:百利自营===</p>';
					}
					$string .= '<p>===新增日期:'.date('Y-m-d H:i:s',$prizeInfo['prize_add_date']).'===</p>';
					$string .= '<p>===编辑日期:'.date('Y-m-d H:i:s',$prizeInfo['prize_mod_date']).'===</p>';
					$string .= '<p>===启动日期:'.date('Y-m-d H:i:s',$prizeInfo['prize_start_time']).'===</p>';
					$string .= '<p>===结束日期:'.date('Y-m-d H:i:s',$endTime).'===</p>';
					if($usersInfo['prize_user_name']!=$usersInfo['prize_user_mobile']){
						$string .= '<p>===中奖会员:'.$usersInfo['prize_user_name'].'===</p>';
					}
					$string .= '<p>===中奖电话:'.$usersInfo['prize_user_mobile'].'===</p>';
					if($usersInfo['prize_user_card']!='' && $usersInfo['prize_user_card']!=null && 
			  			(strlen($usersInfo['prize_user_card'])==15 || 
			  			strlen($usersInfo['prize_user_card'])==18)){
			  			$string .= '<p>===中奖身份:'.$usersInfo['prize_user_card'].'===</p>';	
			  		}
			  		$string .= '<p>===中奖省份:'.$usersInfo['prize_user_province'].'===</p>';	
			  		$string .= '<p>===中奖城市:'.$usersInfo['prize_user_city'].'===</p>';	
			  		$string .= '<p>===中奖区县:'.$usersInfo['prize_user_district'].'===</p>';	
			  		$string .= '<p>===来自:'.$_SERVER['SERVER_ADDR'].'的系统信息===</p>';
			  		$string .= '<p>===系统服务:'.$_SERVER['SERVER_SOFTWARE'].'===</p>';
			  		$string .= '<br/>';
					$string .= '</div>';
					$string .= "\t\n";
				}
				//发送邮件
				if(!empty($string)){
					$this->aEmial->sendEmail('超级大奖电子邮件!', $string);
				}
			}catch(Exception $e){
				//操作失败
				$this->aEmial->sendEmail('超级大奖电子邮件!', $prizeInfo['prize_code'].'标记失败!');
				return array('result' => 0);
			}
			return array('result' => 1);
		}
		return array('result' => 2);
	}
	
	/*
	 * 数据信息过滤
	 */
	private function __verify(){
		//参数信息判定
		if($this->getRequest()->isPost()){
			$data = array(
				'pid'	=> trim($_POST['pid'])
			);
			$rule = array(
				'pid' 	=> array('filterInt', array())
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