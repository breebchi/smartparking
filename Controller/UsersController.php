<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
	
	
	function get_genders() {
	  	return array(
		    '0' => __('Mr.', true),
		    '1' => __('Mrs.', true),
		    '2' => __('Miss', true)
	  	);
	}
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			$this->Session->setFlash(__('Invalid user'), 'alert_error');
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'), 'alert_success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'alert_error');
			}
		}else{
				$this->Session->setFlash(__('Method Post Required. Please, try again.'), 'alert_error');
		}
		$groups = $this->User->Group->find('list');
		$locations = $this->User->Location->find('list');
		$this->set(compact('groups', 'locations'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists($id) && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid user'), 'alert_error');
			return $this->redirect(array('action' => 'index'));
		}
		if ($this->request->is(array('post', 'put')) && !empty($this->request->data)) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'), 'alert_success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'alert_error');
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$groups = $this->User->Group->find('list');
		$locations = $this->User->Location->find('list');
		$this->set(compact('groups', 'locations'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			$this->Session->setFlash(__('Invalid user'), 'alert_error');
			return $this->redirect(array('action' => 'index'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->request->is(array('post', 'put'))) {
			$this->Session->setFlash(__('Method Post Required. Please, try again.'), 'alert_error');
			return $this->redirect(array('action' => 'index'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('The user has been deleted.'), 'alert_success');
		} else {
			$this->Session->setFlash(__('The user could not be deleted. Please, try again.'), 'alert_error');
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->User->exists($id)) {
			$this->Session->setFlash(__('Invalid user'), 'alert_error');
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		$this->set('genders', $this->get_genders());
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'), 'alert_success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'alert_error');
			}
		}else{
				$this->Session->setFlash(__('Method Post Required. Please, try again.'), 'alert_error');
		}
		//$groups = $this->User->Group->find('list');
		//$locations = $this->User->Location->find('list');
		//$this->set(compact('groups', 'locations'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->set('genders', $this->get_genders());
		$this->User->id = $id;
		if (!$this->User->exists($id) && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid user'), 'alert_error');
			return $this->redirect(array('action' => 'index'));
		}
		if ($this->request->is(array('post', 'put')) && !empty($this->request->data)) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'), 'alert_success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'alert_error');
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		
		$groups = $this->User->Group->find('list');
		$locations = $this->User->Location->find('list');
		$this->set(compact('groups', 'locations'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			$this->Session->setFlash(__('Invalid user'), 'alert_error');
			return $this->redirect(array('action' => 'index'));
		}
		$this->request->allowMethod('post', 'delete');
		if (!$this->request->is(array('post', 'put'))) {
			$this->Session->setFlash(__('Method Post Required. Please, try again.'), 'alert_error');
			return $this->redirect(array('action' => 'index'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('The user has been deleted.'), 'alert_success');
		} else {
			$this->Session->setFlash(__('The user could not be deleted. Please, try again.'), 'alert_error');
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	function admin_login() {
		if(!$this->request->data){
			
		}elseif ($this->Session->read('Auth.User')) { 
	  		$this->Session->setFlash(__('You are connected!', true), 'alert_success');
	   		$this->redirect('/admin/pages/main', null, false);
	  	}else{
	   		$this->Session->setFlash(__('You are not connected!', true), 'alert_error');
	  	}
	}
 
 	function admin_logout() {
  		$this->Session->setFlash(__('You have been disconnected!', true), 'alert_success');
  		$this->Session->destroy();
  		$this->redirect($this->Auth->logout());
 	}
 	
 	
 	
 	
}
?>