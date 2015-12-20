<?php

/**
 * 合作商的服务层
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 27 Aug 2015 09:56:43 PM CST
 */

class Service_Agent{
	
	//合作商对象
	private $dAgent;
	//级别对象
	private $dAgentlevel;
	
	/*
	 * 服务信息初始化
	 */
	public function __construct(){
		$this->dAgent = new Dao_Agent_Agent();
		$this->dAgentlevel = new Dao_Agent_Level();
	}
	
	/*
	 * 根据disc获取aid集合
	 * @param $disc
	 * @return string
	 */
	public function loadAidByDisc($disc){
		$string = '';
		$cond = array('location_ids'=>$disc,'field'=>'agent_id');
		$list = $this->dAgentlevel->loadByCondition($cond);
		if($list && count($list)>0){
			foreach($list as $item){
				if($item['agent_id']>0){
					$string .= $item['agent_id'].',';
				}
			}
		}
		if(!empty($string)){
			$string = substr($string,0,strlen($string)-1);
		}
		return $string;
	}
	
	/*
	 * 根据渠道商ID集合获取其信息集合[仅供超级大奖特用] 
	 * @param $ids 渠道商ID集合
	 * @return array
	 */
	public function listAgentByIds($ids){
		return $this->dAgent->listAgentByIds($ids);
	}
	
	/*
	 * 根据agents_id集合获取relation_id集合 
	 * @param $ids agents_id
	 * @return string
	 */
	public function getAgentRidsByAids($aids){
		$string = '';
		$list = $this->dAgent->listAgentByIds($aids);
		if($list && count($list)>0){
			foreach($list as $item){
				$string .= $item['relation_id'].',';
			}
		}
		if(!empty($string)){
			$string = substr($string,0,strlen($string)-1);
		}
		return $string;
	}
	
	/*
	 * 根据agents_id集合获取agent_name集合 
	 * @param $ids agents_id
	 * @return string
	 */
	public function getAgentNamesByAids($aids){
		$string = '';
		$list = $this->dAgent->listAgentByIds($aids);
		if($list && count($list)>0){
			foreach($list as $item){
				$string .= $item['agent_name'].',';
			}
		}
		if(!empty($string)){
			$string = substr($string,0,strlen($string)-1);
		}
		return $string;
	}
	
	/*
	 * 根据店铺ID获取渠道商ID
	 * @param $aid 店铺ID
	 * @return string
	 */
	public function getPidByAid($aid){
		$string = '';
		$cond = array('agent_id'=>$aid,'field'=>'parent_id');
		$list = $this->dAgentlevel->loadByCondition($cond);
		if($list && count($list)>0){
			$string = $list[0]['parent_id'];
		}
		return $string;
	}
	
	/*
	 * 根据渠道商ID获取渠道商名称
	 * @param $pid 渠道商ID
	 * @return string
	 */
	public function getNameByPid($pid){
		$info = $this->dAgent->loadByCondition(array('id'=>$pid),null);
		return $info['agent_name'];
	}
}