<?php
include('functions/funciones.php');
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <title>TP 3 </title>
  </head>
  <body>
    <h1 style="width:95%;margin:auto;text-align:center;">Alumno Alexander Castillo</h1>
    <hr>
    <form action="index.php" method="post" style="width:95%;margin:auto;text-align:center;">
    <button type="submit" class="btn btn-primary" name="button" value="submit">MIGRAR DATOS A MONGO DB</button>
    </form>
    <hr>
    <div class="mostrar">
    <form class="" action="index.php" method="post" onsubmit="return eliminar()">
    <button type="submit" name="button" class="btn btn-outline-danger" value="deleteAll">Borrar Todos los Paises</button>
    </form>
    <hr>
    <form class="" action="index.php" method="post">
    <button type="submit" name="button" class="btn btn-outline-primary" value="getAll">Mostrar Todos los Paises</button>
    </form>
    <hr>
    <form class="" action="index.php" method="post">
    <button type="submit" name="button" class="btn btn-warning" value="allAmericans">Mostrar Paises Americanos</button>
    </form>
    <hr>
    <form class="" action="index.php" method="post">
    <button type="submit" name="button" class="btn btn-success" value="allAmericans2">Mostrar Paises Americanos con poblacion mayor a 100000000</button>
    </form>
    <hr>
    <form class="" action="index.php" method="post">
    <button type="submit" name="button" class="btn btn-info" value="noAfrica">Mostrar Paises donde su region sea distinta de Africa</button>
    </form>
    <hr>
    <form class="" action="index.php" method="post">
    <button type="submit" name="button" class="btn btn-danger" value="egiptUpdate">Cambiar nombre de Egypto a Egipto y su poblacion a 95000000</button>
    </form>
    <hr>
    <form class="" action="index.php" method="post" onsubmit="return eliminar()">
    <button type="submit" name="button" class="btn btn-dark" value="delete258">Eliminar paises donde su codigo sea 258</button>
    </form>
    <hr>
    <form class="" action="index.php" method="post">
    <button type="submit" name="button" class="btn btn-secondary" value="population">Paises cuya población sea mayor a 50000000 y menor a 150000000</button>
    </form>
    <hr>
    <form class="" action="index.php" method="post">
    <button type="submit" name="button" class="btn btn-outline-success" value="byName">Ordenar por nombre</button>
    </form>
    <hr>
    <form class="" action="index.php" method="post">
    <button type="submit" name="button" class="btn btn-outline-info" value="noAfrica">Crear un nuevo indice con el codigo pais</button>
    </form>
    </div>
    <br>
    <table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">Pais</th>
      <th scope="col">Capital</th>
      <th scope="col">Region</th>
      <th scope="col">Poblacion</th>
      <th scope="col">Latitud</th>
      <th scope="col">Longitud</th>
      <th scope="col">Superficie</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <?php if ($_POST) {
       foreach ($_POST as $key => $value): ?>
          <tr>
          <td> <?php echo $value->nombrePais ?> </td>
          <td> <?php echo $value->capitalPais ?> </td>
          <td> <?php echo $value->region ?> </td>
          <td> <?php echo $value->poblacion ?> </td>
          <td> <?php echo $value->latitud ?> </td>
          <td> <?php echo $value->longitud ?> </td>
          <td> <?php echo $value->superficie ?> </td>
          </tr>
        <?php endforeach; }?>
    </tr>
  </tbody>
</table>
  </body>
  <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script type="text/javascript">
    function eliminar(){
      if(confirm("Esta seguro")){
        return true;
      }else {
        return false;
      }
    }
  </script>
</html>
