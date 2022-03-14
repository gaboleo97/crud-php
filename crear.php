<?php

include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'La Farmacia' . escapar($_POST['nombre']) . ' ha sido agregado con éxito'
  ];

  $config = include 'config.php';

  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $farmacia = [
      "nombre"   => $_POST['nombre'],
      "direccion" => $_POST['direccion'],
      "latitud"    => $_POST['latitud'],
      "longitud"     => $_POST['longitud'],
    ];

    $consultaSQL = "INSERT INTO farmacia (nombre, direccion, latitud, longitud)";
    $consultaSQL .= "values (:" . implode(", :", array_keys($farmacia)) . ")";

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute($farmacia);

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}
?>

<?php include 'templates/header.php'; ?>

<?php
if (isset($resultado)) {
  ?>
  <div class="container mt-3">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-4">Crea una farmacia</h2>
      <hr>
      <form method="post">
        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" name="nombre" id="nombre" class="form-control">
        </div>
        <div class="form-group">
          <label for="direccion">Direccion</label>
          <input type="text" name="direccion" id="direccion" class="form-control">
        </div>
        <div class="form-group">
          <label for="latitud">Latitud</label>
          <input type="text" name="latitud" id="latitud" class="form-control">
        </div>
        <div class="form-group">
          <label for="longitud">Longitud</label>
          <input type="text" name="longitud" id="longitud" class="form-control">
        </div>
        <div class="form-group">
          <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
          <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
          <a class="btn btn-primary" href="index.php">Regresar al inicio</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'templates/footer.php'; ?>