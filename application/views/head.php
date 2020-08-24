<!doctype html>
<html lang="">
<head>
    <?php
    
    $UrlOfPage = base_url();
    
    $ResultDB = $this->System_model->GetSystemConfig();
    
    foreach($ResultDB->result() as $row)
    {
        $ConfigTable[$row->config_name] = $row->config_value;
    }
    
        echo '<title>'.$this->lang->line('a0937').'</title>';
    ?>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="<?php echo $UrlOfPage; ?>stylesmenu.css">
   <script src="<?php echo $UrlOfPage; ?>jquery-latest.min.js" type="text/javascript"></script>
   <script src="<?php echo $UrlOfPage; ?>script.js"></script>
   <link href="<?php echo $UrlOfPage; ?>css/bootstrap.min.css" rel="stylesheet">
   <link href="<?php echo $UrlOfPage; ?>css/bootstrap-theme.min.css" rel="stylesheet">
   <link rel="shortcut icon" href="<?php echo $UrlOfPage; ?>favicon.ico" />
   <style>
	html, body
	{
		/*font-family: 'Open Sans', sans-serif;*/
		padding: 0px;
		margin: 0px;
	}

	.container
	{
		max-width: 1000px;
		margin-left: auto;
		margin-right: auto;
	}

	.header
	{
		width: 200px;
		float: left;
        font-family: 'Open Sans', sans-serif;
	}

	.menu
	{
		max-width: 700px;
		float: right;
	}

	@media (max-width: 799px)
	{
		.menu
		{
			float: none;
			clear: both;
		}
	}

	h1
	{
		color: #49A049;
		padding: 0px;
		padding-left: 5px;
		font-weight: normal;
        font-family: 'Open Sans', sans-serif;
	}

	img 
	{
		max-width: 100%;
		height: auto;
	}
    
    div.DownloadRow
    {
        border: solid 1px #DDDDDD;
        border-radius: 5px;
        border-left: solid 5px #1B809E;
        border-right: solid 5px #1B809E;
        padding: 10px;
        text-align: center;
    }
    
    .btn-file {
        position: relative;
        overflow: hidden;
    }
    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }
    
    .RowColor1
    {
        background-color: #F9F9F9;
        padding: 5px;
    }
    
    .RowColor2
    {
        background-color: #ffffff;
        padding: 5px;
    }
    
    .RowColor3
    {
        background-color: #ffffff;
        padding: 5px;
        font-weight: bold;
    }
    
    a, a:hover, h1, h2, h3, h4
    {
        color: #1c87a8;
    }
	</style>
    <script language="JavaScript">
    function DeteleInfo(URL,Comunicate)
    {
    	if(confirm(Comunicate))
    	{
    		window.location = URL;
    	}
    }
    </script>
</head>
<body>

<div class="container" style="margin-top: 5px;">
    <div class="header" style="padding-top: 7px;">
        <div style="float: left;"><a href="<?php echo $UrlOfPage; ?>" title="phpBlueDragon GetPozition"><img src="<?php echo $UrlOfPage; ?>getpozition.png" width="35" height="35" /></a></div>
        <div style="float: left;">&nbsp;&nbsp;</div>
        <div style="float: left; margin-top: 4px;"><a href="<?php echo $UrlOfPage; ?>" style="font-weight: normal; font-size: 20px; text-decoration: none; color: #1c87a8;">PBD GetPozition</a></div>
    </div>
    <div class="menu">
        <div id="cssmenu">
        <ul>
            <?php
            
            if($this->uri->segment(1) == 'proxy')
            {
                $ImportSelect = 'class="active"';
                $SetSelected = true;
            }
            
            if($this->uri->segment(1) == 'add-proxy')
            {
	    	$ImportSelect = 'class="active"';
		$SetSelected = true;
            }
            
            if($this->uri->segment(1) == 'edit-proxy')
	    {
	    	$ImportSelect = 'class="active"';
	    	$SetSelected = true;
            }
            
            if($this->uri->segment(1) == 'change-password')
            {
                $ChangePasswordSelect = 'class="active"';
                $SetSelected = true;
            }
            
            if($this->uri->segment(1) == 'edit-email')
            {
                $EditEmailSelect = 'class="active"';
                $SetSelected = true;
            }
            
            if($this->uri->segment(1) == 'settings')
            {
                $SettingsSelect = 'class="active"';
                $SetSelected = true;
            }
            
            if($this->uri->segment(1) == 'password')
            {
                $PasswordSelect = 'class="active"';
                $SetSelected = true;
            }
            
            
            if($SetSelected == false)
            {
                $HomeSelect = 'class="active"';
            }
            
            ?>
            
            <?php
            
            if($_SESSION['user_id'] != "")
            {
                ?>
                <li <?php echo $HomeSelect; ?>><a href="<?php echo $UrlOfPage; ?>"><?php echo $this->lang->line('a0938'); ?></a></li>
                <li <?php echo $ImportSelect; ?>><a href="<?php echo $UrlOfPage; ?>proxy/"><?php echo $this->lang->line('a1074'); ?></a></li>
                <li <?php echo $ChangePasswordSelect; ?>><a href="<?php echo $UrlOfPage; ?>change-password/"><?php echo $this->lang->line('a0940'); ?></a></li>
                <li <?php echo $EditEmailSelect; ?>><a href="<?php echo $UrlOfPage; ?>edit-email/"><?php echo $this->lang->line('a0941'); ?></a></li>
                <li <?php echo $SettingsSelect; ?>><a href="<?php echo $UrlOfPage; ?>settings/"><?php echo $this->lang->line('a0942'); ?></a></li>
                <li <?php echo $ContSelect; ?>><a href="<?php echo $UrlOfPage; ?>logout/"><?php echo $this->lang->line('a0943'); ?></a></li>
                <?php
            }
            else
            {
                ?>
                <li <?php echo $HomeSelect; ?>><a href="<?php echo $UrlOfPage; ?>"><?php echo $this->lang->line('a0944'); ?></a></li>
                <li <?php echo $PasswordSelect; ?>><a href="<?php echo $UrlOfPage; ?>password/"><?php echo $this->lang->line('a0945'); ?></a></li>
                <?php
            }
            
            ?>
        </ul>
        </div>
    </div>
</div>
<div style="clear: both;"></div>
<div style="width: 100%; background-color: #ffffff; padding-top: 5px; padding-bottom: 5px;">
    <div class="container">
    
        <?php
        /*if($this->System_model->CheckLicenseExistsNoAlert() == 'yes')
        {
            $DontShow = true;
        }
        
        if(!$DontShow)
        {
            ?><div class="alert alert-warning"><?php echo $this->lang->line('licensewarning'); ?></div><?php
        }*/
        ?>
<?php
 
?>