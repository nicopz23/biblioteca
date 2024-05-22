<?php
if (isset($_SESSION["username"])) {
    
}else{
    header("Location: ./");
}
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    require_once 'conexion.php';

    $idLibro = $_GET['id'];

    $sql = "select * from libros where idLibros = :idLibro";
    $consulta = $conn->prepare($sql);

    $consulta->bindParam(':idLibro', $idLibro, PDO::PARAM_INT);

    $consulta->execute();
    $resultados = $consulta->fetch(PDO::FETCH_ASSOC);
} else {
    echo "ID de libro no válido.";
}
if (isset($_POST["idautor"])) {
    require_once 'conexion.php';
    $sql_libro = 'update libros set idAutores=?, Titulo=?, descripcion=? where idLibros = ?';
    $idautor = $_POST["idautor"];
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];

    $stmt = $conn->prepare($sql_libro);
    $stmt->bindParam(1, $idautor);
    $stmt->bindParam(2, $titulo);
    $stmt->bindParam(3, $descripcion);
    $stmt->bindParam(4, $idLibro);
    $stmt->execute();

    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
        header("Location: ./");
    } else {
        $mensaje = 'Ha ocurrido un error al crear el libro, intente de nuevo';
    }
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
        <h1 class="mb-4">Editar Libro</h1>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="number" class="form-label">Autor</label>
                <input type="number" class="form-control" id="idautor" name="idautor" value="<?php echo $resultados['idAutores']; ?>" required></>
            </div>
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $resultados['Titulo']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php echo $resultados['descripcion']; ?></textarea>
            </div>
            <?php if (isset($mensaje)) {
                echo "<p> $mensaje </p>";
            }
            ?>
            <button type="submit" class="btn btn-primary">Guardar Libro</button>
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