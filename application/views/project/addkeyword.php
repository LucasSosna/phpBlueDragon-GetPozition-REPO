<?php

echo '<ol class="breadcrumb">
<li><a href="'.base_url().'">'.$this->lang->line('a1006').'</a></li>
<li><a href="'.base_url().'">'.$this->lang->line('a1007').'</a></li>
<li><a href="'.base_url('details/'.$ProjectId).'">'.$ProjectName.'</a></li>
<li class="active">'.$this->lang->line('a1105').'</li>
</ol>';

echo '<h1>'.$Title.'</h1>';

echo $Content.'<br /><br />';

echo form_open('add-keyword/'.$ProjectId);

if($IsAdded == true)
{
	echo '<div class="alert alert-success">'.$this->lang->line('a1108').'</div>';
	$ClearFields = true;
}

echo '<strong>'.$this->lang->line('a1106').'</strong> <br /> '.form_input(array('name' => 'keyword_keyword', 'id' => 'keyword_keyword', 'value' => $Vkeyword_keyword, 'class' => 'form-control')).'<br />';
echo form_error('keyword_keyword','<div class="alert alert-danger">','</div>');


echo form_hidden('formlogin','yes');
echo form_submit(array('name' => 'buttonstart', 'value' => ''.$this->lang->line('a1107').'', 'class' => 'btn btn-info btn-block'));
echo form_close();

?>