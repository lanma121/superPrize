<?php

/**
 * 邮件/手机接收验证码
 * 
 * @author zhurongqiang<@xabaili.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Wed 26 Aug 2015 06:14:43 PM CST
 */

class Action_Code extends App_Action{
	
	private $aEmail;
	private $aPhone;
	private $sPassport;
	private $sRandom;
	private $sAdmin;
	
	public function __prepare(){
		$this->setView(Blue_Action::VIEW_JSON);	
		$this->aEmail = new App_Email_Email();
		$this->aPhone = new App_Sms_Smssent();
		$this->sPassport = new Service_Passport();
		$this->sRandom = new Service_Random();
		$this->sAdmin = new Service_Admin();
	}
	
	public function __execute(){
		//参数信息过滤
		$data = $this->__verify();
		//数据信息不完整
		if(!($data && count($data)>0)){
			return array('result'=>1);
		}
		//获取管理员基本信息
		$adminInfo = $this->sAdmin->getAdminInfoByLogin($data['userName']);
		//管理员账号不存在
		if(!($adminInfo['admins_id']>0)){
			return array('result'=>2);
		}
		//管理员密码错误
		if(!($this->sPassport->checkPw($data['passWord'], $adminInfo['admin_password']))){
			return array('result'=>3);
		}
		//生成验证码
		$authNumber = $this->sRandom->createRandom(4,'chars');
		//保存会员登录信息
		$loginInfo = array(
			'adminId' 		=> $adminInfo['admins_id'],
			'isrestricted'	=> $adminInfo['isrestricted'],
			'authNumber' 	=> $authNumber
		);
		//邮箱验证
		if(intval($data['wayType'])==1){
			//抓取邮箱
			if(!empty($adminInfo['admins_email'])){
				$emailArray = explode(',',$adminInfo['admins_email']);
			}
			//邮箱未指定
			if(is_array($emailArray) && !in_array($data['condition'],$emailArray)){
				return array('result'=>4);
			}
			//发送邮件
			$emailFlag = $this->aEmail->sendEmail('百利网-【验证码】', '尊敬的管理员,您本次的验证码是 ：'.$authNumber, $data['condition']);
			//发送验证
			if(!$emailFlag){
				//发送失败
				return array('result'=>5);
			}else{
				//发送成功
				$this->setLogin(array('adminInfo'=>$loginInfo));
				return array('result'=>6);
			}
		}
		//手机验证
		if(intval($data['wayType'])==2){
			//抓取手机
			if(!empty($adminInfo['admins_phone'])){
				$phoneArray = explode(',',$adminInfo['admins_phone']);
			}
			//手机未指定
			if(is_array($phoneArray) && !in_array($data['condition'],$phoneArray)){
				return array('result'=>4);
			}
			//发送短信
			//$phoneFlag = $this->aPhone->voiceVerify($authNumber,2,$data['condition'],'400-029-0101',null);
			$phoneFlag = $this->aPhone->sendTemplateSMS($data['condition'], array($authNumber, '10'), '15913');
			//发送验证
			if(!$phoneFlag){
				//发送失败
				return array('result'=>5);
			}else{
				//发送成功
				$this->setLogin(array('adminInfo'=>$loginInfo));
				return array('result'=>6);
			}
		}
		//验证成功
		return array('result'=>7);
	}
	
	/*
	 * 数据信息过滤
	 */
	private function __verify(){
		//参数信息判定
		if($this->getRequest()->isPost()){
			$data = array(
				'userName' 			=> trim($_POST['userName']), 
				'passWord' 			=> trim($_POST['passWord']), 
				'condition' 		=> trim($_POST['condition']),
				'wayType' 			=> isset($_POST['wayType'])?trim($_POST['wayType']):1,
			);
			$rule = array(
				'userName' 			=> array('filterStrlen', array(0, 30), '', true),
				'passWord' 			=> array('filterStrlen', array(0, 30), '', true),
				'condition' 		=> array('filterStrlen', array(0, 30), '', true),
				'wayType' 			=> array('filterInt', array())
			);
			return Blue_Filter::filterArray($data, $rule);
		}
		return null;
	}
}