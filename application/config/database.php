	<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'login';
$active_record = TRUE;

/* DB DE TESORERIA */

$db['tesoreria']['hostname'] = CHOSTNAME;
$db['tesoreria']['username'] = 'root';
$db['tesoreria']['password'] = CPASSWORD;
$db['tesoreria']['database'] = 'tesoreria'.CBD;
$db['tesoreria']['dbdriver'] = 'mysql';
$db['tesoreria']['dbprefix'] = '';
$db['tesoreria']['pconnect'] = TRUE;
$db['tesoreria']['db_debug'] = TRUE;
$db['tesoreria']['cache_on'] = FALSE;
$db['tesoreria']['cachedir'] = '';
$db['tesoreria']['char_set'] = 'utf8';
$db['tesoreria']['dbcollat'] = 'utf8_general_ci';
$db['tesoreria']['swap_pre'] = '';
$db['tesoreria']['autoinit'] = TRUE;
$db['tesoreria']['stricton'] = FALSE;

$db['login']['hostname'] = CHOSTNAME;
$db['login']['username'] = 'root';
$db['login']['password'] = CPASSWORD;
$db['login']['database'] = 'usuarios'.CBD;
$db['login']['dbdriver'] = 'mysql';
$db['login']['dbprefix'] = '';
$db['login']['pconnect'] = TRUE;
$db['login']['db_debug'] = TRUE;
$db['login']['cache_on'] = FALSE;
$db['login']['cachedir'] = '';
$db['login']['char_set'] = 'utf8';
$db['login']['dbcollat'] = 'utf8_general_ci';
$db['login']['swap_pre'] = '';
$db['login']['autoinit'] = TRUE;
$db['login']['stricton'] = FALSE;

$db['usuarios']['hostname'] = CHOSTNAME;
$db['usuarios']['username'] = 'root';
$db['usuarios']['password'] = CPASSWORD;
$db['usuarios']['database'] = 'usuarios'.CBD;
$db['usuarios']['dbdriver'] = 'mysql';
$db['usuarios']['dbprefix'] = '';
$db['usuarios']['pconnect'] = FALSE;
$db['usuarios']['db_debug'] = TRUE;
$db['usuarios']['cache_on'] = FALSE;
$db['usuarios']['cachedir'] = '';
$db['usuarios']['char_set'] = 'utf8';
$db['usuarios']['dbcollat'] = 'utf8_general_ci';
$db['usuarios']['swap_pre'] = '';
$db['usuarios']['autoinit'] = TRUE;
$db['usuarios']['stricton'] = FALSE;

$db['pedidos']['hostname'] = CHOSTNAME;
$db['pedidos']['username'] = 'root';
$db['pedidos']['password'] = CPASSWORD;
$db['pedidos']['database'] = 'ordenes_compra'.CBD;
$db['pedidos']['dbdriver'] = 'mysql';
$db['pedidos']['dbprefix'] = '';
$db['pedidos']['pconnect'] = FALSE;
$db['pedidos']['db_debug'] = TRUE;
$db['pedidos']['cache_on'] = FALSE;
$db['pedidos']['cachedir'] = '';
$db['pedidos']['char_set'] = 'utf8';
$db['pedidos']['dbcollat'] = 'utf8_general_ci';
$db['pedidos']['swap_pre'] = '';
$db['pedidos']['autoinit'] = TRUE;
$db['pedidos']['stricton'] = FALSE;

$db['formulacion']['hostname'] = CHOSTNAME;
$db['formulacion']['username'] = 'root';
$db['formulacion']['password'] = CPASSWORD;
$db['formulacion']['database'] = 'formulacion'.CBD;
$db['formulacion']['dbdriver'] = 'mysql';
$db['formulacion']['dbprefix'] = '';
$db['formulacion']['pconnect'] = FALSE;
$db['formulacion']['db_debug'] = TRUE;
$db['formulacion']['cache_on'] = FALSE;
$db['formulacion']['cachedir'] = '';
$db['formulacion']['char_set'] = 'utf8';
$db['formulacion']['dbcollat'] = 'utf8_general_ci';
$db['formulacion']['swap_pre'] = '';
$db['formulacion']['autoinit'] = TRUE;
$db['formulacion']['stricton'] = FALSE;

$db['porcicultura']['hostname'] = CHOSTNAME;
$db['porcicultura']['username'] = 'root';
$db['porcicultura']['password'] = CPASSWORD;
$db['porcicultura']['database'] = 'monitores_porcicultura'.CBD;
$db['porcicultura']['dbdriver'] = 'mysql';
$db['porcicultura']['dbprefix'] = '';
$db['porcicultura']['pconnect'] = TRUE;
$db['porcicultura']['db_debug'] = TRUE;
$db['porcicultura']['cache_on'] = FALSE;
$db['porcicultura']['cachedir'] = '';
$db['porcicultura']['char_set'] = 'utf8';
$db['porcicultura']['dbcollat'] = 'utf8_general_ci';
$db['porcicultura']['swap_pre'] = '';
$db['porcicultura']['autoinit'] = TRUE;
$db['porcicultura']['stricton'] = FALSE;

