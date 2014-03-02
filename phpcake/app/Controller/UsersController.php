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
App::import('vendor','Facebook',array('file'=>'facebook.php'));

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
public $components = array('Paginator');
public $paginate = array(
        'limit' => 10
);
public $helpers = array('Form','Html','Js','Paginator');
public function beforeFilter(){
	parent::beforeFilter();
	$this->loadModel('friend');
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
			$this->redirect(array('controller'=>'Users','action'=>'index'));
		}
		else{
			$this->Session->setFlash('your Email or password is wrong');
		}
	}
}
public function logout(){
	$this->redirect($this->Auth->logout());
}
public function connectFacebook(){
	 $config = array(
    'appId' => '492159944228947',
    'secret' => '0e2a701f336a22e90cfdb452b0f4765f',
    'allowSignedRequest' => false // 
    );
	$facebook=new Facebook($config);
	$facebook_user=$facebook->getUser();
	if(!$facebook_user){
	$facebook_login=$facebook->getLoginUrl( array(
                       'scope' => 'publish_stream,create_event'
                       ));
	$this->redirect($facebook_login);
	$facebook->setExtendedAccessToken();
	}
	else{
	$params = array(
	        'method' => 'fql.query',
	        'query' => "SELECT name,sex FROM user WHERE uid={$facebook_user}"
	         );
	$result = $facebook->api($params);
	$currentUser=$this->Auth->user();
	$id=$currentUser['id'];
	$this->User->read(NULL,39);
	$this->User->set(array('facebookId'=>$facebook_user,'name'=>$result[0]['name'],'gender'=>$result[0]['sex'],'id'=>$id,'accessToken'=>$facebook->getAccessToken()));
	$result=$facebook->api('/me/friends','get');
	$data=$result['data'];
	foreach($data as $person){
	$savedata=array('name'=>$person['name'],'facebookId'=>$person['id'],'accessToken'=>$facebook->getAccessToken());
	$this->friend->save($savedata);
	}
	$this->paginate = array('limit'=>5,'condition'=>array('accessToken'=>$facebook->getAccessToken()));
	$this->redirect(array('controller'=>'Users','action'=>'index'));
	}

}
public function chooseLike(){
	$currentUser=$this->Auth->user();
	$id=$currentUser['id'];
		$params1 = array(
					'fields'=>array('name','gender','facebookId','accessToken'),
					'limit'=>1,
					'conditions'=>array('id'=>$id),
					);
	$TheUser=$this->User->find('all',$params1);
	if(strlen($TheUser[0]['User']['accessToken'])<5){
	$this->redirect(array('controller'=>'Users','action'=>'connectFacebook'));
	}
	else{
	$this->Paginator->settings=array('limit'=>5,'condition'=>array('accessToken'=>$TheUser[0]['User']['accessToken']));
	$this->set('result',$this->paginate('friend'));
	}
}

}
?>