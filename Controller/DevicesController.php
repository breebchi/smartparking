<?php
App::uses('AppController', 'Controller');

/**
 * Devices Controller
 *
 * @property Device $Device
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class DevicesController extends AppController {

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'Session','RequestHandler');
	public $uses = array('Device', 'Sesssion', 'Parking', 'Spot', 'Activespot', 'Car');
	public $helpers = array('Html', 'Form');

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		var_dump($this);die;
		$this->Device->recursive = 0;
		$this->set('devices', $this->Paginator->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		if (!$this->Device->exists($id)) {
			throw new NotFoundException(__('Invalid device'));
		}
		$options = array('conditions' => array('Device.' . $this->Device->primaryKey => $id));
		$this->set('device', $this->Device->find('first', $options));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Device->create();
			if ($this->Device->save($this->request->data)) {
				$this->Session->setFlash(__('The device has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The device could not be saved. Please, try again.'));
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
		if (!$this->Device->exists($id)) {
			throw new NotFoundException(__('Invalid device'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Device->save($this->request->data)) {
				$this->Session->setFlash(__('The device has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The device could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Device.' . $this->Device->primaryKey => $id));
			$this->request->data = $this->Device->find('first', $options);
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
		$this->Device->id = $id;
		if (!$this->Device->exists()) {
			throw new NotFoundException(__('Invalid device'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Device->delete()) {
			$this->Session->setFlash(__('The device has been deleted.'));
		} else {
			$this->Session->setFlash(__('The device could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	/**
	 * admin_index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this->Device->recursive = 0;
		$this->set('devices', $this->Paginator->paginate());
	}

	/**
	 * admin_view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		if (!$this->Device->exists($id)) {
			throw new NotFoundException(__('Invalid device'));
		}
		$options = array('conditions' => array('Device.' . $this->Device->primaryKey => $id));
		$this->set('device', $this->Device->find('first', $options));
	}

	/**
	 * admin_add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Device->create();
			if ($this->Device->save($this->request->data)) {
				$this->Session->setFlash(__('The device has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The device could not be saved. Please, try again.'));
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
		if (!$this->Device->exists($id)) {
			throw new NotFoundException(__('Invalid device'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Device->save($this->request->data)) {
				$this->Session->setFlash(__('The device has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The device could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Device.' . $this->Device->primaryKey => $id));
			$this->request->data = $this->Device->find('first', $options);
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
		$this->Device->id = $id;
		if (!$this->Device->exists()) {
			throw new NotFoundException(__('Invalid device'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Device->delete()) {
			$this->Session->setFlash(__('The device has been deleted.'));
		} else {
			$this->Session->setFlash(__('The device could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}


	/*private function setSession($Consumer) {
		$otp = $this->getKey($device['Device']['device_token']);
		$uniqueOtp = true;
		while($uniqueOtp){
		$session = $this->Device->Sesssion->find('first', array('conditions'=>array('Sesssion.otp' => $otp)));
		if(!empty($session)){
		$otp = $this->getKey($device['Device']['device_token']);
		}else{
		$uniqueOtp = false;
		}
		}
		$session = $this->Device->Sesssion->find('first', array('conditions'=>array('Sesssion.device_id' => $device['Device']['id'])));
		if(empty($session)){
		$data =  array('Sesssion' => array(
		'device_id' => $device['Device']['id'],
		'otp' => $otp,
		'last_login' => date("Y-m-d H:i:s"),
		'last_logout' => date("Y-m-d H:i:s")
		)
		);
		$this->Device->Sesssion->create();
		$this->Device->Sesssion->saveAll($data);
		}else{
		$this->Device->Sesssion->saveAll(array('Sesssion' => array('id' => $session['Sesssion']['id'], 'device_id' => $device['Consumer']['id'], 'otp' => $otp, 'last_login' => date('Y-m-d H:i:s'))));
		}
		$result = array('otp' => $otp);
		return $result;
		}*/


	/*----------------------------------JSON--------------------------------*/

	// api consumer

	// api login


	public function json_login () {
		if($this->request->is('post')) {
			//$post['username'] = $this->request->data['Device']['username'];
			//$post['password'] = $this->request->data['Device']['password'];
			$post['username'] = $this->request->data['username'];
			$post['password'] = $this->request->data['password'];
			//$data['hash'] = $this->Auth->password($post['password']);
			//return new CakeResponse(array('body' => json_encode($data, JSON_NUMERIC_CHECK)));
			$check = $this->Device->find('first',
			array(
    'conditions' => array(
    'username' => $post['username'],
    'password' => $post['password']

			)
			)
			);
			//return new CakeResponse(array('body' => json_encode($check, JSON_NUMERIC_CHECK)));
			$save = array();
			$return = array();
			if($check) {
				$save['device_id'] = $check['Device']['id'];
				$save['token'] = $this->Auth->password($post['username'].date('dmY'));
				$save['last_login'] = date('Y-m-d H:i:s');
				if($this->Sesssion->save($save)) {
					$return['device_id'] = $save['device_id'];
					$return['token'] = $save['token'];
					$return['last_login'] = $save['last_login'];
					$return['username'] = $check['Device']['username'];
					$condition = array('device_id' => $save['device_id'],'token'=>$save['token']);
					$data=$this->Sesssion->find('first', array('conditions'=>$condition));
					//return new CakeResponse(array('body' => json_encode($data, JSON_NUMERIC_CHECK)));
					$newdata = array(
	            	'Device' => array(
	                'id' => $data['Sesssion']['device_id'],
	                'session_id' => $data['Sesssion']['id']
					)
					);
					$this->Device->save($newdata);

					//$this->Device->save(array('id' => $save['device_id'] , 'session_id'=> $this->Sesssion->getLastInsertId()));
					$return['session_id'] = $check['Device']['session_id'];
				} else {

					//$condition = array('device_id' => $save['device_id']);
					//$data=$this->Sesssion->find('first', array('conditions'=>$condition));


					$return['responseCode'] = 400;
					$return['message'] = "We couldn't log you in, it may be because you are already logged-in, try forcing your way through using the joint TOKEN";
					//$return['token'] = $data['token'];
					//$return = $data;
				}
			} else {
					$return['responseCode'] = 401;
					$return['message'] = "the credentials you entered are invalid, please verify your credentials or register";
					$return['wrong'] = "wrong";
					$return['pusername'] = $post['username'];
					$return['ppassword'] = $post['password'];

			}
		}
		return new CakeResponse(array('body' => json_encode($return, JSON_NUMERIC_CHECK)));

	}


	

	// api logout made by me
	public function json_logout() {
		$errors = array();
		if ($this->request->is('post'))
		{
			//$hash = $this->Auth->password($this->request->data['Device']['password']);
			//$password = $this->request->data['Device']['password'];
			$device_id = $this->request->data['device_id'];
			$token = $this->request->data['token'];
			if($this->authenticateMobile($device_id, $token))
			{
				
				$this->deleteSession($device_id, $token);
					/*$newdata = array(		//I wrote this commented stuff trying to put session_id
					 'Device' => array(		//down to null in Device after logout
					 'id' => $data['Sesssion']['device_id'],   //I ended-up disregarding it as
					 'session_id' => null));		//I couldnt modify the field without adding a new record
					 $this->Device->save($newdata, false);*/
					$output['responseCode'] = 200 ;
					$output['message'] = "session deleted"	;
				
			}else{
				$output['responseCode'] = 401 ;
				$output['message'] = "you are not logged-in to begin with";
			}

		}else{
			$errors['error'] = __('Methode post required');
			$output = array('response' => $this->getError(__('Error', true), 405, $errors));
		}

		return new CakeResponse(array('body' => json_encode($output, JSON_NUMERIC_CHECK)));
	}


	
	
	//delete session by device_id and token
	public function deleteSession($device_id, $token){
				$condition = array('device_id' => $device_id,'token'=>$token);
				$data=$this->Sesssion->find('all', array('conditions'=>$condition));
				if($this->Sesssion->delete($data[0]['Sesssion']['id'], false))
				return true;
	}
	
	
	
	
	//check if auth by token and device id
	public function authenticateMobile($device_id, $token) {
		return $this->Sesssion->find('first',
		array(
    'conditions' => array(
    'device_id' => $device_id,
    'token' => $token
		)
		)
		);
	}


