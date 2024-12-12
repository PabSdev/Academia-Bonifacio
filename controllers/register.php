<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "pablo";
$password = "";
$dbname = "Academia_bonifacio";
$table = "usuarios"; // Nombre de la tabla

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se han enviado datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $Nombre = $_POST["Nombre"];
    $Apellidos = $_POST["Apellidos"];
    $Correo = $_POST["Correo"];
    $Usuario = $_POST["Usuario"];
    $contrasena = $_POST["Contrasena"];


    // Preparar la consulta SQL
    $sql = "INSERT INTO usuarios (Nombre, Apellidos, Correo, Usuario, Contrasena, Rol) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

if ($stmt) {
    $Rol = "Estudiante";
    $stmt->bind_param("ssssss", $Nombre, $Apellidos, $Correo, $Usuario, $contrasena, $Rol);

    if ($stmt->execute()) {
        header("Location: /Ejercicios/Academia-bonifacio/public/login.html");
        exit();
    } else {
        $error = "Error al ejecutar la consulta: " . $stmt->error;
    }

    $stmt->close();
} else {
    $error = "Error al preparar la consulta: " . $conn->error;
}

$conn->close();

}

?>
