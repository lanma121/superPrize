<?php

/**
 * 编辑奖品分类
 * 
 * @author 1399871902<@qq.com>
 * @copyright 2015~ (c) @qq.com
 * @Time: Wed 26 Aug 2015 09:56:43 PM CST
 */

class Commit_Super_Prize_Group_Edit extends Blue_Commit{
	
	private $dGroup;
	
	protected function __register(){
		$this->transDB = array('main');
	}
	
	protected function __prepare(){
		$this->dGroup = new Dao_Super_Prize_Group();
	}
	
	protected function __execute(){
		//接收参数信息
		$data = $this->getRequest();
		//参数格式化
		$param = array(
			'prize_group_name' 		=> $data['name'],
			'prize_group_remark'	=> $data['mark'],
			'prize_group_edate'		=> time()
		);
		$where = sprintf('id = %s',$data['id']);
		return $this->dGroup->update($where, $param);
	}
}