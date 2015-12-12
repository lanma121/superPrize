<?php

/**
 * 
 * 
 * @author name <@yunsupport.com>
 * @copyright 2014~ (c) @yunsupport.com
 * @Time: Mon 24 Nov 2014 03:13:56 PM CST
 */

class Arch_Encrypt_Aes
{
	public function __construct(){
	}


	/**
	 * 加密
	 *
	 * @param mixed $data 要加密的数据，支持字符串、数组、证书
	 * @param string $key 加密的私有KEY
	 *
	 * @return string
	 */
	public function encode($data, $key, $base64 = true){
		$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB),MCRYPT_RAND);
		$str = $this->ser($data);
		$enc = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_ECB, $iv);

		if($base64){
			$enc = base64_encode($enc);
		}

		return $enc;
	}

	/**
	 * 解密
	 *
	 * @param string $str
	 * @param string $key
	 *
	 * @return string
	 */
	public function decode($str, $key, $base64 = true){
		if(empty($str)){
			return null;
		}
		if($base64){
			$str = base64_decode($str);
		}

		$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB), MCRYPT_RAND);  
		$data = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_ECB, $iv);

		if(!empty($data)){
			return $this->unser($data);
		}
		return null;
	}


	/**
	 * 序列化数据
	 *
	 * @param mixed $data
	 *
	 * @return string
	 */
	private function ser($data){
		return serialize($data);
	}

	/**
	 * 反序列化数据
	 *
	 * @param string $str
	 *
	 * @return array
	 */
	private function unser($str){
		return unserialize($str);
	}
}
