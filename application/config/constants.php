<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FACEBOOK_GRAPH_HELPER', $_SERVER['DOCUMENT_ROOT'].'/application/helpers/facebook_graph_helper.php');
define('FACEBOOK_PAGE_HELPER', $_SERVER['DOCUMENT_ROOT'].'/application/helpers/facebook_page_helper.php');
define('CURL_HELPER', $_SERVER['DOCUMENT_ROOT'].'/application/helpers/curl_helper.php');
define('FACEBOOK_API_CONFIG', $_SERVER['DOCUMENT_ROOT'].'/application/config/facebook_api.php');

define('PARSE_SDK_INC', $_SERVER['DOCUMENT_ROOT'].'/parse-php-sdk-master/autoload.php');
//   /intense-plains-3648

define('FACEBOOK_SDK_INC', $_SERVER['DOCUMENT_ROOT'].'/php-graph-sdk-5.4/src/Facebook/autoload.php');

define('PEM_DEV_LOC', $_SERVER['DOCUMENT_ROOT'].'/application/controllers/NotibrewDev.pem');
define('PEM_LOC', $_SERVER['DOCUMENT_ROOT'].'/application/controllers/Notibrew.pem');
//   /intense-plains-3648

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */

/* User Roles */
define('UR_ADMIN',       'admin');
define('UR_RETAILER',    'retailer');
define('UR_BAR',         'bar');
define('UR_BREWERY',     'brewery');
define('UR_DISTRIBUTOR', 'distributor');

/* User Privileges */
define('UP_ALL',					11000);

define('UP_STORE_ALL',           	10100);
define('UP_STORE_VIEW',          	10101);

define('UP_INVENTORY_ALL',       	10110);
define('UP_INVENTORY_VIEW',      	10111);
define('UP_INVENTORY_ORDER_DENY', 	10112);

define('UP_ORDER_ALL',       		10120);
define('UP_ORDER_VIEW',      		10121);
define('UP_ORDER_EDIT_DENY', 		10122);
define('UP_ORDER_APPROVE_DENY', 	10123);
define('UP_ORDER_FINAL_DENY', 		10124);
define('UP_ORDER_DETAIL_DENY', 		10125);

define('UP_DASHBOARD_ALL',			10130);

define('UP_DISTRIBUTOR_ALL',		10140);

define('UP_DELIVERY_ALL',			10150);

define('UP_MARKETING_ALL',			10160);

