<?php
global $servername ;
global $username;
global $database;
global $connect;

$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'netcar';

$connect = mysqli_connect("localhost", "root", "", "netcar");

if (!$connect) die ("<h2>Database error</h2>");

?>
