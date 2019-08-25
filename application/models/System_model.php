<?php

/**
 * @author:    Lukasz Sosna
 * @e-mail:    lukasz.bluedragon@gmail.com
 * @www:       http://phpbluedragon.pl
 * @copyright: 8-7-2015 12:34
 *
 */

class System_model extends CI_Model 
{
    public function __construct()
    {
        parent::__construct();
        
        if($this->CheckLicenseExists() == 'yes')
		{
			$this->ThisFileLicense = true;
		}
    }

    private $ThisFileLicense = false;
    
	private function GetMyUrl($Url) 
	{
		$ResultUrl = parse_url($Url);
		return $ResultUrl['scheme']."://".$ResultUrl['host'];
	}

    public function CheckLicenseExists()
    {
        /*if(file_exists('getpozition.php'))
        {
            //yes
			
			//$ContentLicenseFile = @file_get_contents('hrefsystem.txt');
			$ContentLicenseFileTemp = file('getpozition.php');
            
            $ContentLicenseFile = $ContentLicenseFileTemp[2];
            
			//$ReadyUrl = $this->GetMyUrl($_SERVER['SERVER_NAME']);
			
            if(isset($_SERVER['HTTPS']))
            {
                $HostName = 'https://';
            }
            else
            {
                $HostName = 'http://';
            }
            
			$ReadyUrl = $this->GetMyUrl($HostName.$_SERVER['SERVER_NAME']);
            
			if(password_verify($ReadyUrl.'AEIqfuoMdLewX7O06c1QnDaV5xAJ0z',trim($ContentLicenseFile)))
			{
				$ValToReturn = 'yes';
			}
			else
			{
				$ValToReturn = 'no';
			}
			
        }
        else
        {
            $ValToReturn = 'no';
        }*/

		$ValToReturn = 'yes';
		
        return $ValToReturn;
    }
    
    public function CheckLicenseExistsNoAlert()
    {
        if(file_exists('getpozitionlic.php'))
        {
			$ContentLicenseFileTemp = file('getpozitionlic.php');
            
            $ContentLicenseFile = $ContentLicenseFileTemp[2];
            
            if(isset($_SERVER['HTTPS']))
            {
                $HostName = 'https://';
            }
            else
            {
                $HostName = 'http://';
            }
            
			$ReadyUrl = $this->GetMyUrl($HostName.$_SERVER['SERVER_NAME']);
                       
			if(password_verify($ReadyUrl.'AEIqfuoMdLewX7O06c1QnDaV5xAJ0z_lic',trim($ContentLicenseFile)))
			{
				$ValToReturn = 'yes';
			}
			else
			{
				$ValToReturn = 'no';
			}
        }
        else
        {
            $ValToReturn = 'no';
        }
		
        return $ValToReturn;
    }
    
