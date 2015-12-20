<?php

/**
 * @desc Soap Seve 服务器类函数解析
 * @author 1399871902@qq.com
 * @time Sat 14 Nov 16:16
 */

include_once(__DIR__.'/class/nusoap.class.php');

class App_Soap_Seve{
	
	/*
	 * 服务器资源
	 */
	public $server;
	
	/*
	 * 架构函数
	 * @access public
	 */
	public function __construct(){
		ob_start();
		$this->server = new soap_server();
		//控制器初始化
        if(method_exists($this,'_initialize')){
            $this->_initialize();
        }
        $methods = get_class_methods($this);
       	$methods = array_diff($methods,array('__construct','__call','_initialize','__analytical'));   
        $class = get_class($this);
        $this->server->soap_defencoding = 'utf-8';
        $this->server->decode_utf8 = false; 
        $this->server->xml_encoding = 'UTF-8'; 
        $this->server->configure_wsdl($class);
		foreach($methods as $method){
        	$register = array();	
        	$params = $this->__analytical($class , $method);
        	if($params && count($params)>0){
        		$arrays = explode(',', $params[$method]);
        		foreach($arrays as $array){
					$register[trim($array)] = 'xsd:string';
        		}
        	}
        	$this->server->register($class.'.'.$method,$register,array('return'=>'xsd:string'));
        }
	}
	
	/*
     * 魔术方法 有不存在的操作的时候执行
     * @access public
     * @param string $method 方法名
     * @param array $args 参数
     * @return mixed
     */
	public function __call($method,$args){
    	
    }
	
	/*
	 * php类解析
	 * @param $clsname
	 * @param $methods
	 */
	private function __analytical($clsname, $methods=null){
	    $reflection = new ReflectionClass($clsname); 
	    $aMethods = $reflection->getMethods();
	    foreach($aMethods as $param){
	        $name = $param->name;
	        $args = array();
	        if($methods){
	            if(strtolower($name) !== strtolower($methods)){
	                continue;
	            }
	        }
	        foreach($param->getParameters() as $param){
	            $tmparg = '';
	            if($param->isPassedByReference()){
	            	$tmparg = '&';
	            }
	            if($param->isOptional()){
	                try{
	                    $defaultValue = $param->getDefaultValue();
	                    if(is_null($defaultValue)){
	                        $defaultValue = 'null';
	                    }
	                    $tmparg = '['.$tmparg.'$'.$param->getName().'='.$defaultValue.']';
	                }catch(Exception $e){
	                    $tmparg = '['.$tmparg.'$'.$param->getName().']';
	                }
	            }else{
	                $tmparg .= $param->getName();
	            }
	            $args[] = $tmparg;
	            unset($tmparg);
	        }
	        $functions[$name] = strtr(implode(', ', $args),array('], ['=>', ')) .PHP_EOL;
	    }
	    return $functions;
	}
	
}
