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

$tipo_receta = $_GET['tipo_receta'];
$id = $_GET['id'];

$conexion_recetas = conexion_recetas();
$query = eliminar($conexion_recetas, $id, $usuario_id, $es_admin);

if($query){
    header('location:'.$tipo_receta.'.php?eliminar=success');
} else {
    header('location:'.$tipo_receta.'.php?eliminar=error');
}
?>