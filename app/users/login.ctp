<?php
echo $session->flash('auth');
echo $form->create('User',array('action' => 'login'));
echo $form->input('username',array('label' => 'Login','div'=>'boxed'));
echo $form->input('password', array('label' => 'Senha','div'=>'boxed'));
echo $form->end('Entrar',array('id'=>'login_submit'));
?>

