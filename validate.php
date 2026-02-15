<?php session_start();

require 'admin/config.php';
require 'functions.php';

// comprobar session
if (isset($_SESSION['usuario'])) {
  // Redirigir directamente al index del recetario
  header('Location: '.RUTA.'index.php');
} else {
  header('Location: '.RUTA.'login.php');
}

?>