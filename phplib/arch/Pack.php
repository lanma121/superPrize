<?php

/**
 * 用于RPC通信的打包和解包工具 
 * 
 * @author name <@yunbix.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Tue 18 Aug 2015 05:47:56 PM CST
 */

class Arch_Pack
{
	/**
	 * 打包工具
	 *
	 * 使用pack打包，生成二进制数据
	 * 序列化使用msgpack
	 *
	 * @param mixed $data
	 *
	 * @return raw
	 */
	static public function pack($data){
		$out = msgpack_pack($data);
		$out = pack('N', strlen($out) + 4) . $out;
		return $out;
	}

	/**
	 * 解包工具
	 *
	 * @param string $raw
	 *
	 * @return mixed
	 */
	static public function unpack($raw, $prefix = true){
		if($prefix){
			return msgpack_unpack(substr($raw, 4));
		}else{
			return msgpack_unpack($raw);
		}
	}

	/**
	 * 反解码数据包长度
	 *
	 * @param raw $raw
	 *
	 * @return int
	 */
	static public function unpackLength($raw){
		$l = unpack('N', substr($raw, 0, 4));
		if(empty($l)){
			return 0;
		}
		$l = intval($l[1]);
		return $l;
	}
}
