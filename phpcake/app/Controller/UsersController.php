<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class UsersController extends AppController {
public $name='Users';
public $helpers = array('Form','Html','Js');
public function beforeFilter(){
	parent::beforeFilter();
}
public function index(){
	$params1 = array(
					'fields'=>array('name','gender','facebookId','beLiked'),
					'limit'=>1,
					'conditions'=>array('gender'=>'male'),
					'order'=>array('beLiked DESC')
					);
	$Users1=$this->User->find('all',$params1);
	$this->set('UsersMale',$Users1);
	$params2 = array(
					'fields'=>array('name','gender','facebookId','beLiked'),
					'limit'=>1,
					'conditions'=>array('gender'=>'female'),
					'order'=>array('beLiked DESC')
					);
	$Users2=$this->User->find('all',$params2);
	$this->set('UsersFemale',$Users2);
	$this->set('title_for_layout','the friends secret crush');
}
public function register(){
	if(!empty($this->request->data)){
		if($this->User->save($this->request->data)){
			$this->Session->setFlash('You register has success');
			$this->redirect(array('action'=>'index'));
		}
		else{
			$this->Session->setFlash('Your register didn\'t success');
		}
	
	}

}
public function login(){
	if($this->request->is('post')){
		if($this->Auth->login()){
			$this->redirect($this->Auth->redirect());
		}
		else{
			$this->Session->setFlash('your Email or password is wrong');
		}
	}
}
public function logout(){
	$this->redirect($this->Auth->logout());
}

}
?>