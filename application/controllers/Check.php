<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

set_time_limit(10 * 60);

// 700
// 1440

error_reporting(E_ALL & ~E_WARNING & ~E_PARSE & ~E_NOTICE);

class Check extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('System_model');
        $this->lang->load('system', $this->config->item('language'));
    }

    public function cron()
    {
        $ConfigTable = $this->System_model->GetConfig();
        $HowManyTimes = $ConfigTable['cron'];
        
        for($z=0;$z<$HowManyTimes;$z++)
        {
            $ResultDB = $this->System_model->KeywordSelectGet();
            
            foreach($ResultDB->result() as $row)
            {
                $WebPage = $this->System_model->SelectPageOverId($row->keyword_project_id);
                
                $Result = $this->System_model->ProxySelectGet();
                
                $ResultSearch = null;
                
                if($Result == 'self_connection')
                {
                    // Bez proxy
                    $IsOnList = false;
                    for($i=1;$i<11;$i++)
                    {
                        $TimeRand = rand(5,15);
                        sleep($TimeRand);

                        //echo $row->keyword_keyword.'_'.$WebPage.'_'.$i.'<br />';

                        $ResultSearch = $this->CheckOutLink($row->keyword_keyword,$WebPage,$i);
                        if($ResultSearch['result'] != false)
                        {
                            echo '---------'.$ResultSearch['result'].'----------<br />';
                            $this->System_model->KeywordInsertResult($row->keyword_id,$ResultSearch['result']);
                            $IsOnList = true;
                            break;
                        }
                        echo $ResultSearch['result'].'-'.$ResultSearch['url'].'<br />';
                    }
                    
                    if($IsOnList == false)
                    {
                        $this->System_model->KeywordInsertResult($row->keyword_id,'101');
                    }

                    //echo 'jestem';
                }
                else
                {
                    foreach($Result->result() as $row2)
                    {
                        $ProxyUrl = $row2->proxy_url;
                        $ProxyPort = $row2->proxy_port;
                        $ProxyUser = $row2->proxy_user;
                        $ProxyPaqssword = $row2->proxy_password;
                    }
                    
                    // Z proxy
                    $IsOnList = false;
                    for($i=1;$i<11;$i++)
                    {
                        $TimeRand = rand(5,15);
                        sleep($TimeRand);

                        $ResultSearch = $this->CheckOutLink($row->keyword_keyword,$WebPage,$i,$ProxyUrl,$ProxyPort,$ProxyUser,$ProxyPaqssword);
                        if($ResultSearch['result'] != false)
                        {
                            $this->System_model->KeywordInsertResult($row->keyword_id,$ResultSearch['result']);
                            $IsOnList = true;
                            break;
                        }
                        echo $ResultSearch['result'].'-'.$ResultSearch['url'].'<br />';
                    }
                    
                    if($IsOnList == false)
                    {
                        $this->System_model->KeywordInsertResult($row->keyword_id,'101');
                    }
                }
            }
            
            $ResultDB = $this->System_model->KeywordUpdateCheck($row->keyword_id);
        }
    }
    
    private function CheckOutLink($Keyword,$WebPage,$FieldNumberCheck,$ProxyUrl='',$ProxyPort='',$ProxyUser='',$ProxyPaqssword='')
    {
        $ConfigTable = $this->System_model->GetConfig();
        $EndOfUrl = $ConfigTable['google'];
            
        if($EndOfUrl == "")
        {
            $EndOfUrl = 'com';
        }
        
        $ThisCheckingIs = $FieldNumberCheck;
        
        if($FieldNumberCheck == 1)
        {
            $url = 'http://www.google.'.$EndOfUrl.'/search?q='.urlencode($Keyword);
        }
        else
        {
            $FieldNumberCheck = ($FieldNumberCheck * 10) - 10;
            $url = 'http://www.google.'.$EndOfUrl.'/search?q='.urlencode($Keyword).'&start='.$FieldNumberCheck;
        }
        
        $CheckingResult['url'] = $url;
        $CheckingResult['result'] = false;
           
	    $ch = curl_init();
	    		
	    curl_setopt($ch, CURLOPT_HEADER, 0);
        
        //$ProxyUrl = '104.236.139.208';
        //$ProxyPort = '80';

        if($ProxyUrl != "")
        {
            $ProxyCurl = $ProxyUrl.':'.$ProxyPort;
            $ProxyCurlAuth = $ProxyUser.':'.$ProxyPaqssword;
    
            //echo $ProxyCurl;
            
            curl_setopt($ch, CURLOPT_PROXY, $ProxyCurl);
            if($ProxyUser != ':')
            {
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $ProxyCurlAuth);
            }

            //curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5); 
        }

	    curl_setopt($ch, CURLOPT_COOKIEFILE, "cookiefile");
	    curl_setopt($ch, CURLOPT_COOKIEJAR, "cookiefile");
	    curl_setopt($ch, CURLOPT_USERAGENT, 'User-Agent=Mozilla/5.0 (Windows NT 6.1; rv:6.0) Gecko/20100101 Firefox/5.0');
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_URL, $url);
	    
	    $CurlResponse = curl_exec($ch);
	    curl_close($ch);

        //echo 'aaa';
        
        $DOM = new DOMDocument;
        $DOM->strictErrorChecking = false;
        libxml_use_internal_errors(false);
        $DOM->loadHTML($CurlResponse);
        
        //echo $CurlResponse;
        
        //if($ThisCheckingIs == 1)
        //{
            //file_put_contents('file1.txt',$CurlResponse);    
        //}
        
        $SetForEachNumberCheck = $FieldNumberCheck;
        
        //echo $SetForEachNumberCheck.'<br /><br />';
        //echo $WebPage,'<br /><br />';
        
        $i = $FieldNumberCheck - 1;
        $PageUrl = $WebPage;
        //$PagePozition = 0;

        foreach ($DOM->getElementsByTagName('h3') as $Node) 
        {
            $Value = $Node->getAttribute('class');
            
            if($Value == 'r')
            {
                foreach($Node->getElementsByTagName('a') as $NodeA)
                {
                    if(strrpos($NodeA->getAttribute('href'), '/url?q=http://webcache.googleusercontent.com/', -strlen($NodeA->getAttribute('href'))) === false)
                    {
                        if(strrpos($NodeA->getAttribute('href'), '/search?q=', -strlen($NodeA->getAttribute('href'))) === false)
                        {
                            $i++;

                            if (strpos($NodeA->getAttribute('href'), $PageUrl) !== false)
                            {
                                echo $NodeA->getAttribute('href').'<br />';
                                echo $NodeA->nodeValue.'<br /><br />';

                                //$PagePozition = $i;
                                $CheckingResult['result'] = $i;
                                break;
                                $IsNowBreak = true;
                            }
                            else 
                            {
                                echo $NodeA->getAttribute('href').'<br />';
                                echo $NodeA->nodeValue.'<br /><br />';
                            }
                        }
                    }
                }
                
                if($IsNowBreak)
                {
                    break;
                }
            }
        }

        //echo $PagePozition;

        /*
        foreach ($DOM->getElementsByTagName('h3') as $Node) 
        {
            echo 'jest';
            echo $Value.'<br /><br />';

            $Value = $Node->getAttribute('class');
            
            if($Value == 'r')
            {

                foreach($Node->getElementsByTagName('a') as $NodeA)
                {
                    if(strrpos($NodeA->getAttribute('href'), '/url?q=http://webcache.googleusercontent.com/', -strlen($NodeA->getAttribute('href'))) === false)
                    {
                        if(strrpos($NodeA->getAttribute('href'), '/search?q=', -strlen($NodeA->getAttribute('href'))) === false))
                        {
                            echo $ResultFindUrl = $NodeA->getAttribute('href').'<br />';
                            echo $NodeA->nodeValue.'<br /><br />';

                            $pos = strpos($ResultFindUrl, $WebPage);

                            if ($pos !== false) 
                            {
                                $CheckingResult['result'] = $SetForEachNumberCheck;
                                break;
                            }

                            $SetForEachNumberCheck++;
                        }
                    }
                }
            }
        }
        */
        
        /*if($ThisCheckingIs == 7)
        {
            $CheckingResult['result'] = 72;
        }*/
        
        //echo 'Rezultat całość: '.$CheckingResult['result'].'<br /><br />';
        
        return $CheckingResult;
            
	}
}

?>