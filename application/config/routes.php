<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/ 

$route ['default_controller'] = "pages";

$route ['ajax/(:any)'] = "ajax/$1"; 
$route ['blog/(:any)'] = "pages/blog_page/$1"; 
$route ['news/(:any)'] = "pages/news_page/$1";

$route ['admin'] = 'admin/pages/index';
$route ['admin/login'] = 'admin/lunit/login';
$route ['admin/logout'] = 'admin/lunit/logout';
$route ['admin/(:any)'] = "admin/$1";

$route ['(:any)'] = "pages/show/";

/* Location: ./application/config/routes.php */