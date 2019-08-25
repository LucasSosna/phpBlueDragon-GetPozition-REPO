<?php

echo '<ol class="breadcrumb">
<li><a href="'.base_url().'">'.$this->lang->line('a0950').'</a></li>
<li class="active">'.$this->lang->line('a0951').'</li>
</ol>';

echo '<h1>'.$Title.'</h1>';

echo $Content.'<br /><br />';

echo form_open('change-password');

if($PswdChangedError == true)
{
    echo '<div class="alert alert-danger">'.$this->lang->line('a0952').'</div>';   
}

if($PswdChanged == true)
{
    echo '<div class="alert alert-success">'.$this->lang->line('a0953').'</div>';
}

echo '<div class="row">
  <div class="col-md-2"></div>
  <div class="col-md-8">';
  
echo '<strong>'.$this->lang->line('a0954').'</strong> <br />'.form_password(array('name' => 'user_pswd', 'id' => 'user_pswd', 'class' => 'form-control')).'<br />';
echo form_error('user_pswd','<div class="alert alert-danger">', '</div>');
echo '<strong>'.$this->lang->line('a0955').'</strong> <br />'.form_password(array('name' => 'user_pswd2', 'id' => 'user_pswd2', 'class' => 'form-control')).'<br />';
echo form_error('user_pswd2','<div class="alert alert-danger">', '</div>');
echo '<strong>'.$this->lang->line('a0956').'</strong> <br />'.form_password(array('name' => 'user_pswd3', 'id' => 'user_pswd3', 'class' => 'form-control')).'<br />';
echo form_error('user_pswd3','<div class="alert alert-danger">', '</div>');
echo form_hidden('formchange','yes');
echo form_submit(array('name' => 'changepassword', 'value' => ''.$this->lang->line('a0957').'', 'class' => 'btn btn-info btn-block'));
echo form_close();

echo '</div>
  <div class="col-md-2"></div>
</div>';

?>