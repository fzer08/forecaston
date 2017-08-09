<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

// Include DB to force mysqli_real_escape_string
include_once "assets/lib/dbc.php";

// Get data from url
$cityId = $_GET['id'];
$day = $_GET['day'];

// Get data from API
$apiKey = "7ca02a4b9f9b29a1d573b101476d992b";

$curlSession = curl_init();
curl_setopt($curlSession, CURLOPT_URL, "http://api.openweathermap.org/data/2.5/forecast/daily?id=$cityId&cnt=16&appid=$apiKey");
curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
$jsonData = json_decode(curl_exec($curlSession), true);
curl_close($curlSession);

// Espace city name with special char
$cityName = $jsonData["city"]["name"];
$country = $jsonData["city"]["country"];
$cityName = mysqli_real_escape_string($condb,$cityName);

?>
<!DOCTYPE html>
	<html>
	<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="user-scalable=no,initial-scale=1,maximum-scale=1">
		<title>PlayON</title>
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/styles/style.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald:400,700" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	</head>
	<body>
    <div class="container">
      <header class="header text-center">
        <h1><a href="http://fbacchi.com/playon"><img src="assets/images/branding/playon-logo.png" alt="PlayON Logo"></a></h1>
        <h2 class="text-uppercase font-oswald gray"><strong>Forecast</strong></h2>
      </header>
      <article class="jumbotron text-center z-depth-1">
        <h4>Forecast in <span class="highLight"><strong><?php echo $cityName.", ".$country; ?></strong></span> - <?php $date = $value["dt"]; $date = gmdate("l jS", $date); echo $date; ?></h4>
        <?php
          foreach($jsonData["list"] as $value){
            if($value["dt"] == $day){
        ?>
              <p class="temp"> <?php $temp = $value["temp"]["day"]; $temp = round(($temp - 273.15)); echo "Average: ".$temp."°C"; ?></p>
              <p><?php echo $value["weather"][0]["main"]; ?></p>
              <div class="blc-icon"><img alt="" src="http://openweathermap.org/img/w/<?php echo $value["weather"][0]["icon"]; ?>.png"></div>
              <div class="mn">
                <span> <?php $temp = $value["temp"]["min"]; $temp = round(($temp - 273.15)); echo "Min.: ".$temp."°C"; ?></span> | 
                <span> <?php $temp = $value["temp"]["max"]; $temp = round(($temp - 273.15)); echo "Max.: ".$temp."°C"; ?></span> 
              </div>
              <div class="mn">
                <span> <?php $temp = $value["temp"]["night"]; $temp = round(($temp - 273.15)); echo "Night: ".$temp."°C"; ?></span> | 
                <span> <?php $temp = $value["temp"]["eve"]; $temp = round(($temp - 273.15)); echo "Evening: ".$temp."°C"; ?></span> | 
                <span> <?php $temp = $value["temp"]["morn"]; $temp = round(($temp - 273.15)); echo "Morning: ".$temp."°C"; ?></span>
              </div>
              <p class="sm"><?php echo $value["weather"][0]["description"]; ?></p>
              <p class="sm"><?php echo "Humidity: ".$value["humidity"]."0%"; ?></p>
              <div class="mn">
                <span><?php echo "Wind speed: ".$value["speed"]." m/s"; ?></span> | 
                <span><?php echo "Wind direction: ".$value["deg"]." degrees"; ?></span>
              </div>
              <p class="sm"><?php echo "Pressure: ".$value["pressure"]." hpa"; ?></p>

        <?php
            }
          }
        ?>
      </article>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="assets/js/PlayON.js"></script>
  </body>
</html>