<?php
// Conexión PDO centralizada
// Corrige el DSN para incluir 'host=' y exporta tanto $conexion como $pdo
try {
    $dsn = 'mysql:host=dashboard2026.infinityfreeapp.com;dbname=epiz_12345678_dashboard2026;charset=utf8mb4';
    $username = 'if0_41237493';
    $password = 'Andresxd46';

    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ]);

    // para compatibilidad con código existente que usa $conexion
    $conexion = $pdo;
} catch (PDOException $e) {
    // Fallo en la conexión: muestra mensaje corto (evita exponer credenciales)
    http_response_code(500);
    echo 'Error en la conexión a la base de datos';
    error_log('DB connection error: ' . $e->getMessage());
    exit();
}

?>
