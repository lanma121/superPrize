<?php

/**
 * 超级大奖的奖品数据层
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 26 Aug 2015 09:56:43 PM CST
 */

class Dao_Super_Prize extends Blue_Dao{
	
	/*
	 * 数据信息初始化
	 */
	public function __construct(){
		parent::__construct('main', 'main', 'cms_super_prize');
	}
	
	/*
	 * 收集字段信息
	 */
	private function collectField(){
		$field  = 'id, prize_phase, prize_short_title as prize_title, prize_code, prize_currency,';
		$field .= 'prize_fact_num ,prize_price, prize_status, prize_company, prize_agents,';
		$field .= 'prize_locats, prize_zone, prize_city, prize_disc, prize_aid, prize_win_id,'; 
		$field .= 'prize_picture, prize_min_num, prize_draw_currency, prize_start_time, prize_auto,';
		$field .= 'prize_start,prize_buffer_time,prize_wait_time,prize_ernie,prize_roll_speed,';
		$field .= 'prize_down_time,prize_game_rule,prize_game_explain,prize_out,prize_agents,';
		$field .= 'prize_add_date,prize_mod_date,prize_end_time';
		return $field;
	}

	public function gets($ids){
		if(empty($ids)){
			return array();
		}
		return $this->select(sprintf('id IN (%s)', implode(',', $ids)));
	}
	
	/*
	 * 收集列表查询条件
	 * @param $cond
	 */
	private function getListSqlByCondition($cond){
		$where = sprintf('prize_status!=4');
		if($cond['gid']>0){
			$where .= sprintf(' and prize_gid in (%s)', $cond['gid']);
		}
		if($cond['flg']>=0){
			$where .= sprintf(' and prize_flag in (%s)', $cond['flg']);
		}	
		if($cond['lev']>=0){
			$where .= sprintf(' and prize_level in (%s)', $cond['lev']);
		}
		if($cond['stu']>=0){
			$where .= sprintf(' and prize_status in (%s)', $cond['stu']);
		}	
		if($cond['lev']==0){	
			if(!empty($cond['sid'])){
				$where .= sprintf(' and prize_agents in (%s)', $cond['sid']);
			}
		}
		if($cond['lev']==1){
			if($cond['zid']>0){
				$where .= sprintf(' and prize_zone in (%s)', $cond['zid']);
			}	
			if($cond['cid']>0){
				$where .= sprintf(' and prize_city in (%s)', $cond['cid']);
			}	
			if($cond['did']>0){
				$where .= sprintf(' and prize_disc in (%s)', $cond['did']);
			}
		}
		if(!empty($cond['sea'])){
			$where .= ' and (prize_title like "%'.$this->escape($cond['sea']).'%" or prize_code like "%'.$this->escape($cond['sea']).'%")';
		}
		return $where;
	}
	
	/*
	 * 获取中奖列表信息
	 * @param $cond
	 */
	public function getWinListByCondition($cond){
		$opt = $this->collectField();
		$where  = sprintf(' prize_status=3 and prize_order=-1 and prize_win_id>0 and id!=%d', $cond['pid']);
		$limit = sprintf('order by prize_end_time desc limit %d,%d', ($cond['pn']-1)*$cond['rn'], $cond['rn']);
		return $this->select($where, $opt, $limit);
	}
	
	/*
	 * 奖品列表展示详细,特殊情况
	 * 根据数组条件动态获取列表信息
	 * @param $pid 奖品ID
	 */
	public function getInfoByCondition($cond){
		$opt = $this->collectField();
		if($cond['pid']>0){
			$where .= sprintf('id in (%s)', $cond['pid']);
			return $this->selectOne($where, $opt, null);	
		}else{
			return null;
		}
	}
	
