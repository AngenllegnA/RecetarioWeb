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
$datos = datos($conexion_recetas, $id, $usuario_id, $es_admin);

// Verificar permisos
if (!$datos) {
    header('Location: index.php?error=sin_permisos_descarga');
    exit;
}

$tipo = $datos['tipo'];
$categoria = $datos['categoria'];
$nombre = $datos['nombre'];
$archivo = $datos['archivo'];
header("Content-type:$tipo");
header("Content-Disposition:attachment;filename=\"$nombre.$categoria\"");

echo $archivo;
?>