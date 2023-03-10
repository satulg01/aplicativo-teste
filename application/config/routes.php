<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//$route['teste']["GET"] = 'Auth/verifyBlock';

$route["default_controller"] = "Main";

#Login
$route['logout']["GET"] = 'Auth/logout';
$route['login']["GET"] = 'Auth/index';
$route['login']["POST"] = 'Auth/login';

#PEDIDOS
$route['pedidos']["GET"] = 'Orders/index';
$route['pedidos/add']["GET"] = 'Orders/add';
$route['pedidos/add']["POST"] = 'Orders/insert';
$route['pedidos/(.+)/editar']["GET"] = 'Orders/edit/$1';
$route['pedidos/editar']["PUT"] = 'Orders/update';
$route['pedidos']["DELETE"] = 'Orders/delete';

$route['pedidos_finalizados']["GET"] = 'Orders/finalized/$1';


#COLABORADORES
$route['colaboradores']["GET"] = 'Collaborators/index';
$route['colaboradores/add']["GET"] = 'Collaborators/add';
$route['colaboradores/add']["POST"] = 'Collaborators/insert';
$route['colaboradores/(.+)/editar']["GET"] = 'Collaborators/edit/$1';
$route['colaboradores/editar']["PUT"] = 'Collaborators/update';
$route['colaboradores/reativar']["PUT"] = 'Collaborators/reactivate';


#PRODUTOS
$route['produtos']["GET"] = 'Products/index';
$route['produtos/add']["GET"] = 'Products/add';
$route['produtos/add']["POST"] = 'Products/insert';
$route['produtos/(.+)/editar']["GET"] = 'Products/edit/$1';
$route['produtos/editar']["PUT"] = 'Products/update';
$route['produtos/reativar']["PUT"] = 'Products/reactivate';







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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'main';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
