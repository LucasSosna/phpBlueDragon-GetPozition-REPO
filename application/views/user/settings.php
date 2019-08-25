<?php

/**
 * @author Lukasz Sosna
 * @copyright 2016
 */

echo '<ol class="breadcrumb">
<li><a href="'.base_url().'">'.$this->lang->line('a0974').'</a></li>
<li class="active">'.$this->lang->line('a0975').'</li>
</ol>';

echo '<h1>'.$Title.'</h1>';

echo $Content.'<br /><br />';

echo validation_errors('<div class="alert alert-danger">','</div>');

if($content_added == true)
{
    echo '<div class="alert alert-success">'.$this->lang->line('a0976').'</div>';
}

$OptionsList[1] = '1';
$OptionsList[2] = '2';
$OptionsList[3] = '3';
$OptionsList[4] = '4';
$OptionsList[5] = '5';
$OptionsList[6] = '6';
$OptionsList[7] = '7';
$OptionsList[8] = '8';
$OptionsList[9] = '9';
$OptionsList[10] = '10';
/*$OptionsList[20] = '20';
$OptionsList[30] = '30';
$OptionsList[40] = '40';
$OptionsList[50] = '50';
$OptionsList[100] = '100';*/
 
$OptionsListGoogle['pl'] = 'PL';
$OptionsListGoogle['com'] = 'COM';

echo '<div class="row">
  <div class="col-md-2"></div>
  <div class="col-md-8">';
  
echo form_open('settings');

//echo '<strong>'.$this->lang->line('a0977').'</strong> <br />'.form_input(array('name' => 'title', 'id' => 'title', 'class' => 'form-control', 'value' => $Ctitle)).'<br />';
echo '<strong>'.$this->lang->line('a0978').'</strong> <br />'.form_input(array('name' => 'root_email', 'id' => 'root_email', 'class' => 'form-control', 'value' => $Croot_email)).'<br />';
echo '<strong>'.$this->lang->line('a1116').'</strong> <br />'.form_dropdown('google', $OptionsListGoogle, $Cgoogle, 'class="form-control"').'<br />';
echo '<strong>'.$this->lang->line('a1118').'</strong> <br />'.form_dropdown('cron', $OptionsList, $Ccron, 'class="form-control"').'<br />';

echo form_hidden('addpage','yes');
echo form_submit(array('name' => 'buttonstart', 'value' => ''.$this->lang->line('a0980').'', 'class' => 'btn btn-info btn-block'));
echo form_close();

echo '</div>
  <div class="col-md-2"></div>
</div>';

?>