public function json_checklogin() {
	$errors = array();
		if ($this->request->is('post'))
		{
		$device_id = $this->request->data['device_id'];
		$token = $this->request->data['token'];

		 if($this->authenticateMobile($device_id, $token))
			{
			// 	$check = $this->Sesssion->find('first',
			// array(
   //  'conditions' => array(
   //  'token' => $token,
   //  'device_id' => $device_id)));

			// 	$return['token'] = $check['Sesssion']['token'];
			// 	$return['device_id'] = $check['Sesssion']['device_id'];
				$return['responseCode'] = 200;
				$return['message'] = "you are logged in";
			}else{

				$return['responseCode'] = 401;
				$return['message'] = "you are not logged in";

			}
			
		}else{
			$errors['error'] = __('Methode post required');
			$return = array('response' => $this->getError(__('Error', true), 405, $errors));
		}
			return new CakeResponse(array('body' => json_encode($return, JSON_NUMERIC_CHECK)));
	}


	// api register made by me

	public function json_register() {
		if ($this->request->is('post')) {
			$username = $this->request->data['username'];
			$password = $this->request->data['password'];
			$email = $this->request->data['email'];
			$save = array();
			$save['Device']['username'] = $username;
			$save['Device']['password'] = $password;
			$save['Device']['email'] = $email;
				
			//$output = $this->Device->save($save);
			//return new CakeResponse(array('body' => json_encode($output, JSON_NUMERIC_CHECK)));
			if(!$this->isRegistered($username, $password, $email)){
					
				if($this->Device->save($save)) {
					$output["responseCode"] = 200 ;
					$output["message"] = "You are now registered, please login" ;
				}
					
			}else{
				$output["responseCode"] = 401 ;
					$output["message"] = "You are already registered, please login" ;
			}
		}else{
			$errors['error'] = __('Methode post required');
			$output = array('response' => $this->getError(__('Error', true), 405, $errors));
		}
		return new CakeResponse(array('body' => json_encode($output, JSON_NUMERIC_CHECK)));

	}

	//check if registered
	public function isRegistered($username, $password, $email) {
		return $this->Device->find('first',
		array(
    'conditions' => array(
    'username' => $username,
    'password' => $password,
    'email' => $email
		)
		)
		);
	}

		//api user password edition
	public function json_passwordedit(){
		if ($this->request->is('post'))
		{
			//$hash = $this->Auth->password($this->request->data['Device']['password']);
			//$password = $this->request->data['Device']['password'];
			$device_id = $this->request->data['device_id'];
			$token = $this->request->data['token'];
			$newpassword = $this->request->data['newpassword'];
			$password = $this->request->data['password'];
			$condition = array('id' => $device_id);
			$data=$this->Device->find('all', array('conditions'=>$condition));
			if($this->authenticateMobile($device_id, $token))
			{
				if($data[0]['Device']['password']= $password)
				{
					$newdata = array(
            	'Device' => array(
                'id' => $device_id,
                'password' => $newpassword
					)
					);
					$this->Device->save($newdata);
					//$this->Device->updateAll(array('Device.password' => $newpassword), array('Device.id' => $device_id));
					$output = "Your new password have been set" ;
				}else{
					$output="The old password you entered is wrong";
				}
			}else{
				$output="You are not logged in";
			}
		}else{
			$errors['error'] = __('Methode post required');
			$output = array('response' => $this->getError(__('Error', true), 405, $errors));
		}

		return new CakeResponse(array('body' => json_encode($output, JSON_NUMERIC_CHECK)));
	}


	//asks for a spot and gets it if the parking is not full
	public function json_access(){
		if ($this->request->is('post'))
		{
			$device_id = $this->request->data['device_id'];
			$token = $this->request->data['token'];
			$parking_id = $this->request->data['parking_id'];
			$condition = array('id' => $parking_id);
			$data=$this->Parking->find('all', array('conditions'=>$condition));
			if($this->authenticateMobile($device_id, $token))
			{
				if(!$data[0]['Parking']['status']= 0)
				{
					$data=$this->getSpot($parking_id) ;
					$output = $data['Spot'];
				}else{
					$output['responseCode']=201;
					$output['message']="This parking is full";
				}
			}else{
				$output['responseCode']=400;
				$output['message']="You are not logged in";
				
			}
		}else{
			$errors['error'] = __('Methode post required');
			$output = array('response' => $this->getError(__('Error', true), 405, $errors));
		}

		return new CakeResponse(array('body' => json_encode($output, JSON_NUMERIC_CHECK)));
	}
	
	//seeks the first free spot in the DB table. This table is arranged from closest to to farthest from inGate
	Public function getSpot($parking_id)
	{
		return $this->Spot->find('first',
		array(
    	'conditions' => array(
    	'parking_id' => $parking_id,
    	//'activespot_id' => null
    	'status' => 0
		)
		)
		);
	}

	//declares that the car is on the designated spot and creates a record of it in the DB table Activespots
	public function json_onspot(){
		if ($this->request->is('post'))
		{
			$device_id = $this->request->data['device_id'];
			$token = $this->request->data['token'];
			$parking_id = $this->request->data['parking_id'];
			$spot_id = $this->request->data['spot_id'];
			$car_id = $this->request->data['car_id'];
			$condition = array('id' => $spot_id,'parking_id' => $parking_id);
			$data=$this->Spot->find('all', array('conditions'=>$condition));
			if($this->authenticateMobile($device_id, $token))
			{
				$newdata = array(
            		'Activespot' => array(
                	'spot_id' => $spot_id,
                	'parking_id' => $parking_id,
					'entry_date' => date('Y-m-d H:i:s')	
				)
				);
				$this->Activespot->save($newdata);
				$condition = array('spot_id' => $spot_id,'parking_id'=>$parking_id);
				$data=$this->Activespot->find('all', array('conditions'=>$condition));
				//return new CakeResponse(array('body' => json_encode($data, JSON_NUMERIC_CHECK)));
				$newdata = array(
            		'Spot' => array(
                	'id' => $spot_id,
                	'device_id' => $device_id,
					//'activespot_id' => $data[0]['Activespot']['id'],
					'status' => 0
					
				)
				);
				$this->Spot->save($newdata);
				
				$this->Car->updateAll(array('Car.activespot_id' => $data[0]['Activespot']['id']), array('Car.id' => $car_id));
				$output = $data;
			}else{
				$output="You are not logged in";
			}
		}else{
			$errors['error'] = __('Methode post required');
			$output = array('response' => $this->getError(__('Error', true), 405, $errors));
		}
		return new CakeResponse(array('body' => json_encode($output, JSON_NUMERIC_CHECK)));
	}


	public function json_addcar(){
		if ($this->request->is('post'))
		{
			$device_id = $this->request->data['device_id'];
			$token = $this->request->data['token'];
			$license_plate = $this->request->data['license_plate'];
			if($this->authenticateMobile($device_id, $token))
			{
				$newdata = array(
            		'Car' => array(
                	'device_id' => $device_id,
                	'license_plate' => $license_plate,	
				)
				);
				$condition = array('device_id' => $device_id,'license_plate'=>$license_plate);
				$data=$this->Car->find('all', array('conditions'=>$condition));
				if(empty($data))
				{
					if($this->Car->save($newdata)){
					$condition = array('device_id' => $device_id,'license_plate'=>$license_plate);
					$data=$this->Car->find('all', array('conditions'=>$condition));
					$output = $data[0];
					}
				}else{
					$output= "car and device already associated";
				}
			}else{
				$output="You are not logged in";
			}
		}else{
			$errors['error'] = __('Methode post required');
			$output = array('response' => $this->getError(__('Error', true), 405, $errors));
		}

		return new CakeResponse(array('body' => json_encode($output, JSON_NUMERIC_CHECK)));
	}

	
	public function json_EntryGateStatus(){
		if ($this->request->is('post'))
		{
			$device_id = $this->request->data['device_id'];
			$token = $this->request->data['token'];
			$parking_id = $this->request->data['parking_id'];
			if($this->authenticateMobile($device_id, $token))
			{
				//command to be sent to RPi
				$output = "open in-gate command sent to RPi";
			}else{
				$output="You are not logged in";
			}
		}else{
			$errors['error'] = __('Methode post required');
			$output = array('response' => $this->getError(__('Error', true), 405, $errors));
		}

		return new CakeResponse(array('body' => json_encode($output, JSON_NUMERIC_CHECK)));
	}
	
	
	public function json_ExitGateStatus(){
		if ($this->request->is('post'))
		{
			$device_id = $this->request->data['device_id'];
			$token = $this->request->data['token'];
			$parking_id = $this->request->data['parking_id'];
			$spot_id = $this->request->data['spot_id'];
			if($this->authenticateMobile($device_id, $token))
			{
				//command to be sent to RPi
				
				$this->Spot->updateAll(array('Spot.status' => 0), array('Spot.id' => $spot_id));
				//$this->Spot->updateAll(array('Spot.activespot_id' => 0), array('Spot.id' => $spot_id));
				$condition = array('spot_id' => $spot_id,'parking_id'=>$parking_id);
				$data=$this->Activespot->find('all', array('conditions'=>$condition));
				$this->Activespot->delete($data[0]['Activespot']['id'], false);
				$output = "open out-gate command sent to RPi and spot freed";
			}else{
				$output="You are not logged in";
			}
		}else{
			$errors['error'] = __('Methode post required');
			$output = array('response' => $this->getError(__('Error', true), 405, $errors));
		}

		return new CakeResponse(array('body' => json_encode($output, JSON_NUMERIC_CHECK)));
	}

	
	
	private function getResponse($status = 'Success', $code, $result = null) {
		$response = array(
	 				'status' => $status,
	 				'code' => $code,
	 				'result' => $result
		);
		return $response;
	}

	private function getError($status = 'Error', $code, $errors = null) {
		$error = array(
	 				'status' => $status,
	 				'code' => $code,
	 				'errors' => $errors
		);
		return $error;
	}
	
	/////////////////////// json_login ////////////////////////////
	
	/*public function json_login() {
		App::import('Model', 'Sesssion');
		$this->loadModel('Sesssion');
		App::import('Model', 'Device');
		$this->loadModel('Device');
		$errors = array();
		//var_dump($this);die;
		if ($this->request->is('post')) {
		//$Consumer = $this->Consumer->find('first', array('conditions'=>array('Consumer.android_registration_id' =>$this->data['Consumer']['android_registration_id'])));
		$device = $this->Device->find('first', array('conditions'=>array('Device.android_registration_id' =>$this->request->data['Device']['android_registration_id'])));
		//var_dump($device);
		if(!empty($device))
		{
		$this->setSession($device);
			
		var_dump($device);
		$output = json_encode(array('response' => $this->getResponse(__('Success', true), 200, $device)));
		}else
		{
		/*if (!empty($Consumer))
		{
		$this->setSession($Consumer);
		$Consumer = $this->Consumer->find('first', array('conditions'=>array('Consumer.id' => $Consumer['Consumer']['id'])));
		$output = json_encode(array('response' => $this->getResponse(__('Success'), 200, $Consumer['Sesssion']['otp'])));
		}else{*
		$errors['error'] = __('Login failure: unknown phone number.');
		$output = json_encode(array('response' => $this->getResponse(__('Error'), 203,$errors)));
		//}
		}
		}else{
		$errors['error'] = __('Methode post required');
		$output = json_encode(array('response' => $this->getError(__('Error', true), 405, $errors)));
		//$response = $output;
		//$this->set('response_code', $response->code);
		//$this->set('response_body', $response->body);
		}
		$this->set('output', $output);
		//$this->render('/Layouts/json/json');
		//$this -> render('/Consumer/request_response');
		}*/
	
	
