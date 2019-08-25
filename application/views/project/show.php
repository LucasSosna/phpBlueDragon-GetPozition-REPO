<?php

echo '<ol class="breadcrumb">
<li><a href="'.base_url().'">'.$this->lang->line('a1036').'</a></li>
<li class="active">'.$this->lang->line('a1037').'</li>
</ol>';

echo '<h1>'.$Title.'</h1>';

echo $Content.'<br /><br />';

if($ProjectDeleted)
{
    echo '<div class="alert alert-danger" role="alert">'.$this->lang->line('a1038').'</div>';    
}

$ResultDB = $this->System_model->GetSystemConfig();

foreach($ResultDB->result() as $row)
{
	$ConfigTable[$row->config_name] = $row->config_value;
}

$SortColumn = $ConfigTable['column'];
$SortOrder = $ConfigTable['order'];

$AddDataSort = false;

if($this->input->get('column') != "")
{
    $SortColumn = $this->input->get('column');
    $AddDataSort = true;
}

if($this->input->get('order') != "")
{
    $SortOrder = $this->input->get('order');
    $AddDataSort = true;
}

if($AddDataSort)
{
    $this->System_model->UpdateSort($SortColumn,$SortOrder);
}

$ResultDB = $this->System_model->GetProjectListSort($SortColumn,$SortOrder);

if($SortColumn == 'project_id'){ if($SortOrder == 'asc'){ $LinkIdASC = ' style="font-weight: bold; " '; } else { $LinkIdDESC = ' style="font-weight: bold; " '; } } 	
if($SortColumn == 'project_href'){ if($SortOrder == 'asc'){ $LinkHrefASC = ' style="font-weight: bold; " '; } else { $LinkHrefDESC = ' style="font-weight: bold; " '; } } 	
if($SortColumn == 'project_name'){ if($SortOrder == 'asc'){ $LinkNameASC = ' style="font-weight: bold; " '; } else { $LinkNameDESC = ' style="font-weight: bold; " '; } } 	
if($SortColumn == 'project_lastcheck'){ if($SortOrder == 'asc'){ $LinkLastASC = ' style="font-weight: bold; " '; } else { $LinkLastDESC = ' style="font-weight: bold; " '; } }
if($SortColumn == 'project_long'){ if($SortOrder == 'asc'){ $LinkLongASC = ' style="font-weight: bold; " '; } else { $LinkLongDESC = ' style="font-weight: bold; " '; } }
        
echo '<a href="'.base_url('add').'" class="btn btn-info">'.$this->lang->line('a1039').'</a><br /><br />';

// <div class="col-md-2" style="text-align: center;">'.$this->lang->line('a1042').' <a href="'.base_url('?column=project_lastcheck&order=asc').'" '.$LinkLastASC.'>&uarr;</a> <a href="'.base_url('?column=project_lastcheck&order=desc').'" '.$LinkLastDESC.'>&darr;</a></div>

echo '<div class="row RowColor3">
  <div class="col-md-1"># <a href="'.base_url('?column=project_id&order=asc').'" '.$LinkIdASC.'>&uarr;</a> <a href="'.base_url('?column=project_id&order=desc').'" '.$LinkIdDESC.'>&darr;</a></div>
  <div class="col-md-4">'.$this->lang->line('a1041').' <a href="'.base_url('?column=project_name&order=asc').'" '.$LinkNameASC.'>&uarr;</a> <a href="'.base_url('?column=project_name&order=desc').'" '.$LinkNameDESC.'>&darr;</a></div>
  <div class="col-md-3">'.$this->lang->line('a1072').' <a href="'.base_url('?column=project_href&order=asc').'" '.$LinkHrefASC.'>&uarr;</a> <a href="'.base_url('?column=project_href&order=desc').'" '.$LinkHrefDESC.'>&darr;</a></div>
  <div class="col-md-2" style="text-align: center;">'.$this->lang->line('a1073').' <a href="'.base_url('?column=project_keys&order=asc').'" '.$LinkLongASC.'>&uarr;</a> <a href="'.base_url('?column=project_keys&order=desc').'" '.$LinkLongDESC.'>&darr;</a></div>
  <div class="col-md-2" style="text-align: right;">'.$this->lang->line('a1044').'</div>
  </div>';
  
/*echo '<table>';
echo '<tr>
    <td>ID <a href="'.base_url('?column=project_id&order=asc').'" '.$LinkIdASC.'>&uarr;</a> <a href="'.base_url('?column=project_id&order=desc').'" '.$LinkIdDESC.'>&darr;</a></td>
    <td>Szczegóły <a href="'.base_url('?column=project_name&order=asc').'" '.$LinkNameASC.'>&uarr;</a> <a href="'.base_url('?column=project_name&order=desc').'" '.$LinkNameDESC.'>&darr;</a></td>
    <td>Nazwa <a href="'.base_url('?column=project_href&order=asc').'" '.$LinkHrefASC.'>&uarr;</a> <a href="'.base_url('?column=project_href&order=desc').'" '.$LinkHrefDESC.'>&darr;</a></td>
    <td>Ostatnie sprawdzenie <a href="'.base_url('?column=project_lastcheck&order=asc').'" '.$LinkLastASC.'>&uarr;</a> <a href="'.base_url('?column=project_lastcheck&order=desc').'" '.$LinkLastDESC.'>&darr;</a></td>
    <td>Sprawdzanie co dni <a href="'.base_url('?column=project_long&order=asc').'" '.$LinkLongASC.'>&uarr;</a> <a href="'.base_url('?column=project_long&order=desc').'" '.$LinkLongDESC.'>&darr;</a></td>
    <td>Edytuj</td>
    <td>Usuń</td>
    </tr>';*/
    
$Color = 0;

// <div class="col-md-2" style="text-align: center;">'.$row->project_lastcheck.'</div>

foreach($ResultDB->result() as $row)
{
    if($Color == 0)
    {
        echo '<div class="row RowColor1">';
        $Color = 1;
    }
    else
    {
        echo '<div class="row RowColor2">';
        $Color = 0;
    }
    
    echo '
    <div class="col-md-1">'.$row->project_id.'</div>
    <div class="col-md-4"><a href="'.base_url('details/'.$row->project_id).'">'.$row->project_name.'</a></div>
    <div class="col-md-3">'.$row->project_href.'</div>
    <div class="col-md-2" style="text-align: center;">'.$row->project_keys.'</div>
    <div class="col-md-2" style="text-align: right;"><a href="'.base_url('edit/'.$row->project_id).'" title="'.$this->lang->line('a1045').'" class="btn btn-info btn-xs">'.$this->lang->line('a1046').'</span></a> 
    <a href="JavaScript:DeteleInfo(\''.base_url().'delete/'.$row->project_id.'\',\''.$this->lang->line('a1047').'\');" title="'.$this->lang->line('a1048').'" class="btn btn-danger btn-xs">'.$this->lang->line('a1049').'</a></div>
    </div>';
}

/*
echo '</table>';
*/

?>