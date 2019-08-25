<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Systemid extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('System_model');
        $this->load->library('form_validation');
        //$this->output->enable_profiler(true);
        
        $this->lang->load('system', $this->config->item('language'));
    }
    
    public function index($Action='',$SubAction="")
    {        
        if($_SESSION['user_id'] == "")
        {
            if($this->input->post('formlogin') == 'yes')
    		{
    			$this->form_validation->set_rules('user_email', ''.$this->lang->line('a0860').'', 'required|valid_email');
    			$this->form_validation->set_rules('user_password', ''.$this->lang->line('a0861').'', 'required');
    
    			if($this->form_validation->run() != FALSE)
    			{
    				$TableUser = $this->System_model->CheckUser();

    				if($TableUser['IsAuth'] == 'no')
                    {
                        $SystemLang['bad_data'] = true;
                    }
                    
                    if($TableUser['IsAuth'] == 'yes')
                    {
                        $_SESSION['user_id'] = $TableUser['UserId'];
                        redirect();
                    }
                }
            }
            
            $SystemLang['Title'] = ''.$this->lang->line('a0862').'';
            $SystemLang['Content'] = ''.$this->lang->line('a0863').'';
            
            $this->load->view('head',$SystemLang);
            
            $this->load->view('login', $SystemLang);
            
            $this->load->view('foot');
        }
        else
        {
            $SystemLang['Title'] = ''.$this->lang->line('a0864').'';
            $SystemLang['Content'] = ''.$this->lang->line('a0865').'';
            
            $this->load->view('head',$SystemLang);
            
            if($Action == 'delete')
            {
                $this->System_model->ProjectDelete($SubAction);
                $SystemLang['ProjectDeleted'] = true;
            }
            
            $this->load->view('project/show', $SystemLang);
            
            $this->load->view('foot');
        }
    }
    
    public function usedcomponents()
    {
        if($_SESSION['user_id'] == ""){redirect();exit();}
        
        $SystemLang['Title'] = ''.$this->lang->line('a1069').'';
        $SystemLang['Content'] = ''.$this->lang->line('a1070').'';
        
        $this->load->view('head',$SystemLang);
        
        $this->load->view('components', $SystemLang);
            
        $this->load->view('foot');
    }
    
    public function settingsofscript()
    {
        if($_SESSION['user_id'] == ""){redirect();exit();}
        
        $SystemLang['Title'] = ''.$this->lang->line('a0866').'';
        $SystemLang['Content'] = ''.$this->lang->line('a0867').'';
        
        $this->load->view('head',$SystemLang);
        
        if($this->input->post('addpage') == 'yes')
        {
            //$this->form_validation->set_rules('title', ''.$this->lang->line('a0868').'', 'required');
            $this->form_validation->set_rules('root_email', ''.$this->lang->line('a0869').'', 'required|valid_email');
            //$this->form_validation->set_rules('cron', ''.$this->lang->line('a0870').'', 'required');
                        
            if($this->form_validation->run() != FALSE)
            {
                $this->System_model->UpdateConfig();
                
                $SystemLang['content_added'] = true;
                
                $this->System_model->WriteLog($this->lang->line('a0542'));
            }

            $SystemLang['Ctitle'] = $this->input->post('title');
            $SystemLang['Croot_email'] = $this->input->post('root_email');
            $SystemLang['Ccron'] = $this->input->post('cron');
            $SystemLang['Cgoogle'] = $this->input->post('google');
        }
        else
        {
            $ConfigTable = $this->System_model->GetConfig();
            $SystemLang['Ctitle'] = $ConfigTable['title'];
            $SystemLang['Croot_email'] = $ConfigTable['root_email'];
            $SystemLang['Ccron'] = $ConfigTable['cron'];
            $SystemLang['Cgoogle'] = $ConfigTable['google'];
            
        }
        
        $this->load->view('user/settings', $SystemLang);
            
        $this->load->view('foot');
    }
    
    public function viewarchivereport($ArchiveId)
    {
        if($_SESSION['user_id'] == ""){redirect();exit();}
        
        $SystemLang['ReportId'] = $ArchiveId;
        
        $SystemLang['ArchiveDate'] = $this->System_model->SelectDateArchive($ArchiveId);
        
        $SystemLang['ProjectId'] = $this->System_model->SelectProjectNameByArchive($ArchiveId);
        $SystemLang['ProjectName'] = $this->System_model->SelectProjectName($SystemLang['ProjectId']);
        
        $SystemLang['Title'] = ''.$this->lang->line('a0871').'';
        $SystemLang['Content'] = ''.$this->lang->line('a0872').'';
        
        $this->load->view('head',$SystemLang);
        
        $this->load->view('link/archivereport', $SystemLang);
            
        $this->load->view('foot');
    }
    
    public function exportarchive($ArchiveId,$WhatExport)
    {
        if($_SESSION['user_id'] == ""){redirect();exit();}
        
        $TableHTTPCom[100] = '100 Continue';
        $TableHTTPCom[101] = '101 Switching Protocols';
        $TableHTTPCom[102] = '102 Processing (WebDAV)';
        $TableHTTPCom[200] = '200 OK';
        $TableHTTPCom[201] = '201 Created';
        $TableHTTPCom[202] = '202 Accepted';
        $TableHTTPCom[203] = '203 Non-Authoritative Information';
        $TableHTTPCom[204] = '204 No Content';
        $TableHTTPCom[205] = '205 Reset Content';
        $TableHTTPCom[206] = '206 Partial Content';
        $TableHTTPCom[207] = '207 Multi-Status (WebDAV)';
        $TableHTTPCom[208] = '208 Already Reported (WebDAV)';
        $TableHTTPCom[226] = '226 IM Used';
        $TableHTTPCom[300] = '300 Multiple Choices';
        $TableHTTPCom[301] = '301 Moved Permanently';
        $TableHTTPCom[302] = '302 Found';
        $TableHTTPCom[303] = '303 See Other';
        $TableHTTPCom[304] = '304 Not Modified';
        $TableHTTPCom[305] = '305 Use Proxy';
        $TableHTTPCom[306] = '306 (Unused)';
        $TableHTTPCom[307] = '307 Temporary Redirect';
        $TableHTTPCom[308] = '308 Permanent Redirect (experiemental)';
        $TableHTTPCom[400] = '400 Bad Request';
        $TableHTTPCom[401] = '401 Unauthorized';
        $TableHTTPCom[402] = '402 Payment Required';
        $TableHTTPCom[403] = '403 Forbidden';
        $TableHTTPCom[404] = '404 Not Found';
        $TableHTTPCom[405] = '405 Method Not Allowed';
        $TableHTTPCom[406] = '406 Not Acceptable';
        $TableHTTPCom[407] = '407 Proxy Authentication Required';
        $TableHTTPCom[408] = '408 Request Timeout';
        $TableHTTPCom[409] = '409 Conflict';
        $TableHTTPCom[410] = '410 Gone';
        $TableHTTPCom[411] = '411 Length Required';
        $TableHTTPCom[412] = '412 Precondition Failed';
        $TableHTTPCom[413] = '413 Request Entity Too Large';
        $TableHTTPCom[414] = '414 Request-URI Too Long';
        $TableHTTPCom[415] = '415 Unsupported Media Type';
        $TableHTTPCom[416] = '416 Requested Range Not Satisfiable';
        $TableHTTPCom[417] = '417 Expectation Failed';
        $TableHTTPCom[418] = '418 I\'m a teapot (RFC 2324)';
        $TableHTTPCom[420] = '420 Enhance Your Calm (Twitter)';
        $TableHTTPCom[422] = '422 Unprocessable Entity (WebDAV)';
        $TableHTTPCom[423] = '423 Locked (WebDAV)';
        $TableHTTPCom[424] = '424 Failed Dependency (WebDAV)';
        $TableHTTPCom[425] = '425 Reserved for WebDAV';
        $TableHTTPCom[426] = '426 Upgrade Required';
        $TableHTTPCom[428] = '428 Precondition Required';
        $TableHTTPCom[429] = '429 Too Many Requests';
        $TableHTTPCom[431] = '431 Request Header Fields Too Large';
        $TableHTTPCom[444] = '444 No Response (Nginx)';
        $TableHTTPCom[450] = '450 Blocked by Windows Parental Controls (Microsoft)';
        $TableHTTPCom[499] = '499 Client Closed Request (Nginx)';
        $TableHTTPCom[500] = '500 Internal Server Error';
        $TableHTTPCom[501] = '501 Not Implemented';
        $TableHTTPCom[502] = '502 Bad Gateway';
        $TableHTTPCom[503] = '503 Service Unavailable';
        $TableHTTPCom[504] = '504 Gateway Timeout';
        $TableHTTPCom[505] = '505 HTTP Version Not Supported';
        $TableHTTPCom[506] = '506 Variant Also Negotiates (Experimental)';
        $TableHTTPCom[507] = '507 Insufficient Storage (WebDAV)';
        $TableHTTPCom[508] = '508 Loop Detected (WebDAV)';
        $TableHTTPCom[509] = '509 Bandwidth Limit Exceeded (Apache)';
        $TableHTTPCom[510] = '510 Not Extended';
        $TableHTTPCom[511] = '511 Network Authentication Required';
        $TableHTTPCom[598] = '598 Network read timeout error';
        $TableHTTPCom[599] = '599 Network connect timeout error';

        $ResultDB = $this->System_model->SelectReportExport($ArchiveId,$WhatExport);
        
        $CSV[] = ''.$this->lang->line('a0873').'';
    
        foreach($ResultDB->result() as $row)
        {
            if($row->link_exists == '')
            {
                $row->link_exists = '-';
                $row->link_robots = '-'; 
                $row->link_nofollow = '-';
                $row->link_meta = '-';
                $row->link_http = '-';
                $row->link_howmany = '-';
            }
            
            if($row->link_exists == 'y'){$Exists = ''.$this->lang->line('a0874').'';}else{$Exists = ''.$this->lang->line('a0875').'';}
            if($row->link_robots == 'y'){$Robots = ''.$this->lang->line('a0874').'';}else{$Robots = ''.$this->lang->line('a0875').'';}
            if($row->link_nofollow == 'y'){$NoFollow = ''.$this->lang->line('a0874').'';}else{$NoFollow = ''.$this->lang->line('a0875').'';}
            if($row->link_meta == 'n'){$Meta = ''.$this->lang->line('a0876').'';}else{$Meta = $row->link_meta;}
            
            if($TableHTTPCom[$row->link_http] != "")
            {
                $HttpHeader = $TableHTTPCom[$row->link_http];
            }
            else
            {
                $HttpHeader = $row->link_http;
            }
            
            $CSV[] = htmlspecialchars_decode($row->link_url).';'.$row->link_text.';'.$Exists.';'.$Robots.';'.$NoFollow.';'.$Meta.';'.$HttpHeader.';'.$row->link_howmany;
        }

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=raport-".$ArchiveId."-".date('Y-m-d').".csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        
        for($i=0;$i<count($CSV);$i++)
        {
            echo $CSV[$i]."\n";
        }
    }
    
    public function proxysettings()
    {
	if($_SESSION['user_id'] == ""){redirect();exit();}
	            
	$SystemLang['Title'] = ''.$this->lang->line('a1075').'';
	$SystemLang['Content'] = ''.$this->lang->line('a1076').'';
	            
        $this->load->view('head',$SystemLang);
        
        //echo 'l';
        
        if($this->input->get('delete_proxy') == 'y')
        {
		$this->System_model->DeleteProxy($this->input->get('proxy_id'));
		
		$SystemLang['ProxyDeleted'] = 'yes';
	}
        
	$this->load->view('proxy/proxy', $SystemLang);
	        
        $this->load->view('foot');
    }
    
    
    public function isurlvalidproxy($Url)
    {
	    //if(!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $Url))
	    if (!filter_var($Url, FILTER_VALIDATE_URL))
	    {
		$this->form_validation->set_message('isurlvalidproxy', ''.$this->lang->line('a0883').'');
		return FALSE;
	    }
	    else
	    {
		return TRUE;
	    }
    }
    
    public function proxyadd()
    {
    	if($_SESSION['user_id'] == ""){redirect();exit();}
    	            
    	$SystemLang['Title'] = ''.$this->lang->line('a1084').'';
    	$SystemLang['Content'] = ''.$this->lang->line('a1085').'';
    	            
        $this->load->view('head',$SystemLang);

	if($this->input->post('formlogin') == 'yes')
	{
		$this->form_validation->set_rules('proxy_url', ''.$this->lang->line('a1086').'', 'required|valid_ip');
		$this->form_validation->set_rules('proxy_port', ''.$this->lang->line('a1087').'', 'required');
		//$this->form_validation->set_rules('proxy_user', ''.$this->lang->line('a1088').'', 'required');
		//$this->form_validation->set_rules('proxy_password', ''.$this->lang->line('a1089').'', 'required');

		if($this->form_validation->run() != FALSE)
		{
			$ResultDB = $this->System_model->ProxyAdd();

			$SystemLang['ProxyAdded'] = true;
		}
		else
		{
			$SystemLang['Vproxy_url'] = $this->input->post('proxy_url');
			$SystemLang['Vproxy_port'] = $this->input->post('proxy_port');
			$SystemLang['Vproxy_user'] = $this->input->post('proxy_user');
			$SystemLang['Vproxy_password'] = $this->input->post('proxy_password');
		}
	}

    	$this->load->view('proxy/proxyadd', $SystemLang);
    	        
        $this->load->view('foot');
    }
    
    public function proxyedit($ProxyId)
    {
	    $SystemLang['ProxyId'] = $ProxyId;
	    
	    if($_SESSION['user_id'] == ""){redirect();exit();}
	        	            
	$SystemLang['Title'] = ''.$this->lang->line('a1092').'';
	$SystemLang['Content'] = ''.$this->lang->line('a1093').'';

	$this->load->view('head',$SystemLang);

	if($this->input->post('formlogin') == 'yes')
	{
		$this->form_validation->set_rules('proxy_url', ''.$this->lang->line('a1086').'', 'required|valid_ip');
		$this->form_validation->set_rules('proxy_port', ''.$this->lang->line('a1087').'', 'required');
		//$this->form_validation->set_rules('proxy_user', ''.$this->lang->line('a1088').'', 'required');
		//$this->form_validation->set_rules('proxy_password', ''.$this->lang->line('a1089').'', 'required');

		if($this->form_validation->run() != FALSE)
		{
			$ResultDB = $this->System_model->ProxyEdit($ProxyId);

			$SystemLang['ProxyAdded'] = true;
		}
		//else
		//{
			$SystemLang['Vproxy_url'] = $this->input->post('proxy_url');
			$SystemLang['Vproxy_port'] = $this->input->post('proxy_port');
			$SystemLang['Vproxy_user'] = $this->input->post('proxy_user');
			$SystemLang['Vproxy_password'] = $this->input->post('proxy_password');
		//}
	}
	else
	{
		$ResultDB = $this->System_model->SelectProxyOne($ProxyId);
		        
	    foreach($ResultDB->result() as $row)
	    {
		$SystemLang['Vproxy_url'] = $row->proxy_url;
		$SystemLang['Vproxy_port'] = $row->proxy_port;
		$SystemLang['Vproxy_user'] = $row->proxy_user;
		$SystemLang['Vproxy_password'] = $row->proxy_password;
            }
	}

	$this->load->view('proxy/proxyedit', $SystemLang);
	        	        
        $this->load->view('foot');
    }
    
    public function importlink()
    {
        if($_SESSION['user_id'] == ""){redirect();exit();}
        
        $SystemLang['Title'] = ''.$this->lang->line('a0877').'';
        $SystemLang['Content'] = ''.$this->lang->line('a0878').'';
        
        $this->load->view('head',$SystemLang);
        
        if($this->input->post('addlink') == 'yes')
        {
            $this->load->helper('string');
            $MyRandomString = random_string('alpha',10);
                
            $config['upload_path'] = './uploads/';
    		$config['allowed_types'] = 'csv';
    		$config['max_size']	= '10000';
            $config['remove_spaces'] = true;
            $config['overwrite'] = true;
            $config['file_name'] = time().'_'.$MyRandomString.'.csv';
            
    		$this->load->library('upload', $config);
    
    		if (!$this->upload->do_upload('importfile'))
    		{
    			$SystemLang['UploadError'] = array('error' => $this->upload->display_errors());
    		}
    		else
    		{
    		  $data = $this->upload->data();
              
      		    $ReadFile = file('uploads/'.$data['file_name']);
                        
                if(count($ReadFile) == 0)
                {
                    $SystemLang['FileIsEmpty'] = true;
                }
                else
                {
                    $SystemLang['IsFielImport'] = true;
                    
                    $Color = 0;
                    
                        $SystemLang['Body'] .= '<div class="row RowColor3">';
                        $SystemLang['Body'] .= '
                        <div class="col-md-2">#</div>
                        <div class="col-md-6">'.$this->lang->line('a0879').'</div>
                        <div class="col-md-4">'.$this->lang->line('a0880').'</div>                        
                        ';
                        $SystemLang['Body'] .= '</div>';
                        
                    for($i=0;$i<count($ReadFile);$i++)
                    {
                        $ArrayWithRow = str_getcsv($ReadFile[$i], ';','"');
                        
                        /*echo '<pre>';
                        print_r($ArrayWithRow);
                        echo '</pre>';*/
                    
                        $LineNumber = $i + 1;
                        
                        if($this->IsGoodUrl($ArrayWithRow[0]))
                        {
                            $Comment = ''.$this->lang->line('a0881').'';
                            $this->System_model->ImportToProject($this->input->post('page_id'), $ArrayWithRow[0], $ArrayWithRow[1]);
                        }
                        else
                        {
                            $Comment = ''.$this->lang->line('a0882').'';
                        }
                        
                        if($Color == 0)
                        {
                            $SystemLang['Body'] .= '<div class="row RowColor1">';
                            $Color = 1;
                        }
                        else
                        {
                            $SystemLang['Body'] .= '<div class="row RowColor2">';
                            $Color = 0;
                        }
                        
                        $SystemLang['Body'] .= '
                        <div class="col-md-2">'.$LineNumber.'</div>
                        <div class="col-md-6">'.$ArrayWithRow[0].'</div>
                        <div class="col-md-4">'.$Comment.'</div>                        
                        ';
                        $SystemLang['Body'] .= '</div>';
                    }
                    
                    
                }
  		    }
        }
        
        $this->load->view('link/importlink', $SystemLang);
        
        $this->load->view('foot');
    }
    
    private function IsGoodUrl($Url)
    {
        if(!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $Url))
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
    public function isurlvalid($Url)
    {
        if(!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $Url))
        {
            $this->form_validation->set_message('isurlvalid', ''.$this->lang->line('a0883').'');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
    public function is_this_email2($str)
    {
        $ResultDB = $this->System_model->UserCheckEmail($str);
        
        foreach($ResultDB->result() as $row)
        {
            $HowManyEmail = $row->HowMany;
        }
        
        if($HowManyEmail == 0)
		{
			$this->form_validation->set_message('is_this_email2', ''.$this->lang->line('a0884').'');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
    }
    
    public function is_valid_catpcha($str)
    {
        if($_SESSION['CatpchaWord'] == $str)
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('is_valid_catpcha', ''.$this->lang->line('a0885').'');
			return FALSE;
        }
    }
    
    public function postpassword($UserId,$KeyPassword,$KeyPassword2)
    {
        $SystemLang['Title'] = ''.$this->lang->line('a0886').'';
        $SystemLang['Content'] = ''.$this->lang->line('a0887').'';
        
        $this->load->view('head',$SystemLang);
        
        $ResultDB = $this->System_model->CheckKeyPasswords($UserId,$KeyPassword,$KeyPassword2);

		foreach($ResultDB->result() as $row)
		{
            $HowManyIs = $row->HowMany;
          
            $SystemLang['change_password'] = false;
            
		    if($HowManyIs > 0)
            {                
                $this->load->helper('string');
                $TemporaryPassword = random_string('alnum', 10);
                        
                $this->System_model->ChangePasswordAutomat($UserId,$TemporaryPassword);
                
                $ResultDB4 = $this->System_model->SelectEmailContent('newpass');
                
                foreach($ResultDB4->result() as $row4)
    			{
        			 $ReadyTitle = $row4->email_title;
                     $ReadyContent = $row4->email_content;
                }
                
                $ResultDB5 = $this->System_model->GetUserDataById($UserId);
                
                foreach($ResultDB5->result() as $row5)
    			{
   			          $EmailOfShool = $row5->user_email;
                }
                
                $ReadyContent = str_replace('[new_password]',$TemporaryPassword,$ReadyContent);
                
                $DefUserDate = date('Y-m-d H:i:s');
                $DefUserIp = $_SERVER['REMOTE_ADDR'];
                
                $ReadyTitle = str_replace('[user_date]',$DefUserDate,$ReadyTitle);
                $ReadyTitle = str_replace('[user_ip]',$DefUserIp,$ReadyTitle);
                
                $ReadyContent = str_replace('[user_date]',$DefUserDate,$ReadyContent);
                $ReadyContent = str_replace('[user_ip]',$DefUserIp,$ReadyContent);
                
                $ContactAddress = $this->System_model->GetConfig();
                        
                require 'PHPMailer/PHPMailerAutoload.php';
                $mail = new PHPMailer;
    
                //$mail->SMTPDebug = 3;
                $mail->SMTPDebug = 0;
                //$mail->isSMTP();
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
                $mail->addAddress($EmailOfShool);
                
                $mail->isHTML(false);
                
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
                //echo $mail->ErrorInfo;
                    
                $SystemLang['change_password'] = true;
            }
        }
        
        $this->load->view('user/postpassword', $SystemLang);
            
        $this->load->view('foot');
    }
    
    public function getpassword()
    {
        $SystemLang['Title'] = ''.$this->lang->line('a0888').'';
        $SystemLang['Content'] = ''.$this->lang->line('a0889').'';
        
        $this->load->view('head',$SystemLang);
        
        if($this->input->post('formlogin') == 'yes')
		{
			$this->form_validation->set_rules('user_email', ''.$this->lang->line('a0890').'', 'required|valid_email|callback_is_this_email2');
            $this->form_validation->set_rules('user_captcha', ''.$this->lang->line('a0891').'', 'required|callback_is_valid_catpcha');
            
			if($this->form_validation->run() != FALSE)
			{
				$ResultDB = $this->System_model->UserCheckEmailSelect($this->input->post('user_email'));

				foreach($ResultDB->result() as $row)
				{
				    $UserId = $row->user_id;
                    $UserUsername = $row->user_email;
				}

                if(empty($UserUsername))
                {
                    $SystemLang['bad_data'] = true;
                }
                else
                {
                    $SystemLang['pswd_send'] = true;
                
                    $this->load->helper('string');
                    $KeyPassword = random_string('alnum', 20);
                    $KeyPassword2 = random_string('alnum', 20);
                    
                    $this->System_model->GenerateNewPassword($UserId,$KeyPassword,$KeyPassword2);
                    
                    $ResultDB = $this->System_model->SelectGenerateNewPassword($UserId,$KeyPassword,$KeyPassword2);
            
                    foreach($ResultDB->result() as $row)
        			{
        			     $UserDate = $row->password_time;
                         $UserIp = $row->password_ip;
                    }
                    
                    $ResultDB = $this->System_model->SelectEmailContent('recpassword');
            
                    foreach($ResultDB->result() as $row)
        			{
            			 $ReadyTitle = $row->email_title;
                         $ReadyContent = $row->email_content;
                    }
                    
                    $PrepareMyLink = base_url().'generate-password/'.$UserId.'/'.$KeyPassword.'/'.$KeyPassword2;
        
                    $ReadyContent = str_replace('[change_password]',$PrepareMyLink,$ReadyContent);
        
                    $ReadyTitle = str_replace('[user_date]',$UserDate,$ReadyTitle);
                    $ReadyTitle = str_replace('[user_ip]',$UserIp,$ReadyTitle);
                    
                    $ReadyContent = str_replace('[user_date]',$UserDate,$ReadyContent);
                    $ReadyContent = str_replace('[user_ip]',$UserIp,$ReadyContent);
                    
                    $ContactAddress = $this->System_model->GetConfig();
                        
                    require 'PHPMailer/PHPMailerAutoload.php';
                    $mail = new PHPMailer;
        
                    //$mail->SMTPDebug = 3;
                    $mail->SMTPDebug = 0;
                    //$mail->isSMTP();
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
                    
                    $mail->isHTML(false);
                    
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
		}
        
        $this->load->helper('captcha');
        $this->load->helper('string');
        $SystemLang['RandomString'] = random_string('alnum', 6);
                        
        $_SESSION['CatpchaWord'] = $SystemLang['RandomString'];
        
        $this->load->view('user/getpassword', $SystemLang);
            
        $this->load->view('foot');
    }
    
    public function editemail()
    {
        if($_SESSION['user_id'] == ""){redirect();exit();}
        
        $SystemLang['Title'] = ''.$this->lang->line('a0892').'';
        $SystemLang['Content'] = ''.$this->lang->line('a0893').'';
        
        $this->load->view('head',$SystemLang);
        
        if($this->input->post('formlogin') == 'yes')
		{
            $this->form_validation->set_rules('email_title1', ''.$this->lang->line('a0894').'', 'required');
            $this->form_validation->set_rules('email_title2', ''.$this->lang->line('a0894').'', 'required');
            //$this->form_validation->set_rules('email_title3', ''.$this->lang->line('a0894').'', 'required');
            $this->form_validation->set_rules('email_content1', ''.$this->lang->line('a0895').'', 'required');
            $this->form_validation->set_rules('email_content2', ''.$this->lang->line('a0895').'', 'required');
            //$this->form_validation->set_rules('email_content3', ''.$this->lang->line('a0895').'', 'required');
            
			if($this->form_validation->run() != FALSE)
			{
                $ResultDB = $this->System_model->UpdateEmails();
                
                $SystemLang['EmailUpdated'] = true;

            }
            
            $SystemLang['Femail_title1'] = $this->input->post('email_title1');
            $SystemLang['Femail_content1'] = $this->input->post('email_content1');
            $SystemLang['Femail_title2'] = $this->input->post('email_title2');
            $SystemLang['Femail_content2'] = $this->input->post('email_content2'); 	
            $SystemLang['Femail_title3'] = $this->input->post('email_title3');
            $SystemLang['Femail_content3'] = $this->input->post('email_content3'); 	
            
            $ResultDB = $this->System_model->SelectEmail('recpassword');
            foreach($ResultDB->result() as $row)
    		{
               $SystemLang['Femail_desc1'] = $row->email_desc; 	
            }
            
            $ResultDB = $this->System_model->SelectEmail('newpass');
            foreach($ResultDB->result() as $row)
    		{
               $SystemLang['Femail_desc2'] = $row->email_desc; 	
            }
            
            $ResultDB = $this->System_model->SelectEmail('report');
            foreach($ResultDB->result() as $row)
    		{
               $SystemLang['Femail_desc3'] = $row->email_desc; 	
            }
            
        }
        else
        {
            $ResultDB = $this->System_model->SelectEmail('recpassword');
            foreach($ResultDB->result() as $row)
    		{
    		   $SystemLang['Femail_title1'] = $row->email_title; 	
               $SystemLang['Femail_content1'] = $row->email_content; 	
               $SystemLang['Femail_desc1'] = $row->email_desc; 	
            }
            
            $ResultDB = $this->System_model->SelectEmail('newpass');
            foreach($ResultDB->result() as $row)
    		{
    		   $SystemLang['Femail_title2'] = $row->email_title; 	
               $SystemLang['Femail_content2'] = $row->email_content; 	
               $SystemLang['Femail_desc2'] = $row->email_desc; 	
            }
            
            $ResultDB = $this->System_model->SelectEmail('report');
            foreach($ResultDB->result() as $row)
    		{
    		   $SystemLang['Femail_title3'] = $row->email_title; 	
               $SystemLang['Femail_content3'] = $row->email_content; 	
               $SystemLang['Femail_desc3'] = $row->email_desc; 	
            }
        }
        
        $this->load->view('user/editemail', $SystemLang);
        
        $this->load->view('foot');
    }
    
    public function changepassword()
    {
        if($_SESSION['user_id'] == ""){redirect();exit();}
        
        $SystemLang['Title'] = ''.$this->lang->line('a0896').'';
        $SystemLang['Content'] = ''.$this->lang->line('a0897').'';
        
        $this->load->view('head',$SystemLang);
        
        if($this->input->post('formchange') == 'yes')
		{
            $this->form_validation->set_rules('user_pswd', ''.$this->lang->line('a0898').'', 'required');
			$this->form_validation->set_rules('user_pswd2', ''.$this->lang->line('a0899').'', 'required|min_length[8]|max_length[20]');
			$this->form_validation->set_rules('user_pswd3', ''.$this->lang->line('a0900').'', 'required|min_length[8]|max_length[20]|callback_checkisthesame');

			if($this->form_validation->run() != FALSE)
			{
                $ResultDB = $this->System_model->UserGetData();
                
                $PasswordMatch = false;
                
                foreach($ResultDB->result() as $row)
                {
                    if(password_verify($this->input->post('user_pswd'), $row->user_password) == false)
                    {
                        $PasswordMatch = true;
                    }
                }
                
                if($PasswordMatch)
                {
                    $SystemLang['PswdChangedError'] = true;
                }
                else
                {             
				    $this->System_model->UpdateUserPswd();
                    $SystemLang['PswdChanged'] = true;
                }
			}
		}
        
        $this->load->view('user/changepassword', $SystemLang);
        
        $this->load->view('foot');
    }
    
    public function checkisthesame($str)
    {
        if($this->input->post('user_pswd2') == $this->input->post('user_pswd3'))
        {
            return true;
        }
        else
        {
            $this->form_validation->set_message('checkisthesame', ''.$this->lang->line('a0901').'');
            return false;
        }
    }
    
    public function addnewproject()
    {
        if($_SESSION['user_id'] == ""){redirect();exit();}
        
        $SystemLang['Title'] = ''.$this->lang->line('a0902').'';
        $SystemLang['Content'] = ''.$this->lang->line('a0903').'';
        
        $this->load->view('head',$SystemLang);
        
        if($this->input->post('formlogin') == 'yes')
        {
            $this->form_validation->set_rules('project_name', ''.$this->lang->line('a0904').'', 'required');
            //$this->form_validation->set_rules('project_brief', ''.$this->lang->line('a0905').'', 'required');
            $this->form_validation->set_rules('project_href', ''.$this->lang->line('a0906').'', 'required');
            
            if($this->form_validation->run() != FALSE)
            {
                $this->System_model->ProjectAddNew();
                
                $SystemLang['Vproject_name'] = '';
                $SystemLang['Vproject_brief'] = '';
                $SystemLang['Vproject_href'] = '';
                $SystemLang['Fproject_long'] = '1';
            
                $SystemLang['IsAdded'] = true;
            }
            else
            {
                $SystemLang['Vproject_name'] = $this->input->post('project_name');
                $SystemLang['Vproject_brief'] = $this->input->post('project_brief');
                $SystemLang['Vproject_href'] = $this->input->post('project_href');
                $SystemLang['Fproject_long'] = $this->input->post('project_long');
            }
        }
        
        $this->load->view('project/add', $SystemLang);
        
        $this->load->view('foot');
    }
    
    public function editexistingproject($ProjectId)
    {
        if($_SESSION['user_id'] == ""){redirect();exit();}
        
        $SystemLang['ProjectId'] = $ProjectId;
        
        $SystemLang['Title'] = ''.$this->lang->line('a0907').'';
        $SystemLang['Content'] = ''.$this->lang->line('a0908').'';
        
        $this->load->view('head',$SystemLang);
        
        if($this->input->post('formlogin') == 'yes')
        {
            $this->form_validation->set_rules('project_name', ''.$this->lang->line('a0909').'', 'required');
            //$this->form_validation->set_rules('project_brief', ''.$this->lang->line('a0910').'', 'required');
            $this->form_validation->set_rules('project_href', ''.$this->lang->line('a0911').'', 'required');
            
            if($this->form_validation->run() != FALSE)
            {
                $this->System_model->ProjectEditExisting();
                $SystemLang['IsAdded'] = true;
            }
            
            $SystemLang['Vproject_name'] = $this->input->post('project_name');
            $SystemLang['Vproject_brief'] = $this->input->post('project_brief');
            $SystemLang['Vproject_href'] = $this->input->post('project_href');
            $SystemLang['Fproject_long'] = $this->input->post('project_long');
                
        }
        else
        {
            $ResultDB = $this->System_model->ProjectGetById($ProjectId);
        
            foreach($ResultDB->result() as $row)
            {
                $SystemLang['Vproject_name'] = $row->project_name;
                $SystemLang['Vproject_brief'] = $row->project_brief;
                $SystemLang['Vproject_href'] = $row->project_href;
                $SystemLang['Fproject_long'] = $row->project_long;
                $SystemLang['Fproject_email'] = $row->project_email;
            }
        }
        
        $this->load->view('project/edit', $SystemLang);
        
        $this->load->view('foot');
    }
    
    public function keywordadd($ProjectId)
    {
	    if($_SESSION['user_id'] == ""){redirect();exit();}
	            
	    $SystemLang['ProjectId'] = $ProjectId;

	    $SystemLang['ProjectName'] = $this->System_model->SelectProjectName($ProjectId);

	    $SystemLang['Title'] = ''.$this->lang->line('a1103').'';
        $SystemLang['Content'] = ''.$this->lang->line('a1104').'';
        
        if($this->input->post('formlogin') == 'yes')
	        {
	            $this->form_validation->set_rules('keyword_keyword', ''.$this->lang->line('a1109').'', 'required');

	            if($this->form_validation->run() != FALSE)
	            {
	                $this->System_model->KeywordAdd($ProjectId);
	                $SystemLang['IsAdded'] = true;
	            }	                
        }
        
        $this->load->view('head',$SystemLang);
	        
	        $this->load->view('project/addkeyword', $SystemLang);
	        
        $this->load->view('foot');
    }
    
    public function projectdetails($ProjectId,$Action='',$SubAction='')
    {
        if($_SESSION['user_id'] == ""){redirect();exit();}
        
        $SystemLang['ProjectId'] = $ProjectId;
        
        $SystemLang['ProjectDate'] = $this->input->get('project_date');
        
        $SystemLang['ProjectName'] = $this->System_model->SelectProjectName($ProjectId);
        
        $SystemLang['Title'] = ''.$this->lang->line('a0912').'';
        $SystemLang['Content'] = ''.$this->lang->line('a0913').'';
        
        if($this->input->get('delete_keyword') == 'y')
	        {
	            $this->System_model->DeleteKeyword($this->input->get('keyword_id'),$ProjectId);
	            $SystemLang['ProjectDeleted'] = true;
        }
        
        /*if($Action == 'deletelink')
        {
            $this->System_model->ProjectDeleteLink($SubAction);
            $SystemLang['ProjectDeleted'] = true;
        }
            
        if($this->input->post('action') == 'deleteallchecked')
        {
            $LinkToDelete = $this->input->post('deletelinkis');
            
            if($LinkToDelete != null)
            {
                for($i=0;$i<count($LinkToDelete);$i++)
                {
                    $this->System_model->ProjectDeleteLink($LinkToDelete[$i]);
                }
                
                $SystemLang['LinkDeleted'] = true;
            }
            
            $SystemLang['ProjectDeleted'] = true;
        }*/
        
        $this->load->view('head',$SystemLang);
        
        $this->load->view('project/details', $SystemLang);
        
        $this->load->view('foot');
    }
    
    public function checklinkbyhand($ProjectId)
    {
        if($_SESSION['user_id'] == ""){redirect();exit();}
        
        $SystemLang['ProjectId'] = $ProjectId;
        $SystemLang['ProjectName'] = $this->System_model->SelectProjectName($ProjectId);
        
        $SystemLang['Title'] = ''.$this->lang->line('a0914').'';
        $SystemLang['Content'] = ''.$this->lang->line('a0915').'';
        
        $this->System_model->ProjectResetHandCheck($ProjectId);
        
        $this->load->view('head',$SystemLang);
        
        $this->load->view('link/check', $SystemLang);
        
        $this->load->view('foot');
    }
    
    public function viewarchive($ProjectId)
    {
        if($_SESSION['user_id'] == ""){redirect();exit();}
        
        $SystemLang['ProjectId'] = $ProjectId;
        $SystemLang['ProjectName'] = $this->System_model->SelectProjectName($ProjectId);
        
        $SystemLang['Title'] = ''.$this->lang->line('a0916').'';
        $SystemLang['Content'] = ''.$this->lang->line('a0917').'';
        
        $this->load->view('head',$SystemLang);
        
        $this->load->view('link/archive', $SystemLang);
        
        $this->load->view('foot');
    }
    
    public function linkaddnew($ProjectId)
    {
        if($_SESSION['user_id'] == ""){redirect();exit();}
        
        $SystemLang['ProjectId'] = $ProjectId;
        $SystemLang['ProjectName'] = $this->System_model->SelectProjectName($ProjectId);
        
        $SystemLang['Title'] = ''.$this->lang->line('a0918').'';
        $SystemLang['Content'] = ''.$this->lang->line('a0919').'';
        
        $this->load->view('head',$SystemLang);
        
        if($this->input->post('formlogin') == 'yes')
        {
            $this->form_validation->set_rules('link_url', ''.$this->lang->line('a0920').'', 'required|callback_isurlvalid');
            $this->form_validation->set_rules('link_text', ''.$this->lang->line('a0921').'', 'required');
            
            if($this->form_validation->run() != FALSE)
            {
                $this->System_model->ProjectAddNewLnik($ProjectId);
                
                $SystemLang['Vlink_url'] = '';
                $SystemLang['Vlink_text'] = '';
                
                $SystemLang['IsAdded'] = true;
            }
            else
            {
                $SystemLang['Vlink_url'] = $this->input->post('link_url');
                $SystemLang['Vlink_text'] = $this->input->post('link_text');
            }
        }
        
        $this->load->view('project/addlink', $SystemLang);
        
        $this->load->view('foot');
    }
    
    public function linkeditexisting($LinkId)
    {
        if($_SESSION['user_id'] == ""){redirect();exit();}
        
        $SystemLang['LinkId'] = $LinkId;
        
        $SystemLang['ProjectId'] = $this->System_model->SelectProjectIdByLink($LinkId);
        $SystemLang['ProjectName'] = $this->System_model->SelectProjectNameByLink($LinkId);
        
        $SystemLang['Title'] = ''.$this->lang->line('a0922').'';
        $SystemLang['Content'] = ''.$this->lang->line('a0923').'';
        
        $this->load->view('head',$SystemLang);
        
        if($this->input->post('formlogin') == 'yes')
        {
            $this->form_validation->set_rules('link_url', ''.$this->lang->line('a0924').'', 'required|callback_isurlvalid');
            $this->form_validation->set_rules('link_text', ''.$this->lang->line('a0925').'', 'required');
            
            if($this->form_validation->run() != FALSE)
            {
                $this->System_model->ProjectEditExistingLink();
                $SystemLang['IsAdded'] = true;
            }
            
            $SystemLang['Vlink_url'] = $this->input->post('link_url');
            $SystemLang['Vlink_text'] = $this->input->post('link_text');                
        }
        else
        {
            $ResultDB = $this->System_model->ProjectGetLinkById($LinkId);
        
            foreach($ResultDB->result() as $row)
            {
                $SystemLang['Vlink_url'] = $row->link_url;
                $SystemLang['Vlink_text'] = $row->link_text;
            }
        }
        
        $this->load->view('project/editlink', $SystemLang);
        
        $this->load->view('foot');
    }
    
    public function logout()
    {
        if($_SESSION['user_id'] == "")
        {
            redirect('');
            exit();
        }
        
        $_SESSION['user_id'] = '';
        redirect();
    }
    
    public function error404()
    {
        redirect('');
    }
}

?>