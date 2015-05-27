<?php
App::uses('HttpSocket', 'Network/Http');
class ConsumerController extends AppController {
	public $components = array('Security', 'RequestHandler');
	 
	public function index(){
		 
	}

	public function request_index(){
		 
		// remotely post the information to the server
		$link =  "http://" . $_SERVER['HTTP_HOST'] . $this->webroot.'devices/json_login.json';
		 
		$data = null;
		$httpSocket = new HttpSocket();
		$response = $httpSocket->get($link, $data );
		//var_dump($response);
		$this->set('response_code', $response->code);
		$this->set('response_body', $response->body);
		 
		$this -> render('/Client/request_response');
	}
	 
	public function request_view($id){
		 
		// remotely post the information to the server
		$link =  "http://" . $_SERVER['HTTP_HOST'] . $this->webroot.'rest_spots/'.$id.'.json';

		$data = null;
		$httpSocket = new HttpSocket();
		$response = $httpSocket->get($link, $data );
		$this->set('response_code', $response->code);
		$this->set('response_body', $response->body);
		 
		$this -> render('/Client/request_response');
	}
	 
	public function request_edit($id){
		 
		// remotely post the information to the server
		$link =  "http://" . $_SERVER['HTTP_HOST'] . $this->webroot.'rest_spots/'.$id.'.json';

		$data = null;
		$httpSocket = new HttpSocket();
		$data['Spot']['id'] = 'Updated Spot id';
		$data['Spot']['spot_name'] = 'Updated Spot Name';
		$data['Spot']['spot_domain'] = 'Updated Spot Domain';
		$data['Spot']['status'] = 'Updated Spot status';
		$response = $httpSocket->put($link, $data );
		$this->set('response_code', $response->code);
		$this->set('response_body', $response->body);
		 
		$this -> render('/Client/request_response');
	}
	 
	public function request_add(){
		 
		// remotely post the information to the server
		$link =  "http://" . $_SERVER['HTTP_HOST'] . $this->webroot.'rest_spots.json';

		$data = null;
		$httpSocket = new HttpSocket();
		$data['Spot']['id'] = 22;
		$data['Spot']['spot_name'] = 'New Spot Name';
		$data['Spot']['spot_domain'] = 'New Spot Domain';
		$data['Spot']['status'] = 'New Spot status';
		$response = $httpSocket->post($link, $data );
		$this->set('response_code', $response->code);
		$this->set('response_body', $response->body);
		 
		$this -> render('/Client/request_response');
	}
	 
	public function request_delete($id){
		 
		// remotely post the information to the server
		$link =  "http://" . $_SERVER['HTTP_HOST'] . $this->webroot.'rest_spots/'.$id.'.json';

		$data = null;
		$httpSocket = new HttpSocket();
		$response = $httpSocket->delete($link, $data );
		$this->set('response_code', $response->code);
		$this->set('response_body', $response->body);
		 
		$this -> render('/Client/request_response');
	}

	public function request_login(){
		 
		// remotely post the information to the server
		//$link =  "http://" . $_SERVER['HTTP_HOST'] . $this->webroot.'devices/login.json';
		$link = "http://smartparking/json/devices/login";

		$data = null;
		$httpSocket = new HttpSocket();
		//$data['Device']['username'] = "rami3";
		//$data['Device']['password'] = "rami0";
		$data['username'] = "rami";
		$data['password'] = "rami";
		var_dump($data);
		$response = $httpSocket->post($link, $data );
		$this->set('response_code', $response->code);
		$this->set('response_body', $response->body);

		$this -> render('/consumer/request_response');
	}

	
	
	public function request_logout(){
		 
		// remotely post the information to the server
		//$link =  "http://" . $_SERVER['HTTP_HOST'] . $this->webroot.'devices/login.json';
		$link = "http://smartparking/json/devices/logout";

		$data = null;
		$httpSocket = new HttpSocket();
		$data['Sesssion']['device_id'] = "1";
		$data['Sesssion']['token'] = "5b9378bb441575e709dbb4fc49fef7025e4938ae";
		$response = $httpSocket->post($link, $data );
		$this->set('response_code', $response->code);
		$this->set('response_body', $response->body);

		$this -> render('/consumer/request_response');
	}

	public function request_register(){
		 
		// remotely post the information to the server
		//$link =  "http://" . $_SERVER['HTTP_HOST'] . $this->webroot.'devices/login.json';
		$link = "http://smartparking/json/devices/register";

		$data = null;
		$httpSocket = new HttpSocket();
		$data['Device']['username'] = "az";
		$data['Device']['password'] = "az";
		$data['Device']['email'] = "email.az";
		$response = $httpSocket->post($link, $data );
		$this->set('response_code', $response->code);
		$this->set('response_body', $response->body);

		$this -> render('/consumer/request_response');
	}
	
