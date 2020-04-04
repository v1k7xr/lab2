<?php 

#1 Show all error for debug timeline
ini_set('display_errors', 1);
error_reporting(E_ALL);

#2 Define Router class and other server system files
require_once("../src/Components/Router.php");

#3 DB Connection (?)

#4 Call Router

$router = new Router();
$router->run();
?>