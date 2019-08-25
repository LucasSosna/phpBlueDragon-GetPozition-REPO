<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['default_controller'] = "systemid";
$route['404_override'] = '';

$route['login'] = 'systemid/index';
$route['add'] = 'systemid/addnewproject';
$route['edit/(:num)'] = 'systemid/editexistingproject/$1';
$route['delete/(:num)'] = 'systemid/index/delete/$1';
$route['details/(:num)'] = 'systemid/projectdetails/$1';

$route['link-add/(:num)'] = 'systemid/linkaddnew/$1';
$route['link-edit/(:num)'] = 'systemid/linkeditexisting/$1';
$route['link-delete/(:num)/(:num)'] = 'systemid/projectdetails/$1/deletelink/$2';

$route['check-link/(:num)'] = 'systemid/checklinkbyhand/$1';

$route['view-archive/(:num)'] = 'systemid/viewarchive/$1';
$route['view-archive-report/(:num)'] = 'systemid/viewarchivereport/$1';

$route['import'] = 'systemid/importlink';

$route['proxy'] = 'systemid/proxysettings';
$route['add-proxy'] = 'systemid/proxyadd';
$route['edit-proxy/(:num)'] = 'systemid/proxyedit/$1';

$route['add-keyword/(:num)'] = 'systemid/keywordadd/$1';

$route['logout'] = 'systemid/logout';
$route['change-password'] = 'systemid/changepassword';
$route['password'] = 'systemid/getpassword';
$route['generate-password/(:num)/(:any)/(:any)'] = 'systemid/postpassword/$1/$2/$3';
$route['edit-email'] = 'systemid/editemail';

$route['export/(:num)/(:any)'] = 'systemid/exportarchive/$1/$2';

$route['settings'] = 'systemid/settingsofscript';

$route['components'] = 'systemid/usedcomponents';
