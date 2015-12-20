<?php

/**
 * 超级大奖的首页
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 26 Aug 2015 06:14:43 PM CST
 */

class Action_Index extends App_Action{
	
	private $sPrize;	
	private $sLocation;
	private $sAgent;
	private $sMember;
	private $sEncty;
	
	/**
	 * 业务的准备工作
	 *
	 * 初始化对象 变量等
	 */
	public function __prepare(){
		$this->setView(Blue_Action::VIEW_SMARTY2);
		$this->sPrize = new Service_Prize();
		$this->sLocation = new Service_Location();
		$this->sAgent = new Service_Agent();
		$this->sMember = new Service_Member();
		$this->sEncty = new Service_Encty();
	}

	/**
	 * 实际执行业务逻辑的函数
	 *
	 * @return array
	 */
	public function __execute(){
		//返回集合数组
		$array = array();
		//参数信息过滤
		$data = $this->__verify();
		//获取超级大奖主要信息
		$main_array = $this->loadPrizeMain($data,$data['pn'],$data['rn']);
		//获取超级大奖附加信息
		$attr_array = $this->loadPrizeAttr($data);
		//获取中奖公告信息
		$note_array = $this->loadPrizeNote($data);
		//合并集合集合结果
		$array = array_merge($data,$main_array,$attr_array,$note_array);
		//合并并输出信息
		return $array;
	}
	
	/*
	 * 数据信息过滤
	 */
	private function __verify(){
		//参数信息判定
		if($this->getRequest()->isGet() || $this->getRequest()->isPost()){
			$data = array(
				'sea' 			=> trim($_POST['keyword']), 
				'stu' 			=> isset($_GET['stu'])?trim($_GET['stu']):-1,
				'gid' 			=> isset($_GET['gid'])?trim($_GET['gid']):-1,
				'lev' 			=> isset($_GET['lev'])?trim($_GET['lev']):-1,
				'flg' 			=> isset($_GET['flg'])?trim($_GET['flg']):-1, 
				'zid'	 		=> trim($_GET['zid']),
				'cid' 			=> trim($_GET['cid']), 
				'did' 			=> trim($_GET['did']),
				'pn'			=> isset($_GET['pn'])?trim($_GET['pn']):1,
				'rn'			=> isset($_GET['rn'])?trim($_GET['rn']):10
			);
			$rule = array(
				'sea' 			=> array('filterStrlen', array(0, 30), '', true),
				'stu' 			=> array('filterInt', array()),
				'gid' 			=> array('filterInt', array()),
				'lev' 			=> array('filterInt', array()),
				'flg' 			=> array('filterInt', array()),
				'zid' 			=> array('filterInt', array()),
				'cid' 			=> array('filterInt', array()),
				'did' 			=> array('filterInt', array()),
				'pn' 			=> array('filterInt', array()),
				'rn' 			=> array('filterInt', array()),
			);
			return Blue_Filter::filterArray($data, $rule);
		}
	}
	
	/*
	 * 加载奖品主要信息
	 * @param $data
	 */
	private function loadPrizeMain($data){
		//按店铺限制搜索奖品
		if($data['lev']==0){
			if($data['zid']>0 && $data['cid']==0 && $data['did']==0){
				$disc = $this->sLocation->loadDiscByCondition(array('zone'=>$data['zid'],'type'=>4));
			}if($data['zid']>0 && $data['cid']>0 && $data['did']==0){
				$disc = $this->sLocation->loadDiscByCondition(array('zone'=>$data['zid'],'city'=>$data['cid'],'type'=>3));
			}if($data['zid']>0 && $data['cid']>0 && $data['did']>0){
				$disc = $data['did'];
			}
			//验证渠道商ID集合
			if(!empty($disc)){
				$aids = $this->sAgent->loadAidByDisc($disc);
			}
			//获取渠道商ID集合
			if(!empty($aids)){
				$data['sid'] = $aids;
			}else{
				if($data['zid']>0){
					$data['sid'] = -1;
				}
			}
		}
		//按自营店搜索
		if($data['lev']==2){
			$data['ord'] = 'prize_level desc,prize_order desc,prize_code desc,prize_mod_date desc';
		}else{
			$data['ord'] = 'prize_order desc,prize_code desc,prize_mod_date desc';
		}
		//获取奖品列表
		$prizeObject = $this->sPrize->getPrizeListByCondition1($data);
		//获取奖品数量
		$prizeCount = $this->sPrize->getPrizeCountByCondition($data);
		//保存处理结果
		$prizeList = array();
		//列表格式化处理
		foreach($prizeObject as $prize){
			//处理奖品标题
			if(empty($prize['prize_title'])){
				$prize['prize_title'] = $prize['prize_short_title'];
			}
			//处理会员昵称
			if(!empty($prize['user_name']) && trim($prize['user_name'])!='匿名' && 
			   trim($prize['user_name'])==trim($prize['user_mobile'])){
			    $prize['user_name'] = '匿名';
			}else{
				$prize['user_name'] = mb_substr($prize['user_name'],0,1,'utf-8').'**';
			}
			//获取手机号码并处理
			if(!empty($prize['user_mobile']) && strlen($prize['user_mobile'])==11){
				$mobile = substr($prize['user_mobile'],0,3)."****".substr($prize['user_mobile'],7,4);
				$prize['prize_win_mobile'] = $mobile;
			}
			//限制会员抽奖/处理消息信息
			switch(intval($prize['prize_level'])){
				//按店铺
				case 0:
					$prizeShows = mb_substr($prize['agent_name'],0,20,'utf-8').'......';
					$prizeMssge = '本奖品仅限';
					$prizeSport = '的消费会员参与';
				break;
				//按地区
				case 1:
					$prizeShows = $prize['prize_zone'].$prize['prize_city'].$prize['prize_disc'];
					$prizeMssge = '本奖品仅限';
					$prizeSport = '的消费会员参与';
				break;
				//不限制
				case 2:
					$prizeShows = $prize['prize_company'];
					$prizeMssge = '本奖品由';
					$prizeSport = '冠名支持';
				break;	
			}
			//格式化数据信息
			$prize['prize_shows_text'] = $prizeShows;
			$prize['prize_mssge_text'] = $prizeMssge;
			$prize['prize_sport_text'] = $prizeSport;
			$prize['prize_eid'] = $this->sEncty->encrypt($prize['id'],true);
			$prizeList[] = $prize;
		}
		return array(
			'position'		=> '奖品列表',
			'prize_list' 	=> $prizeList,
			'prize_page' 	=> Blue_Page::pageInfo($prizeCount,$data['pn'],$data['rn'],10)
		);
	}
	
