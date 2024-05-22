<?php
if (isset($_SESSION["username"])) {
    
}else{
    header("Location: ./");
}
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    require_once 'conexion.php';

    $idLibro = $_GET['id'];

    $sql = "DELETE FROM libros WHERE idLibros = :idLibro";
    $consulta = $conn->prepare($sql);

    $consulta->bindParam(':idLibro', $idLibro, PDO::PARAM_INT);

    if($consulta->execute()) {
        if($consulta->rowCount()>0){
            header('Location: index');
            exit();
        }
    } else {
        echo "Error al eliminar el libro.";
    }
} else {
    echo "ID de libro no válido.";
}

