<?php

echo '<ol class="breadcrumb">
<li><a href="'.base_url().'">'.$this->lang->line('a0981').'</a></li>
<li><a href="'.base_url('proxy').'">'.$this->lang->line('a1075').'</a></li>
<li class="active">'.$this->lang->line('a1092').'</li>
</ol>';

echo '<h1>'.$Title.'</h1>';

echo $Content.'<br /><br />';

echo form_open('edit-proxy/'.$ProxyId);

if($ProxyAdded == true)
{
	echo '<div class="alert alert-success">'.$this->lang->line('a1095').'</div>';
	//$ClearFields = true;
}

if($Vproxy_port == "")
{
	$Vproxy_port = '8080';
}

echo '<strong>'.$this->lang->line('a1086').'</strong> <br /> '.form_input(array('name' => 'proxy_url', 'id' => 'proxy_url', 'value' => $Vproxy_url, 'class' => 'form-control')).'<br />';
echo form_error('proxy_url','<div class="alert alert-danger">','</div>');

echo '<strong>'.$this->lang->line('a1087').'</strong> <br /> '.form_input(array('name' => 'proxy_port', 'id' => 'proxy_port', 'value' => $Vproxy_port, 'class' => 'form-control')).'<br />';
echo form_error('proxy_port','<div class="alert alert-danger">','</div>');

echo '<strong>'.$this->lang->line('a1088').'</strong> <br /> '.form_input(array('name' => 'proxy_user', 'id' => 'proxy_user', 'value' => $Vproxy_user, 'class' => 'form-control')).'<br />';
echo form_error('proxy_user','<div class="alert alert-danger">','</div>');

echo '<strong>'.$this->lang->line('a1089').'</strong> <br /> '.form_input(array('name' => 'proxy_password', 'id' => 'proxy_password', 'value' => $Vproxy_password, 'class' => 'form-control')).'<br />';
echo form_error('proxy_password','<div class="alert alert-danger">','</div>');

echo form_hidden('formlogin','yes');
echo form_submit(array('name' => 'buttonstart', 'value' => ''.$this->lang->line('a1094').'', 'class' => 'btn btn-info btn-block'));
echo form_close();

?>