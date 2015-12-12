<?php

/**
 * 
 * 
 * @author name <@yunsupport.com>
 * @copyright 2014~ (c) @yunsupport.com
 * @Time: Mon 17 Nov 2014 01:51:19 PM CST
 */

class Blue_Page
{
	/**
	 * 获取页面的分页信息
	 *
	 * 这里返回几个数据
	 *
	 *   count : 总条数
	 *   pn_count : 总页数
	 *   pn : 当前页
	 *   rn : 每页 条数
	 *   from : 从第几条开始
	 *   to : 到第几条
	 *   uri : 原链接地址
	 *
	 *  @param int $count
	 *  @param int $pn
	 *  @param int $rn
	 *
	 *  @return array
	 */
	static public function page2($count, $pn, $rn){
		$info = self::baseInfo($count, $pn, $rn);

		$info['from'] = ($info['pn'] - 1) * $rn + 1;
		$info['to'] = $info['pn'] * $rn;

		if($info['to'] > $info['count']){
			$info['to'] = $info['count'];
		}
		if($info['from'] > $info['count']){
			$info['from'] = $info['count'];
		}

		return $info;
	}

	static public function pageInfo($count, $pn, $rn, $length = 5){

		$r = intval(($length - 1) / 2);

		$allPage = intval(ceil($count / $rn));

		$start = $pn - $r;
		$end = $pn + $r;

		$end>=$allPage &&  $end =$allPage;
		$start < 1 && $start = 1;
		$pn > $allPage && $pn = $allPage - 1;

		$from = ($pn - 1) * $rn + 1;
		$to = $pn * $rn;

		$to > $count && $to = $count;
		$from > $count && $from = 0;

		$uri = $_SERVER['REQUEST_URI'];
		$params = $_GET;

		$db = array();
		for($i = $start; $i <= $end; $i++){
			$dp[] = $i;
		}

		return array(
			'params' => $params,
			'uri' => $uri,
			'pn' => $pn,
			'rn' => $rn,
			'nu' => $count,
			'nc' => $allPage,
			'has_next' => $pn < $allPage ? 1 : 0,
			'has_prev' => $pn > 1 ? 1 : 0,
			'start' => $start,
			'end' => $end,
			'display_pages' => $dp,
			'from' => $from,
			'to' => $to
		);
	}

	static public function baseInfo($count, $pn, $rn){
		$pnCount = intval(ceil($count / $rn));

		$params = $_GET;
		$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		unset($params['pn']);
		return array(
			'pn' => $pn,
			'rn' => $rn,
			'count' => $count,
			'uri' => $uri . '?' . http_build_query($params),
			'pn_count' => $pnCount,
			'params' => $params,
			'has_next' => $pn < $pnCount ? 1 : 0,
			'has_prev' => $pn > 1 ? 1 : 0,
		);
	}

	/**
	 * 返回基本的URI的信息
	 *
	 * request_uri 基本的链接信息
	 *
	 * @param int $rn 默认的rn大小
	 *
	 * @return array
	 */
	public function uriInfo($rn = 10){
		$res = array();

		$n = strpos($_SERVER['REQUEST_URI'], '?');

		if($n > 0){
			$res['request_uri'] = substr($_SERVER['REQUEST_URI'], 0, $n);
		}else{
			$res['request_uri'] = $_SERVER['REQUEST_URI'];
		}

		//pn rn
		$res['pn'] = intval($_GET['pn']);
		$res['rn'] = intval($_GET['rn']);

		$res['pn'] < 1 && $res['pn'] = 1;
		$res['rn'] < 1 && $res['rn'] = $rn;

		return $res;
	}
}

