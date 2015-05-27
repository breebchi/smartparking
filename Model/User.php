<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 */
class User extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'username';
public function beforeSave($options = array()) {
  parent::beforeSave($options);
  if (!empty($this->data[$this->alias]['password'])) {
   $params = array(
    'conditions' => array(
     'User.id' => $this->data[$this->alias]['id'],
   )
   );
   $user = $this->find('first', $params);
   if ($user['User']['password'] != $this->data[$this->alias]['password']){
    $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
   }
  }
  //$this->data[$this->alias]['token'] = $this->getKey();
  return true;
 }
}
