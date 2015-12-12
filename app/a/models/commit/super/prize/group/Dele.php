<?php

/**
 * 删除奖品分类
 * 
 * @author 1399871902<@qq.com>
 * @copyright 2015~ (c) @qq.com
 * @Time: Wed 26 Aug 2015 09:56:43 PM CST
 */

class Commit_Super_Prize_Group_Dele extends Blue_Commit{
	
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
		$where = sprintf('id = %s',$data['id']);
		return $this->dGroup->delete($where);
	}
}