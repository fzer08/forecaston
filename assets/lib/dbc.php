<?php

//**********************************************************************************************************************************************
// SYSTEM CONFIG
//**********************************************************************************************************************************************

//error_reporting( E_ALL & ~E_DEPRECATED & ~E_NOTICE );

//data base connection info
$host = 'localhost';
$username = '';
$password = '';
$database = '';

//data base connection
$condb=mysqli_connect($host,$username,$password,$database);

//check connection
if(mysqli_connect_errno())echo "Failed to connect to MySQL: " . mysqli_connect_error();

//set db parameters
mysqli_set_charset($condb,"utf8"); //allow special characteres to database

?>
