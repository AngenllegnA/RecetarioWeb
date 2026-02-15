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

#captura de datos
$tipo_usuario = $_POST['rol'];
$id = $_POST['id'];

if (isset($id) && isset($tipo_usuario)) {
    $query = editarusuario($conexion,$id,$tipo_usuario);
    header("location:controles_admin.php?id=$id&editar=success");
}else{
    header("location:controles_admin.php?id=$id");
}

?>