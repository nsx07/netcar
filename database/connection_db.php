<?php
global $servername ;
global $username;
global $password;
global $database;

$servername = "localhost:3306";
$username = "admin";
$password = "netcar@admin";
$database = "netcar";

$connect = mysql_connect($servername, $username, $password);

if (!$connect) die ("<h2>Database error</h2>")

$db = mysql_select_db($database);

?>
