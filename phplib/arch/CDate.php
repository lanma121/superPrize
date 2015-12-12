<?php
/**
 * 处理农历和公历混存的场景
 *
 *
 * 
 * @author hufeng<@yunbix.com>
 * @copyright 2015~ (c) @yunbix.com
 * @Time: Sun 28 Jun 2015 12:04:52 PM CST
 */


class Arch_CDate
{
	static private $monthArr = array(
		'正', '二', '三', '四', '五', '六', '七', '八', '九', '十', '冬', '腊'
	);

	static private $dayArr = array(
		'初一', '初二','初三','初四','初五','初六','初七','初八','初九','初十',
		'十一', '十二','十三','十四','十五','十六','十七','十八','十九','廿',
		'廿一', '廿二','廿三','廿四','廿五','廿六','廿七','廿八','廿九','三十',
	);
	/**
	 * 解析自定义的生日格式
	 *
	 * 生日格式为:019880527
	 * 其中 各个格式的含义为:
	 *
	 * 0 阳历\农历 0表示阳历 1表示农历
	 * 1988 生日年
	 * 05 生日月
	 * 27 生日日
	 *
	 * @param string $str;
	 *
	 * @return array
	 */
	static public function parse($str){
		if(empty($str)){
			return array();
		}

		$ret = array(
			't' => $str[0] == '1' ? 1 : 0,
			'y' => intval(substr($str, 1, 4)),
			'm' => intval(substr($str, 5, 2)),
			'd' => intval(substr($str, 7, 2))
		);
		return $ret;
	}

	static public function parseCMonth($m){
		return self::$monthArr[$m - 1];
	}

	static public function parseCDay($d){
		return self::$dayArr[$d - 1];
	}
}

