<?php
/**
 * View层的基础接口
 * 
 * 增加：getHeaders，处理header要使用的一些header信息
 *
 * $smarty = App_View::factory('smarty');
 * $smarty->setTpl('email/affiliate_register.tpl');
 * $smarty->assign('a', 'b');
 * $content = $smarty->fetch();
 *
 * @author 		monkee <monkee.hu@yeahmobi.com>
 * @package		yeahmobi
 * @version		2.0.2
 * @copyright		Copyright (c) 2014 Yeahmobi, Inc.
 */

abstract class App_View implements Yaf_View_Interface
{
    abstract public function __construct();
    abstract public function assign($spec, $value = null);
    abstract public function render($tpl = '', $var = null);
    abstract public function setScriptPath($path);
    abstract public function getScriptPath();
    abstract public function display($tpl = '', $var = null);
    /**
     * 返回输出需要的Header信息
     * 
     * @return array
     */
    abstract public function getHeaders();
    
    /**
     * 根据实际的key来构造具体的View对象
     * 
     * @param string $name
     * @return App_View instance
     * @throws App_Exception_Fatal
     */
    public static function factory($name){
        $view = 'App_View_' . ucfirst($name);
        if(class_exists($view)){
            return (new $view());
        }else{
            throw new App_Exception_Fatal('Unrecongize ACTION_VIEW:' . $name . ' in action');
        }
    }
}