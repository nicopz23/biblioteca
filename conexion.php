<?php
require_once 'config_Prod.php';
// Datos de conexión a la base de datos
$servername = DB_HOST;
$username = DB_USER;
$password = DB_PASSWORD;
$database = DB_NAME;

try {
    // Crear una conexión con PDO
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);

    // Establecer el modo de error de PDO a excepción
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Conexion exitosa con config";

} catch (PDOException $e) {
    //echo "Fallo la conexion";
    die("Error de conexión: " . $e->getMessage());
}
