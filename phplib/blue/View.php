<?php

/**
 * 
 * 
 * @author name <@yunsupport.com>
 * @copyright 2014~ (c) @yunsupport.com
 * @Time: Fri 07 Nov 2014 11:18:16 PM CST
 */

class Blue_View
{
	static public function factory($type){
		$class = 'Blue_View_' . ucfirst($type);
		return new $class();
	}
}
