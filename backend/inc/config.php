<?php
date_default_timezone_set('Asia/Jakarta');
ini_set("display_errors", true);

$host = "localhost";
$port = 3306;
$db_username = "root";
$db_password = "";
$db_name = "new_backend";

//main directory
define("DIR_MAIN", "");

//admin directory
define("DIR_ADMIN", "backend");

define('DB_CHARACSET', 'utf8');

define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT']."/".DIR_MAIN);

define('DIR_API', 'api');

//languange
$language  = "en";

require_once("lang/$language.php");
require_once('helper/main.php');
require_once "lib/vendor/autoload.php";

use \Backend\Database as DB;
use \Backend\My_pagination as Pagination;
use \Backend\Dtable as Datatable;

$db=new DB($host, $port, $db_username, $db_password, $db_name);
$pg=new Pagination($db);
$datatable=new Datatable($host, $port, $db_username, $db_password, $db_name);
function handleException($exception)
{
    echo  $exception->getMessage();
}

set_exception_handler('handleException');
