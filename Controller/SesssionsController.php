<?php
App::uses('AppController', 'Controller');
/**
 * Sesssions Controller
 *
 * @property Sesssion $Sesssion
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class SesssionsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Sesssion->recursive = 0;
		$this->set('sesssions', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Sesssion->exists($id)) {
			throw new NotFoundException(__('Invalid sesssion'));
		}
		$options = array('conditions' => array('Sesssion.' . $this->Sesssion->primaryKey => $id));
		$this->set('sesssion', $this->Sesssion->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Sesssion->create();
			
			if ($this->Sesssion->save($this->request->data)) {
				$this->Session->setFlash(__('The sesssion has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sesssion could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Sesssion->exists($id)) {
			throw new NotFoundException(__('Invalid sesssion'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Sesssion->save($this->request->data)) {
				$this->Session->setFlash(__('The sesssion has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sesssion could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Sesssion.' . $this->Sesssion->primaryKey => $id));
			$this->request->data = $this->Sesssion->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Sesssion->id = $id;
		if (!$this->Sesssion->exists()) {
			throw new NotFoundException(__('Invalid sesssion'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Sesssion->delete()) {
			$this->Session->setFlash(__('The sesssion has been deleted.'));
		} else {
			$this->Session->setFlash(__('The sesssion could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Sesssion->recursive = 0;
		$this->set('sesssions', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Sesssion->exists($id)) {
			throw new NotFoundException(__('Invalid sesssion'));
		}
		$options = array('conditions' => array('Sesssion.' . $this->Sesssion->primaryKey => $id));
		$this->set('sesssion', $this->Sesssion->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Sesssion->create();
			if ($this->Sesssion->save($this->request->data)) {
				$this->Session->setFlash(__('The sesssion has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sesssion could not be saved. Please, try again.'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Sesssion->exists($id)) {
			throw new NotFoundException(__('Invalid sesssion'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Sesssion->save($this->request->data)) {
				$this->Session->setFlash(__('The sesssion has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sesssion could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Sesssion.' . $this->Sesssion->primaryKey => $id));
			$this->request->data = $this->Sesssion->find('first', $options);
		}
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Sesssion->id = $id;
		if (!$this->Sesssion->exists()) {
			throw new NotFoundException(__('Invalid sesssion'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Sesssion->delete()) {
			$this->Session->setFlash(__('The sesssion has been deleted.'));
		} else {
			$this->Session->setFlash(__('The sesssion could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
