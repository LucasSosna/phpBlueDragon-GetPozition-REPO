<?php

echo '<ol class="breadcrumb">
<li><a href="'.base_url().'">'.$this->lang->line('a1006').'</a></li>
<li><a href="'.base_url().'">'.$this->lang->line('a1007').'</a></li>
<li class="active">'.$ProjectName.'</li>
</ol>';

?>
<style>
div.containerStats
{
	clear:both;
	margin-right: auto;
	margin-left: auto;
}

div.smallStats
{
    float:left;
    width:25px;
    border-left: solid 1px #000000;
    border-right: solid 1px #000000;
    border-bottom: solid 1px #000000;
    border-top: solid 1px #000000;
    text-align: center;
    height: 30px;
    padding-top: 4px; 
    
}

</style>
<?php

echo '<h1>'.$Title.': '.$ProjectName.'</h1>';

echo $Content.'<br /><br />';

if($ProjectDeleted)
{
	echo '<div class="alert alert-danger" role="alert">'.$this->lang->line('a1101').'</div>';    
}

echo '<a href="'.base_url('add-keyword/'.$ProjectId).'" class="btn btn-info">'.$this->lang->line('a1102').'</a><br /><br />';

$ResultDB = $this->System_model->GetKeyword($ProjectId);

$Ketwords = null;

foreach($ResultDB->result() as $row)
{
	$IsThis = true;
	
	$Keywords[] = $row->keyword_id;
	$KeywordsShow[] = $row->keyword_keyword;
}

