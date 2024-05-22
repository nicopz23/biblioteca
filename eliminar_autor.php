<?php
if (isset($_SESSION["username"])) {
    if(isset($_GET['id']) && is_numeric($_GET['id'])) {
        require_once 'conexion.php';
    
        $idautor = $_GET['id'];
    
        $sql = "DELETE FROM autores WHERE idAutores = :idautor";
        $consulta = $conn->prepare($sql);
    
        $consulta->bindParam(':idautor', $idautor, PDO::PARAM_INT);
    
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
}else{
    header("Location: ./");
    exit();
}
