<?php
App::uses('AppController', 'Controller');
/**
 * Parkings Controller
 *
 * @property Parking $Parking
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ParkingsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session','RequestHandler');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->set('parkings', $this->Parking->find('all'));
		$this->Parking->recursive = 0;
		$this->set('parkings', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Parking->exists($id)) {
			throw new NotFoundException(__('Invalid parking'));
		}
		$options = array('conditions' => array('Parking.' . $this->Parking->primaryKey => $id));
		$this->set('parking', $this->Parking->find('first', $options));
		
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Parking->create();
			if ($this->Parking->save($this->request->data)) {
				$this->Session->setFlash(__('The parking has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The parking could not be saved. Please, try again.'));
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
		if (!$this->Parking->exists($id)) {
			throw new NotFoundException(__('Invalid parking'));
		}
		if ($this->request->is(array('parking', 'put'))) {
			if ($this->Parking->save($this->request->data)) {
				$this->Session->setFlash(__('The parking has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The parking could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Parking.' . $this->Parking->primaryKey => $id));
			$this->request->data = $this->Parking->find('first', $options);
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
		$this->Parking->id = $id;
		if (!$this->Parking->exists()) {
			throw new NotFoundException(__('Invalid parking'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Parking->delete()) {
			$this->Session->setFlash(__('The parking has been deleted.'));
		} else {
			$this->Session->setFlash(__('The parking could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Parking->recursive = 0;
		$this->set('parkings', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Parking->exists($id)) {
			throw new NotFoundException(__('Invalid parking'));
		}
		$options = array('conditions' => array('Parking.' . $this->Parking->primaryKey => $id));
		$this->set('parking', $this->Parking->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Parking->create();
			if ($this->Parking->save($this->request->data)) {
				$this->Session->setFlash(__('The parking has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The parking could not be saved. Please, try again.'));
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
		if (!$this->Parking->exists($id)) {
			throw new NotFoundException(__('Invalid parking'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Parking->save($this->request->data)) {
				$this->Session->setFlash(__('The parking has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The parking could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Parking.' . $this->Parking->primaryKey => $id));
			$this->request->data = $this->Parking->find('first', $options);
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
		$this->Parking->id = $id;
		if (!$this->Parking->exists()) {
			throw new NotFoundException(__('Invalid parking'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Parking->delete()) {
			$this->Session->setFlash(__('The parking has been deleted.'));
		} else {
			$this->Session->setFlash(__('The parking could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
