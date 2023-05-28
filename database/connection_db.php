<?php
global $servername ;
global $username;
global $database;
global $connect;
global $_DELETE;
global $_PUT;

$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'netcar';

$connect = mysqli_connect("localhost", "root", "", "netcar");

if (!$connect) die ("<h2>Database error</h2>");

$_DELETE = array();
$_PUT = array();

if (!strcasecmp($_SERVER['REQUEST_METHOD'], 'DELETE')) {
    parse_str(file_get_contents('php://input'), $_DELETE);
}
if (!strcasecmp($_SERVER['REQUEST_METHOD'], 'PUT')) {
    parse_str(file_get_contents('php://input'), $_PUT);
}