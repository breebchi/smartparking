<?php
App::uses('Controller', 'Controller');


class AppController extends Controller {
	
	
	///////////////////////////////////////////////////////////////////////////////////////////////
	
	
	/**
 * Post Model
 *
 * @var Post
 */
 var $Post;

/**
 * User Model
 *
 * @var User
 */
 var $User;

 /**
 * Group Model
 *
 * @var Group
 */
 var $Group;
 
 /**
 * AuthComponent
 *
 * @var AuthComponent
 */
 var $Auth;
 
 /**
 * SessionComponent
 *
 * @var SessionComponent
 */
 var $Session;
 
  /**
 * RequestHandlerComponent
 *
 * @var RequestHandlerComponent
 */
 var $RequestHandler;
 
  /**
 * CategoryComponent
 *
 * @var CategoryComponent
 */
 var $Category;
 
 /**
 * PageComponent
 *
 * @var PageComponent
 */
 var $Page;
 
	
	///////////////////////////////////////////////////////////////////////////////////////////////
	
	public $helpers = array('Html', 'Form', 'Js' => array('Jquery'), 'Session', 'Paginator', 'Ajax', 'Javascript', 'Text', 'Xml', 'Tree', 'XmlTree', 'Time');
	
	public $components = array('Auth', 'RequestHandler', 'Session', 'Email', 'Thumb');
	
	public $ajax = array(
		'update' => '#main-content',
		'evalSripts' => true,
		'before' => 'ajax_before(XMLHttpRequest);', 
		'complete' => 'ajax_complete(XMLHttpRequest, textStatus);',
        'success' => 'ajax_success(XMLHttpRequest, textStatus);',
        'error' => 'ajax_error();'
	);
	
	public function isAuthorized() {
	    throw new ForbiddenException(__('You are not authorized to access.'));
	}
	
	public function beforeFilter(){
		parent::beforeFilter();
		
		if(isset($this->Security) && $this->action == 'admin_login'){
			$this->Security->csrfCheck = false;
			$this->Security->enabled = false;
		}
		/////////////////////////
	if(in_array($this->params['controller'],array('RestSpots'))){
        // For RESTful web service requests, we check the name of our contoller
        $this->Auth->allow();
        // this line should always be there to ensure that all rest calls are secure
        /* $this->Security->requireSecure(); */
        $this->Security->unlockedActions = array('edit','delete','add','view');
         
    }else{
        // setup out Auth
        $this->Auth->allow();        
    }
    /////////////////////////
		//user active 
		 $this->Auth->authenticate = 
		 array( 
         AuthComponent::ALL => array('userModel' => 'User', 'scope' => array("User.active" => 1)),
         'Form');
                                        
		if(!isset($this->request->params['prefix']) || $this->request->params['prefix'] != 'admin')
		{
			$this->Auth->allow();
		} else {
			if($this->Session->read('Auth.User') != null)
			{
			}
			$this->Auth->allow(array('display'));
			$this->Auth->logoutRedirect = '/admin/users/login';
			$this->Auth->loginRedirect = '/admin/pages/main';
			$this->set('Auth', $this->Auth->login());
		}
		$this->Auth->autoRedirect = true;
		$this->Auth->loginAction = array(
			'controller' => 'users',
			'action' => 'login',
			'plugin' => false,
			'admin' => true
		);
		$this->Auth->loginError = __('Login failed. Invalid username or password');
		$this->Auth->authError = __('You are not alloawed to access this content, please login');
		$this->Auth->fields = array('username' => 'username', 'password' => 'password');
	}
	
	public function  beforeRender(){
		parent::beforeRender();
		$this->set('ajax', $this->ajax);
		if(isset($this->params['prefix']) && $this->params['prefix'] == 'admin'){
		   if ($this->RequestHandler->isAjax() || $this->layout == 'ajax') {
		    $this->layout = 'ajax';
		   } else {
		    $this->layout = 'admin';
		   }
  		} else {
			if ($this->RequestHandler->isAjax() || $this->layout == 'ajax') {
	    		$this->layout = 'ajax';
	   		} else if(isset($this->request->params['prefix'])){
	    		$this->layout = $this->request->params['prefix'];
	   		} else if($this->layout != 'xml/default' && $this->layout != 'rss/default' && $this->layout != 'json/default') {
	  	 	}
  		}
		if($this->Session->read('Auth.User') != null)
		{
			$this->set('User', $this->Session->read('Auth.User'));
			
		}	
		
	}
	
	public function on_req_mob_auth()
	{
	$authed = false;
// you might put some standard authentication for browser use here
if($authed == false) {
if($this->request->is('post') && $this->request->data('token') && $this->request->data('hash')) {
App::uses('Device', 'Model');
$this->Device = new Device;
$this->mobile = $this->Device->authenticateMobile($this->request->data('hash'),$this->request->data('token'));
}
}	
	}
	

}
?>