	/*
	 * 加载奖品附加信息
	 * @param $data 收集条件的参数集合
	 * @return array
	 */
	private function loadPrizeAttr($data){
		/*****************************奖品状态区******************************/
		//奖品状态信息
		$statusInfo = $this->sPrize->getPrizeStatusInfo();
		/*****************************奖品推荐区******************************/
		$flagInfo = $this->sPrize->getPrizeFlagInfo();
		/*****************************加载游戏规则******************************/
		$prizeRule = $this->sPrize->getPirzeGameRuleById(3);
		/*****************************奖品关系区******************************/
		$groupList = $this->sPrize->getPrizeGroupInfo();
		/*****************************奖品区域区******************************/
		//按店铺
		if(intval($data['lev'])>-1){
			//加载省份信息
			$zoneList = $this->sLocation->listByCondition(array('key'=>'id,title','type'=>1));
			//加载城市信息
			if(intval($data['zid'])>0){
				$cityList = $this->sLocation->listByCondition(array('key'=>'id,title','zone'=>intval($data['zid']),'type'=>2));
			}
			//加载区县信息
			if(intval($data['cid'])>0){
				$discList = $this->sLocation->listByCondition(array('key'=>'id,title','zone'=>intval($data['zid']),'city'=>intval($data['cid']),'type'=>3));
			}
		}
		//输出信息
		return array(
			//奖品状态
			'wait_count'	=> intval($statusInfo['wait_count']),
			'open_count'	=> intval($statusInfo['open_count']),
			'end_count'		=> intval($statusInfo['end_count']),
			//奖品推荐
			'is_count'		=> intval($flagInfo['is_count']),
			'no_count'		=> intval($flagInfo['no_count']),
			//奖品分类
			'group_list'	=> $groupList,
			//奖品区域区
			'zone_list'		=> $zoneList,
			'city_list'		=> $cityList,
			'disc_list'		=> $discList,
			//加载游戏规则
			'prize_rule'	=> $prizeRule['rule_content']
		);
	}
	
	/*
	 * 加载奖品中奖公告信息
	 * @param $data 收集条件的参数集合
	 * @return array
	 */
	private function loadPrizeNote($data){
		$array = array();
		$list = $this->sPrize->getRecordListByStuAndPub(-1,0,1,10);
		if($list && count($list)>0){
			$prizeIds = Blue_Array::getIds($list, 'prize_id');
			$prizes = $this->sPrize->gets($prizeIds); //select * from prize where prize_id in ()
			foreach($list as $user){
				//获取奖品信息
				//$prize = $this->sPrize->getPrizeInfoByCondition(array('pid'=>$user['prize_id']));
				$prize = $prizes[$user['prize_id']];
				//获取手机号码并处理
				if(!empty($user['prize_user_mobile']) && strlen($user['prize_user_mobile'])==11){
					$mobile = substr($user['prize_user_mobile'],0,3)."****".substr($user['prize_user_mobile'],7,4);
					$user['user_mobile'] = $mobile;
				}
				$user['user_province'] = $user['prize_user_province'];
				$user['user_city'] = $user['prize_user_city'];
				$user['user_name'] = $user['prize_user_name'];
				$user['encty_id'] = $this->sEncty->encrypt($user['prize_id'],true);
				$user['prize_title'] = $prize['prize_title'];
				$user['prize_phase'] = $prize['prize_phase'];
				$array[] = $user;
			}
		}
		return array(
			'note_list' => $array
		);
	}
}

	
