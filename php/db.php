<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'pablo');
define('DB_PASS', '');    
define('DB_NAME', 'Academia_bonifacio');
define('JWT_SECRET', 'hola'); 

function connectDB() {
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($connection->connect_error) {
        die("Error de conexión: " . $connection->connect_error);
    }
    return $connection;
}
?>
