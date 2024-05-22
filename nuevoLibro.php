<?php
require_once 'conexion.php';
session_start();
if (isset($_SESSION["username"])) {
    
}else{
    header("Location: ./");
}
$sql = 'SELECT * FROM autores';

// Verificar si se ha enviado una solicitud de búsqueda
if (isset($_GET['search']) && !empty($_GET['search'])) {
    // Obtener el término de búsqueda
    $searchTerm = '%' . $_GET['search'] . '%';

    // Modificar la consulta para filtrar por nombre del autor
    $sql .= ' WHERE nombre_completo LIKE :searchTerm';
}

// Preparar y ejecutar la consulta
$consulta = $conn->prepare($sql);

// Si hay un término de búsqueda, vincularlo a la consulta
if (isset($searchTerm)) {
    $consulta->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
}

$consulta->execute();

// Obtener los resultados
$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST["idautor"])) {
    $sql_libro = 'insert into libros (idAutores,Titulo,descripcion) values (?,?,?)';
    $idautor = $_POST["idautor"];
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $stmt = $conn->prepare($sql_libro);
    $stmt->bindParam(1, $idautor);
    $stmt->bindParam(2, $titulo);
    $stmt->bindParam(3, $descripcion);
    $stmt->execute();

    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
        $mensaje = 'Se ha creado el libro correctamente';
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
    <title>Nuevo libro</title>
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

    <div class="container row">
        <h3>Autores</h3>
        <form action="" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Buscar por nombre de autor" name="search">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </form>
        <div class="table-responsive ">
            <table class="table table-striped">
                <thead style="background-color: #343a40; color: white;">
                    <tr>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>

                        <th scope="col">#</th>
                        <th scope="col">Autores</th>
                        <th scope="col">Acciones</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultados as $libro) : ?>
                        <tr>
                            <td scope="row" style="background-color:#343a40; color:white;"><?php echo ''; ?></td>
                            <td scope="row" style="background-color:#343a40; color:white;"><?php echo ''; ?></td>
                            <td scope="row" style="background-color:#343a40; color:white;"><?php echo ''; ?></td>
                            <td scope="row" style="background-color:#343a40; color:white;"><?php echo ''; ?></td>
                            <td scope="row" style="background-color:#343a40; color:white;"><?php echo ''; ?></td>

                            <td scope="row" style="background-color:#343a40; color:white;"><?php echo $libro['idAutores']; ?></td>
                            <td scope="row" style="background-color:#343a40; color:white;"><?php echo $libro['nombre_completo']; ?></td>
                            <td scope="row" style="background-color:#343a40; color:white;"><?php echo "<i class='fas fa-trash-alt delete-book' data-book-id='" . $libro['idAutores'] . "'></i>"; ?>
                                <a href="editarautor?id=<?php echo $libro['idAutores']; ?>"><i class='fas fa-edit edit-book'></i></a>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
    if (empty($resultados)) {
        echo '<div class="alert alert-warning" role="alert">No se encontraron resultados para la búsqueda.</div>';
    }
    ?>
    <div class="container mt-5 row">
        <h1 class="mb-4">Crear Nuevo Libro</h1>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="number" class="form-label">Autor</label>
                <input type="number" class="form-control" id="idautor" name="idautor" required></>
            </div>
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
            <?php if (isset($mensaje)) {
                echo "<p> $mensaje </p>";
            }
            ?>
            <button type="submit" class="btn btn-primary">Guardar Libro</button>
        </form>
    </div>




<!-- Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="color: #343a40;" class="modal-title" id="exampleModalLabel">Confirmación de Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="color: #343a40;">
                    ¿Estás seguro de que quieres borrar este autor para siempre?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirmDeleteButton">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const confirmDeleteButton = document.getElementById('confirmDeleteButton');
            const deleteIcons = document.querySelectorAll('.delete-book');

            deleteIcons.forEach(icon => {
                icon.addEventListener('click', function() {
                    const bookId = this.getAttribute('data-book-id');
                    confirmDeleteButton.setAttribute('data-book-id', bookId);
                    const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
                    modal.show();
                });
            });

            confirmDeleteButton.addEventListener('click', function() {
                const bookId = this.getAttribute('data-book-id');
                fetch('eliminar_autor?id=' + bookId)
                    .then(response => {
                        if (response.ok) {
                            // Aquí puedes actualizar la página o realizar cualquier otra acción necesaria después de eliminar el libro
                            console.log('Libro eliminado exitosamente');
                            location.reload()
                        } else {
                            console.error('Error al eliminar el libro');
                        }
                    })
                    .catch(error => {
                        console.error('Error de red:', error);
                    });

                const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
                modal.hide();
            });
        });
    </script>
</body>

</html>