<?php
use GraphQL\GraphQL;
use GraphQL\Error\Debug;
require 'vendor/autoload.php';
require 'schema.php'; // Incluye el esquema

// Mostrar errores para depuración (solo en desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Leer el cuerpo de la solicitud
$requestPayload = file_get_contents("php://input");

try {
    // Decodificar el JSON de la solicitud
    $input = json_decode($requestPayload, true);

    // Verificar que exista una consulta
    $query = $input['query'] ?? null;
    if (!$query) {
        throw new Exception("La consulta no está definida.");
    }

    // Ejecutar la consulta o mutación de GraphQL
    $result = GraphQL::executeQuery(
        $schema,
        $query,
        null,  // Root value
        null,  // Contexto
        $input['variables'] ?? [] // Variables (si las hay)
    );

    // Enviar respuesta JSON
    header('Content-Type: application/json');
    echo json_encode($result->toArray());

} catch (Exception $e) {
    // Manejar errores
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
