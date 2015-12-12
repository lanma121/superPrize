<?php

/**
 * 
 * 
 * @author name <@yunsupport.com>
 * @copyright 2014~ (c) @yunsupport.com
 * @Time: Fri 14 Nov 2014 01:12:58 PM CST
 */

class Bole_Image
{
	private $image = null;
	public function __construct($file){
		$this->image = new Imagick($file);
	}

	/**
	 * 获取图片尺寸
	 *
	 * @return array
	 */
	public function getSize(){
		return $this->image->getImageGeometry();
	}

	/**
	 *
         * 
         */
	public function resize(){
	}
}

