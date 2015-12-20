<?php

/**
 * 超级大奖的奖品服务层
 * 
 * @author zhurongqiang<@qq.com>
 * @copyright 2015~ (c) @qq.com
 * @Time: Wed 26 Aug 2015 09:56:43 PM CST
 */

class Service_Prize{
	
	//奖品信息对象
	private $dPrize;
	//奖品分类对象
	private $dGroup;
	//奖品关系对象
	private $dRelation;
	//奖品抽奖对象
	private $dUser;
	
	private $dRule;
	
	private $dRecord;
	
	private $dLevel;
	
	private $dNote;
	
	/*
	 * 服务信息初始化
	 */
	public function __construct(){
		$this->dPrize = new Dao_Super_Prize();
		$this->dGroup = new Dao_Super_Prize_Group();
		$this->dRelation = new Dao_Super_Prize_Group_Relation();
		$this->dUser = new Dao_Super_Prize_User();
		$this->dRule = new Dao_Super_Prize_Game_Rule();
		$this->dRecord =  new Dao_User_Level_Record();
		$this->dLevel = new Dao_Level();
		$this->dPrecord = new Dao_Super_Prize_Record();
		$this->dNote = new Dao_User_Note();
	}

	public function gets($ids){
		$ret = $this->dPrize->gets($ids);
		$ret = Blue_Array::changeIndex($ret, 'id');
		return $ret;
	}
	
	/*
	 * 奖品详细,特殊情况
	 * 根据数组条件动态获取列表信息
	 * @param $pid 奖品ID
	 * @return array
	 */
	public function getPrizeInfoByCondition($cond){
		return $this->dPrize->getInfoByCondition($cond);
	}
	
	/*
	 * 奖品列表,特殊情况
	 * 根据数组条件动态获取列表信息
	 * @param $cond 收集动态条件
	 * @return array
	 */
	public function getPrizeListByCondition1($cond){
		return $this->dPrize->getListByCondition1($cond);
	}
	
	/*
	 * 奖品列表,特殊情况
	 * 根据数组条件动态获取列表信息
	 * @param $cond 收集动态条件
	 * @return array
	 */
	public function getPrizeListByCondition($cond){
		return $this->dPrize->getListByCondition($cond);
	}
	
	/*
	 * 获取中奖列表信息
	 * @param $cond
	 */
	public function getPrizeWinListByCondition($cond){
		return $this->dPrize->getWinListByCondition($cond);
	}
	
	/*
	 * 奖品分页,特殊情况
	 * 根据数组条件动态获取列表信息
	 * @param $cond 收集动态条件
	 */
	public function getPrizeCountByCondition($cond){
		return $this->dPrize->getCountByCondition($cond);
	}
	
	/*
	 * 获取奖品详细信息
	 * @param $condtions 奖品参数集合
	 * @return array
	 */
	public function prizeGetByCondition($condtions){
		return $this->dPrize->getByCondition($condtions);
	}
	
	/*
	 * 获取超级大奖各项总记录数
	 * @param $condtions 奖品参数集合
	 * @return int
	 */
	public function getPrizeTotalByCondition($condtions){
		return $this->dPrize->getTotalByCondition($condtions);
	}
	
	/*
	 * 获取奖品分类ID查询奖品ID集合
	 * @param $gid 查询条件集合
	 */
	public function prizePidByGid($gid){
		return $this->dRelation->loadPidByGid($gid);
	}
	
	/*
	 * 获取奖品分类信息
	 * @return array
	 */
	public function prizeRelationList(){
		return $this->dRelation->relationList();
	}
	
	/*
	 * 根据GID获取奖品PID集合
	 * @param $gid 奖品分类ID
	 * @return array
	 */
	public function prizeRelationPidByGid($gid){
		$string = '';
		$list = $this->dRelation->relationPidByGid($gid);
		if($list && count($list)>0){
			foreach($list as $item){
				$string .= $item['prize_rel_prize_id'].',';
			}
		}
		if(!empty($string)){
			$string = substr($string,0,strlen($string)-1);
		}
		return $string;
	}
	
	/*
	 * 根据ID获取奖品分类信息
	 * @param $id 奖品分类ID
	 * @param $key 奖品分类表字段
	 * @return array
	 */
	public function prizeGroupById($id,$key){
		return $this->dGroup->getGroupById($id,$key);
	}
	
	/*
	 * 根据条件获取抽奖会员单条纪录信息
	 * @param $id 抽奖会员纪录ID
	 * @return array
	 */
	public function getUserInfoById($id){
		$cond = array('id'=> $id);
		return $this->dUser->getInfoByCondition($cond);
	}
	
	/*
	 * 根据奖品ID检查奖品状态
	 * @param $id 超级大奖奖品ID
	 * @return boolean
	 */
	public function checkStatusById($id){
		$result = false;
		$object = $this->dPrize->loadStatusById($id);
		if($object['prize_status']!='' && intval($object['prize_status'])!=4 && 
		   intval($object['prize_status'])>=0){
			$result = true;
		}
		return $result;
	}
	
