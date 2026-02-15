<?php 

#Conexión a la base de datos
function conexion_recetas(){
    require 'admin/config.php';
    try {
        $con = new PDO('mysql:host=localhost;dbname='.$bd_config['db_name'], $bd_config['user'], $bd_config['pass']);
        return $con;
    } catch (PDOException $e) {
        return false;
    }
}

#Listar archivos con control de usuario
function listar($conexion, $tipo_comida, $usuario_id, $es_admin = false){
    if ($es_admin) {
        $sql = "SELECT * FROM recetas WHERE tipo_receta = :tipo_comida";
        $query = $conexion->prepare($sql);
    } else {
        $sql = "SELECT * FROM recetas WHERE tipo_receta = :tipo_comida AND usuario_id = :usuario_id";
        $query = $conexion->prepare($sql);
        $query->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    }
    $query->bindParam(':tipo_comida', $tipo_comida, PDO::PARAM_STR);
    $query->execute();
    return $query;
}
function listar_usuarios($conexion, $usuario_id){
        $sql = "SELECT * FROM usuarios";
        $query = $conexion->prepare($sql);
    $query->execute();
    return $query;
}

#insertar

function insertar($conexion, $nombre, $categoria, $archivoBLOB, $tipo_receta, $tipo, $usuario_id){
    $sql = "INSERT INTO recetas(nombre, categoria, archivo, tipo_receta, tipo, usuario_id) VALUES(:nombre, :categoria, :archivo, :tipo_receta, :tipo, :usuario_id)";
    $query = $conexion->prepare($sql);
    $query->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $query->bindParam(':categoria', $categoria, PDO::PARAM_STR);
    $query->bindParam(':archivo', $archivoBLOB, PDO::PARAM_LOB);
    $query->bindParam(':tipo_receta', $tipo_receta, PDO::PARAM_STR);
    $query->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $query->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    return $query->execute();
}

#eliminar con control de usuario
function eliminar($conexion, $id, $usuario_id, $es_admin = false){
    if ($es_admin) {
        $sql = "DELETE FROM recetas WHERE id = :id";
        $query = $conexion->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
    } else {
        $sql = "DELETE FROM recetas WHERE id = :id AND usuario_id = :usuario_id";
        $query = $conexion->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    }
    return $query->execute();
}
function eliminar_usuario($conexion, $id){

        $sql = "DELETE FROM usuarios WHERE id = :id";
        $query = $conexion->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);

    return $query->execute();
}
#editar - obtener datos con control de usuario
function datos($conexion, $id, $usuario_id, $es_admin = false){
    if ($es_admin) {
        $sql = "SELECT * FROM recetas WHERE id = :id";
        $query = $conexion->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
    } else {
        $sql = "SELECT * FROM recetas WHERE id = :id AND usuario_id = :usuario_id";
        $query = $conexion->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    }
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

function editarnombre($conexion, $id, $nombre, $usuario_id, $es_admin = false){
    if ($es_admin) {
        $sql = "UPDATE recetas SET nombre = :nombre WHERE id = :id";
        $query = $conexion->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
    } else {
        $sql = "UPDATE recetas SET nombre = :nombre WHERE id = :id AND usuario_id = :usuario_id";
        $query = $conexion->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    }
    $query->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    return $query->execute();
}

function editararchivo($conexion, $id, $categoria, $tipo, $tipo_receta, $archivoBLOB, $usuario_id, $es_admin = false){
    if ($es_admin) {
        $sql = "UPDATE recetas SET categoria = :categoria, tipo = :tipo, tipo_receta = :tipo_receta, archivo = :archivo WHERE id = :id";
        $query = $conexion->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
    } else {
        $sql = "UPDATE recetas SET categoria = :categoria, tipo = :tipo, tipo_receta = :tipo_receta, archivo = :archivo WHERE id = :id AND usuario_id = :usuario_id";
        $query = $conexion->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    }
    $query->bindParam(':categoria', $categoria, PDO::PARAM_STR);
    $query->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $query->bindParam(':tipo_receta', $tipo_receta, PDO::PARAM_STR);
    $query->bindParam(':archivo', $archivoBLOB, PDO::PARAM_LOB);
    return $query->execute();
}

function editar($conexion, $id, $nombre, $categoria, $tipo, $tipo_receta, $archivoBLOB, $usuario_id, $es_admin = false){
    if ($es_admin) {
        $sql = "UPDATE recetas SET nombre = :nombre, categoria = :categoria, tipo = :tipo, tipo_receta = :tipo_receta, archivo = :archivo WHERE id = :id";
        $query = $conexion->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
    } else {
        $sql = "UPDATE recetas SET nombre = :nombre, categoria = :categoria, tipo = :tipo, tipo_receta = :tipo_receta, archivo = :archivo WHERE id = :id AND usuario_id = :usuario_id";
        $query = $conexion->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    }
    $query->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $query->bindParam(':categoria', $categoria, PDO::PARAM_STR);
    $query->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    $query->bindParam(':tipo_receta', $tipo_receta, PDO::PARAM_STR);
    $query->bindParam(':archivo', $archivoBLOB, PDO::PARAM_LOB);
    return $query->execute();
}

function editarusuario($conexion, $id, $tipo_usuario){
    $sql = "UPDATE usuarios SET tipo_usuario = :tipo_usuario WHERE id = :id";
    $query = $conexion->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->bindParam(':tipo_usuario', $tipo_usuario, PDO::PARAM_STR);
    return $query->execute();
}

function TipoArchivo($tipo, $extension) {
    $extensiones_permitidas = [
        'jpg', 'jpeg', 'png', 'webp',
        'mp4','pdf', 'doc', 'docx'
    ];
    
    $tipos_permitidos = [
        'image/jpeg', 'image/jpg', 'image/png', 'image/webp',
        'video/mp4', 'application/pdf', 'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];
    
    $extension = strtolower($extension);
    
    if (!in_array($extension, $extensiones_permitidas)) {
        return [
            'valido' => false,
            'mensaje' => "La extensión .$extension no está permitida."
        ];
    }
    
    if (!in_array($tipo, $tipos_permitidos)) {
        return [
            'valido' => false,
            'mensaje' => "El tipo de archivo $tipo no está permitido."
        ];
    }
    
    return [
        'valido' => true,
        'mensaje' => "Archivo válido."
    ];
}

?>