$db['ganaderia']['hostname'] = CHOSTNAME;
$db['ganaderia']['username'] = 'root';
$db['ganaderia']['password'] = CPASSWORD;
$db['ganaderia']['database'] = 'ganaderia'.CBD;
$db['ganaderia']['dbdriver'] = 'mysql';
$db['ganaderia']['dbprefix'] = '';
$db['ganaderia']['pconnect'] = TRUE;
$db['ganaderia']['db_debug'] = TRUE;
$db['ganaderia']['cache_on'] = FALSE;
$db['ganaderia']['cachedir'] = '';
$db['ganaderia']['char_set'] = 'utf8';
$db['ganaderia']['dbcollat'] = 'utf8_general_ci';
$db['ganaderia']['swap_pre'] = '';
$db['ganaderia']['autoinit'] = TRUE;
$db['ganaderia']['stricton'] = FALSE;

$db['agenda']['hostname'] = CHOSTNAME;
$db['agenda']['username'] = 'root';
$db['agenda']['password'] = CPASSWORD;
$db['agenda']['database'] = 'agenda_tecnicos'.CBD;
$db['agenda']['dbdriver'] = 'mysql';
$db['agenda']['dbprefix'] = '';
$db['agenda']['pconnect'] = TRUE;
$db['agenda']['db_debug'] = TRUE;
$db['agenda']['cache_on'] = FALSE;
$db['agenda']['cachedir'] = '';
$db['agenda']['char_set'] = 'utf8';
$db['agenda']['dbcollat'] = 'utf8_general_ci';
$db['agenda']['swap_pre'] = '';
$db['agenda']['autoinit'] = TRUE;
$db['agenda']['stricton'] = FALSE;

$db['precios']['hostname'] = CHOSTNAME;
$db['precios']['username'] = 'root';
$db['precios']['password'] = CPASSWORD;
$db['precios']['database'] = 'catalogo_propuesta'.CBD;
$db['precios']['dbdriver'] = 'mysql';
$db['precios']['dbprefix'] = '';
$db['precios']['pconnect'] = TRUE;
$db['precios']['db_debug'] = TRUE;
$db['precios']['cache_on'] = FALSE;
$db['precios']['cachedir'] = '';
$db['precios']['char_set'] = 'utf8';
$db['precios']['dbcollat'] = 'utf8_general_ci';
$db['precios']['swap_pre'] = '';
$db['precios']['autoinit'] = TRUE;
$db['precios']['stricton'] = FALSE;

$db['hojastecnicas']['hostname'] = CHOSTNAME;
$db['hojastecnicas']['username'] = 'root';
$db['hojastecnicas']['password'] = CPASSWORD;
$db['hojastecnicas']['database'] = 'hojas_tecnicas'.CBD;
$db['hojastecnicas']['dbdriver'] = 'mysql';
$db['hojastecnicas']['dbprefix'] = '';
$db['hojastecnicas']['pconnect'] = TRUE;
$db['hojastecnicas']['db_debug'] = TRUE;
$db['hojastecnicas']['cache_on'] = FALSE;
$db['hojastecnicas']['cachedir'] = '';
$db['hojastecnicas']['char_set'] = 'utf8';
$db['hojastecnicas']['dbcollat'] = 'utf8_general_ci';
$db['hojastecnicas']['swap_pre'] = '';
$db['hojastecnicas']['autoinit'] = TRUE;
$db['hojastecnicas']['stricton'] = FALSE;

$db['fletes']['hostname'] = CHOSTNAME;
$db['fletes']['username'] = 'root';
$db['fletes']['password'] = CPASSWORD;
$db['fletes']['database'] = 'fletes'.CBD;
$db['fletes']['dbdriver'] = 'mysql';
$db['fletes']['dbprefix'] = '';
$db['fletes']['pconnect'] = TRUE;
$db['fletes']['db_debug'] = TRUE;
$db['fletes']['cache_on'] = FALSE;
$db['fletes']['cachedir'] = '';
$db['fletes']['char_set'] = 'utf8';
$db['fletes']['dbcollat'] = 'utf8_general_ci';
$db['fletes']['swap_pre'] = '';
$db['fletes']['autoinit'] = TRUE;
$db['fletes']['stricton'] = FALSE;

$db['bioeconomico']['hostname'] = CHOSTNAME;
$db['bioeconomico']['username'] = 'root';
$db['bioeconomico']['password'] = CPASSWORD;
$db['bioeconomico']['database'] = 'bioeconomico'.CBD;
$db['bioeconomico']['dbdriver'] = 'mysql';
$db['bioeconomico']['dbprefix'] = '';
$db['bioeconomico']['pconnect'] = TRUE;
$db['bioeconomico']['db_debug'] = TRUE;
$db['bioeconomico']['cache_on'] = FALSE;
$db['bioeconomico']['cachedir'] = '';
$db['bioeconomico']['char_set'] = 'utf8';
$db['bioeconomico']['dbcollat'] = 'utf8_general_ci';
$db['bioeconomico']['swap_pre'] = '';
$db['bioeconomico']['autoinit'] = TRUE;
$db['bioeconomico']['stricton'] = FALSE;

