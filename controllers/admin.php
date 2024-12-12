<?php
require_once '../vendor/autoload.php'; // Cargar Firebase JWT
use \Firebase\JWT\JWT;

define('JWT_SECRET', 'hola'); // Definir tu clave secreta

header("Content-Type: application/json");

// Comprobar si el JWT está presente en la URL
if (!isset($_GET['jwt']) || empty($_GET['jwt'])) {
    http_response_code(401); // No autorizado
    echo json_encode(["message" => "Acceso denegado. Token no proporcionado."]);
    exit;
}

$jwt = $_GET['jwt'];

try {
    // Decodificar el token
    // Aquí no debes pasar por referencia el tercer argumento (headers)
    $decoded = JWT::decode($jwt, JWT_SECRET, ['HS256']);
    $userData = (array) $decoded->data;

    // Validar que el rol sea "Administrador"
    if ($userData['Rol'] !== 'Administrador') {
        http_response_code(403); // Prohibido
        echo json_encode(["message" => "Acceso denegado. Solo administradores."]);
        exit;
    }
    
    // Si la validación es exitosa, mostrar el panel de administración
    echo "<h1>Bienvenido al Panel de Administración</h1>";
    echo "<p>Hola, " . htmlspecialchars($userData['usuario']) . ".</p>";
    // Aquí puedes añadir el contenido del panel de administración, por ejemplo:
    echo "<ul>";
    echo "<li><a href='manage_users.php'>Gestionar Usuarios</a></li>";
    echo "<li><a href='manage_courses.php'>Gestionar Cursos</a></li>";
    echo "<li><a href='view_stats.php'>Ver Estadísticas</a></li>";
    echo "</ul>";
} catch (Exception $e) {
    // Si el token no es válido o ha expirado
    http_response_code(401); // No autorizado
    echo json_encode(["message" => "Acceso denegado. Token inválido o expirado."]);
    exit;
}
?>