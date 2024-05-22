<?php
require_once 'conexion.php';
session_start();
$sql = 'select * from libros l join autores a on a.idAutores=l.idAutores';
$consulta = $conn->prepare($sql);
$consulta->execute();
$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Biblioteca</title>
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
    </style>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand mr-auto" href="./">Biblioteca</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <?php if (isset($_SESSION["username"])) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="nuevoLibro">Crear Libro</a>
                        </li>
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

    <div class="container row" style="margin-top: 70px;">

        <h3>Libros</h3>

        <div class="table-responsive">
            <table class="table">
                <thead style="background-color: #343a40; color: white;">
                    <tr>
                        <th scope="col">Autor</th>
                        <th scope="col">Correo de contacto</th>
                        <th scope="col">Título</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Fecha de Publicación en la Pagina</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultados as $libro) : ?>
                        <tr>
                            <td scope="row" style="background-color:#343a40; color:white;"><?php echo $libro['nombre_completo']; ?></td>
                            <td scope="row" style="background-color:#343a40; color:white;"><?php echo $libro['correo_contacto']; ?></td>
                            <td scope="row" style="background-color:#343a40; color:white;"><?php echo $libro['Titulo']; ?></td>
                            <td scope="row" style="background-color:#343a40; color:white;"><?php echo $libro['descripcion']; ?></td>
                            <td scope="row" style="background-color:#343a40; color:white;"><?php echo $libro['fecha_publicacion']; ?></td>
                            <td scope="row" style="background-color:#343a40; color:white;"><?php echo "<i class='fas fa-trash-alt delete-book' data-book-id='" . $libro['idLibros'] . "'></i>"; ?>
                                <a href="editarlibro?id=<?php echo $libro['idLibros']; ?>"><i class='fas fa-edit edit-book'></i></a>
                            <?php endforeach; ?>
                </tbody>
            </table>    
        </div>
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
                    ¿Estás seguro de que quieres eliminar este libro?
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
                fetch('eliminar_libro?id=' + bookId)
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