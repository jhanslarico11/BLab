<?php
$servername = "localhost";
$username = "root"; // Usuario por defecto en XAMPP
$password = "";     // Contraseña por defecto en XAMPP
$dbname = "bolsa_laboral"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