    public function GetProjectList()
    {
        $QueryResult = $this->db->query('SELECT * FROM 
		{PREFIXDB}project
        ORDER BY
        project_id ASC
		');
        		
		return $QueryResult;
    }
    
    public function GetHowManyProject()
    {
        $QueryResult = $this->db->query('SELECT count(project_id) AS HowMany FROM 
		{PREFIXDB}project
		');
        		
		return $QueryResult;
    }
    
    public function GetProxyList()
    {
	    $QueryResult = $this->db->query('SELECT * FROM 
	    		{PREFIXDB}proxy
	            ORDER BY
	            proxy_id ASC
	    		');
	            		
		return $QueryResult;
    }
    
    public function DeleteProxy($ProxyId)
    {
	if(is_numeric($ProxyId))
	{
		$QueryResult = $this->db->query('DELETE FROM 
		{PREFIXDB}proxy
		WHERE
		proxy_id = "'.$this->db->escape_str($ProxyId).'"
		');
	}
    }
    
    public function DeleteKeyword($KeywordId,$ProjectId)
    {
	    if(is_numeric($KeywordId))
	    	{
	    		$QueryResult = $this->db->query('DELETE FROM 
	    		{PREFIXDB}keywords
	    		WHERE
	    		keyword_id = "'.$this->db->escape_str($KeywordId).'"
	    		');
	    		
	    	$QueryResult = $this->db->query('SELECT count(keyword_id) AS HowMany FROM 
	    		{PREFIXDB}keywords
	            WHERE
	            keyword_project_id = "'.$this->db->escape_str($ProjectId).'"
	    		');
	    		
	    		foreach($QueryResult->result() as $row)
			{
				$HowManyKeywords = $row->HowMany;
			}
			
		$QueryResult = $this->db->query('UPDATE 
			            {PREFIXDB}project
			            SET
			            project_keys = "'.$this->db->escape_str($HowManyKeywords).'"
			            WHERE
			            project_id = "'.$this->db->escape_str($ProjectId).'"
	            ');
			
	}
    }
    
    public function KeywordAdd($ProjectId)
    {
	    $QueryResult = $this->db->query('INSERT INTO 
	            {PREFIXDB}keywords
	            (
	            keyword_project_id,
	            keyword_keyword
	            )
	            VALUES
	            (
	            "'.$this->db->escape_str($ProjectId).'",
	            "'.$this->db->escape_str($this->input->post('keyword_keyword')).'"
	            )
        ');
        
	    $QueryResult = $this->db->query('SELECT count(keyword_id) AS HowMany FROM 
	    	    		{PREFIXDB}keywords
	    	            WHERE
	    	            keyword_project_id = "'.$this->db->escape_str($ProjectId).'"
	    	    		');
	    	    		
	    	    		foreach($QueryResult->result() as $row)
	    			{
	    				$HowManyKeywords = $row->HowMany;
	    			}
	    			
	    		$QueryResult = $this->db->query('UPDATE 
	    			            {PREFIXDB}project
	    			            SET
	    			            project_keys = "'.$this->db->escape_str($HowManyKeywords).'"
	    			            WHERE
	    			            project_id = "'.$this->db->escape_str($ProjectId).'"
	            ');
	            
    }
    
    public function ProxyAdd()
    {
	$QueryResult = $this->db->query('INSERT INTO 
        {PREFIXDB}proxy
        (
        proxy_url,
        proxy_port,
        proxy_user,
        proxy_password
        )
        VALUES
        (
        "'.$this->db->escape_str($this->input->post('proxy_url')).'",
        "'.$this->db->escape_str($this->input->post('proxy_port')).'",
        "'.$this->db->escape_str($this->input->post('proxy_user')).'",
        "'.$this->db->escape_str($this->input->post('proxy_password')).'"
        )
        ');
        
    }
    
    public function ProxySelectGet()
    {
	    $QueryResult = $this->db->query('SELECT count(proxy_id) AS HowMany FROM 
		{PREFIXDB}proxy
		');

		foreach($QueryResult->result() as $row)
		{
			$HowManyProxy = $row->HowMany;
		}
		
		if($HowManyProxy == 0)
		{
			$QueryResult = 'self_connection';
		}
		elseif($HowManyProxy == 1)
		{
			$QueryResult = $this->db->query('SELECT * FROM 
					{PREFIXDB}proxy
					LIMIT 0,1
			');
		}
		else
		{
			$QueryResult = $this->db->query('SELECT * FROM 
			{PREFIXDB}proxy
			WHERE
			proxy_select = "y"
			');
			
			$SelectedProxy = null;
			
			foreach($QueryResult->result() as $row)
			{
				$SelectedProxy = $row->proxy_id;
			}
			
			if($SelectedProxy == null)
			{
				$QueryResult = $this->db->query('SELECT * FROM 
				{PREFIXDB}proxy
				LIMIT 0,1
				');

				foreach($QueryResult->result() as $row)
				{
					$ProxyId = $row->proxy_id;
				}
			
				$QueryResult = $this->db->query('UPDATE 
				    {PREFIXDB}proxy
				    SET
				    proxy_select = "y"
				    WHERE
				    proxy_id = "'.$this->db->escape_str($ProxyId).'"
	            		');
			}
			
            $QueryResult = $this->db->query('UPDATE 
			{PREFIXDB}proxy
            SET
            proxy_used = proxy_used + 1
			WHERE
			proxy_select = "y"
			');
            
			$QueryResult = $this->db->query('SELECT * FROM 
			{PREFIXDB}proxy
			WHERE
			proxy_select = "y"
			');

		}
		
	return $QueryResult;
    }
   
   public function KeywordSelectGet()
   {
        /*
        $QueryResult = $this->db->query('SELECT * FROM 
        {PREFIXDB}keywords
        WHERE
        keyword_lasttest < "'.$this->db->escape_str(date("Y-m-d")).'"
        AND
        keyword_page1 = "y" AND
        keyword_page2 = "y" AND
        keyword_page3 = "y" AND
        keyword_page4 = "y" AND
        keyword_page5 = "y" AND
        keyword_page6 = "y" AND
        keyword_page7 = "y" AND
        keyword_page8 = "y" AND
        keyword_page9 = "y" AND
        keyword_page10 = "y"
        ORDER BY keyword_id ASC
        LIMIT 0,1
        ');
        
        foreach($QueryResult->result() as $row)
        {
            $QueryResult = $this->db->query('UPDATE 
            {PREFIXDB}keywords
            SET
            keyword_lasttest = "'.$this->db->escape_str(date("Y-m-d")).'",
            keyword_page1 = "",
            keyword_page2 = "",
            keyword_page3 = "",
            keyword_page4 = "",
            keyword_page5 = "",
            keyword_page6 = "",
            keyword_page7 = "",
            keyword_page8 = "",
            keyword_page9 = "",
            keyword_page10 = ""
            WHERE
            keyword_id = "'.$this->db->escape_str($row->keyword_id).'"
            ');
        }
        
        $QueryResult = $this->db->query('SELECT * FROM 
        {PREFIXDB}keywords
        WHERE
        keyword_lasttest < "'.$this->db->escape_str(date("Y-m-d")).'"
        AND
        (
        keyword_page1 = "" OR
        keyword_page2 = "" OR
        keyword_page3 = "" OR
        keyword_page4 = "" OR
        keyword_page5 = "" OR
        keyword_page6 = "" OR
        keyword_page7 = "" OR
        keyword_page8 = "" OR
        keyword_page9 = "" OR
        keyword_page10 = ""
        )
        ORDER BY keyword_id ASC
        LIMIT 0,1
        ');
   	    */
        
        $QueryResult = $this->db->query('SELECT * FROM 
        {PREFIXDB}keywords
        WHERE
        keyword_lasttest < "'.$this->db->escape_str(date("Y-m-d")).'"
        ORDER BY keyword_id ASC
        LIMIT 0,1
        ');
        
	return $QueryResult;
}

public function KeywordUpdateCheck($KeywordId)
{
     $QueryResult = $this->db->query('UPDATE 
	            {PREFIXDB}keywords
	            SET
	            keyword_lasttest = "'.$this->db->escape_str(date("Y-m-d")).'"
	            WHERE
	            keyword_id = "'.$this->db->escape_str($KeywordId).'"
	            ');
    
}

public function KeywordInsertResult($KeywordId,$ResultSearch)
{
    $QueryResult = $this->db->query('INSERT INTO 
        {PREFIXDB}keyword_date
        (
        date_keyword_id,
        date_date,
        date_poz
        )
        VALUES
        (
        "'.$this->db->escape_str($KeywordId).'",
        "'.$this->db->escape_str(date("Y-m-d")).'",
        "'.$this->db->escape_str($ResultSearch).'"
        )
        ');
}

public function SelectPageOverId($ProjectId)
{
	$QueryResult = $this->db->query('SELECT * FROM 
		    	{PREFIXDB}project
		    	WHERE
		    	project_id = "'.$this->db->escape_str($ProjectId).'"
		    	');
		    	
	foreach($QueryResult->result() as $row)
	{
		$WebPage = $row->project_href;
	}
	
	return $WebPage;
}

    public function ProxyEdit($ProxyId)
    {
	    $QueryResult = $this->db->query('UPDATE 
	            {PREFIXDB}proxy
	            SET
	            proxy_url = "'.$this->db->escape_str($this->input->post('proxy_url')).'",
	            proxy_port = "'.$this->db->escape_str($this->input->post('proxy_port')).'",
	            proxy_user = "'.$this->db->escape_str($this->input->post('proxy_user')).'",
	            proxy_password = "'.$this->db->escape_str($this->input->post('proxy_password')).'"
	            WHERE
	            proxy_id = "'.$this->db->escape_str($ProxyId).'"
	            ');
    }
    
    public function GetKeyword($ProjectId)
    {
	    $QueryResult = $this->db->query('SELECT * FROM 
	    	{PREFIXDB}keywords
	    	WHERE
	    	keyword_project_id = "'.$this->db->escape_str($ProjectId).'"
	    	');
	    
	return $QueryResult;
    }
    
    public function GetKeywordStats($Keywords,$ProjectDate='',$SortColumn='',$SortOrder='')
    {
	if($ProjectDate == "")
	{
		$ProjectDate = date("Y-m");	    
	}

	for($i=0;$i<count($Keywords);$i++)
	{
		$QueryResult = $this->db->query('SELECT * FROM 
		{PREFIXDB}keyword_date
		WHERE
		date_keyword_id = "'.$this->db->escape_str($Keywords[$i]).'"
		AND
		date_date LIKE "'.$this->db->escape_str($ProjectDate).'-%"
		ORDER BY
		date_date ASC
		');
		
		foreach($QueryResult->result() as $row)
		{
			$Answer[$Keywords[$i]][$row->date_date] = $row->date_poz;
		}
	}

	return $Answer;
    }
    
    public function SelectProxyOne($ProxyId)
    {
	    $QueryResult = $this->db->query('SELECT * FROM 
	    	    		{PREFIXDB}proxy
	    	            WHERE
	    	            proxy_id = "'.$this->db->escape_str($ProxyId).'"
	    	    		');
	    	            		
		return $QueryResult;
    }
    
    public function GetProjectListSort($Column='', $Order='')
    {
        
        if($Column == 'project_id'){ $SortColumn = 'project_id'; } 	
        if($Column == 'project_href'){ $SortColumn = 'project_href'; } 	
        if($Column == 'project_name'){ $SortColumn = 'project_name'; } 	
        if($Column == 'project_lastcheck'){ $SortColumn = 'project_lastcheck'; }
        if($Column == 'project_keys'){ $SortColumn = 'project_keys'; }
        if($SortColumn == ''){$SortColumn = 'project_id';}
        
        if($Order == 'desc')
        {
            $SortOrder = 'DESC';
        }
        else
        {
            $SortOrder = 'ASC';
        }
        
        $QueryResult = $this->db->query('SELECT * FROM 
		{PREFIXDB}project
        ORDER BY
        '.$this->db->escape_str($SortColumn).' '.$this->db->escape_str($SortOrder).'
		');
        		
		return $QueryResult;
    }
    
    public function ProjectAddNew()
    {
        $ProjectName = htmlspecialchars($this->input->post('project_name'));
        $ProjectBrief = htmlspecialchars($this->input->post('project_brief'));
        $ProjectHref = htmlspecialchars($this->input->post('project_href'));
        $ProjectLong = htmlspecialchars($this->input->post('project_long'));
        $ProjectEmail = htmlspecialchars($this->input->post('project_email'));
        
        $QueryResult = $this->db->query('INSERT INTO 
        {PREFIXDB}project
        (
        project_name,
        project_brief,
        project_href,
        project_long,
        project_email
        )
        VALUES
        (
        "'.$this->db->escape_str($ProjectName).'",
        "'.$this->db->escape_str($ProjectBrief).'",
        "'.$this->db->escape_str($ProjectHref).'",
        "'.$this->db->escape_str($ProjectLong).'",
        "'.$this->db->escape_str($ProjectEmail).'"
        )
        ');
    }
    
    public function UpdateSort($SortColumn,$SortOrder)
    {
        $QueryResult = $this->db->query('UPDATE 
        {PREFIXDB}config
        SET
        config_value = "'.$this->db->escape_str($SortColumn).'"
        WHERE
        config_name = "column"
        ');
        
        $QueryResult = $this->db->query('UPDATE 
        {PREFIXDB}config
        SET
        config_value = "'.$this->db->escape_str($SortOrder).'"
        WHERE
        config_name = "order"
        ');
    }
    
    public function UpdateSort2($SortColumn,$SortOrder)
    {
        $QueryResult = $this->db->query('UPDATE 
        {PREFIXDB}config
        SET
        config_value = "'.$this->db->escape_str($SortColumn).'"
        WHERE
        config_name = "column2"
        ');
        
        $QueryResult = $this->db->query('UPDATE 
        {PREFIXDB}config
        SET
        config_value = "'.$this->db->escape_str($SortOrder).'"
        WHERE
        config_name = "order2"
        ');
    }
    
    public function UpdateSort3($SortColumn,$SortOrder)
    {
        $QueryResult = $this->db->query('UPDATE 
        {PREFIXDB}config
        SET
        config_value = "'.$this->db->escape_str($SortColumn).'"
        WHERE
        config_name = "column3"
        ');
        
        $QueryResult = $this->db->query('UPDATE 
        {PREFIXDB}config
        SET
        config_value = "'.$this->db->escape_str($SortOrder).'"
        WHERE
        config_name = "order3"
        ');
    }
    
    public function ProjectEditExisting()
    {
        $ProjectName = htmlspecialchars($this->input->post('project_name'));
        $ProjectBrief = htmlspecialchars($this->input->post('project_brief'));
        $ProjectHref = htmlspecialchars($this->input->post('project_href'));
        $ProjectLong = htmlspecialchars($this->input->post('project_long'));
        $ProjectEmail = htmlspecialchars($this->input->post('project_email'));
        
        $QueryResult = $this->db->query('UPDATE 
        {PREFIXDB}project
        SET
        project_name = "'.$this->db->escape_str($ProjectName).'",
        project_brief = "'.$this->db->escape_str($ProjectBrief).'",
        project_href = "'.$this->db->escape_str($ProjectHref).'",
        project_long = "'.$this->db->escape_str($ProjectLong).'",
        project_email = "'.$this->db->escape_str($ProjectEmail).'"
        WHERE
        project_id = "'.$this->db->escape_str($this->input->post('project_id')).'"
        ');
    }
    
    public function ProjectGetById($ProjectId)
    {
        $QueryResult = $this->db->query('SELECT * FROM 
		{PREFIXDB}project
        WHERE
        project_id = "'.$this->db->escape_str($ProjectId).'"
		');
        		
		return $QueryResult;
    }
    
    public function ProjectDelete($ProjectId)
    {
        $QueryResult = $this->db->query('DELETE FROM 
		{PREFIXDB}project
        WHERE
        project_id = "'.$this->db->escape_str($ProjectId).'"
		');
    }
    
    public function GetOneLinkFromProject($ProjectId)
    {
        $QueryResult = $this->db->query('SELECT * FROM 
		{PREFIXDB}project_link
        WHERE
        link_project_id = "'.$this->db->escape_str($ProjectId).'"
        AND
        link_checkhand = ""
        ORDER BY
        link_id ASC
        LIMIT 0,1
		');
        		
		return $QueryResult;
    }
    
    public function UpdateLinkHandStatus($LinkId)
    {
        $QueryResult = $this->db->query('UPDATE 
        {PREFIXDB}project_link
        SET
        link_checkhand = "y"
        WHERE
        link_id = "'.$this->db->escape_str($LinkId).'"
        ');
    }
    
    public function UpdateLinkCronStatus($LinkId)
    {
        $QueryResult = $this->db->query('UPDATE 
        {PREFIXDB}project_link
        SET
        link_check = "y"
        WHERE
        link_id = "'.$this->db->escape_str($LinkId).'"
        ');
    }
    
    public function GetLinkProjectData($LinkId)
    {
        $QueryResult = $this->db->query('SELECT * FROM 
		{PREFIXDB}project_link
        WHERE
        link_id = "'.$this->db->escape_str($LinkId).'"
		');
        
        return $QueryResult;
    }
    
    public function CheckEmptyLink($ProjectId)
    {
        $QueryResult = $this->db->query('SELECT count(link_id) AS HowMany FROM 
		{PREFIXDB}project_link
        WHERE
        link_project_id = "'.$this->db->escape_str($ProjectId).'"
        AND
        link_check != "y"
		');
        
        return $QueryResult;
    }
    
    public function GetOneLinkFromProjectCron()
    {
        $CronCheck = false;
        $LinkId = false;
        
        $QueryResult = $this->db->query('SELECT * FROM 
		{PREFIXDB}project
        WHERE
        project_lastcheck = "0000-00-00"
        LIMIT 0,1
		');
        
        foreach($QueryResult->result() as $row)
		{	
            $CronCheck = true;
            
            $IsLink = false;
            
            $ProjectId = $row->project_id;
            
            $QueryResult2 = $this->db->query('SELECT * FROM 
    		{PREFIXDB}project_link
            WHERE
            link_project_id = "'.$this->db->escape_str($ProjectId).'"
            AND
            link_check = ""
    		');
            
            foreach($QueryResult2->result() as $row2)
            {
                $IsLink = true;
                
                $LinkId = $row2->link_id;
            }
            
            if($IsLink == false)
            {
                $this->ProjectMakeReport($ProjectId);
                
                // Aktualizacja linków
                
                $QueryResult = $this->db->query('UPDATE 
                {PREFIXDB}project_link
                SET
                link_check = ""
                WHERE
                link_project_id = "'.$this->db->escape_str($ProjectId).'"
                ');
                
                // Aktualizacja projktu
                
                $QueryResult = $this->db->query('UPDATE 
                {PREFIXDB}project
                SET
                project_lastcheck = "'.$this->db->escape_str(date('Y-m-d')).'"
                WHERE
                project_id = "'.$this->db->escape_str($ProjectId).'"
                ');
            }
        }
        
        
        if($CronCheck == false)
        {
            $QueryResult = $this->db->query('SELECT * FROM 
    		{PREFIXDB}project
    		');
            
            foreach($QueryResult->result() as $row)
    		{
    		  $DateStamp = explode('-', $row->project_lastcheck);
              
    		  $DateDB =  mktime(0, 1, 0, $DateStamp[1], $DateStamp[2], $DateStamp[0]);
              $DataAfterDB = $row->project_long * 24 * 60 * 60;
              
              $DateDB = $DateDB + $DataAfterDB;
              
              if($DateDB < time())
              {
                $QueryResult2 = $this->db->query('SELECT * FROM 
        		{PREFIXDB}project_link
                WHERE
                link_project_id = "'.$this->db->escape_str($row->project_id).'"
                AND
                link_check = ""
        		');
                
                $IsLink = false;
                
                foreach($QueryResult2->result() as $row2)
                {
                    $IsLink = true;
                    
                    $LinkId = $row2->link_id;
                    
                    $BreakWhole = true;
                    
                    break;
                }
                
                if($IsLink == false)
                {
                    $this->ProjectMakeReport($row->project_id);
                    
                    // Aktualizacja linków
                    
                    $QueryResult = $this->db->query('UPDATE 
                    {PREFIXDB}project_link
                    SET
                    link_check = ""
                    WHERE
                    link_project_id = "'.$this->db->escape_str($row->project_id).'"
                    ');
                    
                    // Aktualizacja projktu
                    
                    $QueryResult = $this->db->query('UPDATE 
                    {PREFIXDB}project
                    SET
                    project_lastcheck = "'.$this->db->escape_str(date('Y-m-d')).'"
                    WHERE
                    project_id = "'.$this->db->escape_str($row->project_id).'"
                    ');
                }
              }
              
              if($BreakWhole)
              {
                break;
              }
                  
            }
        }

		return $LinkId;
    }
    
    public function GetLinkData($LinkId)
    {
        $QueryResult = $this->db->query('SELECT * FROM 
		{PREFIXDB}project_link
        WHERE
        link_id = "'.$this->db->escape_str($LinkId).'"
		');
        
        return $QueryResult;
    }
    
    public function UpdateLink($LinkId,$CORE_RobotAviable,$CORE_MetaAviable,$CORE_UrlInOnPage,$CORE_UrlHasNoFollow,$CORE_HeaderStatus,$CORE_LinksOut)
    {
        $QueryResult = $this->db->query('UPDATE 
        {PREFIXDB}project_link
        SET
        link_robots = "'.$this->db->escape_str($CORE_RobotAviable).'",
        link_meta = "'.$this->db->escape_str($CORE_MetaAviable).'",
        link_exists = "'.$this->db->escape_str($CORE_UrlInOnPage).'",
        link_nofollow = "'.$this->db->escape_str($CORE_UrlHasNoFollow).'",
        link_http = "'.$this->db->escape_str($CORE_HeaderStatus).'",
        link_howmany = "'.$this->db->escape_str($CORE_LinksOut).'"
        WHERE
        link_id = "'.$this->db->escape_str($LinkId).'"
        ');
    }
    
    public function ProjectMakeReport($ProjectId)
    {
        $DateOfArchive = date("Y-m-d");
        
        $this->db->query('INSERT INTO 
        {PREFIXDB}archive
        (
        archive_project_id,
        archive_date
        )
        VALUES
        (
        "'.$this->db->escape_str($ProjectId).'",
        "'.$this->db->escape_str($DateOfArchive).'"
        )
        ');
        
        $InsertedId = $this->db->insert_id();
        
        $QueryResult = $this->db->query('INSERT INTO {PREFIXDB}project_archive 
        (
        link_link_id,
        link_project_id,
        link_url,
        link_text,
        link_exists,
        link_robots,
        link_nofollow,
        link_meta,
        link_http,
        link_howmany,
        link_date,
        link_archive_id
        )
        SELECT link_id,
        link_project_id,
        link_url,
        link_text,
        link_exists,
        link_robots,
        link_nofollow,
        link_meta,
        link_http,
        link_howmany,
        "'.$this->db->escape_str($DateOfArchive).'",
        "'.$this->db->escape_str($InsertedId).'"
        FROM {PREFIXDB}project_link WHERE link_project_id = "'.$this->db->escape_str($ProjectId).'"
        ');
        
        //
        // Aktualizacja projektu
        //
        
        $this->db->query('UPDATE 
		{PREFIXDB}project
        SET
        project_lastcheck = "'.$this->db->escape_str($DateOfArchive).'"
        WHERE
        project_id = "'.$this->db->escape_str($ProjectId).'"
		');
        
        //
        // Wybieranie danych i generowanie raportu
        //
        
        $QueryResult = $this->db->query('SELECT * FROM 
		{PREFIXDB}project
        WHERE
        project_id = "'.$this->db->escape_str($ProjectId).'"
		');
        
        foreach($QueryResult->result() as $row)
		{
            $IsReportOnEmail = $row->project_email;
            $EmailProjectName = $row->project_name;
            $EmailProjectHref = $row->project_href;
        }
        
        $ResultDB = $this->SelectEmailContent('report');
                
        foreach($ResultDB->result() as $row)
		{
			 $ReadyTitle = $row->email_title;
             $ReadyContent = $row->email_content;
        }
        
        if($IsReportOnEmail == 'y')
        {
            
            $ResultDB = $this->GetProjectLinksSort($ProjectId,'link_exists','asc');

            $UserReportTable = '<!DOCTYPE HTML>
            <html>
            <head>
            	<meta http-equiv="content-type" content="text/html" />
            	<title>'.$ReadyTitle.'</title>
            </head>
            <body>
            <br /><br />
            '.$this->lang->line('a1066').' '.$EmailProjectName.'<br />
            '.$this->lang->line('a1067').' '.$EmailProjectHref.'<br />
            '.$this->lang->line('a1068').' '.$DateOfArchive.'<br />
            <br />
            <table style="border-spacing: 0px; border-collapse: collapse; border: 1px solid black;">';
            
            $UserReportTable .= '<tr>
            <td style="background-color: #ffffff; padding: 5px; color: #000000; font-weight: bold; border: solid 1px #000000;">'.$this->lang->line('a1014').'</td>
            <td style="background-color: #ffffff; padding: 5px; color: #000000; font-weight: bold; text-align: center; border: solid 1px #000000;">'.$this->lang->line('a1015').'</td>
            <td style="background-color: #ffffff; padding: 5px; color: #000000; font-weight: bold; text-align: center; border: solid 1px #000000;">'.$this->lang->line('a1016').'</td>
            <td style="background-color: #ffffff; padding: 5px; color: #000000; font-weight: bold; text-align: center; border: solid 1px #000000;">'.$this->lang->line('a1017').'</td>
            <td style="background-color: #ffffff; padding: 5px; color: #000000; font-weight: bold; text-align: center; border: solid 1px #000000;">'.$this->lang->line('a1018').'</td>
            <td style="background-color: #ffffff; padding: 5px; color: #000000; font-weight: bold; text-align: center; border: solid 1px #000000;">'.$this->lang->line('a1019').'</td>
            <td style="background-color: #ffffff; padding: 5px; color: #000000; font-weight: bold; text-align: center; border: solid 1px #000000;">'.$this->lang->line('a1020').'</td>
            </tr>';
                
            foreach($ResultDB->result() as $row)
            {
                if($row->link_exists == 'y'){$Exists = '<span class="btn btn-info btn-xs">'.$this->lang->line('a1022').'</span>';}else{$Exists = '<span class="btn btn-danger btn-xs">'.$this->lang->line('a1023').'</span>';}
                if($row->link_robots == 'y'){$Robots = '<span class="btn btn-info btn-xs">'.$this->lang->line('a1022').'</span>';}else{$Robots = '<span class="btn btn-danger btn-xs">'.$this->lang->line('a1023').'</span>';}
                if($row->link_nofollow == 'y'){$NoFollow = '<span class="btn btn-danger btn-xs">'.$this->lang->line('a1022').'</span>';}else{$NoFollow = '<span class="btn btn-info btn-xs">'.$this->lang->line('a1023').'</span>';}
                if($row->link_meta == 'n'){$Meta = '<span class="btn btn-info btn-xs">'.$this->lang->line('a1024').'</span>';}else{
                    if (strpos($row->link_meta, 'noindex') !== false) {$HasBad = true;}
                    if (strpos($row->link_meta, 'nofollow') !== false) {$HasBad = true;}
                    if($HasBad)
                    {
                        $Meta = '<span class="btn btn-danger btn-xs">'.$row->link_meta.'</span>';
                    }
                    else
                    {
                        $Meta = '<span class="btn btn-info btn-xs">'.$row->link_meta.'</span>';
                    }
                    }
                
                /*if($TableHTTPCom[$row->link_http] != "")
                {
                    if($row->link_http == '200')
                    {
                        $HttpHeader = '<span class="btn btn-info btn-xs">'.$TableHTTPCom[$row->link_http].'</span>';
                    }
                    else
                    {
                        $HttpHeader = '<span class="btn btn-danger btn-xs">'.$TableHTTPCom[$row->link_http].'</span>';
                    }
                }
                elseif($row->link_http == 'n')
                {
                    $HttpHeader = '<span class="btn btn-danger btn-xs">'.$this->lang->line('a1025').'</span>';
                }
                else
                {
                    $HttpHeader = '<span class="btn btn-danger btn-xs">'.$row->link_http.'</span>';
                }*/
                
                if($row->link_http == 'n')
                {
                    $HttpHeader = '<span class="btn btn-danger btn-xs">'.$this->lang->line('a1025').'</span>';
                }
                else
                {
                    $HttpHeader = $row->link_http;
                }
                
                if($row->link_howmany == 0)
                {
                    $HowMany = '<span class="btn btn-info btn-xs">'.$row->link_howmany.'</span>';
                }
                else
                {
                    $HowMany = '<span class="btn btn-success btn-xs">'.$row->link_howmany.'</span>';
                }
            
                if($Color == 0)
                {
                    $UserReportTable .= '<tr>';
                    $InsertStyle = 'style="background-color: #f9f9f9; padding: 5px; color: #000000; text-align: center; border: solid 1px #000000;"';
                    $InsertStyleMain = 'style="background-color: #f9f9f9; padding: 5px; color: #000000; text-align: left; border: solid 1px #000000;"';
                    $Color = 1;
                }
                else
                {
                    $UserReportTable .= '<tr>';
                    $InsertStyle = 'style="background-color: #ffffff; padding: 5px; color: #000000; text-align: center; border: solid 1px #000000;"';
                    $InsertStyleMain = 'style="background-color: #ffffff; padding: 5px; color: #000000; text-align: left; border: solid 1px #000000;"';
                    $Color = 0;
                }
                
                $UserReportTable .= '
                <td '.$InsertStyleMain.'>'.$row->link_url.'<br /><span style="font-size: 12px; font-style: italic;">'.$row->link_text.'</span></td>
                <td '.$InsertStyle.'>'.$Exists.'</td>
                <td '.$InsertStyle.'>'.$Robots.'</td>
                <td '.$InsertStyle.'>'.$NoFollow.'</td>
                <td '.$InsertStyle.'>'.$Meta.'</td>
                <td '.$InsertStyle.'>'.$HttpHeader.'</td>
                <td '.$InsertStyle.'>'.$HowMany.'</td>
                </tr>';
            }
            
            $UserReportTable .= '</table>
            <br />
            <br />
            </body>
            </html>';

            $ReadyContent = str_replace('[user_content]',$UserReportTable,$ReadyContent);
            
            $QueryResult = $this->db->query('SELECT * FROM 
    		{PREFIXDB}user
            WHERE
            user_id = "1"
    		');
            
            foreach($QueryResult->result() as $row)
    		{
    			 $UserUsername = $row->user_email;
            }

            $ContactAddress = $this->System_model->GetConfig();
                
            require 'PHPMailer/PHPMailerAutoload.php';
            $mail = new PHPMailer;
    
            $mail->SMTPDebug = 0;
            if($this->config->item('send_email_tls'))
            {
                $mail->SMTPSecure = 'tls';
            }
            $mail->Host = $this->config->item('send_email_stmp_host');
            $mail->SMTPAuth = true;
            $mail->Username = $this->config->item('send_email_stmp_username');
            $mail->Password = $this->config->item('send_email_stmp_password');
            $mail->Port = $this->config->item('send_email_stmp_port');
            $mail->CharSet = 'UTF-8';
            
            $mail->FromName = $this->config->item('send_email_user_name');
            $mail->From = $ContactAddress['root_email'];
            $mail->addAddress($UserUsername);
            
            $mail->isHTML(true);
            
            $mail->Subject = $ReadyTitle;
            $mail->Body    = $ReadyContent;
    
            if(!$mail->send())
            {
                $SystemLang['email_send2'] = true;
            } 
            else 
            {
                $SystemLang['email_send'] = true;
            }
        }
    }
    
    public function UpdateConfig()
    {
        //$QueryResult = $this->db->query('UPDATE {PREFIXDB}config SET config_value = "'.$this->db->escape_str($this->input->post('title')).'" WHERE config_name = "title"');
        $QueryResult = $this->db->query('UPDATE {PREFIXDB}config SET config_value = "'.$this->db->escape_str($this->input->post('root_email')).'" WHERE config_name = "root_email"');
        $QueryResult = $this->db->query('UPDATE {PREFIXDB}config SET config_value = "'.$this->db->escape_str($this->input->post('cron')).'" WHERE config_name = "cron"');
        $QueryResult = $this->db->query('UPDATE {PREFIXDB}config SET config_value = "'.$this->db->escape_str($this->input->post('google')).'" WHERE config_name = "google"');
    }
    
    public function ProjectSelectArchive($ProjectId)
    {
        $QueryResult = $this->db->query('SELECT * FROM 
		{PREFIXDB}archive
        WHERE
        archive_project_id = "'.$this->db->escape_str($ProjectId).'"
        ORDER BY
        archive_id DESC
        LIMIT 0,8
		');
        		
		return $QueryResult;
    }
    
    public function ProjectSelectAllArchive($ProjectId)
    {
        $QueryResult = $this->db->query('SELECT * FROM 
		{PREFIXDB}archive
        WHERE
        archive_project_id = "'.$this->db->escape_str($ProjectId).'"
        ORDER BY
        archive_id DESC
		');
        		
		return $QueryResult;
    }
    
    public function ProjectResetHandCheck($ProjectId)
    {
        $QueryResult = $this->db->query('UPDATE 
        {PREFIXDB}project_link
        SET
        link_checkhand = ""
        WHERE
        link_project_id = "'.$this->db->escape_str($ProjectId).'"
        ');
    }
    
    public function GetProjectLinks($ProjectId)
    {
        $QueryResult = $this->db->query('SELECT * FROM 
		{PREFIXDB}project_link
        WHERE
        link_project_id = "'.$this->db->escape_str($ProjectId).'"
        ORDER BY
        link_id ASC
		');
        		
		return $QueryResult;
    }
    
    public function GetProjectLinksSort($ProjectId,$Column='',$Order='')
    {
        if($Column == 'link_url'){ $SortColumn = 'link_url'; } 	
        if($Column == 'link_text'){ $SortColumn = 'link_text'; } 	
        if($Column == 'link_exists'){ $SortColumn = 'link_exists'; } 	
        if($Column == 'link_robots'){ $SortColumn = 'link_robots'; }
        if($Column == 'link_nofollow'){ $SortColumn = 'link_nofollow'; }
        if($Column == 'link_meta'){ $SortColumn = 'link_meta'; }
        if($Column == 'link_http'){ $SortColumn = 'link_http'; }
        if($Column == 'link_howmany'){ $SortColumn = 'link_howmany'; }
        
        if($SortColumn == ''){$SortColumn = 'link_url';}
        
        if($Order == 'desc')
        {
            $SortOrder = 'DESC';
        }
        else
        {
            $SortOrder = 'ASC';
        }

        $QueryResult = $this->db->query('SELECT * FROM 
		{PREFIXDB}project_link
        WHERE
        link_project_id = "'.$this->db->escape_str($ProjectId).'"
        ORDER BY
        '.$this->db->escape_str($SortColumn).' '.$this->db->escape_str($SortOrder).'
		');
        		
		return $QueryResult;
    }
    
    public function SelectReportSort($ReportId,$Column='',$Order='')
    {
        if($Column == 'link_url'){ $SortColumn = 'link_url'; } 	
        if($Column == 'link_text'){ $SortColumn = 'link_text'; } 	
        if($Column == 'link_exists'){ $SortColumn = 'link_exists'; } 	
        if($Column == 'link_robots'){ $SortColumn = 'link_robots'; }
        if($Column == 'link_nofollow'){ $SortColumn = 'link_nofollow'; }
        if($Column == 'link_meta'){ $SortColumn = 'link_meta'; }
        if($Column == 'link_http'){ $SortColumn = 'link_http'; }
        if($Column == 'link_howmany'){ $SortColumn = 'link_howmany'; }
        
        if($SortColumn == ''){$SortColumn = 'link_url';}
        
        if($Order == 'desc')
        {
            $SortOrder = 'DESC';
        }
        else
        {
            $SortOrder = 'ASC';
        }
        
        $QueryResult = $this->db->query('SELECT * FROM 
        {PREFIXDB}project_archive 
        WHERE
        link_archive_id = "'.$this->db->escape_str($ReportId).'"
        ORDER BY
        '.$this->db->escape_str($SortColumn).' '.$this->db->escape_str($SortOrder).'
        ');
        
        return $QueryResult;
    }
    
    public function SelectReportExport($ArchiveId,$WhatExport)
    {
        if($WhatExport == 'link')
        {
            $QueryResult = $this->db->query('SELECT * FROM 
            {PREFIXDB}project_archive 
            WHERE
            link_archive_id = "'.$this->db->escape_str($ArchiveId).'"
            AND
            link_exists = "y"
            ORDER BY
            link_id ASC
            ');
        }
        elseif($WhatExport == 'nolink')
        {
            $QueryResult = $this->db->query('SELECT * FROM 
            {PREFIXDB}project_archive 
            WHERE
            link_archive_id = "'.$this->db->escape_str($ArchiveId).'"
            AND
            link_exists != "y"
            ORDER BY
            link_id ASC
            ');
        }
        else
        {
            //all   
            $QueryResult = $this->db->query('SELECT * FROM 
            {PREFIXDB}project_archive 
            WHERE
            link_archive_id = "'.$this->db->escape_str($ArchiveId).'"
            ORDER BY
            link_id ASC
            ');
        }
        
        return $QueryResult;
    }
    
    public function ProjectAddNewLnik($ProjectId)
    {
        $LinkUrl = htmlspecialchars($this->input->post('link_url'));
        $Linktext = htmlspecialchars($this->input->post('link_text'));
        
        $QueryResult = $this->db->query('INSERT INTO 
        {PREFIXDB}project_link
        (
        link_url,
        link_text,
        link_project_id
        )
        VALUES
        (
        "'.$this->db->escape_str($LinkUrl).'",
        "'.$this->db->escape_str($Linktext).'",
        "'.$this->db->escape_str($ProjectId).'"
        )
        ');
    }
    
    public function ProjectEditExistingLink()
    {
        $LinkUrl = htmlspecialchars($this->input->post('link_url'));
        $Linktext = htmlspecialchars($this->input->post('link_text'));
        
        $QueryResult = $this->db->query('UPDATE 
        {PREFIXDB}project_link
        SET
        link_url = "'.$this->db->escape_str($LinkUrl).'",
        link_text = "'.$this->db->escape_str($Linktext).'"
        WHERE
        link_id = "'.$this->db->escape_str($this->input->post('link_id')).'"
        ');
    }
    
    public function ProjectGetLinkById($LinkId)
    {
        $QueryResult = $this->db->query('SELECT * FROM 
		{PREFIXDB}project_link
        WHERE
        link_id = "'.$this->db->escape_str($LinkId).'"
		');
        		
		return $QueryResult;
    }
    
    public function ProjectDeleteLink($LinkId)
    {
        $QueryResult = $this->db->query('DELETE FROM 
		{PREFIXDB}project_link
        WHERE
        link_id = "'.$this->db->escape_str($LinkId).'"
		');
    }
    
    public function ImportToProject($ProjectId, $Url, $Brief='')
    {
        $LinkUrl = htmlspecialchars($Url);
        $LinkBrief = htmlspecialchars($Brief);
        
        if($LinkBrief == "")
        {
            $LinkBrief = '*';
        }
        
        $QueryResult = $this->db->query('INSERT INTO 
        {PREFIXDB}project_link
        (
        link_url,
        link_text,
        link_project_id
        )
        VALUES
        (
        "'.$this->db->escape_str($LinkUrl).'",
        "'.$this->db->escape_str($LinkBrief).'",
        "'.$this->db->escape_str($ProjectId).'"
        )
        ');
    }
    
    public function CheckCountProject()
    {
        $IsSomethingToCheck = false;
        
        $QueryResult = $this->db->query('SELECT * FROM 
		{PREFIXDB}project
		');
        
        foreach($QueryResult->result() as $row)
        {
            if($row->project_lastcheck == '0000-00-00')
            {
                $IsSomethingToCheck = true;
            }
            else
            {
                $DateSeparated = explode('-', $row->project_lastcheck);
                
                $time1 = mktime(0, 1, 0, $DateSeparated[1], $DateSeparated[2], $DateSeparated[0]);
                $time2 = time() - $row->project_long;

                if($time1 < $time2)
                {
                    $IsSomethingToCheck = true;
                }
            }
        }
        		
		return $IsSomethingToCheck;
    }
    
    public function UserCheckEmail($Email)
    {
        $Email = htmlspecialchars($Email);
        
        $QueryResult = $this->db->query('SELECT count(user_email) AS HowMany FROM 
		{PREFIXDB}user
        WHERE
        user_email = "'.$this->db->escape_str($Email).'"
		');
        		
		return $QueryResult;
    }
    
    public function ChangePasswordAutomat($UserId,$TemporaryPassword)
    {
        /*
        user_password_clear = "'.$this->db->escape_str($TemporaryPassword).'"
        */
        
        $UserId = htmlspecialchars($UserId);
        $TemporaryPassword = htmlspecialchars($TemporaryPassword);
        
        $SaltPassword = password_hash($TemporaryPassword, PASSWORD_DEFAULT);
        
        $QueryResult = $this->db->query('UPDATE 
        {PREFIXDB}user
        SET
        user_password = "'.$this->db->escape_str($SaltPassword).'"
        WHERE
        user_id = "'.$this->db->escape_str($UserId).'"
        ');
        
    }
    
    public function CheckKeyPasswords($UserId,$KeyPassword,$KeyPassword2)
    {
        $UserId = htmlspecialchars($UserId);
        $KeyPassword = htmlspecialchars($KeyPassword);
        $KeyPassword2 = htmlspecialchars($KeyPassword2);
        
        $QueryResult = $this->db->query('SELECT count(password_id) As HowMany FROM 
        {PREFIXDB}password 
        WHERE
        password_user_id = "'.$this->db->escape_str($UserId).'"
        AND
        password_hash1 = "'.$this->db->escape_str($KeyPassword).'"
        AND
        password_hash2 = "'.$this->db->escape_str($KeyPassword2).'"
        AND
        password_time > "'.$this->db->escape_str(date('Y-m-d H:i:s')).'"
        AND
        password_used = ""
        ');
        
        $this->db->query('UPDATE 
        {PREFIXDB}password 
        SET
        password_used = "y"
        WHERE
        password_user_id = "'.$this->db->escape_str($UserId).'"
        AND
        password_hash1 = "'.$this->db->escape_str($KeyPassword).'"
        AND
        password_hash2 = "'.$this->db->escape_str($KeyPassword2).'"
        AND
        password_time > "'.$this->db->escape_str(date('Y-m-d H:i:s')).'"
        ');
        
        return $QueryResult;
    }
    
    public function GenerateNewPassword($UserId,$KeyPassword,$KeyPassword2)
    {
        $UserId = htmlspecialchars($UserId);
        $KeyPassword = htmlspecialchars($KeyPassword);
        $KeyPassword2 = htmlspecialchars($KeyPassword2);
        
        $QueryResult = $this->db->query('INSERT INTO 
        {PREFIXDB}password
        (
        password_user_id,
        password_hash1,
        password_hash2,
        password_time,
        password_ip
        )
        VALUES
        (
        "'.$this->db->escape_str($UserId).'",
        "'.$this->db->escape_str($KeyPassword).'",
        "'.$this->db->escape_str($KeyPassword2).'",
        "'.$this->db->escape_str(date("Y-m-d H:i:s",time()+2*60*60)).'",
        "'.$this->db->escape_str($_SERVER['REMOTE_ADDR']).'"
        )
        ');
    }
    
    public function SelectGenerateNewPassword($UserId,$KeyPassword,$KeyPassword2)
    {
        $UserId = htmlspecialchars($UserId);
        $KeyPassword = htmlspecialchars($KeyPassword);
        $KeyPassword2 = htmlspecialchars($KeyPassword2);
        
        $QueryResult = $this->db->query('SELECT * FROM 
		{PREFIXDB}password
        WHERE
        password_user_id = "'.$this->db->escape_str($UserId).'"
        AND
        password_hash1 = "'.$this->db->escape_str($KeyPassword).'"
        AND
        password_hash2 = "'.$this->db->escape_str($KeyPassword2).'"
		');
        		
		return $QueryResult;
    }
    
    public function UserCheckEmailSelect($Email)
    {
        $Email = htmlspecialchars($Email);
        
        $QueryResult = $this->db->query('SELECT * FROM 
		{PREFIXDB}user
        WHERE
        user_email = "'.$this->db->escape_str($Email).'"
		');
        		
		return $QueryResult;
    }
    
    public function UserGetData()
    {
        $QueryResult = $this->db->query('SELECT * FROM 
		{PREFIXDB}user
        WHERE
        user_id = "'.$this->db->escape_str($_SESSION['user_id']).'"
		');
        		
		return $QueryResult;
    }
    
    public function UpdateUserPswd()
    {
        $SaltPassword = password_hash($this->input->post('user_pswd2'), PASSWORD_DEFAULT);
        $SaltPassword = htmlspecialchars($SaltPassword);
        
        $QueryResult = $this->db->query('UPDATE 
        {PREFIXDB}user
        SET
        user_password = "'.$this->db->escape_str($SaltPassword).'"
        WHERE
        user_id = "'.$this->db->escape_str($_SESSION['user_id']).'"
        ');
    }
    
    public function CheckUser()
    {
        $Email = htmlspecialchars($this->input->post('user_email'));
        
        $QueryResult = $this->db->query('SELECT * FROM 
		{PREFIXDB}user
        WHERE
        user_email = "'.$this->db->escape_str($Email).'"
		');
        
        foreach($QueryResult->result() as $row)
		{
            $PasswordToVerify = $row->user_password;
            $UserId = $row->user_id;
        }
        
        if(password_verify($this->input->post('user_password'), $PasswordToVerify) == false)
        {
            $TableUser['IsAuth'] = 'no';
        }
        else
        {
            $TableUser['IsAuth'] = 'yes';
            $TableUser['UserId'] = $UserId;
        }
        
        return $TableUser;
    }
    public function GetUserData($Email)
    {
        $Email = htmlspecialchars($Email);
        
        $QueryResult = $this->db->query('SELECT * FROM 
		{PREFIXDB}user
        WHERE
        user_email = "'.$this->db->escape_str($Email).'"
		');
        		
		return $QueryResult;
    }
    
    public function GetUserDataById($Id)
    {
        $Id = htmlspecialchars($Id);
        
        $QueryResult = $this->db->query('SELECT * FROM 
		{PREFIXDB}user
        WHERE
        user_id = "'.$this->db->escape_str($Id).'"
		');
        		
		return $QueryResult;
    }
    
    public function GetUserDataByDate($Id)
    {
        $Id = htmlspecialchars($Id);
        
        $QueryResult = $this->db->query('SELECT * FROM 
		{PREFIXDB}user
        WHERE
        user_id = "'.$this->db->escape_str($Id).'"
        AND
        user_package_date > "'.$this->db->escape_str(date('Y-m-d H:i:s')).'"
		');
        		
		return $QueryResult;
    }    
    public function WriteLog($Message)
    {
        $Message = htmlspecialchars($Message);
        
        $QueryResult = $this->db->query('INSERT INTO 
        {PREFIXDB}log
        (
        log_user_id,
        log_what,
        log_time,
        log_ip
        )
        VALUES
        (
        "'.$this->db->escape_str($_SESSION['user_id']).'",
        "'.$this->db->escape_str($Message).'",
        "'.$this->db->escape_str(date('Y-m-d H:i:s')).'",
        "'.$this->db->escape_str($_SERVER['REMOTE_ADDR']).'"
        )
        ');
    }
    
    public function PageSelect($Id)
    {
        $QueryResult = $this->db->query('SELECT * FROM 
        {PREFIXDB}pages 
        WHERE
        page_id = "'.$this->db->escape_str($Id).'"
        ');
        
        return $QueryResult;
    }
    
    public function GetSystemConfig()
    {
        $QueryResult = $this->db->query('SELECT * FROM 
        {PREFIXDB}config
        ');
        
        return $QueryResult;
    }
    
    public function UpdateEmails()
    {    
        $EmailTitle1 = htmlspecialchars($this->input->post('email_title1'));
        $EmailContent1 = htmlspecialchars($this->input->post('email_content1'));

        $QueryResult = $this->db->query('UPDATE 
        {PREFIXDB}email
        SET
        email_title = "'.$this->db->escape_str($EmailTitle1).'",
        email_content = "'.$this->db->escape_str($EmailContent1).'"
        WHERE
        email_what = "recpassword"
        ');
        
        $EmailTitle2 = htmlspecialchars($this->input->post('email_title2'));
        $EmailContent2 = htmlspecialchars($this->input->post('email_content2'));

        $QueryResult = $this->db->query('UPDATE 
        {PREFIXDB}email
        SET
        email_title = "'.$this->db->escape_str($EmailTitle2).'",
        email_content = "'.$this->db->escape_str($EmailContent2).'"
        WHERE
        email_what = "newpass"
        ');
        
        $EmailTitle3 = htmlspecialchars($this->input->post('email_title3'));
        $EmailContent3 = htmlspecialchars($this->input->post('email_content3'));

        $QueryResult = $this->db->query('UPDATE 
        {PREFIXDB}email
        SET
        email_title = "'.$this->db->escape_str($EmailTitle3).'",
        email_content = "'.$this->db->escape_str($EmailContent3).'"
        WHERE
        email_what = "report"
        ');
    }
    
    public function SelectProjectName($ProjectId)
    {
        $QueryResult = $this->db->query('SELECT * FROM 
        {PREFIXDB}project
        WHERE
        project_id = "'.$this->db->escape_str($ProjectId).'"
        ');
        
        foreach($QueryResult->result() as $row)
    	{
    		$ProjectName = $row->project_name;
    	}
        
        return $ProjectName;
    }
    
    public function SelectProjectIdByLink($LinkId)
    {
        $QueryResult = $this->db->query('SELECT * FROM 
        {PREFIXDB}project_link
        WHERE
        link_id = "'.$this->db->escape_str($LinkId).'"
        ');
        
        foreach($QueryResult->result() as $row)
    	{
    		$ProjectId = $row->link_project_id;
    	}
        
        return $ProjectId;
    }
    
    public function SelectProjectNameByLink($LinkId)
    {
        $QueryResult = $this->db->query('SELECT * FROM 
        {PREFIXDB}project_link
        WHERE
        link_id = "'.$this->db->escape_str($LinkId).'"
        ');
        
        foreach($QueryResult->result() as $row)
    	{
    		$ProjectId = $row->link_project_id;
    	}
        
        $QueryResult = $this->db->query('SELECT * FROM 
        {PREFIXDB}project
        WHERE
        project_id = "'.$this->db->escape_str($ProjectId).'"
        ');
        
        foreach($QueryResult->result() as $row)
    	{
    		$ProjectName = $row->project_name;
    	}
        
        return $ProjectName;
    }
    
    public function SelectEmail($Name)
    {
        $QueryResult = $this->db->query('SELECT * FROM 
        {PREFIXDB}email 
        WHERE
        email_what = "'.$this->db->escape_str($Name).'"
        ');
        
        return $QueryResult;
    }
    
    public function GetConfig()
    {
        $ResultDB = $this->System_model->GetSystemConfig();
    
    	foreach($ResultDB->result() as $row)
    	{
    		$ConfigTable[$row->config_name] = $row->config_value;
    	}
        
        return $ConfigTable;
    }
    
    public function SelectEmailContent($WhatEmail)
    {
        $QueryResult = $this->db->query('SELECT * FROM 
		{PREFIXDB}email
        WHERE
        email_what = "'.$this->db->escape_str($WhatEmail).'"
		');
        		
		return $QueryResult;
    }
    
    public function GetUserEmail()
    {
        $QueryResult = $this->db->query('SELECT * FROM 
        {PREFIXDB}user 
        WHERE
        user_id = "'.$this->db->escape_str($_SESSION['user_id']).'"
        ');
        
        foreach($QueryResult->result() as $row)
    	{
    	   $UserEmail = $row->user_email;
        }
        
        return $UserEmail;
    }
    
    public function SelectReport($ReportId)
    {
        $QueryResult = $this->db->query('SELECT * FROM 
        {PREFIXDB}project_archive 
        WHERE
        link_archive_id = "'.$this->db->escape_str($ReportId).'"
        ORDER BY link_url ASC
        ');
        
        return $QueryResult;
    }
    
    public function SelectProjectNameByArchive($ArchiveId)
    {
        $QueryResult = $this->db->query('SELECT * FROM 
        {PREFIXDB}project_archive 
        WHERE
        link_archive_id = "'.$this->db->escape_str($ArchiveId).'"
        LIMIT 0,1
        ');
        
        foreach($QueryResult->result() as $row)
    	{
    	   $ProjectId = $row->link_project_id;
        }
        
        return $ProjectId;
    }
    
    public function SelectDateArchive($ArchiveId)
    {
        $QueryResult = $this->db->query('SELECT * FROM 
        {PREFIXDB}project_archive 
        WHERE
        link_archive_id = "'.$this->db->escape_str($ArchiveId).'"
        LIMIT 0,1
        ');
        
        foreach($QueryResult->result() as $row)
    	{
    	   $DateOfArchive = $row->link_date;
        }
        
        return $DateOfArchive;
    }
}

?>