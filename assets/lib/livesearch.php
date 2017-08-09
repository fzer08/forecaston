<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

// Connect to DB 
include_once "dbc.php";

// Get data from PlayON.js
$q = $_GET['q'];
//$q = 'ass';

// Search for query
$sql = mysqli_query($condb,"SELECT * FROM cities WHERE city LIKE '%{$q}%'") or die(mysqli_error($condb));

// Treat search result
if(mysqli_num_rows($sql) == 0){
  echo "<li class='hide'></li>";
}else{
  while ($row_sql = mysqli_fetch_array($sql)){
    $id = $row_sql["id"];
    $city = $row_sql["city"];
    $country = $row_sql["country"];
    echo "<a class='list-group-item' href='forecast.php?id=$id'>$city, $country</a>";
  }
}

?>