/////////////////////// json_register ////////////////////////////
	
	/*public function json_register() {
		App::import('Controller', 'PutData');
		$putData = new PutDataController();
		App::import('Model','KnownConsumer');
		$this->loadModel('KnownConsumer');
		$errors = array();
		if ($this->request->is('post'))
		{
		$sms_code = $this->getKey($this->getKey('', 6,'num'), 6,'num');
		$uniqueCode = true;
		while($uniqueCode)
		{
		$consumer_test = $this->Consumer->find('first', array('conditions'=>array('Consumer.sms_code' => $sms_code)));
		if(!empty($consumer_test)){
		$sms_code = $this->getKey($this->getKey('', 6,'num'), 6,'num');
		}else{
		$uniqueCode = false;
		}
		}
		$this->Consumer->create();
		$Consumer = array('Consumer' => array(
		'phone_number' =>$this->request->data['Consumer']['phone_number'],
		'country_code' =>$this->request->data['Consumer']['country_code'],
		'device_token' =>$this->request->data['Consumer']['device_token'],
		'sms_code' => $sms_code,
		'active'=>0,
		)
		);
		if($this->Consumer->saveAll($Consumer))
		{
		$to = $Consumer["Consumer"]["country_code"].$Consumer["Consumer"]["phone_number"];
		if(!empty($to) && !empty($sms_code)){
		$putData->SendSms($to, $sms_code);
		$output = json_encode(array('response' => $this->getResponse(__('Success', true), 200, __('Success'))));
		}
		else{
		$fields = $this->Consumer->invalidFields();
		$keys = array_keys($fields);
		$errors['error'] = $fields[$keys[0]][0];
		$output = json_encode(array('response' => $this->getError(__('Error', true), 203, $errors)));
		}
			
		}else{
		$fields = $this->Consumer->invalidFields();
		$keys = array_keys($fields);
		$errors['error'] = $fields[$keys[0]][0];
		$output = json_encode(array('response' => $this->getError(__('Error', true), 203, $errors)));
		}

		}else{
		$errors['error'] = __('Methode post required');
		$output = json_encode(array('response' => $this->getError(__('Error', true), 405, $errors)));
		}
		$this->set('output', $output);
		$this->render('/Layouts/json/json');
		}*/
	
	
