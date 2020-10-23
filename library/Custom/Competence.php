<?php

class Custom_Competence extends Zend_Controller_Action {
	protected $application;
	
	/**
	 * 系统用户对象
	 *
	 * @var System_Admin_User
	 */
	protected $user;
	
	/**
	 * 系统操作
	 *
	 * @var string
	 */
	protected $act = "";
	
	/**
	 * 模块名称
	 *
	 * @var string
	 */
	protected $moduleName = "";
	
	/**
	 * 控制器名称
	 *
	 * @var string
	 */
	protected $controllerName = "";
	
	/**
	 * 方法名称
	 *
	 * @var string
	 */
	protected $actionName = "";
	
	/**
	 * URL列表
	 *
	 * @var array
	 */
	protected $urlArray = array ();
	
	/**
	 * URL全程
	 *
	 * @var string
	 */
	protected $urlName = "";
	
	/**
	 * 重复刷新控制
	 *
	 * @var string
	 */
	protected $refreshValide = "";

	/**
	 * 初始化(non-PHPdoc)
	 *
	 * @see Zend_Controller_Action::init()
	 */
	public function init() {
		parent::init ();
		
		$this->controllerName = $this->getRequest ()->getControllerName ();
		$this->actionName = $this->getRequest ()->getActionName ();
		$this->urlArray [] = $this->controllerName;
		$explodeAction = explode ( ".", $this->actionName );
		$this->urlArray [] = $explodeAction [0];
		$this->urlName = "/" . $this->controllerName . "/" . $this->actionName;
		
		$this->_helper->viewRenderer->setNoRender ();
		$this->application = new Zend_Session_Namespace ( "application" );
		$this->application->setExpirationSeconds ( 86400 );
		try {
			$this->user = new System_Admin_User ( $this->application->manager ["Id"] );
			if ($this->user->GetId () > 0) {
				$this->view->assign ( "theme", $this->user->GetTheme () );
				$this->act = $this->_getParam ( 'act', null );
				
				$params = $this->getAllParams ();
				unset ( $params ['module'] );
				unset ( $params ['controller'] );
				unset ( $params ['action'] );
				$this->view->assign ( "module", $this->moduleName );
				$this->view->assign ( "controller", $this->controllerName );
				$this->view->assign ( "action", $this->actionName );
				$this->view->assign ( "params", $params );
				
				if (isset ( $this->application->rand ['refreshDisabled'] )) {
					if ($this->application->rand ['refreshDisabled'] == $this->_getParam ( "rand", "" )) {
						$this->act = null;
					} else {
						if (! is_null ( $this->_getParam ( "rand", null ) )) {
							$this->application->rand ['refreshDisabled'] = $this->_getParam ( "rand", "" );
						}
						
						// $actData ['userGuid'] = $this->user->GetGuid ();
						// $actData ['userName'] = $this->user->GetUserName ();
						// $actData ['ip'] = Func::GetIp ();
						// $actData ['agent'] = $_SERVER ['HTTP_USER_AGENT'];
						// $actData ['time'] = date ( "Y-m-d H:i:s" );
						// $actData ['data'] = $this->_getAllParams ();
						// $logDir = LOGDIR . "/act";
						// if (! file_exists ( $logDir )) {
						// mkdir ( $logDir, 0777, true );
						// }
						// file_put_contents ( LOGDIR . "/act/" . date ( "Y-m-d" ) . ".log", Zend_Json::encode ( $actData ) . "\n", FILE_APPEND );
					}
				} else {
					$this->application->rand ['refreshDisabled'] = "";
				}
				$this->CheckUrlName ();
				$this->GetMenuTitle ();
				return;
			} else {
				$this->_helper->redirector ( "login", "signin" );
			}
		} catch ( Exception $e ) {
			$this->_helper->redirector ( "login", "signin" );
		}
	}
	
	/**
	 * 组权限列表
	 *
	 * @var array
	 */
	protected $orgnizeUrlArray = array ();
	
	/**
	 * 只读权限列表
	 *
	 * @var array
	 */
	protected $orgnizeReadOnlyArray = array ();

	/**
	 * 获取组权限明细
	 */
	protected function GetGroupRelation() {
		$adminCongregation = new System_Admin_Congregation ( $this->user );
		$congregationArray = array ();
		foreach ( $adminCongregation->GetItems () as $congregationKey => $congregationVelue ) {
			$congregationArray [] = $congregationVelue->GetOrganize ();
		}
		$purviewArray = array ();
		foreach ( $congregationArray as $congregationArrayKey => $congregationArrayValue ) {
			$purviewArray = new System_Admin_Purview ( $congregationArrayValue );
			foreach ( $purviewArray->GetPurview () as $purviewKey => $purviewValue ) {
				$tmpArray = array ();
				$tmpArray [] = $purviewValue->GetMenu ()->GetControllerName ();
				$tmpExplode = explode ( "?", $purviewValue->GetMenu ()->GetActionName () );
				$tmpArray [] = $tmpExplode [0];
				$this->orgnizeUrlArray [] = $tmpArray;
				$tmpArray [] = $purviewValue->GetReadOnly ();
				$this->orgnizeReadOnlyArray [] = $tmpArray;
				
				$processArr = array ();
				$processArr [] = $purviewValue->GetMenu ()->GetControllerName ();
				$processArr [] = str_replace ( "list", "process", $tmpExplode [0] );
				$this->orgnizeUrlArray [] = $processArr;
				$processArr [] = $purviewValue->GetReadOnly ();
				$this->orgnizeReadOnlyArray [] = $processArr;
				
				$editArr = array ();
				$editArr [] = $purviewValue->GetMenu ()->GetControllerName ();
				$editArr [] = str_replace ( "list", "edit", $tmpExplode [0] );
				$this->orgnizeUrlArray [] = $editArr;
				$editArr [] = $purviewValue->GetReadOnly ();
				$this->orgnizeReadOnlyArray [] = $editArr;
			}
		}
	}
	
