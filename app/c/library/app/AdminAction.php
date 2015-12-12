<?php

/**
 * 
 * 
 * @author name <@yunsupport.com>
 * @copyright 2014~ (c) @yunsupport.com
 * @Time: Mon 24 Nov 2014 02:45:35 PM CST
 */

class App_AdminAction extends Blue_Action{
	
	const SESSION_TOKEN = 'djcisu&*%$3df';

	protected $hookNeedLogin = false;
	protected $hookNeedPrivileges = true;
	protected $hookCheckPrivileges = false;
	protected $loginInfo;
	protected $sManager;
	protected $sAdmin;
	protected $result;
	protected $dllk;
	/*
	 * 当前模块的权限,用于左侧栏的显示 和 权限的判断
	 */
	protected $privileges = array();
	
	/*
	 * 全局的权限,用户拥有的所有的
	 */
	protected $_privileges = array();
	
	/*
	 * 更细分的两级权限
	 *
	 * 跟历史版本有关系,兼容
	 */
	protected $pagePriv = array(0, 0);
	
	/*
	 * 模块名称
	 */
	protected $pageModule = 'index';
	
	
	protected function __before(){
		$this->loginInfo = $this->getLogined();
		$this->sManager = new Service_Manager();
		$this->sAdmin = new Service_Admin();
		if($this->hookNeedLogin){
			$this->needLogin();
		}
		if($this->hookNeedPrivileges){
			$this->needPrivileges();
		}
		if($this->hookCheckPrivileges){
			$this->checkPrivileges();
		}
		$this->__common();
	}
	
	
	/*
	 * 需要的管理员权限
	 */
	protected function needPrivileges(){
		$sess = $this->getLogined();	
		//表示 拥有所有权限
		if(intval($sess['adminInfo']['isrestricted'])==0){
			$this->_privileges = Arch_Yaml::get('privileges');
		}else{
			$privileges = $this->sManager->getAdminManagerById($sess['adminInfo']['adminId']);
			$this->_privileges = @unserialize($privileges['admin_privilege']);
		}
		if(isset($this->_privileges[$this->pageModule])){
			$this->privileges = $this->_privileges[$this->pageModule];
		}
		
	}
	
	/*
	 * 依赖的权限信息
	 */
	protected function checkPrivileges(){
		if($this->privileges === null){
			return true;
		}
		$mo = $this->pageModule;
		if(empty($this->privileges)){
			throw new Blue_Exception_Warning('权限受限', $this->pagePriv);
		}
		$cat = $this->pagePriv[0];
		$sub = $this->pagePriv[1];
		if(isset($this->privileges[$cat]) == false || empty($this->privileges[$cat])){
			throw new Blue_Exception_Warning('权限受限', $this->pagePriv);
		}
		$cat = $this->privileges[$cat];
		if(isset($cat['children'][$sub]) == false || empty($cat['children'][$sub])){
			throw new Blue_Exception_Warning('权限受限', $this->pagePriv);
		}
	}
	
	/*
	 * 判断用户是否有该模块的权限
	 * 兼容旧系统
	 * @param array $privileges 权限的数组
	 * @param string $mo 权限模块
	 * @param string $cat 权限的一级标签
	 * @param string $sub 权限的二级标签
	 *
	 * return boolean
	 */
	public function checkPrivilege($privileges, $mo, $cat, $sub){
		if(is_array($privileges) == false){
			return false;
		}
		if(empty($privileges[$mo])){
			return false;
		}
		$mp = $privileges[$mo];
		if(isset($mp[$cat]) && isset($mp[$cat]['children'][$sub])){
			return true;
		}
		return false;
	}
	
	/*
	 * 管理员需要登录 
	 */
	private function needLogin(){
		$sess = $this->getLogined();
		if(empty($sess)){ // 用户没有登录，重定向到登录
			$redirect = urlencode($_SERVER['REQUEST_URI']);
			$this->redirect('/a/index/login?redirect=' . $redirect);
		}
	}
	

	protected function parseToken($token, $needLogin = false){
		if(empty($token)){
			return null;
		}
		$aes = Arch_Encrypt::factory('aes');
		$ret = $aes->decode($token, self::SESSION_TOKEN);

		if($needLogin && (empty($ret) || empty($ret['id']))){
			throw new Blue_Exception_Warning("用户需要登录");
		}

		return $ret;
	}
	
	
	/****************************公共业务处理*****************************/
	/*
	 * 公共信息处理
	 */
	protected function __common(){
		//验证管理员登录
		if(!($this->loginInfo['adminInfo']['adminId']>0)){
			$this->redirect('/a/index/login');	
		}
		//保存模块信息
		$modules = array();
		//保存菜单信息
		$menus = array();
		//加载管理员信息
		$adminInfo = $this->sAdmin->getAdminInfoById($this->loginInfo['adminInfo']['adminId']);
		//加载权限模块
		if(is_array($this->_privileges) && count($this->_privileges)>0){
			foreach($this->_privileges as $key => $val){
				$moduleInfo = $this->sAdmin->getModuleInfoByName($key);
				if(!empty($moduleInfo['module']) && intval($moduleInfo['status'])==1){
					$modules[] = array('key'=>$moduleInfo['module'],'name'=>$moduleInfo['module_name']);
				}
			}
		}
		//数据信息过滤
		$data = $this->__verify($modules[0]['key']);
		//默认子菜单
		$this->dllk = $this->_privileges[$data['mo']][1]['children'][1]['process'];
		//加载菜单信息【默认加载第一个模块下的菜单】
		if(is_array($this->_privileges[$data['mo']]) && count($this->_privileges[$data['mo']])>0){
			foreach($this->_privileges[$data['mo']] as $key => $val){
				//子菜单信息
				$limits = array();
				if(is_array($val['children']) &&  count($val['children'])>0){
					foreach($val['children'] as $k => $v){
						$limits[] = array('title'=>$v['name'],'link'=>$v['process']);
					}
				}
				$menus[] = array('name'=>$val['name'],'childs'=>$limits);
			}
		}
		//加载指定菜单
		$this->result = array(	
			'time'		=> date('Y-m-d H:i:s',time()),
			'key'		=> $data['mo'],
			'admin'		=> $adminInfo['admins_name'],
			'modules'	=> $modules,
			'menus'		=> $menus,
			'content'	=> $data['lk'],
			'dllk'		=> $this->dllk
		);
	}
	
	/*
	 * 数据信息过滤
	 */
	protected function __verify($dmo){
		//参数信息判定
		if($this->getRequest()->isGet()){
			$data = array(
				'mo' 				=> isset($_GET['mo'])?trim($_GET['mo']):$dmo,
				'lk'				=> $_GET['lk']		
			);
			$rule = array(
				'mo' 			=> array('filterStrlen', array(0, 30), '', true),
				'lk' 			=> array('filterStrlen', array(0, 100), '', true)
			);
			return Blue_Filter::filterArray($data, $rule);
		}
		return null;
	}
}