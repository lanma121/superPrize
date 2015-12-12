<?php

/**
 * @desc Send Email 
 * @author 1399871902@qq.com
 * @time Sat 14 Nov 16:16
 */

include_once( __DIR__.'/class/email.class.php' );

class App_Email_Email{
	
	/**
	 * 发送特定电子邮件
	 * @param $subject 主题
	 * @param $content 内容
	 */
	public function sendEmail($subject,$content,$address='1399871902@qq.com'){
		$mail = new PHPMailer(true); 
		$mail -> IsSMTP(); 
	  	$mail -> CharSet='UTF-8';       
	  	$mail -> SMTPAuth = true;       
	  	$mail -> SMTPKeepAlive = true;  
	  	$mail -> Port = 25;             
	  	$mail -> Host = 'smtp.163.com'; 
		$mail -> Username = 'zhurongqiang1@163.com'; 		
  		$mail -> Password = 'FIGHTER##@@';       
  		$mail -> AddReplyTo($mail->Username, $mail->Username);
  		if(empty($address)){
	  		$mail -> AddAddress('1399871902@qq.com', '1399871902@qq.com'); 
  		}else{
  			$mail -> AddAddress($address, $address); 
  		}   
  		$mail -> SetFrom($mail->Username, $mail->Username);  
  		$mail -> Subject = $subject;
  		$mail -> AltBody = '邮件信息'; 
  		$mail -> WordWrap = 80; 
  		$mail -> MsgHTML($content); 
  		$result = $mail->Send();
  		$mail -> ClearAddresses();
		$mail -> ClearAttachments();
  		return ($result)?1:0;
	}
	
}