	/**
	 * 个人权限列表
	 *
	 * @var array
	 */
	protected $userUrlArray = array ();
	
	/**
	 * 只读权限列表
	 *
	 * @var array
	 */
	protected $userReadOnlyArray = array ();

	/**
	 * 获取个人权限明细
	 */
	protected function GetUserRelation() {
		$adminRelation = new System_Admin_Relation ( $this->user );
		foreach ( $adminRelation->GetRelation () as $relationKey => $relationVelue ) {
			$tmpArray = array ();
			$tmpArray [] = $relationVelue->GetMenu ()->GetControllerName ();
			$tmpExplode = explode ( "?", $relationVelue->GetMenu ()->GetActionName () );
			$tmpArray [] = $tmpExplode [0];
			$this->userUrlArray [] = $tmpArray;
			$tmpArray [] = $relationVelue->GetReadOnly ();
			$this->userReadOnlyArray [] = $tmpArray;
		}
	}

	/**
	 * 检测是否有访问权限
	 */
	private function CheckEnabled() {
		if (! in_array ( $this->urlArray, $this->userUrlArray ) && ! in_array ( $this->urlArray, $this->orgnizeUrlArray )) {
			$this->_helper->redirector ( "level", "error" );
			die ();
		} else {
			$this->CheckReadonly ();
		}
	}

	/**
	 * 检测是否只读权限
	 */
	private function CheckReadonly() {
		$orgnizeReadOnly = true;
		foreach ( $this->orgnizeReadOnlyArray as $value ) {
			if ($value [0] == $this->urlArray [0] && $value [1] == $this->urlArray [1]) {
				$orgnizeReadOnly = $value [2] == 0 ? true : false;
				if ($orgnizeReadOnly) {
					break;
				}
			}
		}
		$userReadOnly = $orgnizeReadOnly;
		foreach ( $this->userReadOnlyArray as $value ) {
			if ($value [0] == $this->urlArray [0] && $value [1] == $this->urlArray [1]) {
				$userReadOnly = $value [2] == 0 ? true : false;
				break;
			}
		}
		
		if ($userReadOnly) {
			$this->act = Func::Randomkeys ( 8 );
			$act = $this->_getParam ( 'act', null );
			if (! is_null ( $act )) {
				if(strstr($value[1], "process")){
					$jsonData = array (
							"code" => - 1,
							"msg" => "您当前为只读权限，不可以进行修改操作。",
							"time" => date ( 'Y-m-d H:i:s' ) 
					);
					echo JsonData::ArrayToJson ( $jsonData );
					exit ();
				}
				// $this->view->assign ( "alert", "<script>alert('您当前为只读权限，不可以进行修改操作。')</script>" );
				return;
			}
		}
	}

	/**
	 * 访问控制
	 */
	private function CheckUrlName() {
		if ($this->user->GetId () > 1) {
			$checkUrl = array (
					"/admin/index",
					"/admin/logoff",
					"/admin/system",
					"/admin/menu",
					"/admin/hello",
					"/admin/hold.session",
					"/admin/right",
					"/admin/password",
					"/manage/index",
					"/manage/system",
					"/manage/menu" 
			);
			
			if (! in_array ( $this->urlName, $checkUrl )) {
				$this->GetGroupRelation ();
				$this->GetUserRelation ();
				$this->CheckEnabled ();
			}
		}
	}

	/**
	 * 功能菜单
	 */
	private function GetMenuTitle() {
		$menuTitleArray = array ();
		$group = new System_Admin_Group ();
		foreach ( $group->GetItems () as $groupValue ) {
			$menuList = $groupValue->GetChildren ();
			foreach ( $menuList as $menuValue ) {
				if ($menuValue->GetUrl () != "") {
					if (strstr ( $_SERVER ["REQUEST_URI"], $menuValue->GetUrl () )) {
						$menuTitleArray [] = $menuValue->GetParentMenu ()->GetTitle ();
						$menuTitleArray [] = $menuValue->GetTitle ();
						break;
					}
				}
			}
			if (! empty ( $menuTitleArray )) {
				$this->view->assign ( "menuParentTitle", $menuTitleArray [0] );
				$this->view->assign ( "menuTitle", $menuTitleArray [1] );
			} else {
				$this->view->assign ( "menuParentTitle", SYSTEM_TITLE );
				$this->view->assign ( "menuTitle", "" );
			}
		}
	}
}