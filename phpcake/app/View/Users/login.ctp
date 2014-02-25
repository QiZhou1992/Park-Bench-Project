<h1>It is a website for secret crush</h1>
<h2>login</h2>
<?php
echo $this->Form->create();
echo $this->Form->input('Email');
echo $this->Form->input('Password',array('type'=>'password'));
echo $this->Form->end('login');
?>

