<h1>Welcome to register</h1>
<?php
echo $this->Form->create('User',array('action'=>'register'));
echo $this->Form->input('Email');
echo $this->Form->input('Password',array('type'=>'password'));
echo $this->Form->input('Password confirmation',array('type'=>'password'));
echo $this->Form->end('Register');
?>