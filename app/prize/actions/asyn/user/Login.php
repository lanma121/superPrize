<?php

/**
 * 验证会员登录
 * @author 1399871902 <@qq.com>
 * @copyright 2015~ (c) @qq.com
 * @Time: Mon 07 Sep 2015 04:18:30 PM CST
 */

class Action_UserLogin extends App_Action{
	
	/*
	 * 类变量设置 
	 */
	private $sPassport;
	private $sUser;
	private $sMember;
	private $sRecord;
	
	/*
	 * 业务的准备工作
	 * 初始化对象 变量等
	 */
	public function __prepare(){
		$this->setView(App_Action::VIEW_JSON);
		$this->sPassport = new Service_Passport();
		$this->sUser = new Service_User();
		$this->sMember = new Service_Member();
		$this->sRecord = new Service_Record();
	}
	
	/*
	 * 实际执行业务逻辑的函数
	 * @return array
	 */
	public function __execute(){
		//判断验证码
		$image = new Arch_ValidImage();
		//验证数据信息
		$data = $this->__verify();
		//数据信息有误
		if(empty($data)){
			return array('result' => 1);
		}
		//验证码错误
		if($image->check($data['code']) == false){
			return array('result' => 2);
		}
		//会员信息
		$userInfo = $this->sUser->getUserInfoByMobile($data['name']);
		//账号错误
		if(!($userInfo['users_id']>0)){
			return array('result' => 3);
		}
		//密码错误
		if(!($this->sPassport->checkPw($data['pass'], $userInfo['users_pass']))){
			return array('result' => 4);
		}
		//账号被冻结
		if(intval($userInfo['status'])!=1){
			return array('result' => 5);
		}
		//获取会员积分信息
		$memberInfo = $this->sMember->getMemberInfoByRid($userInfo['relation_id']);
		//会员积分异常
		if(intval($userInfo['users_points'])!=intval($memberInfo['member_points'])){
			return array('result' => 6);
		}
		//判断会员当天是否首次登录
		$recordCount = $this->sRecord->checkFirstLoginToDayByMid($memberInfo['member_id']);
		//增加登录积分
		if(intval($recordCount)<=0){
			//格式化参数信息
			$param = array(
				'uid'			=> $userInfo['users_id'],
				'mid'			=> $memberInfo['member_id'],
				'rid'			=> $userInfo['relation_id']
			);
			//更新会员基本信息
			try{
				Blue_Commit::call('User_Login', $param);
			}catch(Exception $e){
				//数据更新失败
				return array('result' => 7);
			}
		}
		//保存会员登录信息
		$userInfo = array(
			'users_id' 		=> $userInfo['users_id'],
			'relation_id' 	=> $userInfo['relation_id'],
			'member_id' 	=> $memberInfo['member_id']
		);
		$this->setLogin(array('user_info'=>$userInfo));
		//登录成功
		return array('result' => 8);
	}
	
	
	/*
	 * 数据信息过滤
	 */
	private function __verify(){
		//参数信息判定
		if($this->getRequest()->isPost()){
			$data = array(
				'name'	=> trim($_POST['name']),
				'pass'	=> trim($_POST['pass']),
				'code'	=> trim($_POST['code'])
			);
			$rule = array(
				'name' => array('filterStrlen', array(0, 12), '', true),
				'pass' => array('filterStrlen', array(0, 20), '', true),
				'code' => array('filterStrlen', array(0, 10), '', true)
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