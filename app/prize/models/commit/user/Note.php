<?php

/**
 * 会员成就点信息
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 26 Aug 2015 09:56:43 PM CST
 */

class Commit_User_Note extends Blue_Commit{
	
	private $dNote;
	
	protected function __register(){
		$this->transDB = array('main');
	}

	protected function __prepare(){
		$this->dNote = new Dao_User_Note();
	}
	
	protected function __execute(){
		$data = $this->getRequest();
		switch(intval($data['tpe'])){
			//新增
			case 1:
				$this->addUserNote($data['mid']);
			break;
			//编辑
			case 2:

			break;	
		}
	}
	
	/*
	 * 添加会员成就点信息 
	 * @param $param 需要新增的内容信息
	 */
	private function addUserNote($param){
		$data = array(
            'member_id'			=> $param['mid'],
            'use_points_4'		=> 0,
            'use_points_18'		=> 0,
            'dot'				=> 0,
            'level'				=> 0,
            'update_time' 		=> time()
        );
		return $this->dNote->insert($data);
	}
}