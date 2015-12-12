<?php
/**
 * 处理上传文件
 * 
 * @author name <@yunsupport.com>
 * @copyright 2014~ (c) @yunsupport.com
 * @Time: Thu 13 Nov 2014 10:13:58 PM CST
 */

class Blue_File
{
	private $file;

	/**
	 * 上传时的文件名称
	 *
	 * @param string $name
	 */
	public function __construct($name){
		$this->file = $_FILES[$name];
	}

	/**
	 * 获取文件大小
	 *
	 * @return int
	 */
	public function getSize(){
		return $this->file['size'];
	}

	/**
	 * 获取错误信息
	 *
	 * 如果没有错误,则返回:0
	 *
	 * @return int
	 */
	public function getError(){
		return $this->file['error'];
	}

	/**
	 * 获取文件的mimetype
	 *
	 * @return string
	 */
	public function getType(){
		return $this->file['type'];
	}

	/**
	 * 获取文件后缀名
	 * 
	 * 后缀名已经被小写
	 *
	 * @return string
	 */
	public function getFileType(){
		return strtolower(substr($file['name'], strrpos($file['name'], '.') + 1));
	}

	/**
	 * 获取上传文件名的名称
	 *
	 * @return string
	 */
	public function getName(){
		return $file['name'];
	}

	/**
	 * 获取临时文件地址
	 *
	 * @return string
	 */
	public function getFile(){
		return $file['tmp_name'];
	}
}

