<?php
/**
 * 静态文件分发脚本
 *
 * @author hufeng(@yunsupport.com)
 */


include __DIR__ . '/alioss/sdk.class.php';

class Arch_Oss extends ALIOSS
{
	private $bucket = '';
	private $host = '';
	private $ns = '';
	private $cdn = '';
	public static function getInstance($ini){

		if(Arch_Yaml::get('oss', $ini, true)){
			$conf = Arch_Yaml::get('oss', $ini, true);
		}else{
			$conf = Core_Conf::getConf('oss:' . $ini);
		}

		if(empty($conf)){
			throw new Blue_Exception_Fatal("Conf oss:{$ini} is empty");
		}

		return new Arch_Oss($conf['ak'], $conf['sk'], $conf['host'], $conf['bucket'], $conf['ns'], $conf['cdn']);
	}

	public function __construct($ak, $sk, $host, $bucket, $ns = '', $cdn = ''){
		parent::__construct($ak, $sk, $host);
		$this->bucket = $bucket;
		$this->host = $host;
		$this->ns = $ns;
		$this->cdn = $cdn;
	}

	public function uploadFile($object, $src){
		$object = $this->formatObject($object);
		return $this->upload_file_by_file($this->bucket, $object, $src);
	}

	/**
	 * 根据内容发布数据
	 *
	 * @param string $object
	 * @param string $content
	 */
	public function uploadFileByContent($object, $content){
		$object = $this->formatObject($object);
		return $this->upload_file_by_content($this->bucket, $object, array('content' => $content));
		//return $this->upload_file_by_content($this->bucket, $object, $content);
	}
	/**
	 * 获取未加密的URL地址
	 *
	 * @param string $object
	 * @return string
	 */
	public function getUrl($object, $cdn = false){
		if($cdn == false){
			return sprintf('http://%s/%s/%s', $this->host, $this->bucket, $this->formatObject($object));
		}else{
			return sprintf('http://%s/%s', $this->cdn, $this->formatObject($object));
		}
	}

	private function formatObject($object){
		if(empty($this->ns)){
			return $object;
		}
		return $this->ns . '/' . $object;
	}
}

