<?php
/**
 * 短信发送接口
 * 
 * @author hufeng<@yunsupport.com>
 * @copyright 2014~ (c) @yunsupport.com
 * @Time: Wed 17 Dec 2014 03:31:33 PM CST
 */

class App_Sms_Sms
{
	private $remoteUrl = "";
	private $remoteBakUrl = "";
	private $userName="";
	private $userPassword="";
	 
	public function __construct($url,$bakUrl,$name,$password)
	{
		$this->remoteUrl = $url;
		$this->userName = $name;
		$this->userPassword = $password;
		$this->remoteBakUrl = $bakUrl;
	}
	
	public function getFee()
	{
		
		$ret = "";
		$fp=fopen($this->remoteUrl."/getfee.asp?name=".$this->userName."&pwd=".$this->userPassword,"r");
		$ret  = fgetss($fp,255);
		fclose($fp);
		
		if(strlen($ret)==0){
			$newfp=fopen($this->remoteBakUrl."/getfee.asp?name=".$this->userName."&pwd=".$this->userPassword,"r");
			$newret  = fgetss($newfp,255);
			fclose($newfp);
			return $newret;
		}
		return $ret;
		
	}
	
	/**
	 * 群发短信 $mobiles 用,分开
	 * @param int $mobiles 目标电话
	 * @param int $msg 发生内容
	 * @param  $time
	*/
	public function sendSms($mobiles,$msg,$time='')
	{
		try{
			$str = $this->remoteUrl."/gsend.asp?name=$this->userName&pwd=$this->userPassword&dst=$mobiles&msg=$msg&time=$time&txt=ccdx";
		}catch (Exception $e){
			$str = $this->remoteBakUrl."/gsend.asp?name=$this->userName&pwd=$this->userPassword&dst=$mobiles&msg=$msg&time=$time&txt=ccdx";
		}
		$fp = fopen($str, "r");
		$ret= fgetss($fp, 255);
		fclose($fp);
		return $ret;
	}
	
	public function changePassword($mewpassword)
	{
		$ret  = "";
		$fp = fopen($this->remoteUrl."/cpwd.asp?name=".$this->userName."&pwd=".$this->userPassword."&newpwd=$mewpassword","r");
		$ret    = fgetss($fp,255);
		fclose($fp);
		return $ret;
			
	}
}

