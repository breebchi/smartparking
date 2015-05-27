<?php
App::uses('AppController', 'Controller');
/**
 * Cars Controller
 *
 * @property Car $Car
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CarsController extends AppController {

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
		$this->Car->recursive = 0;
		$this->set('cars', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Car->exists($id)) {
			throw new NotFoundException(__('Invalid car'));
		}
		$options = array('conditions' => array('Car.' . $this->Car->primaryKey => $id));
		$this->set('car', $this->Car->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Car->create();
			if ($this->Car->save($this->request->data)) {
				$this->Session->setFlash(__('The car has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The car could not be saved. Please, try again.'));
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
		if (!$this->Car->exists($id)) {
			throw new NotFoundException(__('Invalid car'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Car->save($this->request->data)) {
				$this->Session->setFlash(__('The car has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The car could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Car.' . $this->Car->primaryKey => $id));
			$this->request->data = $this->Car->find('first', $options);
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
		$this->Car->id = $id;
		if (!$this->Car->exists()) {
			throw new NotFoundException(__('Invalid car'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Car->delete()) {
			$this->Session->setFlash(__('The car has been deleted.'));
		} else {
			$this->Session->setFlash(__('The car could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Car->recursive = 0;
		$this->set('cars', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Car->exists($id)) {
			throw new NotFoundException(__('Invalid car'));
		}
		$options = array('conditions' => array('Car.' . $this->Car->primaryKey => $id));
		$this->set('car', $this->Car->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Car->create();
			if ($this->Car->save($this->request->data)) {
				$this->Session->setFlash(__('The car has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The car could not be saved. Please, try again.'));
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
		if (!$this->Car->exists($id)) {
			throw new NotFoundException(__('Invalid car'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Car->save($this->request->data)) {
				$this->Session->setFlash(__('The car has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The car could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Car.' . $this->Car->primaryKey => $id));
			$this->request->data = $this->Car->find('first', $options);
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
		$this->Car->id = $id;
		if (!$this->Car->exists()) {
			throw new NotFoundException(__('Invalid car'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Car->delete()) {
			$this->Session->setFlash(__('The car has been deleted.'));
		} else {
			$this->Session->setFlash(__('The car could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
