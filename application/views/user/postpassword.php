<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

echo '<h1>'.$Title.'</h1>';

echo $Content.'<br />';

if($change_password)
{
    echo '<br /><div class="alert alert-success">'.$this->lang->line('a0972').'</div>';
}
else
{
    echo '<br /><div class="alert alert-danger">'.$this->lang->line('a0973').'</div>';
}

?>