	/*
	 * 奖品详细,特殊情况
	 * 根据数组条件动态获取列表信息
	 * @param $cond 收集动态条件
	 */
	public function getListByCondition1($cond){
		$array = array();
		$where  = 'select ';
		$where .= 'id,prize_status,prize_code,prize_phase,prize_title,prize_picture,';
		$where .= 'prize_fact_num,prize_draw_currency,prize_price,prize_agents,prize_short_title,';
		$where .= 'prize_win_id,prize_min_num,prize_company,prize_level,prize_phase,';
		$where .= '(select title from cms__locations where id=prize_zone) as prize_zone,';
		$where .= '(select title from cms__locations where id=prize_city) as prize_city,';
		$where .= '(select title from cms__locations where id=prize_disc) as prize_disc,';
		$where .= '(select prize_user_name from cms_super_prize_user where id=prize_win_id) as user_name,';
		$where .= '(select prize_user_mobile from cms_super_prize_user where id=prize_win_id) as user_mobile,';
		$where .= '(select prize_user_province from cms_super_prize_user where id=prize_win_id) as user_province,';
		$where .= '(select prize_user_city from cms_super_prize_user where id=prize_win_id) as user_city,';
		$where .= '(select prize_user_district from cms_super_prize_user where id=prize_win_id) as user_district,';
		$where .= '(select prize_user_word from cms_super_prize_user where id=prize_win_id) as user_word,';
		$where .= '(select prize_user_publish from cms_super_prize_user where id=prize_win_id) as user_publish,';
		$where .= '(select agent_name from cms_agent_agents where id in (prize_agents)) as agent_name ';
		$where .= ' from cms_super_prize where ';
		$where .= $this->getListSqlByCondition($cond);
		$where .= sprintf(' order by '.$cond['ord'].' limit %d,%d', ($cond['pn']-1)*$cond['rn'], $cond['rn']);
		$res = $this->execute($where);
		if($res === false){
			throw new Blue_Exception_Fatal("sql execute fail", array('sql' => $where));
		}
		$array = $this->fetchAll($res);
		return $array;
	}
	
	/*
	 * 奖品详细,特殊情况
	 * 根据数组条件动态获取列表信息
	 * @param $cond 收集动态条件
	 */
	public function getListByCondition($cond){
		$opt  = 'id as pid,prize_status as stu,prize_flag as flg ,prize_agents as sid,';
		$opt .= 'prize_aid as aid,prize_zone as zid,prize_city as cid,prize_disc as did,';
		$opt .= 'prize_level as lev,prize_gid as gid';
		$where = $this->getListSqlByCondition($cond);
		$limit = sprintf(' order by '.$cond['ord'].' limit %d,%d', ($cond['pn']-1)*$cond['rn'], $cond['rn']);
		return $this->select($where, $opt, $limit);	
	}
	
	
	
	/*
	 * 奖品分页,特殊情况
	 * 根据数组条件动态获取列表信息
	 * @param $cond 收集动态条件
	 */
	public function getCountByCondition($cond){
		$where = $this->getListSqlByCondition($cond);
		return $this->selectCount($where);
	}
	
	/*
	 * 获取奖品列表
	 * @param  $condtions 奖品参数集合
	 * @param  $pn 当前页 
	 * @param  $rn 当前条数
	 * @return array
	 */
	public function loadByCondition($condtions,$pn,$rn){
		$opt = $this->collectField();
		if(!empty($condtions['field'])){
			$opt = $condtions['field'];
		}
		$limit = sprintf('order by prize_end_time desc limit %d,%d', ($pn-1)*$rn, $rn);
		$where = $this->sqlByCondition($condtions);
		return $this->select($where, $opt, $limit);
	}
	
	/*
	 * 获取奖品详细
	 * @param $condtions 奖品参数集合
	 */
	public function getByCondition($condtions){
		$opt = $this->collectField();
		if(!empty($condtions['field'])){
			$opt = $condtions['field'];
		}
		$where = ' 1 ';
		if($condtions['id']>0){
			$where .= sprintf(' and id=%d',$condtions['id']);
		}
		if($condtions['wid']>0){
			$where .= sprintf(' and prize_win_id=%d',$condtions['wid']);
		}
		if($condtions['status']>-1){
			$where .= sprintf(' and prize_status=%d',$condtions['status']);
		}
		return $this->selectOne($where, $opt, null);
	}
	
