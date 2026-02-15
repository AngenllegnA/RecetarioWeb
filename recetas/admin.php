<?php session_start();

require 'admin/config.php';
require 'functions.php';

// comprobar session
if (!isset($_SESSION['usuario'])) {
  header('Location: '.RUTA.'login.php');
}

$conexion = conexion($bd_config);
$admin = iniciarsesion('usuarios', $conexion);

if ($admin['tipo_usuario'] == 'administrador') {
  // traer el nombre del usuario
  $user = iniciarsesion('usuarios', $conexion);

  require 'views/admin.view.php';
  
} else {
  header('Location: '.RUTA.'validate.php');
}

 ?>