	/* 
	 * 获取超级大奖奖品状态和启动状态
	 * @param $id 超级大奖ID
	 */
	public function getPrizeStatusAndStartById($id){
		$cond = array(
			'id'		=> $id,
			'field'		=> 'prize_status,prize_start,prize_fact_num,prize_min_num'
		);
		return $this->dPrize->getByCondition($cond);
	}
	
	/*
	 * 根据动态条件获取抽奖会员集合
	 * @param $cond 动态查询条件集合
	 */
	public function prizeUserByCondition($cond){
		return $this->dUser->loadByCondition($cond);
	}
	
	/*
	 * 根据prize_id获取当前抽奖会员中奖ID
	 * @param $pid 奖品Id
	 * @return int
	 */
	public function getPrizeUserWidByPid($pid){
		$winId = 0;
		$cond = array(
			'pid'		=> $pid,
			'field'		=> 'id'
		);
		$list = $this->dUser->loadByCondition($cond);
		if($list && count($list)>0){
			foreach($list as $item){
				$array[] = $item['id'];
			}
		}
		if(count($array)>0){
			$index = mt_rand(0, count($array)-1);
			$winId = $array[$index];
		}
		return intval($winId);
	}
	
	/*
	 * 根据id查询奖品信息 
	 * @param $id 指定的奖品id
	 * @return array
	 */
	public function getPrizeInfoById($id){
		$cond = array(
			'id'		=> $id,
			'field'		=> 'prize_draw_currency,prize_auth,prize_agents,
							prize_locats,prize_status,prize_title,prize_zone,
							prize_city,prize_disc,prize_min_num,prize_code,
							prize_show,prize_short_title,prize_fact_num,
							prize_auto,prize_start,prize_win_id,prize_wait_time,
							prize_start_time,prize_buffer_time,prize_phase,
							prize_company,prize_explain,prize_picture,prize_ernie,
							prize_roll_speed,prize_down_time,id,prize_price,prize_out,
							prize_currency,prize_add_date,prize_mod_date,prize_end_time,
							prize_phase'
		);
		return $this->dPrize->getByCondition($cond);
	}
	
	/*
	 * 查询奖品的最大期数
	 * @return int
	 */
	public function getPrizeMaxPhaseById(){
		$info = $this->dPrize->loadMaxPhase();
		return intval($info['max_phase']);
	}
	
	/*
	 * 根据奖品id和会员id获取投注次数 
	 * @param $pid
	 * @param $uid
	 * @return int
	 */
	public function getPrizeUserDrawCountByPidAndUid($pid,$uid){
		$info = $this->dUser->loadDrawCountByPidAndUid($pid,$uid);
		return intval($info['total']);
	}
	
	public function getPirzeGameRuleById($id){
		return $this->dRule->getRuleById($id);
	}
	
	/*
	 * 根据wid获取中奖人员信息[格式化处理]
	 * @param $wid 中奖人ID
	 * @param $off 是否支持格式化
	 */
	public function getPrizeWinUserByWid($wid,$off){
		$opt  = 'id,prize_user_name,prize_user_mobile,prize_user_province,';
		$opt .= 'prize_user_city,prize_user_district'; 
		$info = $this->dUser->getUserById($wid,$opt);
		if($off && $info){
			if(!empty($info['prize_user_mobile']) && strlen($info['prize_user_mobile'])==11){
				$mobile_first = substr($info['prize_user_mobile'], 0, 3); 
				$mobile_last = substr($info['prize_user_mobile'], 7, strlen($info['prize_user_mobile'])); 
				$mobile_user = $mobile_first.'****'.$mobile_last;
			}
			$string  = $info['prize_user_province'].' '.$info['prize_user_city'].' ';
			$string .= $info['prize_user_district'].' '.$info['prize_user_name'].' ';
			$string .= $mobile_user.' '.$info['id'];
			return $string;
		}else{
			return $info;
		}
	}
	
	/*
	 * 获取抽奖会员信息 
	 * @param $pid 奖品ID
	 * @param $off 是否支持格式化
	 */
	public function getPrizeDrwUserByPid($pid,$off){
		$cond = array(
			'pid'	=> $pid,
			'pn'	=> 1,
			'rn'	=> 500,
			'field'	=> 'id,prize_user_name,prize_user_mobile,prize_user_province,
						prize_user_city,prize_user_district'
		);
		$list = $this->dUser->loadByCondition($cond);
		if($off && $list && count($list)>0){
			$string = '';
			foreach($list as $item){
				if(!empty($item['prize_user_mobile']) && strlen($item['prize_user_mobile'])==11){
					$mobile_first = substr($item['prize_user_mobile'], 0, 3); 
					$mobile_last = substr($item['prize_user_mobile'], 7, strlen($item['prize_user_mobile'])); 
					$mobile_user = $mobile_first.'****'.$mobile_last;
				}
				$string .= $item['prize_user_province'].' '.$item['prize_user_city'].' ';
				$string .= $item['prize_user_district'].' '.$item['prize_user_name'].' ';
				$string .= $mobile_user.' '.$item['id'].',';
			}
			if(!empty($string)){
				$string = substr($string,0,strlen($string)-1);
			}
			return $string;
		}else{
			return $list;
		}
	}
	
