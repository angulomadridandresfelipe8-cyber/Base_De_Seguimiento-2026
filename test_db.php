<?php
/**
 * Archivo de prueba para diagnosticar errores de conexión a BD
 * Elimina este archivo después de resolver el problema
 */

echo "<h2>🔧 Diagnóstico de Conexión a BD</h2>";
echo "<hr>";

// Intenta diferentes hosts comunes en InfinityFree
$hosts_a_probar = [
    'dashboard2026.infinityfreeapp.com',
    'localhost',
    '127.0.0.1',
    'sql.infinityfreeapp.com',
];

$username = 'if0_41237493';
$password = 'Andresxd46';
$dbname = 'epiz_12345678_dashboard2026';

echo "<h3>Credenciales configuradas:</h3>";
echo "<ul>";
echo "<li><strong>Usuario:</strong> $username</li>";
echo "<li><strong>Base de datos:</strong> $dbname</li>";
echo "<li><strong>Contraseña:</strong> " . str_repeat("*", strlen($password)) . " (ocultada)</li>";
echo "</ul>";

echo "<h3>Intentos de conexión:</h3>";

foreach ($hosts_a_probar as $host) {
    echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px 0; background: #f9f9f9;'>";
    echo "<strong>Host: $host</strong><br>";
    
    try {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 5
        ]);
        
        echo "<span style='color: green; font-weight: bold;'>✅ ÉXITO</span><br>";
        echo "Conexión establecida correctamente.<br>";
        echo "<strong>Usa este host en conexion.php:</strong> <code>$host</code>";
        
        // Intenta una consulta simple
        $result = $pdo->query("SELECT 1");
        if ($result) {
            echo "<br>✅ Consulta de prueba OK";
        }
        
    } catch (PDOException $e) {
        echo "<span style='color: red; font-weight: bold;'>❌ FALLÓ</span><br>";
        echo "Error: " . htmlspecialchars($e->getMessage()) . "<br>";
        echo "Código: " . htmlspecialchars($e->getCode());
    }
    echo "</div>";
}

echo "<hr>";
echo "<h3>💡 Sugerencias:</h3>";
echo "<ul>";
echo "<li>Si una conexión tiene ✅ ÉXITO, copia el host y úsalo en conexion.php</li>";
echo "<li>Si ninguno funciona, verifica en el panel de InfinityFree el nombre exacto del host MySQL</li>";
echo "<li>Las credenciales podrían estar incorrectas; revísalas en el panel de hosting</li>";
echo "<li>Algunos hosts comparten límites de conexiones; espera unos minutos e intenta de nuevo</li>";
echo "</ul>";

echo "<hr>";
echo "<p><small>⚠️ Elimina este archivo (test_db.php) después de usar; es solo para depuración</small></p>";
?>
