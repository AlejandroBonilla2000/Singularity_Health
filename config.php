<?php
// Configuración de la base de datos
$host = 'localhost';     // Cambiar según tu configuración
$dbname = 'singularity_health'; // Cambiar según tu base de datos
$username = 'root';   // Cambiar por tu usuario de la base de datos
$password = ''; // Cambiar por tu contraseña de la base de datos

try {
    // Conexión a la base de datos usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Establecer el modo de error a excepción para facilitar la depuración
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si hay un error en la conexión, muestra el mensaje
    echo "Error de conexión: " . $e->getMessage();
    exit;
}
