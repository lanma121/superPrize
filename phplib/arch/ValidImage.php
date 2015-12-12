<?php 
/**
 * 验证码
 *
 * 生成图片和验证code是否一致
 *
 * 基于Session
 * 
 * @author hufeng<@yunbix.com>
 * @copyright 2014~ (c) @yunbix.com
 * @Time: Mon 24 Nov 2014 03:13:56 PM CST
 */

class Arch_ValidImage
{
	public function __construct(){
		session_start();
	}

	/**
	 * 验证本次验证码是否正确
	 * @param  string $code 
	 * @return boolean       
	 */
	public function check($code){
		$code = strtoupper($code);
		return $_SESSION['_authcode'] === $code;
	}

	/**
	 * 获取生成的Code
	 * 
	 * @return [type] [description]
	 */
	public function display(){
		header("Content-type: image/PNG");
		$im = imagecreate(52,20); 
		$black = ImageColorallocate($im, 0,0,0); 
		$white = ImageColorallocate($im, 230,255,255); 
		$gray = ImageColorallocate($im, 200,200,255); 
		$blue = ImageColorallocate($im, 40,100,225);
		imagefill($im,0,0,$white);
		$_SESSION['_authcode'] = $this->genCode();
		$authnum = $_SESSION['_authcode'];
		imagestring($im, 6, 8, 3, $authnum, $blue); 
		for($i=0;$i<200;$i++)
		{ 
		    $randcolor = ImageColorallocate($im,rand(0,255),rand(0,255),rand(0,255));
		    imagesetpixel($im, rand()%70 , rand()%30 , $randcolor); 
		}
		ImagePNG($im);
		ImageDestroy($im);
		exit;
	}

	public function genCode(){
		$codes = '0000';
		$a = ord('a');
		for($i = 0; $i < 4; $i++){
			$codes[$i] = chr(mt_rand(1, 26) + $a);
		}
		return strtoupper($codes);
	}
}

