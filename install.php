<?php

// Pole e-mail
error_reporting(E_ALL & ~E_NOTICE);

session_start();

//echo $_POST['select_language'];

if($_POST['change_language'] == 'yes')
{
    $_SESSION['language_install'] = $_POST['select_language'];
}
    
if($_SESSION['language_install'] == '')
{
    $_SESSION['language_install'] = 'english';
}

$LanguageSelected = $_SESSION['language_install'];
    
$SqlQuert[] = "CREATE TABLE IF NOT EXISTS [DBPREFIX]config (
  config_id int(11) NOT NULL,
  config_name varchar(15) NOT NULL,
  config_value varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;";

$SqlQuert[] = "INSERT INTO [DBPREFIX]config (config_id, config_name, config_value) VALUES
(1, 'title', 'Sprawdzanie linków'),
(2, 'description', 'strona do sprawdzania linków'),
(3, 'keywords', 'sprawdzanie, link, linków'),
(4, 'root_email', '[USER_EMAIL]'),
(5, 'foot', 'Copyright &copy; <a href=\"http://phpbluedragon.eu/documentation/phpbluedragon-getpozition/\">phpBlueDragon GetPozition</a>'),
(6, 'column', 'project_keys'),
(7, 'order', 'asc'),
(8, 'column2', 'link_exists'),
(9, 'order2', 'desc'),
(10, 'column3', 'link_url'),
(11, 'order3', 'desc'),
(12, 'cron', '1'),
(13, 'google', 'com');";

