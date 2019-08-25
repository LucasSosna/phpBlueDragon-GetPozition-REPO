<?php

echo '<ol class="breadcrumb">
<li><a href="'.base_url().'">'.$this->lang->line('a0981').'</a></li>
<li><a href="'.base_url().'">'.$this->lang->line('a0982').'</a></li>
<li class="active">'.$this->lang->line('a0983').'</li>
</ol>';

echo '<h1>'.$Title.'</h1>';

if($this->System_model->CheckLicenseExists() == 'yes')
{
    $SystemCanAdd = true;
}
else
{
    $ResultDB = $this->System_model->GetHowManyProject();
    
    $HowManyProjects = 0;
    
    foreach($ResultDB->result() as $row)
    {
        $HowManyProjects = $row->HowMany;   
    }
    
    if($HowManyProjects == 0)
    {
        $SystemCanAdd = true;
    }   
    else
    {
        $SystemCanAdd = false;
    }     
    
}

if($SystemCanAdd)
{
    echo $Content.'<br /><br />';
    
    if($IsAdded)
    {
        echo '<div class="alert alert-success">'.$this->lang->line('a0984').'</div>';
        $ClearFields = true;
    }
    
    $OptionsList[1] = '1 '.$this->lang->line('a0985').'';
    $OptionsList[2] = '2 '.$this->lang->line('a0985').'';
    $OptionsList[3] = '3 '.$this->lang->line('a0985').'';
    $OptionsList[4] = '4 '.$this->lang->line('a0985').'';
    $OptionsList[5] = '5 '.$this->lang->line('a0985').'';
    $OptionsList[6] = '6 '.$this->lang->line('a0985').'';
    $OptionsList[7] = '7 '.$this->lang->line('a0985').'';
    $OptionsList[8] = '8 '.$this->lang->line('a0985').'';
    $OptionsList[9] = '9 '.$this->lang->line('a0985').'';
    $OptionsList[10] = '10 '.$this->lang->line('a0985').'';
    
    echo form_open('add');
    
    echo '<strong>'.$this->lang->line('a0986').'</strong> <br /> '.form_input(array('name' => 'project_name', 'id' => 'project_name', 'value' => $Vproject_name, 'class' => 'form-control')).'<br />';
    echo form_error('project_name','<div class="alert alert-danger">','</div>');
    
    /*echo '<strong>'.$this->lang->line('a0987').'</strong> <br /> '.form_textarea(array('name' => 'project_brief', 'id' => 'project_brief', 'value' => $Vproject_brief, 'class' => 'form-control')).'<br />';
    echo form_error('project_brief','<div class="alert alert-danger">','</div>');*/
    
    echo '<strong>'.$this->lang->line('a0988').'</strong> 
    <div class="alert alert-warning alert-dismissable">'.$this->lang->line('a0989').'</div>
     '.form_input(array('name' => 'project_href', 'id' => 'project_href', 'value' => $Vproject_href, 'class' => 'form-control')).'<br />';
    echo form_error('project_href','<div class="alert alert-danger">','</div>');
    
    $IsChecked = false;
    if($this->input->post('project_email') == 'y')
    {
        $IsChecked = true;
    }
    
    if($ClearFields)
    {
        $IsChecked = false;
    }
    
    //echo form_checkbox(array('name' => 'project_email', 'id' => 'project_email', 'value' => 'y', 'checked' => $IsChecked)).' <strong>'.$this->lang->line('a0990').'</strong><br />';
    
    /*echo '<br /><strong>'.$this->lang->line('a0991').'</strong> <br /> '.form_dropdown('project_long', $OptionsList, $Fproject_long, 'class="form-control"').'<br />';
    echo form_error('project_long','<div class="alert alert-danger">','</div>');*/
    
    echo '<br />';
    
    echo form_hidden('formlogin','yes');
    echo form_submit(array('name' => 'buttonstart', 'value' => ''.$this->lang->line('a0992').'', 'class' => 'btn btn-info btn-block'));
    echo form_close();
}
else
{
    echo '<div class="alert alert-danger">'.$this->lang->line('a1071').'</div>';
}

?>