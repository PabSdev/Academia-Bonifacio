<?php
require_once '../php/db.php';
require_once '../vendor/autoload.php'; // Cargar Firebase JWT
use \Firebase\JWT\JWT;

header("Content-Type: application/json");

// Tomar datos del formulario
$data = $_POST; 
$username = $data['usuario'] ?? '';
$password = $data['contrasena'] ?? '';

// Conectar a la base de datos
$conn = connectDB();
$query = "SELECT * FROM usuarios WHERE Usuario = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["message" => "Usuario no encontrado"]);
    exit;
}

$user = $result->fetch_assoc();

// Comparar contraseñas en texto plano
if ($password !== $user['Contrasena']) {
    echo json_encode(["message" => "Contraseña incorrecta"]);
    exit;
}

// Generar token JWT
$payload = [
    "iat" => time(),
    "exp" => time() + (60 * 60), // Expira en 1 hora
    "data" => [
        "id" => $user['ID'],
        "usuario" => $user['Usuario'],
        "Rol" => $user['Rol']
    ]
];

try {
    // Generar el token
    $jwt = JWT::encode($payload, JWT_SECRET, 'HS256');

    // Redirigir dependiendo del rol del usuario
    if ($user['Rol'] === 'Administrador') {
        header("Location: ../controllers/admin.php?jwt=$jwt");
    } else if ($user['Rol'] === 'user') {
        header("Location: ../controllers/user.php?jwt=$jwt");
    } else {
        echo json_encode(["message" => "Rol no reconocido"]);
    }

    exit;  // Detener la ejecución después de la redirección
} catch (Exception $e) {
    echo json_encode(["message" => "Error al generar token", "error" => $e->getMessage()]);
    exit;
}
?>
