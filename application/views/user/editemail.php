<?php

echo '<ol class="breadcrumb">
<li><a href="'.base_url().'">'.$this->lang->line('a0958').'</a></li>
<li class="active">'.$this->lang->line('a0959').'</li>
</ol>';

echo '<h1>'.$Title.'</h1>';

echo $Content.'<br /><br />';

if($EmailUpdated)
{
    echo '<div class="alert alert-success">'.$this->lang->line('a0960').'</div>';    
}

echo form_open('edit-email');

echo '<h4>'.$this->lang->line('a0961').'</h4>';
echo '<hr class="alt short">';
echo '<div class="alert alert-warning alert-dismissable">'.nl2br($Femail_desc1).'</div>';
echo '<strong>'.$this->lang->line('a0964').'</strong> <br /> '.form_input(array('name' => 'email_title1', 'id' => 'email_title1', 'value' => $Femail_title1, 'class' => 'form-control')).'<br />';
echo form_error('email_title1','<div class="alert alert-danger">', '</div>');
echo '<strong>'.$this->lang->line('a0965').'</strong> <br /> '.form_textarea(array('name' => 'email_content1', 'id' => 'email_content1', 'style' => 'width:100%; height: 250px;', 'value' => $Femail_content1, 'class' => 'form-control')).'<br />';
echo form_error('email_content1','<div class="alert alert-danger">', '</div>');

echo '<h4>'.$this->lang->line('a0962').'</h4>';
echo '<hr class="alt short">';
echo '<div class="alert alert-warning alert-dismissable">'.nl2br($Femail_desc2).'</div>';
echo '<strong>'.$this->lang->line('a0964').'</strong> <br /> '.form_input(array('name' => 'email_title2', 'id' => 'email_title2', 'value' => $Femail_title2, 'class' => 'form-control')).'<br />';
echo form_error('email_title2','<div class="alert alert-danger">', '</div>');
echo '<strong>'.$this->lang->line('a0965').'</strong> <br /> '.form_textarea(array('name' => 'email_content2', 'id' => 'email_content2', 'style' => 'width:100%; height: 250px;', 'value' => $Femail_content2, 'class' => 'form-control')).'<br />';
echo form_error('email_content2','<div class="alert alert-danger">', '</div>');

/*echo '<h4>'.$this->lang->line('a0963').'</h4>';
echo '<hr class="alt short">';
echo '<div class="alert alert-warning alert-dismissable">'.nl2br($Femail_desc3).'</div>';
echo '<strong>'.$this->lang->line('a0964').'</strong> <br /> '.form_input(array('name' => 'email_title3', 'id' => 'email_title3', 'value' => $Femail_title3, 'class' => 'form-control')).'<br />';
echo form_error('email_title3','<div class="alert alert-danger">', '</div>');
echo '<strong>'.$this->lang->line('a0965').'</strong> <br /> '.form_textarea(array('name' => 'email_content3', 'id' => 'email_content3', 'style' => 'width:100%; height: 250px;', 'value' => $Femail_content3, 'class' => 'form-control')).'<br />';
echo form_error('email_content3','<div class="alert alert-danger">', '</div>');*/

echo form_hidden('formlogin','yes');
echo form_submit(array('name' => 'zaloguj', 'value' => ''.$this->lang->line('a0966').'', 'class' => 'btn btn-info btn-block'));
echo form_close();

echo '<br /><br /><br />';

?>