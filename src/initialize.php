<?php


use Src\databaseHelper\DatabaseObject;
use Src\databaseHelper\DatabaseUtils;
use Src\helper\StringUtils;
ob_start();
session_start();

define("SRC_PATH", dirname(__FILE__));
define("SHARED_PATH", SRC_PATH . '/shared');

$public_end = strpos($_SERVER['SCRIPT_NAME'], '/shopping_cart') + 10;
$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
define("WWW_ROOT", $doc_root);


$connection = DatabaseUtils::database_connection();
$databaseObject = new DatabaseObject;
$databaseObject->set_database($connection);
StringUtils::set_database($connection);
