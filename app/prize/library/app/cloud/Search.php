<?php
/**
 * @desc Open Search (开放式数据搜索)
 * @author 1399871902@qq.com
 * @time Sat 14 Nov 16:16
 */

include_once(__DIR__.'/search/CloudsearchClient.php' );
include_once(__DIR__.'/search/CloudsearchIndex.php' );
include_once(__DIR__.'/search/CloudsearchDoc.php' );
include_once(__DIR__.'/search/CloudsearchSearch.php' );

class App_Cloud_Search{
	
	private $client;
	
	public function __construct(){
		$opt = Arch_Yaml::get('prize/blue', 'search', true);
		$opts = array('host'=>$opt['host']);
		$this->client = new CloudsearchClient($opt['access'], $opt['secret'], $opts, $opt['type']);
	}
	
	/**
	 * 云端搜索
	 */
	public function cloudSearch(){
		$appName = 	'sdk_user_demo';
		$object = new CloudsearchIndex($appName,$this->client);
		$result = $object->createByTemplateName('builtin_novel');
		print_r($result);
	}
	
}