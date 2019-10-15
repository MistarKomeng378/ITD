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

$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = '.,1433';
$db['default']['username'] = 'CUSTODY';
$db['default']['password'] = 'CUSTODY1';
$db['default']['database'] = 'ITD';
$db['default']['dbdriver'] = 'sqlsrv';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = FALSE;
$db['default']['stricton'] = FALSE;

$db['dbdocim']['hostname'] = '.,1433';
$db['dbdocim']['username'] = 'CUSTODY';
$db['dbdocim']['password'] = 'CUSTODY1';
$db['dbdocim']['database'] = 'docim_live';
$db['dbdocim']['dbdriver'] = 'sqlsrv';
$db['dbdocim']['dbprefix'] = '';
$db['dbdocim']['pconnect'] = TRUE;
$db['dbdocim']['db_debug'] = TRUE;
$db['dbdocim']['cache_on'] = FALSE;
$db['dbdocim']['cachedir'] = '';
$db['dbdocim']['char_set'] = 'utf8';
$db['dbdocim']['dbcollat'] = 'utf8_general_ci';
$db['dbdocim']['swap_pre'] = '';
$db['dbdocim']['autoinit'] = FALSE;
$db['dbdocim']['stricton'] = FALSE;

$db['dbjasgir']['hostname'] = '.,1433';
$db['dbjasgir']['username'] = 'CUSTODY';
$db['dbjasgir']['password'] = 'CUSTODY1';
$db['dbjasgir']['database'] = 'cs_jasa_giro';
$db['dbjasgir']['dbdriver'] = 'sqlsrv';
$db['dbjasgir']['dbprefix'] = '';
$db['dbjasgir']['pconnect'] = TRUE;
$db['dbjasgir']['db_debug'] = TRUE;
$db['dbjasgir']['cache_on'] = FALSE;
$db['dbjasgir']['cachedir'] = '';
$db['dbjasgir']['char_set'] = 'utf8';
$db['dbjasgir']['dbcollat'] = 'utf8_general_ci';
$db['dbjasgir']['swap_pre'] = '';
$db['dbjasgir']['autoinit'] = FALSE;
$db['dbjasgir']['stricton'] = FALSE;

$db['dbnfs']['hostname'] = '.,1433';
$db['dbnfs']['username'] = 'CUSTODY';
$db['dbnfs']['password'] = 'CUSTODY1';
$db['dbnfs']['database'] = 'NFS_DB';
$db['dbnfs']['dbdriver'] = 'sqlsrv';
$db['dbnfs']['dbprefix'] = '';
$db['dbnfs']['pconnect'] = TRUE;
$db['dbnfs']['db_debug'] = TRUE;
$db['dbnfs']['cache_on'] = FALSE;
$db['dbnfs']['cachedir'] = '';
$db['dbnfs']['char_set'] = 'utf8';
$db['dbnfs']['dbcollat'] = 'utf8_general_ci';
$db['dbnfs']['swap_pre'] = '';
$db['dbnfs']['autoinit'] = FALSE;
$db['dbnfs']['stricton'] = FALSE;
/* End of file database.php */
/* Location: ./application/config/database.php */