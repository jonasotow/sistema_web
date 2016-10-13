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
$db['tesoreria']['dbdriver'] = CDBDRIVER;
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
$db['login']['dbdriver'] = CDBDRIVER;
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
$db['usuarios']['dbdriver'] = CDBDRIVER;
$db['usuarios']['dbprefix'] = '';
$db['usuarios']['pconnect'] = TRUE;
$db['usuarios']['db_debug'] = TRUE;
$db['usuarios']['cache_on'] = FALSE;
$db['usuarios']['cachedir'] = '';
$db['usuarios']['char_set'] = 'utf8';
$db['usuarios']['dbcollat'] = 'utf8_general_ci';
$db['usuarios']['swap_pre'] = '';
$db['usuarios']['autoinit'] = TRUE;
$db['usuarios']['stricton'] = FALSE;


/* End of file database.php */
/* Location: ./application/config/database.php */