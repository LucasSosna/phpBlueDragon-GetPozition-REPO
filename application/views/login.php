<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author:    Lukasz Sosna
 * @e-mail:    lukasz.bluedragon@gmail.com
 * @www:       http://phpbluedragon.pl
 * @copyright: 10-7-2015 18:45
 *
 */
 
echo '<h1>'.$Title.'</h1>';

echo $Content.'<br />';

if($bad_data == TRUE)
{
	echo '<br /><div class="alert alert-danger" role="alert">'.$this->lang->line('a0946').'</div>';	
}

echo '<div class="row">
  <div class="col-md-2"></div>
  <div class="col-md-8">';

echo form_open('login');
echo '<br /><strong>'.$this->lang->line('a0947').'</strong> <br /> '.form_input(array('name' => 'user_email', 'id' => 'user_email', 'class' => 'form-control')).'<br />';
echo form_error('user_email','<div class="alert alert-danger">', '</div>');
echo '<strong>'.$this->lang->line('a0948').'</strong> <br /> '.form_password(array('name' => 'user_password', 'id' => 'user_password', 'class' => 'form-control')).' <br />';
echo form_error('user_password','<div class="alert alert-danger">', '</div>');
echo form_hidden('formlogin','yes');
echo form_submit(array('name' => 'buttonstart', 'value' => ''.$this->lang->line('a0949').'', 'class' => 'btn btn-info btn-block'));
echo form_close();

echo '</div>
  <div class="col-md-2"></div>
</div>';

?>