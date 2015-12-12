<?php

/**
 * 
 * 
 * @author name <@yunsupport.com>
 * @copyright 2014~ (c) @yunsupport.com
 * @Time: Wed 03 Dec 2014 03:16:13 PM CST
 */

include __dir__ . '/xs/XS.php';


class Arch_Search extends XS
{
	public function __construct($mod){
		$mod = PDP_DIR_CONF . '/' . PDP_APP . '/' . $mod . '.ini';

		parent::__construct($mod);
	}
}

