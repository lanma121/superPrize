<?php

/**
 * 系统地址的数据层
 * @author 1399871902<@qq.com>
 * @copyright 2015~ (c) @qq.com
 * @Time: Monday 26 October 2015 13:31:13 PM CST
 */

class Dao_Cms_Location extends Blue_Dao{
	
	/*
	 * 数据信息初始化
	 */
	public function __construct(){
		parent::__construct('main', 'main', 'cms__locations');
	}
	
	/**
	 * 根据条件获取区域信息
	 * @param $cond
	 */
	public function getListByCondition($cond){
		//获取全部字段值信息
		$opt = 'id,title,type,parent1,parent2,parent3';
		$where = '1';
		if(!empty($cond['ids'])){
			$where .= sprintf(' and id in (%s)', $cond['ids']);
		}
		return $this->select($where, $opt, null);	
	}
	
	/*
	 * 获取地址信息
	 * @param $cond 地址参数集合
	 */
	public function listByCondition($cond){
		//获取全部字段值信息
		$opt = 'id,title,type,parent1,parent2,parent3';
		//获取被选定字段信息
		if(!empty($cond['key'])){
			$opt = $cond['key'];
		}
		//兼容新版本
		if(!empty($cond['field'])){
			$opt = $cond['field'];
		}
		//根据ID获取单条数据
		if(intval($cond['id'])>0){
			$where = sprintf('id=%d',intval($cond['id']));
			return $this->selectOne($where, $opt, null);
		}
		//根据其它条件获取集合信息
		else{
			$where = '';
			switch(intval($cond['type'])){
				//获取省份信息
				case 1:
					$where = sprintf("type='zone' and parent1=44");
				break;
				//获取某省份下的城市信息
				case 2:
					$where = sprintf("type='city' and parent1=44 and parent2=%d",intval($cond['zone']));
				break;	
				//获取某城市下区县信息
				case 3:
					$where = sprintf("type='district' and parent1=44 and parent2=%d and parent3=%d",intval($cond['zone']),intval($cond['city']));
				break;
				//获取某省份下的区县信息
				case 4:
					$where = sprintf("type='district' and parent1=44 and parent2=%d",intval($cond['zone']));
				break;	
			}
			if(!empty($cond['ids'])){
				$where = sprintf('id in (%s)', $cond['ids']);
			}
			if(!empty($where)){
				return $this->select($where, $opt, null);
			}else{
				return null;
			}
		}
	}
}