	/*
	 * 获取超级大奖各项总记录数
	 * @param $condtions 奖品参数集合
	 */
	public function getTotalByCondition($condtions){
		$where = sprintf('prize_status!=4');
		if($condtions['status']>-1){
			$where .= sprintf(' and prize_status=%d',$condtions['status']);
		}else if($condtions['flag']>=0){
			$where .= sprintf(' and prize_flag=%d',$condtions['flag']);
		}
		return $this->selectCount($where);
	}
	
	/*
	 * 构建查询SQL
	 * @param $condtions 奖品参数集合
	 */
	public function sqlByCondition($condtions){
		$where = sprintf('prize_status!=4');
		if($condtions['status']>-1){
			$where .= sprintf(' and prize_status=%d',$condtions['status']);
		}
		if($condtions['flag']>=0){
			$where .= sprintf(' and prize_flag=%d',$condtions['flag']);
		}
		if(!empty($condtions['pid'])){
			$where .= sprintf(' and id in (%s)',$condtions['pid']);
		}
		if($condtions['out']==-1){
			$where .= sprintf(' and prize_out > 0');
		}
		if($condtions['wid']>0){
			if($condtions['gt']){
				$where .= sprintf(' and prize_win_id>0');
			}else{
				$where .= sprintf(' and prize_win_id=%d',$condtions['wid']);
			}
		}
		switch(intval($condtions['level'])){
			case 1:
				if(!empty($condtions['agents'])){
					$where .= sprintf(' and prize_agents in (%s)', $condtions['agents']);
				}else{
					$where .= sprintf(" and prize_agents!='' and prize_agents is not null and prize_agents!=0");
				}
			break;
			case 2:
				if($condtions['zone']>0){
					$where .= sprintf(' and prize_zone=%d',$condtions['zone']);
					if($condtions['city']>0){
						$where .= sprintf(' and prize_city=%d',$condtions['city']);
						if($condtions['disc']>0){
							$where .= sprintf(' and prize_disc=%d',$condtions['disc']);
						}
					}
				}else{
					$where .= sprintf(' and prize_locats>0');
				}
			break;
			case 3:
				$where .= sprintf(' and (prize_locats=0) and (prize_agents=0 or prize_agents is null)');
			break;	
		}
		return $where;
	}
	
	/*
	 * 根据奖品ID加载奖品状态
	 * @param $id 超级大奖奖品ID
	 */
	public function loadStatusById($id){
		$opt  = 'prize_status';
		$where = sprintf('id=%d',$id);
		return $this->selectOne($where, $opt, null);
	}
	
	/*
	 * 查询奖品的最大期数
	 */
	public function loadMaxPhase(){
		$opt  = 'max(prize_phase) as max_phase';
		return $this->selectOne(null, $opt, null);
	}
	
	/*
	 * 获取奖品状态
	 */
	public function getStatusInfo(){
		$opt = 'prize_status,count(prize_status) as total ';
		$limit = sprintf('group by prize_status');
		return $this->select(null, $opt, $limit);
	}
	
	/*
	 * 获取奖品推荐
	 */
	public function getFlagInfo(){
		$opt = 'prize_flag,count(prize_flag) as total';
		$where = sprintf('prize_status!=4');
		$limit = sprintf('group by prize_flag');
		return $this->select($where, $opt, $limit);
	}
	
	/*
	 * 获取奖品分类
	 */
	public function getGroupInfo(){
		$where  = 'select prize_gid as group_id,prize_group_name as group_title,'; 
		$where .= 'count(prize_gid) as group_total ';
		$where .= 'from cms_super_prize a,cms_super_prize_group b where ';
		$where .= 'a.prize_gid=b.id and prize_status!=4 group by prize_gid';
		$res = $this->execute($where);
		if($res === false){
			throw new Blue_Exception_Fatal("sql execute fail", array('sql' => $where));
		}
		$array = $this->fetchAll($res);
		return $array;
	}
	
}
