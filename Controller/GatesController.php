<?php
App::uses('AppController', 'Controller');
/**
 * Gates Controller
 *
 * @property Gate $Gate
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class GatesController extends AppController {

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
		$this->Gate->recursive = 0;
		$this->set('gates', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Gate->exists($id)) {
			throw new NotFoundException(__('Invalid gate'));
		}
		$options = array('conditions' => array('Gate.' . $this->Gate->primaryKey => $id));
		$this->set('gate', $this->Gate->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Gate->create();
			if ($this->Gate->save($this->request->data)) {
				$this->Session->setFlash(__('The gate has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The gate could not be saved. Please, try again.'));
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
		if (!$this->Gate->exists($id)) {
			throw new NotFoundException(__('Invalid gate'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Gate->save($this->request->data)) {
				$this->Session->setFlash(__('The gate has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The gate could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Gate.' . $this->Gate->primaryKey => $id));
			$this->request->data = $this->Gate->find('first', $options);
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
		$this->Gate->id = $id;
		if (!$this->Gate->exists()) {
			throw new NotFoundException(__('Invalid gate'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Gate->delete()) {
			$this->Session->setFlash(__('The gate has been deleted.'));
		} else {
			$this->Session->setFlash(__('The gate could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Gate->recursive = 0;
		$this->set('gates', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Gate->exists($id)) {
			throw new NotFoundException(__('Invalid gate'));
		}
		$options = array('conditions' => array('Gate.' . $this->Gate->primaryKey => $id));
		$this->set('gate', $this->Gate->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Gate->create();
			if ($this->Gate->save($this->request->data)) {
				$this->Session->setFlash(__('The gate has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The gate could not be saved. Please, try again.'));
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
		if (!$this->Gate->exists($id)) {
			throw new NotFoundException(__('Invalid gate'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Gate->save($this->request->data)) {
				$this->Session->setFlash(__('The gate has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The gate could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Gate.' . $this->Gate->primaryKey => $id));
			$this->request->data = $this->Gate->find('first', $options);
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
		$this->Gate->id = $id;
		if (!$this->Gate->exists()) {
			throw new NotFoundException(__('Invalid gate'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Gate->delete()) {
			$this->Session->setFlash(__('The gate has been deleted.'));
		} else {
			$this->Session->setFlash(__('The gate could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
