<?php

require "rb/rb.php";
R::setup('mysql:host=localhost;dbname=rb_pharmacy', 'root', 'root'); //for both mysql or mariaDB
R::freeze(true);
R::useJSONFeatures(TRUE); 

if (!R::testConnection()) {
  echo 'нет подключения';
}

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type");

json_decode(file_get_contents("php://input"));

function dumpPhp($var)
{
  echo '<pre>';
  print_r($var);
  echo '</pre>';
}
function getListCities()
{
  //$cities = R::findAll('cities');
  $cities = R::getAll( 'SELECT * FROM cities');
  var_dump($cities);
  //return $cities;
 
}
//print_r(dumpPhp(getListCities()));

// $cities = R::findAll('cities');
// #dumpPhp($cities);
// foreach ($cities as $city) {
//   echo $city['id'];
//   echo '  ';
//   echo $city['name'];
//   echo '<br>';
// }