	public function request_passwordedit(){
		 
		// remotely post the information to the server
		//$link =  "http://" . $_SERVER['HTTP_HOST'] . $this->webroot.'devices/login.json';
		$link = "http://smartparking/json/devices/passwordedit";

		$data = null;
		$httpSocket = new HttpSocket();
		$data['Sesssion']['device_id'] = "5";
		$data['Sesssion']['token'] = "256fe1c31331fc91730358858e103d9888b7740b";
		$data['Device']['password'] = "rami3";
		$data['Device']['newpassword'] = "rami0";
		$response = $httpSocket->post($link, $data );
		$this->set('response_code', $response->code);
		$this->set('response_body', $response->body);

		$this -> render('/consumer/request_response');
	}

	public function request_access(){
		 
		// remotely post the information to the server
		//$link =  "http://" . $_SERVER['HTTP_HOST'] . $this->webroot.'devices/login.json';
		$link = "http://smartparking/json/devices/access";

		$data = null;
		$httpSocket = new HttpSocket();
		$data['Sesssion']['device_id'] = "5";
		$data['Sesssion']['token'] = "256fe1c31331fc91730358858e103d9888b7740b";
		$data['Parking']['id'] = "1";
		$response = $httpSocket->post($link, $data );
		$this->set('response_code', $response->code);
		$this->set('response_body', $response->body);

		$this -> render('/consumer/request_response');
	}
	
	public function request_onspot(){
		 
		// remotely post the information to the server
		//$link =  "http://" . $_SERVER['HTTP_HOST'] . $this->webroot.'devices/login.json';
		$link = "http://smartparking/json/devices/onspot";

		$data = null;
		$httpSocket = new HttpSocket();
		$data['Sesssion']['device_id'] = "5";
		$data['Sesssion']['token'] = "256fe1c31331fc91730358858e103d9888b7740b";
		$data['Parking']['id'] = "1";
		$data['Spot']['id'] = "2";
		$data['Car']['id'] = "9";
		$response = $httpSocket->post($link, $data );
		$this->set('response_code', $response->code);
		$this->set('response_body', $response->body);

		$this -> render('/consumer/request_response');
	}
	
public function request_addcar(){
		 
		// remotely post the information to the server
		//$link =  "http://" . $_SERVER['HTTP_HOST'] . $this->webroot.'devices/login.json';
		$link = "http://smartparking/json/devices/addcar";

		$data = null;
		$httpSocket = new HttpSocket();
		$data['Sesssion']['device_id'] = "5";
		$data['Sesssion']['token'] = "256fe1c31331fc91730358858e103d9888b7740b";
		$data['Car']['license_plate'] = "bgjb";
		$response = $httpSocket->post($link, $data );
		$this->set('response_code', $response->code);
		$this->set('response_body', $response->body);

		$this -> render('/consumer/request_response');
	}
	
	public function request_openingate(){
		 
		// remotely post the information to the server
		//$link =  "http://" . $_SERVER['HTTP_HOST'] . $this->webroot.'devices/login.json';
		$link = "http://smartparking/json/devices/openingate";

		$data = null;
		$httpSocket = new HttpSocket();
		$data['Sesssion']['device_id'] = "5";
		$data['Sesssion']['token'] = "256fe1c31331fc91730358858e103d9888b7740b";
		$data['Parking']['id'] = "1";
		$response = $httpSocket->post($link, $data );
		$this->set('response_code', $response->code);
		$this->set('response_body', $response->body);

		$this -> render('/consumer/request_response');
	}
	
	public function request_openoutgate(){
		 
		// remotely post the information to the server
		//$link =  "http://" . $_SERVER['HTTP_HOST'] . $this->webroot.'devices/login.json';
		$link = "http://smartparking/json/devices/openoutgate";

		$data = null;
		$httpSocket = new HttpSocket();
		$data['Sesssion']['device_id'] = "5";
		$data['Sesssion']['token'] = "256fe1c31331fc91730358858e103d9888b7740b";
		$data['Parking']['id'] = "1";
		$data['Spot']['id']= "2";
		$response = $httpSocket->post($link, $data );
		$this->set('response_code', $response->code);
		$this->set('response_body', $response->body);

		$this -> render('/consumer/request_response');
	}
	
}