<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class User extends AppModel {
	var $name = 'User';
	public $components = array(
		'Session',
		'Auth',
		'Security'
	
	);
	var $validate =array(
		'Email'=>array(
		'Email is not blank'=>array(
			'rule'=>'notEmpty',
			'message'=>'The email should not be empty'
		),
		'Email is not valid'=>array(
			'rule'=>'email',
			'message'=>'The email is not valid a email'
		),
		'Email is not unique'=>array(
			'rule'=>'isUnique',
			'message'=>'This email has been used'
		)
		),
		'Password'=>array(
		'password\'s length'=>array(
			'rule'=>array('between',8,15),
			'message'=>'the password has between 8 character and 15 character'
		),
		'password match'=>array(
			'rule'=>'MatchPassword',
			'message'=>'Your password must match password confirmation '
		)
		),
		'Password confirmation'=>array(
			'password confirmation is empty'=>array(
				'rule'=>'notEmpty',
				'message'=>'password confirmation is empty'
			)
		)
	);
	public function MatchPassword($data){
	 if($data['Password']==$this->data['User']['Password confirmation']){
		return true;
	 }
	   $this->invalidate('Password confirmation','Your password must match password confirmation ');
		return false;
	}
	public function beforeSave($options = array()) {
    if (isset($this->data['User']['password'])) {
        $passwordHasher = $this->Auth->passwordHasher($this->data['User']['password']);
        $this->data['User']['password'] =$passwordHasher;
        };
    return true;
}

}
?>