$db['prenomina']['hostname'] = CHOSTNAME;
$db['prenomina']['username'] = 'root';
$db['prenomina']['password'] = CPASSWORD;
$db['prenomina']['database'] = 'prenomina'.CBD;
$db['prenomina']['dbdriver'] = 'mysql';
$db['prenomina']['dbprefix'] = '';
$db['prenomina']['pconnect'] = TRUE;
$db['prenomina']['db_debug'] = TRUE;
$db['prenomina']['cache_on'] = FALSE;
$db['prenomina']['cachedir'] = '';
$db['prenomina']['char_set'] = 'utf8';
$db['prenomina']['dbcollat'] = 'utf8_general_ci';
$db['prenomina']['swap_pre'] = '';
$db['prenomina']['autoinit'] = TRUE;
$db['prenomina']['stricton'] = FALSE;

$db['panel_vimifos']['hostname'] = '10.2.0.4';
$db['panel_vimifos']['username'] = 'root';
$db['panel_vimifos']['password'] = 'vp1011itsz1962';
$db['panel_vimifos']['database'] = 'panel_vimifos';
$db['panel_vimifos']['dbdriver'] = 'mysql';
$db['panel_vimifos']['dbprefix'] = '';
$db['panel_vimifos']['pconnect'] = FALSE;
$db['panel_vimifos']['db_debug'] = TRUE;
$db['panel_vimifos']['cache_on'] = FALSE;
$db['panel_vimifos']['cachedir'] = '';
$db['panel_vimifos']['char_set'] = 'utf8';
$db['panel_vimifos']['dbcollat'] = 'utf8_general_ci';
$db['panel_vimifos']['swap_pre'] = '';
$db['panel_vimifos']['autoinit'] = TRUE;
$db['panel_vimifos']['stricton'] = FALSE;

$db['facturas']['hostname'] = '10.2.0.23';
$db['facturas']['username'] = 'eespiritu';
$db['facturas']['password'] = 'ees7831P';
$db['facturas']['database'] = 'efactura';
$db['facturas']['dbdriver'] = CDBDRIVER;
$db['facturas']['dbprefix'] = '';
$db['facturas']['pconnect'] = FALSE;
$db['facturas']['db_debug'] = TRUE;
$db['facturas']['cache_on'] = FALSE;
$db['facturas']['cachedir'] = '';
$db['facturas']['char_set'] = 'utf8';
$db['facturas']['dbcollat'] = 'utf8_general_ci';
$db['facturas']['swap_pre'] = '';
$db['facturas']['autoinit'] = TRUE;
$db['facturas']['stricton'] = FALSE;	

$db['business']['hostname'] = '10.2.0.23';
$db['business']['username'] = 'eespiritu';
$db['business']['password'] = 'ees7831P';
$db['business']['database'] = 'business';
$db['business']['dbdriver'] = CDBDRIVER;
$db['business']['dbprefix'] = '';
$db['business']['pconnect'] = FALSE;
$db['business']['db_debug'] = TRUE;
$db['business']['cache_on'] = FALSE;
$db['business']['cachedir'] = '';
$db['business']['char_set'] = 'utf8';
$db['business']['dbcollat'] = 'utf8_general_ci';
$db['business']['swap_pre'] = '';
$db['business']['autoinit'] = TRUE;
$db['business']['stricton'] = FALSE;

$db['businesscfdi']['hostname'] = '10.2.0.23';
$db['businesscfdi']['username'] = 'eespiritu';
$db['businesscfdi']['password'] = 'ees7831P';
$db['businesscfdi']['database'] = 'businessCFDI';
$db['businesscfdi']['dbdriver'] = CDBDRIVER;
$db['businesscfdi']['dbprefix'] = '';
$db['businesscfdi']['pconnect'] = FALSE;
$db['businesscfdi']['db_debug'] = TRUE;
$db['businesscfdi']['cache_on'] = FALSE;
$db['businesscfdi']['cachedir'] = '';
$db['businesscfdi']['char_set'] = 'utf8';
$db['businesscfdi']['dbcollat'] = 'utf8_general_ci';
$db['businesscfdi']['swap_pre'] = '';
$db['businesscfdi']['autoinit'] = TRUE;
$db['businesscfdi']['stricton'] = FALSE;

$db['censos']['hostname'] = CHOSTNAME;
$db['censos']['username'] = 'root';
$db['censos']['password'] = CPASSWORD;
$db['censos']['database'] = 'sistemas_internos'.CBD;
$db['censos']['dbdriver'] = 'mysql';
$db['censos']['dbprefix'] = '';
$db['censos']['pconnect'] = TRUE;
$db['censos']['db_debug'] = TRUE;
$db['censos']['cache_on'] = FALSE;
$db['censos']['cachedir'] = '';
$db['censos']['char_set'] = 'utf8';
$db['censos']['dbcollat'] = 'utf8_general_ci';
$db['censos']['swap_pre'] = '';
$db['censos']['autoinit'] = TRUE;
$db['censos']['stricton'] = FALSE;
/* End of file database.php */
/* Location: ./application/config/database.php */