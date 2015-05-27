<?php
class RestSpotsController extends AppController {
    public $uses = array('Spot');
    public $helpers = array('Html', 'Form');
    public $components = array('RequestHandler');
 
 
    public function index() {
        //var_dump($this);die;
    	$spots = $this->Spot->find('all');
        $this->set(array(
            'spots' => $spots,
            '_serialize' => array('spots')
        ));
    }
 
    public function add() {
        $this->Spot->create();
        if ($this->Spot->save($this->request->data)) {
             $message = 'Created';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }
     
    public function view($id) {
        $spot = $this->Spot->findById($id);
        $this->set(array(
            'spot' => $spot,
            '_serialize' => array('spot')
        ));
    }
 
     
    public function edit($id) {
        $this->Spot->id = $id;
        if ($this->Spot->save($this->request->data)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }
     
    public function delete($id) {
        if ($this->Spot->delete($id)) {
            $message = 'Deleted';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }
}       