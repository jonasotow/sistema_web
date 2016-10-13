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

$route['default_controller'] = "inicio_class";
$route['404_override'] = '';


$exclude = array(
			'.',
			'..',
			"index.html",
			"inicio_class.php",
			"inicio.php"
	);
	
$installed = array(
	'usuarios',
	'aplicaciones',
	'tesoreria'
);

foreach($installed as $install){
	$handle = opendir(APPPATH."controllers/".$install."/");
	
	while(false !== ($file = readdir($handle))){
		if(!in_array($file,$exclude))
		{
			if( !is_dir(APPPATH."controllers/".$file))
			{
				$file = substr($file,0,strlen($file)-4);
			}
			$installed_modules[] = $file;
		}
	}
	
	closedir($handle);
	
	foreach($installed_modules as $module){
		if(in_array(substr($module,0,strpos($module,"_")),$installed)){
			$route[substr($module,strpos($module,"_") + 1,strlen($module))] = $install.'/'.$module;
			$route[substr($module,strpos($module,"_") + 1,strlen($module))."/(.*)"] = $install.'/'.$module."/$1";
		}
		else{
			$route[$module] = $module;
			$route[$module."/(.*)"] = $module."/$1";
		}
	}
	unset($installed_modules);
}

foreach($installed as $install){
	$route[$install] = "inicio/login";
	$route[$install.'/home'] = "inicio_class";
}

/* End of file routes.php */
/* Location: ./application/config/routes.php */
