<?php

/**
 * 
 * 
 * @author name <@yunsupport.com>
 * @copyright 2015~ (c) @yunsupport.com
 * @Time: Fri 06 Mar 2015 12:06:47 PM CST
 */


class Bole_Date
{

	static public function add($date, $days){
		$d = new DateTime($date);
		$d->add(new DateInterval(sprintf('P%dD', $days)));
		return $d->format('Y-m-d');
	}
}