if(!$IsThis)
{
	echo '<div class="alert alert-success">'.$this->lang->line('a1096').'</div>';
}
else
{
	$ResultDB = $this->System_model->GetKeywordStats($Keywords,$ProjectDate,$SortColumn,$SortOrder);
	
	//echo '<pre>';
	//print_r($ResultDB);
	//echo '</pre>';
	
	if($ProjectDate == "")
	{
		$ProjectDate = date("Y-m");	    
	}

	$DateExploded = explode('-', $ProjectDate);

	$NumberDays = cal_days_in_month(CAL_GREGORIAN, $DateExploded[1], $DateExploded[0]);

	$Fproject_month = $DateExploded[0].'-'.$DateExploded[1];
	
	$OptionsList[date('Y-m', strtotime(date('Y-m').""))] = date('m-Y', strtotime(date('Y-m').""));
	$OptionsList[date('Y-m', strtotime(date('Y-m')." -1 month"))] = date('m-Y', strtotime(date('Y-m')." -1 month"));
	$OptionsList[date('Y-m', strtotime(date('Y-m')." -2 month"))] = date('m-Y', strtotime(date('Y-m')." -2 month"));
	$OptionsList[date('Y-m', strtotime(date('Y-m')." -3 month"))] = date('m-Y', strtotime(date('Y-m')." -3 month"));
	$OptionsList[date('Y-m', strtotime(date('Y-m')." -4 month"))] = date('m-Y', strtotime(date('Y-m')." -4 month"));
	$OptionsList[date('Y-m', strtotime(date('Y-m')." -5 month"))] = date('m-Y', strtotime(date('Y-m')." -5 month"));
	$OptionsList[date('Y-m', strtotime(date('Y-m')." -6 month"))] = date('m-Y', strtotime(date('Y-m')." -6 month"));
    
	if($DateExploded[1] == 1){$MonthName = $this->lang->line('month_1');}
	if($DateExploded[1] == 2){$MonthName = $this->lang->line('month_2');}
	if($DateExploded[1] == 3){$MonthName = $this->lang->line('month_3');}
	if($DateExploded[1] == 4){$MonthName = $this->lang->line('month_4');}
	if($DateExploded[1] == 5){$MonthName = $this->lang->line('month_5');}
	if($DateExploded[1] == 6){$MonthName = $this->lang->line('month_6');}
	if($DateExploded[1] == 7){$MonthName = $this->lang->line('month_7');}
	if($DateExploded[1] == 8){$MonthName = $this->lang->line('month_8');}
	if($DateExploded[1] == 9){$MonthName = $this->lang->line('month_9');}
	if($DateExploded[1] == 10){$MonthName = $this->lang->line('month_10');}
	if($DateExploded[1] == 11){$MonthName = $this->lang->line('month_11');}
	if($DateExploded[1] == 12){$MonthName = $this->lang->line('month_12');}
	
	echo '<div class="alert alert-success">'.$this->lang->line('a1097').$MonthName.' '.$DateExploded[0].'</div>';
	
	$SizeFullLayer = 180 + ($NumberDays * 25);
		
	echo '<div class="containerStats" style="width: '.$SizeFullLayer.'px">';
		
		echo '<div class="smallStats" style="width: 180px; border-width: 0px; border-right-width: 1px;">&nbsp;</div>';
		echo '<div class="smallStats" style="width: '.($NumberDays * 25).'px;">'.$MonthName.' '.$DateExploded[0].'</div>';
			
	echo '</div>';
	
	echo '<div class="containerStats" style="width: '.$SizeFullLayer.'px">';
	echo '<div class="smallStats" style="width: 180px;">#</div>';

	for($i=1;$i<$NumberDays+1;$i++)
	{
		echo '<div class="smallStats">'.$i.'</div>';
	}

	echo '</div>';
	
	for($i=0;$i<count($Keywords);$i++)
	{
		echo '<div class="containerStats" style="width: '.$SizeFullLayer.'px">';
		  
		echo '<div class="smallStats" style="width: 180px; text-align: left;">&nbsp;<a href="JavaScript:DeteleInfo(\''.base_url().'details/'.$ProjectId.'/?delete_keyword=y&keyword_id='.$Keywords[$i].'\',\''.$this->lang->line('a1047').'\');" title="'.$this->lang->line('a1048').'" class="btn btn-danger btn-xs">'.$this->lang->line('a1100').'</a> '.$KeywordsShow[$i].'</div>';
		
		for($z=1;$z<$NumberDays+1;$z++)
		{
			$NowKeyword = $Keywords[$i];
			
			if(
				$ResultDB[$NowKeyword][$ProjectDate.'-0'.$z] == 1 OR 
				$ResultDB[$NowKeyword][$ProjectDate.'-'.$z] == 1
			)
			{
				$GetStyle = 'style="background-color: #7CBDEF"';
			}

			if(
				$ResultDB[$NowKeyword][$ProjectDate.'-0'.$z] == 2 OR 
				$ResultDB[$NowKeyword][$ProjectDate.'-0'.$z] == 3 OR
				$ResultDB[$NowKeyword][$ProjectDate.'-'.$z] == 2 OR 
				$ResultDB[$NowKeyword][$ProjectDate.'-'.$z] == 3
			)
			{
				$GetStyle = 'style="background-color: #9BC651"';
			}

			if(
				$ResultDB[$NowKeyword][$ProjectDate.'-'.$z] >= 4 OR
				$ResultDB[$NowKeyword][$ProjectDate.'-0'.$z] >= 4
			)
			{
				$GetStyle = 'style="background-color: #F9E37F"';
			}

			
			if(
				$ResultDB[$NowKeyword][$ProjectDate.'-0'.$z] >= 11 OR
				$ResultDB[$NowKeyword][$ProjectDate.'-'.$z] >= 11
			)
			{
				$GetStyle = 'style="background-color: #FCD1D1"';
			}
			
			if(
				$ResultDB[$NowKeyword][$ProjectDate.'-0'.$z] > 50 OR 
				$ResultDB[$NowKeyword][$ProjectDate.'-'.$z] > 50)
			{
				$GetStyle = 'style="background-color: #F79494"';
			}
            
            if(
				$ResultDB[$NowKeyword][$ProjectDate.'-0'.$z] > 100 OR 
				$ResultDB[$NowKeyword][$ProjectDate.'-'.$z] > 100)
			{
				$GetStyle = 'style="background-color: #F79494"';
			}
			
			if($z < 10)
			{
				if($ResultDB[$NowKeyword][$ProjectDate.'-0'.$z] == null)
				{
					$ResultDB[$NowKeyword][$ProjectDate.'-0'.$z] = '-';
				}
				
				echo '<div class="smallStats" '.$GetStyle.'>'.$ResultDB[$NowKeyword][$ProjectDate.'-0'.$z].'</div>';
			}
			else
			{
				if($ResultDB[$NowKeyword][$ProjectDate.'-'.$z] == null)
				{
					$ResultDB[$NowKeyword][$ProjectDate.'-'.$z] = '-';
				}
				
                if($ResultDB[$NowKeyword][$ProjectDate.'-'.$z] == '101')
				{
					$ResultDB[$NowKeyword][$ProjectDate.'-'.$z] = '-';
				}
                
				echo '<div class="smallStats" '.$GetStyle.'>'.$ResultDB[$NowKeyword][$ProjectDate.'-'.$z].'</div>';
			}
			
			$GetStyle = '';
			
		}
		echo '</div>';
	}
	
	
	echo '<br /><br />';
	
	echo '<div class="row" style="width: '.$SizeFullLayer.'px">';
	
	echo '<div class="col-md-6" style="padding-left: 50px;">';
	
		echo '<div class="row" style="margin-bottom: 3px;">';
		echo '<div class="col-md-1" style="width: 35px;">';
		echo '<div class="smallStats">-</div>';
		echo '</div>';
		echo '<div class="col-md-11" style="padding-top: 4px;">';
		echo $this->lang->line('a1110');
		echo '</div>';
		echo '</div>';

		echo '<div class="row" style="margin-bottom: 3px;">';
		echo '<div class="col-md-1" style="width: 35px;">';
		echo '<div class="smallStats" style="background-color: #7CBDEF;">1</div>';
		echo '</div>';
		echo '<div class="col-md-11" style="padding-top: 4px;">';
		echo $this->lang->line('a1111');
		echo '</div>';
		echo '</div>';

		echo '<div class="row" style="margin-bottom: 3px;">';
		echo '<div class="col-md-1" style="width: 35px;">';
		echo '<div class="smallStats" style="background-color: #9BC651;">2</div>';
		echo '</div>';
		echo '<div class="col-md-11" style="padding-top: 4px;">';
		echo $this->lang->line('a1112');
		echo '</div>';
		echo '</div>';

		echo '<div class="row" style="margin-bottom: 3px;">';
		echo '<div class="col-md-1" style="width: 35px;">';
		echo '<div class="smallStats" style="background-color: #F9E37F;">4</div>';
		echo '</div>';
		echo '<div class="col-md-11" style="padding-top: 4px;">';
		echo $this->lang->line('a1113');
		echo '</div>';
		echo '</div>';

		echo '<div class="row" style="margin-bottom: 3px;">';
		echo '<div class="col-md-1" style="width: 35px;">';
		echo '<div class="smallStats" style="background-color: #FCD1D1;">11</div>';
		echo '</div>';
		echo '<div class="col-md-11" style="padding-top: 4px;">';
		echo $this->lang->line('a1114');
		echo '</div>';
		echo '</div>';

		echo '<div class="row" style="margin-bottom: 3px;">';
		echo '<div class="col-md-1" style="width: 35px;">';
		echo '<div class="smallStats" style="background-color: #F79494;">51</div>';
		echo '</div>';
		echo '<div class="col-md-11" style="padding-top: 4px;">';
		echo $this->lang->line('a1115');
		echo '</div>';
		echo '</div>';
        
        echo '<div class="row" style="margin-bottom: 3px;">';
		echo '<div class="col-md-1" style="width: 35px;">';
		echo '<div class="smallStats" style="background-color: #F79494;">-</div>';
		echo '</div>';
		echo '<div class="col-md-11" style="padding-top: 4px;">';
		echo $this->lang->line('a1119');
		echo '</div>';
		echo '</div>';
	
	echo '</div>';
	
	echo '<div class="col-md-6">';
	
		echo '<div class="row">';
		$attributes = array('method' => 'get');
		echo '<div class="col-md-6" style="background-color: #CCE7F4; border: solid 1px #B2DAEF; border-right-width: 0px; padding-top: 5px; padding-bottom: 5px; border-top-left-radius: 5px; border-bottom-left-radius: 5px;">';
			echo form_open('details/'.$ProjectId.'/',$attributes);
			echo form_dropdown('project_date', $OptionsList, $Fproject_month, 'class="form-control"');
		echo '</div>';
		echo '<div class="col-md-6" style="background-color: #CCE7F4; border: solid 1px #B2DAEF; border-left-width: 0px; padding-top: 5px; padding-bottom: 5px; border-top-right-radius: 5px; border-bottom-right-radius: 5px;">';
			echo form_hidden('formlogin','yes');
			echo form_submit(array('name' => 'buttonstart', 'value' => ''.$this->lang->line('a1099').'', 'class' => 'btn btn-success btn-block'));
			echo form_close();
	    	echo '</div>';
    		echo '</div>';
    	
	echo '</div>';
	
	echo '</div>';
}

?>
<script>
function CheckAll(DivNameId)
{
    $('#' + DivNameId + ' :checkbox').each(function ()
    {
        $(this).prop('checked', true);
    });
}

function UncheckAll(DivNameId)
{
    $('#' + DivNameId + ' :checkbox').each(function ()
    {
        $(this).prop('checked', false);
    });
}

</script>