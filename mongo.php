<?php
require ("vendor/autoload.php");
$client = new MongoDB\Client();

$db = $client->paises_db->pais;
$cursos = $db->find();
$i = 0;
foreach ($cursos as $key => $value) {
  // code...
  echo $value->nombrePais;
  $i++;
  echo $i;
  echo "<br>";
}

 ?>
