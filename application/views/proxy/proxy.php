<?php

echo '<ol class="breadcrumb">
<li><a href="'.base_url().'">'.$this->lang->line('a0981').'</a></li>
<li class="active">'.$this->lang->line('a1075').'</li>
</ol>';

echo '<h1>'.$Title.'</h1>';

echo $Content.'<br /><br />';

if($ProxyDeleted == 'yes')
{
	echo '<div class="alert alert-danger" role="alert">'.$this->lang->line('a1083').'</div>';    
}

$ResultDB = $this->System_model->GetProxyList();


echo '<a href="'.base_url('add-proxy').'" class="btn btn-info">'.$this->lang->line('a1077').'</a><br /><br />';

echo '<div class="row RowColor3">
  <div class="col-md-1">#</div>
  <div class="col-md-2">'.$this->lang->line('a1078').'</div>
  <div class="col-md-2">'.$this->lang->line('a1079').'</div>
  <div class="col-md-2">'.$this->lang->line('a1080').'</div>
  <div class="col-md-2">'.$this->lang->line('a1081').'</div>
  <div class="col-md-1" style="text-align: center;">'.$this->lang->line('a1117').'</div>
  <div class="col-md-2" style="text-align: right;">'.$this->lang->line('a1082').'</div>
  </div>';

$Color = 0;

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
    <div class="col-md-1">'.$row->proxy_id.'</div>
    <div class="col-md-2">'.$row->proxy_url.'</div>
    <div class="col-md-2">'.$row->proxy_port.'</div>
    <div class="col-md-2">'.$row->proxy_user.'</div>
    <div class="col-md-2">'.$row->proxy_password.'</div>
    <div class="col-md-1" style="text-align: center;">'.$row->proxy_used.'</div>
    <div class="col-md-2" style="text-align: right;"><a href="'.base_url('edit-proxy/'.$row->proxy_id).'" title="'.$this->lang->line('a1045').'" class="btn btn-info btn-xs">'.$this->lang->line('a1046').'</span></a> 
    <a href="JavaScript:DeteleInfo(\''.base_url().'proxy?delete_proxy=y&proxy_id='.$row->proxy_id.'\',\''.$this->lang->line('a1047').'\');" title="'.$this->lang->line('a1048').'" class="btn btn-danger btn-xs">'.$this->lang->line('a1049').'</a></div>
    </div>';
}

?>