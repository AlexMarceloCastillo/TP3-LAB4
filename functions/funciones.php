<?php
//MONGO DB

set_time_limit(40000);
error_reporting(0);
$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");

//INSERTAR PAISES
function insertarPais($codigoPais,$nombre,$capital,$region,$poblacion,$latitud,$longitud,$superficie,$numericCode){
  global $manager;
  $bulkWrite = new MongoDB\Driver\BulkWrite;
  $bulkWrite->insert(['codigoPais' => $codigoPais, 'nombrePais' => $nombre, 'capitalPais' => $capital,'region' => $region, 'poblacion' => $poblacion, 'latitud' => $latitud, 'longitud' => $longitud,
  'superficie' => $superficie ,'numericCode' => $numericCode]);
  try {
  $manager->executeBulkWrite("paises_db.pais", $bulkWrite);
   }catch (MongoDB\Driver\Exception\BulkWriteException $e) {
    $manager = $e->getWriteResult();
   }
  }
//COMPROBAR PAIS
function existePais($numericCode){
  global $manager;
  $filter = ['numericCode' => "$numericCode"];
  $options = [];
  $query = new \MongoDB\Driver\Query($filter, $options);
  $rows = $manager->executeQuery('paises_db.pais', $query);
  $a;
  foreach ($rows as $key => $value) {
    $a = $key;
  }
  if(isset($a)){
    return true;
  }else{
    return false;
  }
}

//ACTUALIZAR PAISE
function actualizarPais($numericCode,$pais){
  global $manager;
  $bulkWrite = new MongoDB\Driver\BulkWrite;
  $bulkWrite->update(['numericCode' => "$numericCode"],
  ['$set' => ['codigoPais' => $pais->callingCodes,'nombrePais' => $pais->name,
  'capitalPais' => $pais->capital, 'region' => $pais->region, 'poblacion' => $pais->population,
  'latitud' => $pais->latlng[0], 'longitud' => $pais->latlng[1], 'superficie' => $pais->area, 'numericCode' => $numericCode]
  ]);
  $manager->executeBulkWrite("paises_db.pais",$bulkWrite);
}


//Retorna todo los paises
function returnAll(){
  global $manager;
  $filter = [];
  $options = ['sort' => ['region' => 1]];
  $query = new \MongoDB\Driver\Query($filter, []);
  $paises = $manager->executeQuery('paises_db.pais', $query);
  return $paises;
}
function deleteAll(){
  global $manager;
  $bulkWrite = new MongoDB\Driver\BulkWrite;
  $bulkWrite->delete([]);
  $manager->executeBulkWrite("paises_db.pais",$bulkWrite);
}

//PAISES DONDE LA REGION SEA AMERICA
function paisesAmericanos(){
  global $manager;
  $filter = ['region' => "Americas"];
  $options = [];
  $query = new \MongoDB\Driver\Query($filter, $options);
  $paises = $manager->executeQuery('paises_db.pais', $query);
  return $paises;
}


//PAISES DONDE LA REGION SEA AMERICA Y TENGA UNA POBLACION MAYOR A 100000000
function americanosMayorA(){
  global $manager;
  $filter = ['region' => "Americas",'poblacion' =>['$gte' => 100000000] ];
  $options = [];
  $query = new \MongoDB\Driver\Query($filter, $options);
  $paises = $manager->executeQuery('paises_db.pais', $query);
  return $paises;
}


//PAISES DONDE LA REGION SEA DISTINTA DE AFRICA
function noAfrica(){
  global $manager;
  $filter = ['region' => ['$ne' => "Africa"] ];
  $options = [];
  $query = new \MongoDB\Driver\Query($filter, $options);
  $paises = $manager->executeQuery('paises_db.pais', $query);
  return $paises;
}


//UPDATE EGYPT
function updateEgypt(){
  global $manager;
  $bulkWrite = new MongoDB\Driver\BulkWrite;
  $bulkWrite->update(['numericCode' => '818'],['$set' => ['nombrePais' => "Egipto","poblacion" => 95000000]]);
  $manager->executeBulkWrite("paises_db.pais",$bulkWrite);
  $filter = ['nombrePais' => 'Egipto'  ];
  $options = [];
  $query = new \MongoDB\Driver\Query($filter, $options);
  $pais = $manager->executeQuery('paises_db.pais', $query);
  return $pais;
}


//ELIMINAR PAIS CODIGO = 258
function eliminarPorCodigo($codigo){
  global $manager;
  $bulkWrite = new MongoDB\Driver\BulkWrite;
  $bulkWrite->delete(['codigoPais' => $codigo]);
  $manager->executeBulkWrite("paises_db.pais",$bulkWrite);
}

                         //36155487          //323.947.000
//PAISES POBLACION MAYOR A 50000000 y MENOR A 150.000.000.
function paisesEntre(){
  global $manager;
  $filter = [ 'poblacion' =>['$gte' => 50000000] ,'poblacion' =>['$lte' => 150000000]];
  $options = [];
  $query = new \MongoDB\Driver\Query($filter, $options);
  $paises = $manager->executeQuery('paises_db.pais', $query);
  return $paises;
}


//ORDENAR POR NOMBRE
function orderByName(){
  global $manager;
  $options = ['sort' => ['nombrePais' => 1]];
  $query = new \MongoDB\Driver\Query([], $options);
  $paises = $manager->executeQuery('paises_db.pais', $query);
  return $paises;
}
//
function crearIndice(){
  global $manager;
  $command = new \MongoDB\Driver\Command(['createIndexes' => 'pais','indexes' => [['name' => 'codigoPais','key'  => ['codigoPais' => 1]]]]);
  $manager->executeCommand('paises_db', $command);

}
function migrarDatos(){
  for ($codigo=1; $codigo <= 300 ; $codigo++) {
  try {
    $api = file_get_contents("https://restcountries.eu/rest/v2/callingcode/$codigo");
    $json = json_decode($api);
    if($json){
    foreach ($json as $key => $pais) {
       if(existePais($pais->numericCode)){
         actualizarPais($pais->numericCode,$pais);
       }else{
         insertarPais($pais->callingCodes,$pais->name,$pais->capital,$pais->region,$pais->population,$pais->latlng[0],$pais->latlng[1],$pais->area,$pais->numericCode);
       }
     }
    }else {
    //echo "ERROR EN LA URL (404) https://restcountries.eu/rest/v2/callingcode/$i";
    //echo "<br>";
    continue;
     }
    }catch (\Exception $e) {
   }
  }
}



$pais;
if($_POST){
  $_POST = ejecutar($_POST['button']);
}
function ejecutar($funcion){

  switch ($funcion) {
    case 'getAll':
      $pais = returnAll();
      break;
    case 'submit':
      migrarDatos();
      break;
    case 'noAfrica':
      echo "no africa";
      $pais = noAfrica();
      break;
    case 'allAmericans':
      $pais = paisesAmericanos();
      break;
    case 'allAmericans2':
      $pais = americanosMayorA();
      break;
    case 'egiptUpdate':
      echo "EGIPTO ACTUALIZADO";
      $pais = updateEgypt();
      break;
    case 'delete258':
      eliminarPorCodigo("258");
      echo "REGISTRO 258 ELIMINADO";
      $pais = true;
    case 'population':
      $pais = paisesEntre();
      break;
    case 'deleteAll':
      deleteAll();
      $pais = [];
      echo "BORRADO CON EXITO";
      break;
    case 'byName':
      $pais = orderByName();
      break;
    case 'newIndex':
      crearIndice();
      $pais = [];
      echo "Indice creado";
      break;
  }
  return $pais;
}
