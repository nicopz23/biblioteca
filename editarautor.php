<?php
session_start();
if (isset($_SESSION["username"])) {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        require_once 'conexion.php';
    
        $idautor = $_GET['id'];
    
        $sql = "select * from autores where idAutores = :idautor";
        $consulta = $conn->prepare($sql);
    
        $consulta->bindParam(':idautor', $idautor, PDO::PARAM_INT);
    
        $consulta->execute();
        $resultados = $consulta->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "ID de autor no válido.";
    }
    if (isset($_POST["nombre_completo"])) {
        require_once 'conexion.php';
        $sql_libro = 'update autores set nombre_completo=?, correo_contacto=? where idAutores = ?';
        
        $nombre = $_POST["nombre_completo"];
        $correo = $_POST["correo_contacto"];
        
        $stmt = $conn->prepare($sql_libro);
        $stmt->bindParam(1, $nombre);
        $stmt->bindParam(2, $correo);
        $stmt->bindParam(3, $idautor);
        $stmt->execute();
    
        $rowCount = $stmt->rowCount();
        if ($rowCount > 0) {
            header("Location: ./");
        } else {
            $mensaje = 'Ha ocurrido un error al editar el autor, intente de nuevo';
        }
    }
}else{
    header("Location: ./");
    exit();
}

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Editar libro</title>
</head>

<body>
    <style>
        body {
            background-color: #666666;
            color: white;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
        }
    </style>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand mr-auto" href="./">Biblioteca</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <?php if (isset($_SESSION["username"])) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="nuevoAutor">Crear Autor</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register">Register</a>
                        </li>
                    <?php endif; ?>

                    <?php if (isset($_SESSION["username"])) : ?>
                        <li class="nav-item">
                            <span class="nav-link" style="color: rgba(255,255,255,.55); margin-left: 500px;">Bienvenido <?php echo $_SESSION["username"]; ?></span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" style="color: rgba(255,255,255,.55);" href="close">Cerrar sesión</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 row">
        <h1 class="mb-4">Crear Nuevo Autor</h1>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="nombre_completo" class="form-label">Nombre Completo</label>
                <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" value="<?php echo $resultados['nombre_completo']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="correo_contacto" class="form-label">Correo de Contacto</label>
                <input type="email" class="form-control" id="correo_contacto" name="correo_contacto" value="<?php echo $resultados['correo_contacto']; ?>" required>
            </div>
            <?php if (isset($mensaje)) {
                echo "<p> $mensaje </p>";
            }
            ?>
            <button type="submit" class="btn btn-primary">Editar Autor</button>
        </form>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

</body>

</html>