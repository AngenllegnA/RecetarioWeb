<?php

function conexion($bd_config){
  try {
    $conexion = new PDO('mysql:host=localhost;dbname='.$bd_config['db_name'],$bd_config['user'],$bd_config['pass']);
    return $conexion;
  } catch (PDOException $e) {
    return false;
  }
}

function limpiardatos($datos){
  $datos = htmlspecialchars($datos);
  $datos = trim($datos);
  $datos = filter_var($datos, FILTER_SANITIZE_STRING);

  return $datos;
}

function iniciarsesion($table, $conexion){
  $statement = $conexion->prepare("SELECT * FROM $table WHERE usuario = :usuario");
  $statement->execute([
    ':usuario' => $_SESSION['usuario']
  ]);
  return $statement->fetch(PDO::FETCH_ASSOC);
}

// Función para obtener el ID del usuario actual
function obtener_usuario_id($conexion) {
    $user = iniciarsesion('usuarios', $conexion);
    return $user['id'];
}

// Función para verificar si es administrador
function es_administrador($conexion) {
    $user = iniciarsesion('usuarios', $conexion);
    return $user['tipo_usuario'] == 'administrador';
}

?>