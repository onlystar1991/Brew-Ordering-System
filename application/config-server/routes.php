<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
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

$route['default_controller'] = "auth";
$route['404_override'] = 'error404';

$route['store/index'] = "store/index";
$route['store/(:num)'] = "store/index/(:num)";
$route['store/edit/(:val)'] = "store/edit/(:val)";
$route['store/delete/(:val)'] = "store/delete/(:val)";

$route['users/index'] = "users/index";
$route['users/(:num)'] = "users/index/(:num)";

$routes['auth/'] = 'auth/index';
$routes['auth/index'] = 'auth/index';

$route['inventory/index'] = "inventory/index";
$route['inventory/(:num)'] = "inventory/index/(:num)";
$route['inventory/edit/(:val)'] = "inventory/edit/(:val)";
$route['inventory/delete/(:val)'] = "inventory/delete/(:val)";

$route['order/index'] = "order/index";
$route['order/(:num)'] = "order/index/(:num)";
$route['order/edit/(:val)'] = "order/edit/$1";
$route['order/edit/(:val)/{:any}'] = "order/edit/$1/$2";
$route['order/delete/(:val)'] = "order/delete/(:val)";

$route['distributor/index'] = "distributor/index";
$route['distributor/(:num)'] = "distributor/index/(:num)";
$route['distributor/edit/(:val)'] = "distributor/edit/(:val)";
$route['distributor/delete/(:val)'] = "distributor/delete/(:val)";
$route['facebook/execute'] = "facebook/execute";
$route['facebook/index'] = "facebook/index";

/* End of file routes.php */


/* Location: ./application/config/routes.php */