	/*
	 * 根据id查询检查是否已经flash
	 * @param $id 指定的奖品id
	 * @return int
	 */
	public function getPrizeOutById($id){
		$cond = array(
			'id'		=> $id,
			'field'		=> 'prize_out'
		);
		$info = $this->dPrize->getByCondition($cond);
		return intval($info['prize_out']);
	}
	
	/*
	 * 根据抽奖记录状态和消息状态获取多条记录信息
	 * @param $stu 抽奖记录状态
	 * @param $uid 抽奖消息状态
	 * @param $pn 当前页数
	 * @param $rn 每页记录
	 */
	public function getRecordListByStuAndPub($stu,$pub,$pn,$rn){
		$cond = array('stu'=>$stu,'pub'=>$pub,'pn'=>$pn,'rn'=>$rn);
		return $this->dUser->getListByCondition($cond);
	}
	
	/*
	 * 获取单条记录信息
	 * @param $pid
	 * @param $uid
	 * @return array
	 */
	public function getRecordInfoById($id){
		$cond = array('id'=>$id);
		return $this->dUser->getInfoByCondition($cond);
	}
	
	/*
	 * 获取最后一条投注记录
	 * @param $uid
	 * @return array
	 */
	public function getRecordInfoLastByPid($pid){
		$cond = array('pid'=>$pid);
		return $this->dUser->getInfoByCondition($cond);
	}	
	
	/*
	 * 统计奖品抽奖记录信息
	 * @param $pid 超级大奖ID
	 * @return int
	 */
	public function getRecordCountByPid($pid){
		$cond = array('pid'=>$pid);
		return $this->dUser->getCountByCondition($cond);
	}
	
	/*
	 * 获取会员等级记录TYPE_ID集合
	 * @param $mid 会员积分账号ID
	 * @return string
	 */
	public function getRecordLidsByMid($mid){
		$string = '';
		$cond = array('mid'=>$mid);
		$list = $this->dRecord->getListByCondition($cond);
		if($list && count($list)>0){
			foreach($list as $item){
				$string .= $item['level_id'].',';
			}
		}
		if(!empty($string)){
			$string = substr($string,0,strlen($string)-1);
		}
		return $string;
	}
	
	/*
	 * 获取会员成就点多条信息
	 * @param $pid 超级大奖ID
	 * @return array
	 */
	public function getLevelListByLidAndTid($lid,$tid){
		$cond = array('lid'=>$lid,'tid'=>$tid);
		return $this->dLevel->getListByCondition($cond);
	}
	
	/*
	 * 根据条件获取会员投注积分总和
	 * @param $cond 动态查询条件
	 * @return int
	 */
	public function getRecordSumByUid($uid){
		$cond = array('uid'=>$uid);
		$info = $this->dUser->getSumByCondition($cond);
		return intval($info['total']);
	}
	
	/*
	 * 获取奖品状态
	 * @return array
	 */
	public function getPrizeStatusInfo(){
		$array = array();
		$list = $this->dPrize->getStatusInfo();
		if($list && count($list)>0){
			foreach($list as $item){
				switch(intval($item['prize_status'])){
					case 0:
						$array['wait_count'] = $item['total'];
					break;
					case 1:
						$array['open_count'] = $item['total'];
					break;
					case 3:
						$array['end_count'] = $item['total'];
					break;
				}
			}
		}
		return $array;
	}
	
	/*
	 * 获取奖品推荐
	 * @return array
	 */
	public function getPrizeFlagInfo(){
		$array = array();
		$list = $this->dPrize->getFlagInfo();
		if($list && count($list)>0){
			foreach($list as $item){
				switch(intval($item['prize_flag'])){
					case 0:
						$array['is_count'] = $item['total'];
					break;
					case 1:
						$array['no_count'] = $item['total'];
					break;
				}
			}
		}
		return $array;
	}
	
	/*
	 * 获取奖品分类
	 * @return array
	 */
	public function getPrizeGroupInfo(){
		return $this->dPrize->getGroupInfo();
	}
	
	/*
	 * 获取中奖会员的最大排序号
	 * @param $off 是否自动加1 true:是;false:否
	 * @return int
	 */
	public function getPrizeUserMaxOrder($off=false){
		$info = $this->dUser->getMaxOrder();
		$maxOrder = ($info['max_order']>0)?intval($info['max_order']):0;
		if($off){
			$maxOrder += 1;
		}
		return $maxOrder;
	}
}
