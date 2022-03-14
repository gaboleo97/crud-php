<?php
include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

$error = false;
$config = include 'config.php';

try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
  
      $consultaSQL = "SELECT * FROM farmacia";
    
  
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();
  
    $farmacia           = $sentencia->fetchAll();
    $farmacias          = $sentencia;
    $farmacias          = array();
    $farmacias['items'] = array();

    $resultado = $farmacias;
    if($resultado && $sentencia->rowCount() > 0){

        foreach ($farmacia as $row) {
            $item = array(
                'id'        => $row['id'],
                'nombre'    => $row['nombre'],
                'direccion' => $row['direccion'],
                'latitud'   => $row['latitud'],
                'longitud'  => $row['longitud'],
                'created'   => $row['created'],
                'updated'   => $row['updated'],
            );
        echo json_encode($farmacia);
    }
}else{
        echo json_encode(array('mensaje' => 'No hay registros'));
    } 
  } catch(PDOException $error) {
    $error= $error->getMessage();
  }


?>