/////////////////////// json_register 2////////////////////////////	
	
	/*public function json_register() {
		App::import('Controller', 'PutData');
		$putData = new PutDataController();
		App::import('Model','KnownConsumer');
		$this->loadModel('KnownConsumer');
		App::import('Model', 'Consumer');
		$this->loadModel('Consumer');
		$errors = array();
		if ($this->request->is('post'))
		{
		//$consumer = $this->Consumer->find('first', array('conditions'=>array('Consumer.phone_number' => $this->request->data['Consumer']['phone_number'])));
		//$knownconsumer = $this->KnownConsumer->find('first', array('conditions'=>array('KnownConsumer.phone_number' => $this->request->data['Consumer']['phone_number'])));
		//if(!empty($knownconsumer))
		//{
		//$output = json_encode(array('response' => $this->getResponse(__('Success', true), 200, $knownconsumer)));
		//}else
		//{
		//if(!empty($consumer))
		//{
		//$output = json_encode(array('response' => $this->getResponse(__('Success', true), 200, $consumer)));
		//}else
		//{
		$sms_code = $this->getKey($this->getKey('', 6,'num'), 6,'num');
		$uniqueCode = true;
		while($uniqueCode)
		{
		$consumer_test = $this->Consumer->find('first', array('conditions'=>array('Consumer.sms_code' => $sms_code)));
		if(!empty($consumer_test)){
		$sms_code = $this->getKey($this->getKey('', 6,'num'), 6,'num');
		}else{
		$uniqueCode = false;
		}
		}
		$this->Consumer->create();
		$Consumer = array('Consumer' => array(
		'phone_number' =>$this->request->data['Consumer']['phone_number'],
		'country_code' =>$this->request->data['Consumer']['country_code'],
		'device_token' =>$this->request->data['Consumer']['device_token'],
		'sms_code' => $sms_code,
		'active'=>0,
		)
		);
		if($this->Consumer->saveAll($Consumer))
		{
		$to = $Consumer["Consumer"]["country_code"].$Consumer["Consumer"]["phone_number"];
		if(!empty($to) && !empty($sms_code)){
		$putData->SendSms($to, $sms_code,$Consumer["Consumer"]["country_code"]);
		$output = json_encode(array('response' => $this->getResponse(__('Success', true), 200, __('Success'))));
		}
		else{
		$fields = $this->Consumer->invalidFields();
		$keys = array_keys($fields);
		$errors['error'] = $fields[$keys[0]][0];
		$output = json_encode(array('response' => $this->getError(__('Error', true), 203, $errors)));
		}
			
		}else{
		$fields = $this->Consumer->invalidFields();
		$keys = array_keys($fields);
		$errors['error'] = $fields[$keys[0]][0];
		$output = json_encode(array('response' => $this->getError(__('Error', true), 203, $errors)));
		//	}
		//	}
		}

		}else{
		$errors['error'] = __('Methode post required');
		$output = json_encode(array('response' => $this->getError(__('Error', true), 405, $errors)));
		}
		$this->set('output', $output);
		$this->render('/Layouts/json/json');
		}*/
}
?>