$SqlQuert[] = "CREATE TABLE IF NOT EXISTS [DBPREFIX]keywords (
  keyword_id int(11) NOT NULL,
  keyword_project_id int(11) NOT NULL,
  keyword_keyword varchar(255) NOT NULL,
  keyword_lasttest date NOT NULL,
  keyword_page1 char(1) NOT NULL,
  keyword_page2 char(1) NOT NULL,
  keyword_page3 char(1) NOT NULL,
  keyword_page4 char(1) NOT NULL,
  keyword_page5 char(1) NOT NULL,
  keyword_page6 char(1) NOT NULL,
  keyword_page7 char(1) NOT NULL,
  keyword_page8 char(1) NOT NULL,
  keyword_page9 char(1) NOT NULL,
  keyword_page10 char(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;";

$SqlQuert[] = "CREATE TABLE IF NOT EXISTS [DBPREFIX]keyword_date (
  date_id int(11) NOT NULL,
  date_keyword_id int(11) NOT NULL,
  date_date date NOT NULL,
  date_poz char(3) NOT NULL,
  date_result text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8;";


$SqlQuert[] = "CREATE TABLE IF NOT EXISTS [DBPREFIX]log (
  log_id int(11) NOT NULL,
  log_user_id int(11) NOT NULL,
  log_what varchar(255) NOT NULL,
  log_time datetime NOT NULL,
  log_ip varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;";


$SqlQuert[] = "CREATE TABLE IF NOT EXISTS [DBPREFIX]login (
  login_id int(11) NOT NULL,
  login_ip varchar(15) NOT NULL,
  login_time varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";


$SqlQuert[] = "CREATE TABLE IF NOT EXISTS [DBPREFIX]password (
  password_id int(11) NOT NULL,
  password_user_id int(11) NOT NULL,
  password_hash1 varchar(20) NOT NULL,
  password_hash2 varchar(20) NOT NULL,
  password_time datetime NOT NULL,
  password_ip varchar(15) NOT NULL,
  password_used char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$SqlQuert[] = "CREATE TABLE IF NOT EXISTS [DBPREFIX]project (
  project_id int(11) NOT NULL,
  project_href varchar(255) NOT NULL,
  project_name varchar(255) NOT NULL,
  project_brief text NOT NULL,
  project_exists varchar(255) NOT NULL,
  project_lastcheck date NOT NULL,
  project_noexists varchar(255) NOT NULL,
  project_check char(1) NOT NULL,
  project_long int(11) NOT NULL,
  project_email char(1) NOT NULL,
  project_keys int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;";

$SqlQuert[] = "CREATE TABLE IF NOT EXISTS [DBPREFIX]proxy (
  proxy_id int(11) NOT NULL,
  proxy_url varchar(255) NOT NULL,
  proxy_port int(11) NOT NULL,
  proxy_user varchar(120) NOT NULL,
  proxy_password varchar(120) NOT NULL,
  proxy_select char(1) NOT NULL,
  proxy_used int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";


$SqlQuert[] = "ALTER TABLE [DBPREFIX]config
  ADD PRIMARY KEY (config_id);";

$SqlQuert[] = "ALTER TABLE [DBPREFIX]keywords
  ADD PRIMARY KEY (keyword_id),
  ADD KEY keyword_project_id (keyword_project_id);";

$SqlQuert[] = "ALTER TABLE [DBPREFIX]keyword_date
  ADD PRIMARY KEY (date_id),
  ADD KEY date_keyword_id (date_keyword_id);";

$SqlQuert[] = "ALTER TABLE [DBPREFIX]log
  ADD PRIMARY KEY (log_id);";

$SqlQuert[] = "ALTER TABLE [DBPREFIX]login
  ADD PRIMARY KEY (login_id);";

$SqlQuert[] = "ALTER TABLE [DBPREFIX]password
  ADD PRIMARY KEY (password_id);";

$SqlQuert[] = "ALTER TABLE [DBPREFIX]project
  ADD PRIMARY KEY (project_id);";

$SqlQuert[] = "ALTER TABLE [DBPREFIX]proxy
  ADD PRIMARY KEY (proxy_id);";

$SqlQuert[] = "ALTER TABLE [DBPREFIX]config
  MODIFY config_id int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;";

$SqlQuert[] = "ALTER TABLE [DBPREFIX]keywords
  MODIFY keyword_id int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;";

$SqlQuert[] = "ALTER TABLE [DBPREFIX]keyword_date
  MODIFY date_id int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=124;";

$SqlQuert[] = "ALTER TABLE [DBPREFIX]log
  MODIFY log_id int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;";

$SqlQuert[] = "ALTER TABLE [DBPREFIX]login
  MODIFY login_id int(11) NOT NULL AUTO_INCREMENT;";

$SqlQuert[] = "ALTER TABLE [DBPREFIX]password
  MODIFY password_id int(11) NOT NULL AUTO_INCREMENT;";

$SqlQuert[] = "ALTER TABLE [DBPREFIX]project
  MODIFY project_id int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;";

$SqlQuert[] = "ALTER TABLE [DBPREFIX]proxy
  MODIFY proxy_id int(11) NOT NULL AUTO_INCREMENT;";

$SqlQuert[] = "ALTER TABLE [DBPREFIX]keywords
  ADD CONSTRAINT [DBPREFIX]keywords_ibfk_1 FOREIGN KEY (keyword_project_id) REFERENCES [DBPREFIX]project (project_id) ON DELETE CASCADE ON UPDATE NO ACTION;";

$SqlQuert[] = "ALTER TABLE [DBPREFIX]keyword_date
  ADD CONSTRAINT [DBPREFIX]keyword_date_ibfk_1 FOREIGN KEY (date_keyword_id) REFERENCES [DBPREFIX]keywords (keyword_id) ON DELETE CASCADE ON UPDATE NO ACTION;";

$SqlQuert[] = "CREATE TABLE IF NOT EXISTS [DBPREFIX]email (
  email_id int(11) NOT NULL AUTO_INCREMENT,
  email_title varchar(255) NOT NULL,
  email_content text NOT NULL,
  email_what varchar(15) NOT NULL,
  email_desc text NOT NULL,
  PRIMARY KEY (email_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;";

/*$SqlQuert[] = "ALTER TABLE [DBPREFIX]email
  ADD PRIMARY KEY (email_id);";
  
$SqlQuert[] = "ALTER TABLE [DBPREFIX]email
  MODIFY email_id int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;";*/


if($_SESSION['language_install'] == 'polish')
{
    $SqlQuert[] = "INSERT INTO [DBPREFIX]email (email_id, email_title, email_content, email_what, email_desc) VALUES
    (2, 'Przypominanie hasła', 'Dzień dobry\r\n\r\nZażądałeś przypomnienia hasła. W tym celu kliknij w link:\r\n[change_password]\r\n\r\nProśba o przypomnienie została wysłana [user_date]\r\nz komputera o IP: [user_ip]', 'recpassword', '[change_password] - łącze zmiany hasła\r\n[user_date] - data wysłania\r\n[user_ip] - IP komputera'),
    (3, 'Twoje hasło zostało zmienione', 'Dzień dobry\r\n\r\nGratuluje przeprowadzenia poprawnego procesu zmiany hasła. Nowe hasło do serwisu:\r\n\r\n[new_password]\r\n\r\nNowe hasło zostało wygenerowane: [user_date]\r\nz komputera o IP [user_ip]', 'newpass', '[new_password] - hasło do serwisu\r\n[user_date] - data wysłania\r\n[user_ip] - IP komputera'),
    (5, 'Raport ze sparawdzania linków', '[user_content]', 'report', '[user_content] - treść raportu');";
}
else
{
    $SqlQuert[] = "INSERT INTO [DBPREFIX]email (email_id, email_title, email_content, email_what, email_desc) VALUES
    (2, 'Password reminder on the site phpBlueDragon GetPozition', 'Good morning,\n\nYou requested a password reminder. To do this, click on the link: \n[change_password]\n\nRequest reminder was sent: [user_date]\nComputer with the IP: [user_ip] ','recpassword',' [change_password] - link to change your password\r\n[user_date] - the date of sending\r\n[user_ip] - computer IP'),
	(3, 'Your password has been changed on the site phpBlueDragon GetPozition', 'The new password to the site:\n\n[new_password]\n\nNew password was generated: [user_date]\nPC IP: [user_ip]','newpass','[new_password] - password to the site\r\n[user_date] - the date of sending\r\n[user_ip] - computer IP'),
    (5, 'The report link checker phpBlueDragon GetPozition', '[user_content]', 'report', '[user_content] - content of the report');";
}

$SqlQuert[] = "CREATE TABLE IF NOT EXISTS [DBPREFIX]user (
   user_id int(11) NOT NULL AUTO_INCREMENT,
  user_email varchar(90) NOT NULL,
  user_password varchar(255) NOT NULL,
  user_key varchar(20) NOT NULL,
  PRIMARY KEY (user_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;";

$SqlQuert[] = "ALTER TABLE [DBPREFIX]user
ADD UNIQUE(user_email);";

/*
$SqlQuert[] = "ALTER TABLE [DBPREFIX]user
  MODIFY user_id int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;";
*/

$SqlQuert[] = "INSERT INTO [DBPREFIX]user (user_id, user_email, user_password, user_key) VALUES
(1, '[USER_EMAIL]', '[USER_PASSWORD]', '');";

function GetLang($Line)
{
    if($_SESSION['language_install'] == 'polish')
    {
    	$lang['install_title'] = 'Instalator programu';
    	$lang['install_select_language'] = 'Wybór języka';
    	$lang['install_set_language'] = 'Wybierz język: ';
    	$lang['install_nex_step_button'] = 'Następny krok';
    	$lang['install_check_requirements'] = 'Sprawdzenie wymagań';
    	$lang['install_version_php'] = 'Wersja PHP (przynajmniej 7): ';
    	$lang['install_akcept'] = 'Akceptuje';
    	$lang['install_not_akcept'] = 'Brak lub wersja zbyt niska';
    	$lang['install_function_steam_socket'] = 'Funkcja - stream_socket_client(): ';
    	$lang['install_mod_rewrite'] = 'Mod Rewrite: ';
    	$lang['install_reqbrief'] = 'Oprócz poniższych wymagań serwerem powinien być <strong>Apache</strong>, potrzebuje modułu: <strong>mod_rewrite</strong> oraz bazę danych <strong>MySQL/MariaDB w wersji 5/10 lub wyższej</strong>. Po stronie klienta (Twoim) powinna znajdować się przeglądarka potrafiąca obsługiwać funkcje <strong>AJAX (jQuery)</strong> (są to wszystkie najpopularniejsze przeglądarki, pamiętaj o tym aby aktywować <strong>JavaScript</strong>, jeżeli jest nieaktywny).';
    	$lang['install_reqdont'] = 'Serwer nie spełnia wymagań minimalnych - instalacja jest niemożliwa.';
    	$lang['install_mysql_lib'] = 'Biblioteka MySQL/MariaDB: ';
    	$lang['install_config_path'] = 'Konfiguracja ścieżki';
    	$lang['install_address_url'] = 'Adres URL lokalizacji systemu: ';
    	$lang['install_url_is_not_valid'] = 'Adres URL jest niepoprawny';
    	$lang['install_config_path_error'] = 'Adres URL lokalizacji systemu';
    	$lang['install_post_server'] = 'Serwer pocztowy';
    	$lang['install_catalog_access'] = 'Dostęp do katalogów';
    	$lang['install_calogname'] = 'Katalog: ';
    	$lang['install_catalogcom1'] = 'Uprawnienia poprawne';
    	$lang['install_catalogcom2'] = 'Brak uprawnień - system nie będzie działał prawidłowo';
    	$lang['install_filename'] = 'Dostęp do plików';
    	$lang['install_catalogbrief'] = 'Dostęp do katalogów powienien zostać ustawiony w sposób, aby można było tworzyć w nich katalogi oraz zapisywać pliki. W systemie Linux możesz nadać im odpowiednie prawa poprzez komendę: <strong>chmod 777 NazwaKatalogu</strong>.';
    	$lang['install_filebrief'] = 'Dostęp do plików powienien zostać ustawiony w sposób, aby można było w nich zapisywać dane. W systemie Linux możesz nadać im odpowiednie prawa poprzez komendę: <strong>chmod 666 NazwaPliku</strong>.';
    	$lang['install_filenameone'] = 'Plik: ';
    	$lang['install_serversmtp'] = 'Serwer SMTP';
    	$lang['install_serversmtpbrief'] = 'Podaj dane do konta z którego mają być wysyłane informacje przeznaczone do wysyłania listów e-mial przez system, z danymi podczas rejestracji konta, przypominaniem hasła itp.';
    	$lang['install_smtpname'] = 'Nazwa osoby/firmy wysyłającej e-mail: ';
    	$lang['install_smtpaddress'] = 'Adres serwera SMTP: ';
    	$lang['install_smtplogin'] = 'Login do serwera SMTP: ';
    	$lang['install_smtppswd'] = 'Hasło do serwera SMTP: ';
    	$lang['install_smtpport'] = 'Port do serwera SMTP: ';
    	$lang['install_smtpname2'] = 'Nazwa osoby/firmy wysyłającej e-mail';
    	$lang['install_smtpaddress2'] = 'Adres serwera SMTP';
    	$lang['install_smtplogin2'] = 'Login do serwera SMTP';
    	$lang['install_smtppswd2'] = 'Hasło do serwera SMTP';
    	$lang['install_smtpport2'] = 'Port do serwera SMTP';
    	$lang['install_db'] = 'Baza danych';
    	$lang['install_dbbrief'] = 'Podaj dane do konfiguracji połączenia z bazą danych MySQL/MariaDB takie jak: host, nazwa bazy danych, login i hasło oraz prefix dla tabel.';
    	$lang['install_dbhostname'] = 'Nazwa serwera: ';
    	$lang['install_dbusername'] = 'Nazwa użytkownika: ';
    	$lang['install_dbpassword'] = 'Hasło użytkownika: ';
    	$lang['install_dbdatabase'] = 'Nazwa bazy danych: ';
    	$lang['install_dbprefix'] = 'Prefix tabel: ';
    	$lang['install_dbhostname2'] = 'Nazwa serwera: ';
    	$lang['install_dbusername2'] = 'Nazwa użytkownika: ';
    	$lang['install_dbpassword2'] = 'Hasło użytkownika: ';
    	$lang['install_dbdatabase2'] = 'Nazwa bazy danych: ';
    	$lang['install_dbprefix2'] = 'Prefix tabel: ';
    	$lang['install_instalsystembutton'] = 'Zainstaluj system';
    	$lang['install_subbar'] = 'Instalator programu phpBlueDragon GetPozition';
    	$lang['install_havespaces'] = 'Ciąg zawiera spacje, powinien zostać zapisany bez spacji';
    	$lang['install_noabilityconnecttodb'] = 'Nie można nawiązać połączenia z bazą danych - sprawdź dane które podałeś.';
    	$lang['install_fieldhastobefilled'] = 'Pole musi zostać wypełnione';
    	$lang['install_fieldisnotnumber'] = 'Pole musi zawierać liczbę całkowitą';
    	$lang['install_errorocured'] = 'Wystąpiły błędy, sprawdź pola poniżej!';
    	$lang['install_changelangsubmit'] = 'Zmień język';
        
        // v.1.beta
        $lang['install2_email_address'] = 'E-mail administratora: ';
        $lang['install2_emailaddrisntcorrect'] = 'Adres e-mail jest niepoprawny'; 
        $lang['install2_gratulations'] = '<h2>Gratulacje</h2>Instalacja została zakończona.<br /><br />Login: <strong>[LOGIN]</strong><br />Hasło: <strong>[PASSWORD]</strong><br /><br /><strong>Pamiętaj, należy usunąć plik &quot;install.php&quot; z serwera.</strong>';
        
        // v.2.beta
    	$lang['install3_port'] = 'Port: ';
    	$lang['install3_acces'] = 'Uwierzytalnianie: ';
    	$lang['install3_text'] = 'Czysty tekst';
    	$lang['install3_tls'] = 'TLS';
    	$lang['install3_tableprefixis'] = 'Tabele z podanym prefixem istnieją już w bazie danych';
        
		// GetPozition
    	$lang['install_curl'] = 'CURL';
    	$lang['install_dom'] = 'DOMDocument';
    	$lang['install_'] = '';
    	$lang['install_'] = '';
    	$lang['install_'] = '';
    }
    else
    {
        $lang['install_title'] = 'Setup'; 
        $lang['install_select_language'] = 'Select Language'; 
        $lang['install_set_language'] = 'Select Language'; 
        $lang['install_nex_step_button'] = 'Next step'; 
        $lang['install_check_requirements'] = 'Checking requirements'; 
        $lang['install_version_php'] = 'PHP version (at least 7):'; 
        $lang['install_akcept'] = 'Accept'; 
        $lang['install_not_akcept'] = 'None or too low'; 
        $lang['install_function_steam_socket'] = 'Function - stream_socket_client()'; 
        $lang['install_mod_rewrite'] = 'Mod Rewrite'; 
        $lang['install_reqbrief'] = 'In addition to following the requirements of the server should be <strong>Apache</strong>, needs module: <strong>mod_rewrite</strong> and the database <strong>MySQL/MariaDB version 5/10 or higher</strong>. On the client side (your) should be the browser that can support the functions of the <strong>AJAX (jQuery)</strong> (they are all popular browsers, remember that to activate <strong>JavaScript</strong> if it is inactive). '; 
        $lang['install_reqdont'] = 'The server does not meet the minimum requirements - installation is not possible.'; 
        $lang['install_mysql_lib'] = 'Library MySQL/MariaDB'; 
        $lang['install_config_path'] = 'Setup path &amp; e-mail address'; 
        $lang['install_address_url'] = 'URL location of the system';  
        $lang['install_url_is_not_valid'] = 'URL is incorrect'; 
        $lang['install_config_path_error'] = 'URL location of the system'; 
        $lang['install_post_server'] = 'Mail server'; 
        $lang['install_catalog_access'] = 'Access to the directories'; 
        $lang['install_calogname'] = 'Rirectory'; 
        $lang['install_catalogcom1'] = 'Permissions correct'; 
        $lang['install_catalogcom2'] = 'No permission - the system will not run properly'; 
        $lang['install_filename'] = 'Access to files'; 
        $lang['install_catalogbrief'] = 'Access directories child should be set in a way that you can create in their catalogs and save files. In Linux, you can give them the appropriate rights by the command: <strong>chmod 777 DirectoryName</strong>. '; 
        $lang['install_filebrief'] = 'Access to file child should be set in a way that you can save data in them. In Linux, you can give them the appropriate rights by the command: <strong>chmod 666 Filename</strong>. '; 
        $lang['install_filenameone'] = 'File:'; 
        $lang['install_serversmtp'] = 'SMTP'; 
        $lang['install_serversmtpbrief'] = 'Provide the account from which to send information intended to send e-letters had by the system, with the data during registration, passwords, etc. reminder.'; 
        $lang['install_smtpname'] = 'Name of person/company sending the e-mail'; 
        $lang['install_smtpaddress'] = 'SMTP server address'; 
        $lang['install_smtplogin'] = 'Login to the SMTP server'; 
        $lang['install_smtppswd'] = 'Password for the SMTP server'; 
        $lang['install_smtpport'] = 'Port to an SMTP server'; 
        $lang['install_smtpname2'] = 'Name of person/company sending the e-mail'; 
        $lang['install_smtpaddress2'] = 'SMTP server address'; 
        $lang['install_smtplogin2'] = 'Login to the SMTP server'; 
        $lang['install_smtppswd2'] = 'Password for the SMTP server'; 
        $lang['install_smtpport2'] = 'Port to an SMTP server'; 
        $lang['install_db'] = 'Database'; 
        $lang['install_dbbrief'] = 'Enter the configuration data to connect to the MySQL/MariaDB database, such as: host, database name, username, password and prefix for tables.';
        $lang['install_dbhostname'] = 'Name server'; 
        $lang['install_dbusername'] = 'Username:'; 
        $lang['install_dbpassword'] = 'User password'; 
        $lang['install_dbdatabase'] = 'Database name'; 
        $lang['install_dbprefix'] = 'Prefix for tables:'; 
        $lang['install_dbhostname2'] = 'Name server'; 
        $lang['install_dbusername2'] = 'Username:'; 
        $lang['install_dbpassword2'] = 'User password'; 
        $lang['install_dbdatabase2'] = 'Database name'; 
        $lang['install_dbprefix2'] = 'Prefix for tables:'; 
        $lang['install_instalsystembutton'] = 'Install'; 
        $lang['install_subbar'] = 'Setup phpBlueDragon GetPozition'; 
        $lang['install_havespaces'] = 'String contains spaces, it should be written without spaces'; 
        $lang['install_noabilityconnecttodb'] = 'Unable to connect to the database - check the data you have entered.'; 
        $lang['install_fieldhastobefilled'] = 'Field must be filled'; 
        $lang['install_fieldisnotnumber'] = 'Field must contain an integer'; 
        $lang['install_errorocured'] = 'There were errors, check the box below'; 
        $lang['install_changelangsubmit'] = 'Change language';
        
        // v.1.beta
        $lang['install2_email_address'] = 'E-mail for main user: ';
        $lang['install2_emailaddrisntcorrect'] = 'The email address is invalid'; 
        //$lang['install2_gratulations'] = '<h2>Gratulacje</h2>Instalacja została zakończona.<br /><br />Login: <strong>[LOGIN]</strong><br />Hasło: <strong>[PASSWORD]</strong><br /><br /><strong>Pamiętaj, należy usunąć plik &quot;install.php&quot; z serwera.</strong>'; 
        $lang['install2_gratulations'] = '<h2>Congratulations</h2>Installation is complete.<br /><br />Login: <strong>[LOGIN]</strong><br />Password: <strong>[PASSWORD]</strong><br /><br /><strong>Please note, delete the file &quot;install.php&quot; from the server.</strong> ';
        
        // v.2.beta
    	$lang['install3_port'] = 'Port: ';
    	$lang['install3_acces'] = 'Authentication: ';
    	$lang['install3_text'] = 'TEXT';
    	$lang['install3_tls'] = 'TLS';
        $lang['install3_tableprefixis'] = 'The tables with the prefix already exist in the database';
        
		// GetPozition
    	$lang['install_curl'] = 'CURL';
    	$lang['install_dom'] = 'DOMDocument'; 
        $lang['install_'] = ''; 
        $lang['install_'] = ''; 
        $lang['install_'] = ''; 
        $lang['install_'] = ''; 
        $lang['install_'] = ''; 
        $lang['install_'] = '';
    }
	
	return $lang[$Line];
    
    /*
    DELETED NOTES
    */
}

function PrintHead()
{
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title><?php echo GetLang('install_title'); ?></title>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<link rel="stylesheet" type="text/css" href="library/style.css" />
		<link rel="Shortcut icon" href="favicon.ico" />
	</head>
	<body>
		<div class="TopMenu" style="width: 100%; height: 40px;">
			<div style="width: 980px; height: 40px; margin-left: auto; margin-right: auto; padding-top: 0px; text-align: left;">
			
			<h2><?php echo GetLang('install_title'); ?></h2>
			
		 </div>
		</div>

		<div style="width: 100%; height: 30px; background-color: #E7E7E7; bnorder-top: solid 1px #D0D0D0; border-bottom: solid 1px #D0D0D0;">
			<div style="width: 980px; height: 30px; margin-left: auto; margin-right: auto; font-weight: bold; padding-top: 7px; font-family: 'Trebuchet MS'; color: #555E5E;">
			<?php
			echo GetLang('install_subbar');
			?>
			</div>
		</div>

	<div style="width: 980px; margin-left: auto; margin-right: auto; padding-top: 10px;">
	<div style="clear: both;"></div>
	<div>
	<?php
}

function PrintFoot()
{
	?>
	</div>
	</div>
	<?php
	/*echo '<pre>';
	print_r($_SESSION);
	echo '</pre>';*/
	?>
	</body>
	</html>
	<?php
}

PrintHead();

if($_POST['step'] == "")
{

        
	if($_POST['formlogin'] == 'yes')
	{
		$IsError = false;
		
        if($_POST['page_email_addr'] == "")
		{
			$Error['EmailEmptyAddr'] = true;
			$IsError = true;
		}
        
        if($_POST['page_email_addr'] != "")
		{
            if(!filter_var($_POST['page_email_addr'], FILTER_VALIDATE_EMAIL)) 
            {
                $Error['EmailIncorrectAddr'] = true;
                $IsError = true;
            }
        }

		if($_POST['page_url'] == "")
		{
			$Error['PageUrlEmpty'] = true;
			$IsError = true;
		}
		
		if($_POST['page_url'] != "")
		{
			if(!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST['page_url']))
			{
				$Error['PageUrlNotValid'] = true;
				$IsError = true;
			}
		}
		
		if($_POST['send_email_user_name'] == "")
		{
			$Error['EMPTYsend_email_user_name'] = true;
			$IsError = true;
		}
		
		if($_POST['send_email_stmp_host'] == "")
		{
			$Error['EMPTYsend_email_stmp_host'] = true;
			$IsError = true;
		}
		
		if($_POST['send_email_stmp_username'] == "")
		{
			$Error['EMPTYsend_email_stmp_username'] = true;
			$IsError = true;
		}
		
		if($_POST['send_email_stmp_password'] == "")
		{
			$Error['EMPTYsend_email_stmp_password'] = true;
			$IsError = true;
		}
		
		if($_POST['send_email_stmp_port'] == "")
		{
			$Error['EMPTYsend_email_stmp_port'] = true;
			$IsError = true;
		}
		
		if($_POST['send_email_stmp_port'] != "")
		{
			if(!preg_match('/^\d+$/', $_POST['send_email_stmp_port']))
			{
				$Error['send_email_stmp_portNotValid'] = true;
				$IsError = true;
			}
		}
		
		if($_POST['hostname'] == "")
		{
			$Error['EMPTYhostname'] = true;
			$IsError = true;
		}
		
		if($_POST['username'] == "")
		{
			$Error['EMPTYusername'] = true;
			$IsError = true;
		}
		
		if($_POST['password'] == "")
		{
			$Error['EMPTYpassword'] = true;
			$IsError = true;
		}
		
		if($_POST['database'] == "")
		{
			$Error['EMPTYdatabase'] = true;
			$IsError = true;
		}
		
		if($_POST['dbprefix'] == "")
		{
			$Error['EMPTYdbprefix'] = true;
			$IsError = true;
		}
                
        if($_POST['dbport'] == "")
		{
			$Error['EMPTYdbport'] = true;
			$IsError = true;
		}
        
        if($_POST['dbport'] != "")
		{
			if(!preg_match('/^\d+$/', $_POST['dbport']))
			{
				$Error['database_port_stmp_portNotValid'] = true;
				$IsError = true;
			}
		}
		
		if($_POST['hostname'] != "" AND $_POST['username'] != "" AND $_POST['password'] != "" AND $_POST['database'] != "")
		{			
			$ConnectionLink = mysqli_connect($_POST['hostname'], $_POST['username'], $_POST['password'], $_POST['database'],$_POST['dbport']);

			if (!$ConnectionLink) 
			{
				$Error['NotConnectedToDB'] = true;
				$IsError = true;
			}
			else
			{
                $ReadyQuery = 'SHOW TABLES LIKE "[DBPREFIX]attachment"';
                $ReadyQuery = str_replace('[DBPREFIX]', $_POST['dbprefix'], $ReadyQuery);
                
                if(mysqli_num_rows(mysqli_query($ConnectionLink, $ReadyQuery)) == 1)
                {
                    $Error['DBTableExists'] = true;
    				$IsError = true;
                }
                
				mysqli_close($ConnectionLink);
			}
		}
        
        if($IsError == false)
        {
            //header("Location: install.php?step=data");
            //die();
            $_POST['step'] = 'data';
        }
	}

	if($IsError == true)
	{
		echo '<div style="padding: 10px; color: #600000; font-weight: bold; text-align: center; font-size: 18px;">'.GetLang('install_errorocured').'</div>';
	}
	
	/*echo '<script>
	function ChangeLanguage()
	{
		//var lang = document.getElementsByName("select_language")[0].name;
        //var lang = document.getElementById("select_language").selectedIndex ;
        var lang = select_language.options[select_language.selectedIndex].value;
		window.location.href = "install.php?lang=" + lang;
	}
	</script>';*/

	//
	// 1
	//
    if($_POST['step'] == "")
    {
    	echo '<h2>1. '.GetLang('install_select_language').'</h2>';
    
    	echo '<form action="install.php" method="post">';
        
    	echo '<div class="BorderDiv">';
    
    	if($_SESSION['language_install'] == 'polish')
    	{
    		$VarPlSelected = ' selected="selected" ';
    	}
    	
    	if($_SESSION['language_install'] == 'english')
    	{
    		$VarEnSelected = ' selected="selected" ';
    	}
        
    	echo GetLang('install_set_language').' <br /> '.'
    	<select name="select_language" id="select_language" style = "width: 100%;">
    		<option value="english" '.$VarEnSelected.'>English</option>
    		<option value="polish" '.$VarPlSelected.'>Polski</option>
    	</select>'.'<br />';
    
    	echo '<br />';
        
        echo '<input type="hidden" name="change_language" value="yes" />';
    	echo '<input type="submit" name="change_lang_submit" value="'.GetLang('install_changelangsubmit').'" style = "width: 100%;" />';
        
    	echo '</div>';
        echo '</form>';
        
        echo '<form action="install.php" method="post">';
    	//
    	// 2
    	//
    	echo '<h2 style="margin-top: 15px;">2. '.GetLang('install_check_requirements').'</h2>';
    
    	$ReqIs = true;
    
    	echo '<div class="BorderDiv">';
    
    	echo '<p style="padding: 10px;">'.GetLang('install_reqbrief').'</p>';
    
    	echo '<strong>'.GetLang('install_version_php').'</strong><br />';
    	echo phpversion();
    
    	if (version_compare(PHP_VERSION, '7.0.0') >= 0) 
    	{
    		echo '<div style="padding: 10px; color: #27A2CF; font-weight: bold;">'.GetLang('install_akcept').'</div>';
    	}
    	else
    	{
    		$ReqIs = false;
    		
    		echo '<div style="padding: 10px; color: #600000; font-weight: bold;">'.GetLang('install_not_akcept').'</div>';
    	}
    
    	echo '<strong>'.GetLang('install_function_steam_socket').'</strong><br />';
    
    	if (function_exists('stream_socket_client')) 
    	{
    		echo '<div style="padding: 10px; color: #27A2CF; font-weight: bold;">'.GetLang('install_akcept').'</div>';
    	}
    	else
    	{
    		$ReqIs = false;
    		
    		echo '<div style="padding: 10px; color: #600000; font-weight: bold;">'.GetLang('install_not_akcept').'</div>';
    	}
    
    	echo '<strong>'.GetLang('install_mysql_lib').'</strong><br />';
    
    	if (function_exists('mysqli_connect')) 
    	{
    		echo '<div style="padding: 10px; color: #27A2CF; font-weight: bold;">'.GetLang('install_akcept').'</div>';
    	}
    	else
    	{
    		$ReqIs = false;
    		
    		echo '<div style="padding: 10px; color: #600000; font-weight: bold;">'.GetLang('install_not_akcept').'</div>';
    	}
    
		echo '<strong>'.GetLang('install_curl').'</strong><br />';
    
    	if (function_exists('curl_init')) 
    	{
    		echo '<div style="padding: 10px; color: #27A2CF; font-weight: bold;">'.GetLang('install_akcept').'</div>';
    	}
    	else
    	{
    		$ReqIs = false;
    		
    		echo '<div style="padding: 10px; color: #600000; font-weight: bold;">'.GetLang('install_not_akcept').'</div>';
    	}

		echo '<strong>'.GetLang('install_dom').'</strong><br />';
    
    	if (class_exists('DOMDocument')) 
    	{
    		echo '<div style="padding: 10px; color: #27A2CF; font-weight: bold;">'.GetLang('install_akcept').'</div>';
    	}
    	else
    	{
    		$ReqIs = false;
    		
    		echo '<div style="padding: 10px; color: #600000; font-weight: bold;">'.GetLang('install_not_akcept').'</div>';
    	}

    	echo '</div>';
    	
    	//
    	// 3
    	//
        echo '<h2 style="margin-top: 15px;">3. '.GetLang('install_catalog_access').'</h2>';
        
        echo '<div class="BorderDiv">';
        
        echo '<p style="padding: 10px;">'.GetLang('install_catalogbrief').'</p>';
        
        echo GetLang('install_calogname').' <strong>&quot;uploads&quot;</strong>';
        if(is_writable('uploads')){echo '<div style="padding: 10px; color: #27A2CF; font-weight: bold;">'.GetLang('install_catalogcom1').'</div>';}
        else{$ReqIs = false;echo '<div style="padding: 10px; color: #600000; font-weight: bold;">'.GetLang('install_catalogcom2').'</div>';}
        
        /*echo GetLang('install_calogname').' <strong>&quot;thumbs&quot;</strong>';
        if(is_writable('thumbs')){echo '<div style="padding: 10px; color: #27A2CF; font-weight: bold;">'.GetLang('install_catalogcom1').'</div>';}
        else{$ReqIs = false;echo '<div style="padding: 10px; color: #600000; font-weight: bold;">'.GetLang('install_catalogcom2').'</div>';}*/
        
        /*echo GetLang('install_calogname').' <strong>&quot;import&quot;</strong>';
        if(is_writable('import')){echo '<div style="padding: 10px; color: #27A2CF; font-weight: bold;">'.GetLang('install_catalogcom1').'</div>';}
        else{$ReqIs = false;echo '<div style="padding: 10px; color: #600000; font-weight: bold;">'.GetLang('install_catalogcom2').'</div>';}*/
        
        echo GetLang('install_calogname').' <strong>&quot;captcha&quot;</strong>';
        if(is_writable('captcha')){echo '<div style="padding: 10px; color: #27A2CF; font-weight: bold;">'.GetLang('install_catalogcom1').'</div>';}
        else{$ReqIs = false;echo '<div style="padding: 10px; color: #600000; font-weight: bold;">'.GetLang('install_catalogcom2').'</div>';}
        
        /*echo GetLang('install_calogname').' <strong>&quot;attachment&quot;</strong>';
        if(is_writable('attachment')){echo '<div style="padding: 10px; color: #27A2CF; font-weight: bold;">'.GetLang('install_catalogcom1').'</div>';}
        else{$ReqIs = false;echo '<div style="padding: 10px; color: #600000; font-weight: bold;">'.GetLang('install_catalogcom2').'</div>';}*/

		echo GetLang('install_calogname').' <strong>&quot;cookiefile&quot;</strong>';
        if(is_writable('cookiefile')){echo '<div style="padding: 10px; color: #27A2CF; font-weight: bold;">'.GetLang('install_catalogcom1').'</div>';}
        else{$ReqIs = false;echo '<div style="padding: 10px; color: #600000; font-weight: bold;">'.GetLang('install_catalogcom2').'</div>';}
        
        echo '</div>';
        
    	//
    	// 4
    	//
        echo '<h2 style="margin-top: 15px;">4. '.GetLang('install_filename').'</h2>';
        
        echo '<div class="BorderDiv">';
        
        echo '<p style="padding: 10px;">'.GetLang('install_filebrief').'</p>';
        
        echo GetLang('install_filenameone').' <strong>&quot;application/config/autoload.php&quot;</strong>';
        if(is_writable('application/config/autoload.php')){echo '<div style="padding: 10px; color: #27A2CF; font-weight: bold;">'.GetLang('install_catalogcom1').'</div>';}
        else{$ReqIs = false;echo '<div style="padding: 10px; color: #600000; font-weight: bold;">'.GetLang('install_catalogcom2').'</div>';}
        
        echo GetLang('install_filenameone').' <strong>&quot;application/config/config.php&quot;</strong>';
        if(is_writable('application/config/config.php')){echo '<div style="padding: 10px; color: #27A2CF; font-weight: bold;">'.GetLang('install_catalogcom1').'</div>';}
        else{$ReqIs = false;echo '<div style="padding: 10px; color: #600000; font-weight: bold;">'.GetLang('install_catalogcom2').'</div>';}
        
        echo GetLang('install_filenameone').' <strong>&quot;application/config/database.php&quot;</strong>';
        if(is_writable('application/config/database.php')){echo '<div style="padding: 10px; color: #27A2CF; font-weight: bold;">'.GetLang('install_catalogcom1').'</div>';}
        else{$ReqIs = false;echo '<div style="padding: 10px; color: #600000; font-weight: bold;">'.GetLang('install_catalogcom2').'</div>';}    
        
        echo '</div>';
        
    	//
    	// 5
    	//
    	echo '<h2 style="margin-top: 15px;">5. '.GetLang('install_config_path').'</h2>';
        
    	echo '<div class="BorderDiv">';
    	
    	if($_POST['page_url'] == '')
    	{
    		$_POST['page_url'] = "http".(!empty($_SERVER['HTTPS'])?"s":"")."://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    		$_POST['page_url'] = str_replace('install.php', '', $_POST['page_url']);
    	}
    
    	echo GetLang('install_address_url').' <br /><input type="text" name="page_url" style = "width:100%" value = "'.$_POST['page_url'].'" /><br />';
    	if($Error['PageUrlEmpty'] == true)
    	{
    		echo '<div class="error">'.GetLang('install_fieldhastobefilled').'</div>';
    	}
    	
    	if($Error['PageUrlNotValid'] == true)
    	{
    		echo '<div class="error">'.GetLang('install_url_is_not_valid').'</div>';
    	}
    	
        echo '<br />'.GetLang('install2_email_address').' <br /><input type="text" name="page_email_addr" style = "width:100%" value = "'.$_POST['page_email_addr'].'" /><br />';
    	if($Error['EmailEmptyAddr'] == true)
    	{
    		echo '<div class="error">'.GetLang('install_fieldhastobefilled').'</div>';
    	}
        
        if($Error['EmailIncorrectAddr'] == true)
    	{
    		echo '<div class="error">'.GetLang('install2_emailaddrisntcorrect').'</div>';
    	}
        
    	echo '</div>';
    	
    	//
    	// 6
    	//
    	
    	echo '<h2 style="margin-top: 15px;">6. '.GetLang('install_serversmtp').'</h2>';
        
        echo '<div class="BorderDiv">';
        
        echo '<p style="padding: 10px;">'.GetLang('install_serversmtpbrief').'</p>';
    
        echo GetLang('install_smtpname').' <br /><input type="text" name="send_email_user_name" style = "width:100%" value = "'.$_POST['send_email_user_name'].'" /><br />';
    	if($Error['EMPTYsend_email_user_name'] == true)
    	{
    		echo '<div class="error">'.GetLang('install_fieldhastobefilled').'</div>';
    	}
    
        echo '<br />';
        
        echo GetLang('install_smtpaddress').' <br /><input type="text" name="send_email_stmp_host" style = "width:100%" value = "'.$_POST['send_email_stmp_host'].'" /><br />';
    	if($Error['EMPTYsend_email_stmp_host'] == true)
    	{
    		echo '<div class="error">'.GetLang('install_fieldhastobefilled').'</div>';
    	}
    	
        echo '<br />';
        
        echo GetLang('install_smtplogin').' <br /><input type="text" name="send_email_stmp_username" style = "width:100%" value = "'.$_POST['send_email_stmp_username'].'" /><br />';
    	if($Error['EMPTYsend_email_stmp_username'] == true)
    	{
    		echo '<div class="error">'.GetLang('install_fieldhastobefilled').'</div>';
    	}
    	
        echo '<br />';
        
        echo GetLang('install_smtppswd').' <br /><input type="password" name="send_email_stmp_password" style = "width:100%" value = "'.$_POST['send_email_stmp_password'].'" /><br />';
    	if($Error['EMPTYsend_email_stmp_password'] == true)
    	{
    		echo '<div class="error">'.GetLang('install_fieldhastobefilled').'</div>';
    	}
    	
        echo '<br />';
        
        if($_POST['send_email_stmp_port'] == "")
        {
            $_POST['send_email_stmp_port'] = 587;
        }
        
        echo GetLang('install_smtpport').' <br /><input type="text" name="send_email_stmp_port" style = "width:50px;" value = "'.$_POST['send_email_stmp_port'].'" /><br />';
    	if($Error['EMPTYsend_email_stmp_port'] == true)
    	{
    		echo '<div class="error">'.GetLang('install_fieldhastobefilled').'</div>';
    	}
    	
    	if($Error['send_email_stmp_portNotValid'] == true)
    	{
    		echo '<div class="error">'.GetLang('install_fieldisnotnumber').'</div>';
    	}
    	
        echo '<br />';
        
        $SelectValue1 = null;
        $SelectValue2 = null;
        
        if($_POST['smtp_access'] == ""){$SelectValue1 = ' checked="checked" ';}
        if($_POST['smtp_access'] == "text"){$SelectValue1 = ' checked="checked" ';}
        if($_POST['smtp_access'] == "tls"){$SelectValue2 = ' checked="checked" ';}
        
        echo GetLang('install3_acces').' <br />
        <input type="radio" name="smtp_access" value="text" '.$SelectValue1.' /> '.GetLang('install3_text').'
        <input type="radio" name="smtp_access" value="tls" '.$SelectValue2.' /> '.GetLang('install3_tls').'<br />';
        echo '</div>';
        
    	//
    	// 7
    	//
        echo '<h2 style="margin-top: 15px;">7. '.GetLang('install_db').'</h2>';
        
        echo '<div class="BorderDiv">';
    	
        echo '<p style="padding: 10px;">'.GetLang('install_dbbrief').'</p>';
    	
    	echo GetLang('install_dbhostname').' <br /><input type="text" name="hostname" style = "width:100%" value = "'.$_POST['hostname'].'" /><br />';
    	if($Error['EMPTYhostname'] == true)
    	{
    		echo '<div class="error">'.GetLang('install_fieldhastobefilled').'</div>';
    	}
    	
    	if($Error['NotConnectedToDB'] == true)
    	{
    		echo '<div class="error">'.GetLang('install_noabilityconnecttodb').'</div>';
    	}
    	
        echo '<br />';
    	
    	echo GetLang('install_dbusername').' <br /><input type="text" name="username" style = "width:100%" value = "'.$_POST['username'].'" /><br />';
    	if($Error['EMPTYusername'] == true)
    	{
    		echo '<div class="error">'.GetLang('install_fieldhastobefilled').'</div>';
    	}
    	
        echo '<br />';
    	
    	echo GetLang('install_dbpassword').' <br /> <input type="password" name="password" style = "width:100%" value = "'.$_POST['password'].'" /><br />';
    	if($Error['EMPTYpassword'] == true)
    	{
    		echo '<div class="error">'.GetLang('install_fieldhastobefilled').'</div>';
    	}
    	
        echo '<br />';
    	
    	echo GetLang('install_dbdatabase').' <br /> <input type="text" name="database" style = "width:100%" value = "'.$_POST['database'].'" /><br />';
    	if($Error['EMPTYdatabase'] == true)
    	{
    		echo '<div class="error">'.GetLang('install_fieldhastobefilled').'</div>';
    	}
    	
        echo '<br />';
    	
    	if($_POST['dbprefix'] == "")
    	{
    		$_POST['dbprefix'] = 'gpoz_';
    	}
    	echo GetLang('install_dbprefix').' <br /> <input type="text" name="dbprefix" style = "width:150px;" value = "'.$_POST['dbprefix'].'" /><br />';
    	if($Error['EMPTYdbprefix'] == true)
    	{
    		echo '<div class="error">'.GetLang('install_fieldhastobefilled').'</div>';
    	}
        
        if($Error['DBTableExists'] == true)
        {
            echo '<div class="error">'.GetLang('install3_tableprefixis').'</div>';
        }
    	
        echo '<br />';
    	
        if($_POST['dbport'] == "")
    	{
    		$_POST['dbport'] = '3306';
    	}
    	echo GetLang('install3_port').' <br /> <input type="text" name="dbport" style = "width:150px;" value = "'.$_POST['dbport'].'" /><br />';
    	if($Error['EMPTYdbport'] == true)
    	{
    		echo '<div class="error">'.GetLang('install_fieldhastobefilled').'</div>';
    	}
        
        if($Error['database_port_stmp_portNotValid'] == true)
    	{
    		echo '<div class="error">'.GetLang('install_fieldisnotnumber').'</div>';
    	}
    	
        echo '<br />';
        
        
        echo '</div>';
    	
    	//
    	// 8
    	//
    	echo '<h2 style="margin-top: 15px;">8. '.GetLang('install_instalsystembutton').'</h2>';
    	
    	echo '<div class="BorderDiv">';
    	
    	if($ReqIs)
    	{	
    		echo '<input type="hidden" name="formlogin" value="yes" />';
    		echo '<input type="submit" name="install_aplication" value="'.GetLang('install_instalsystembutton').'" style = "width: 100%;" />';
    	}
    	else
    	{
    		echo '<p style="padding: 10px; color: #600000;">'.GetLang('install_reqdont').'</p>';
    	}
    	
    	echo '</div><br /><br />';
    	
    	echo '</form>';
     }

}

if($_POST['step'] == 'data')
{
	// Konfiguracja frameworka

$ValueFromChecking = 'false';

if($_POST['smtp_access'] == "tls")
{
    $ValueFromChecking = 'true';
}

$ConfigData = 
'<?php

$config[\'base_url\'] = \''.$_POST['page_url'].'\';

$config[\'send_email_user_name\'] = \''.$_POST['send_email_user_name'].'\';
$config[\'send_email_stmp_host\'] = \''.$_POST['send_email_stmp_host'].'\';
$config[\'send_email_stmp_username\'] = \''.$_POST['send_email_stmp_username'].'\';
$config[\'send_email_stmp_password\'] = \''.$_POST['send_email_stmp_password'].'\';
$config[\'send_email_stmp_port\'] = '.$_POST['send_email_stmp_port'].';
$config[\'send_email_access\'] = \''.$_POST['smtp_access'].'\';
$config[\'send_email_tls\'] = '.$ValueFromChecking.';

$config[\'language\'] = \''.$_SESSION['language_install'].'\';

?>';

	file_put_contents("application/config/config.php", $ConfigData, FILE_APPEND);
	
$DataBaseData = 
'<?php

$db[\'default\'][\'hostname\'] = \''.$_POST['hostname'].'\';
$db[\'default\'][\'username\'] = \''.$_POST['username'].'\';
$db[\'default\'][\'password\'] = \''.$_POST['password'].'\';
$db[\'default\'][\'database\'] = \''.$_POST['database'].'\';
$db[\'default\'][\'dbdriver\'] = \'mysqli\';
$db[\'default\'][\'dbprefix\'] = \''.$_POST['dbprefix'].'\';
$db[\'default\'][\'pconnect\'] = TRUE;
$db[\'default\'][\'db_debug\'] = TRUE;
$db[\'default\'][\'cache_on\'] = FALSE;
$db[\'default\'][\'cachedir\'] = \'\';
$db[\'default\'][\'char_set\'] = \'utf8\';
$db[\'default\'][\'dbcollat\'] = \'utf8_general_ci\';
$db[\'default\'][\'swap_pre\'] = \'{PREFIXDB}\';
$db[\'default\'][\'autoinit\'] = TRUE;
$db[\'default\'][\'stricton\'] = FALSE;
$db[\'default\'][\'port\'] = \''.$_POST['dbport'].'\';


?>';

	file_put_contents("application/config/database.php", $DataBaseData, FILE_APPEND);

	function GenerateRootPassword() 
	{
        $ReadyRandomString = null;
       
	    $Chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

	    for ($i=0; $i<15; $i++) 
	    {
	        $ReadyRandomString .= $Chars[rand(0, 39)];
	    }
	    
	    return $ReadyRandomString;
	}
	
    $PasswordString = GenerateRootPassword();
    $SaltPassword = password_hash($PasswordString, PASSWORD_DEFAULT);
     
	// Wgrywanie pliku do bazy danych
	$ConnectionLink = mysqli_connect($_POST['hostname'], $_POST['username'], $_POST['password'], $_POST['database'],$_POST['dbport']);
	
    if(mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL/MariaDB: " . mysqli_connect_error();
    }
    
    mysqli_query($ConnectionLink, 'SET NAMES utf8');
    
    //print_r($ConnectionLink);
  
	//$SqlQuery[]
	for($i=0;$i<count($SqlQuert);$i++)
	{
		$SqlQuert[$i] = str_replace('[DBPREFIX]', $_POST['dbprefix'], $SqlQuert[$i]);
		$SqlQuert[$i] = str_replace('[USER_EMAIL]', $_POST['page_email_addr'], $SqlQuert[$i]);
		$SqlQuert[$i] = str_replace('[USER_PASSWORD]', $SaltPassword, $SqlQuert[$i]);

		if(!mysqli_query($ConnectionLink, $SqlQuert[$i]))
		{
            echo $SqlQuert[$i].'<br />';
			echo '<strong>DataBase Error</strong><br />';
            echo mysqli_error($ConnectionLink).'<br />';
		}
	}
			
	mysqli_close($ConnectionLink);
	
	// Wyświetlanie loginu i hasła
    
    $Text = GetLang('install2_gratulations');
    $Text = str_replace('[LOGIN]', $_POST['page_email_addr'], $Text);
    $Text = str_replace('[PASSWORD]', $PasswordString, $Text);
    
    echo $Text;
}

PrintFoot();

/*echo '<pre>';
print_r($_POST);
echo '</pre>';*/

?>