<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

echo '<h1>'.$Title.'</h1>';

echo $Content.'<br />';

if($bad_data == TRUE)
{
	echo '<br /><div class="alert alert-danger">'.$this->lang->line('a0967').'</div>';
}

if($pswd_send == TRUE)
{
	echo '<br /><div class="alert alert-success">'.$this->lang->line('a0968').'</div>';
}

echo '<div class="row">
  <div class="col-md-2"></div>
  <div class="col-md-8">';

echo form_open('password');

echo '<br /><strong>'.$this->lang->line('a0969').'</strong> <br />'.form_input(array('name' => 'user_email', 'id' => 'user_email', 'value' => $Fuser_email, 'class' => 'form-control')).'<br />';
echo form_error('user_email','<div class="alert alert-danger">', '</div>');


$ValuesOfImage = array(
    'word' => $RandomString,
    'img_path' => './captcha/',
    'img_url' => base_url().'/captcha/',
    'font_path' => 'arial.ttf',
    'img_width' => 200,
    'img_height' => 30,
    'class' => 'img-responsive',
    );

$CaptchaFile = create_captcha($ValuesOfImage);
echo '<div style="margin-right: auto; margin-left: auto; width: 200px;">'.$CaptchaFile['image'].'</div>';

echo '<strong>'.$this->lang->line('a0970').'</strong> <br />'.form_input(array('name' => 'user_captcha', 'id' => 'user_captcha', 'class' => 'form-control')).'<br />';
echo form_error('user_captcha','<div class="alert alert-danger">', '</div>');
echo form_hidden('formlogin','yes');
echo form_submit(array('name' => 'buttonstart', 'value' => ''.$this->lang->line('a0971').'', 'class' => 'btn btn-info btn-block'));
echo form_close();

echo '</div>
  <div class="col-md-2"></div>
</div>';

?>