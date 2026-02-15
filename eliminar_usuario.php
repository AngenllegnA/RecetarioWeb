<?php 
session_start();
require 'admin/config.php';
require 'functions.php';
require 'funciones.php';

// comprobar session
if (!isset($_SESSION['usuario'])) {
  header('Location: login.php');
}

$conexion = conexion($bd_config);
$user = iniciarsesion('usuarios', $conexion);
$usuario_id = obtener_usuario_id($conexion);
$es_admin = es_administrador($conexion);

$id = $_GET['id'];

$conexion_recetas = conexion_recetas();
$query = eliminar_usuario($conexion_recetas, $id);

if($query){
    header('location:controles_admin.php?eliminar=success');
} else {
    header('location:controles_admin.php?eliminar=error');
}
?>