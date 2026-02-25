<?php
session_start();

if(isset($_POST['ingresar'])){
    $_SESSION['nombre'] = $_POST['nombre'];
    $_SESSION['apellido'] = $_POST['apellido'];
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>🚀 ERP Comercial 2026 - Login</title>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #333;
}

.container {
    width: 420px;
    padding: 50px;
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    text-align: center;
    animation: fadeIn 0.8s ease-in-out;
    position: relative;
    overflow: hidden;
}

.container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2, #f093fb, #f5576c);
    background-size: 400% 400%;
    animation: gradientShift 3s ease infinite;
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(30px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.logo {
    font-size: 48px;
    margin-bottom: 10px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

h2 {
    color: #2d3748;
    margin-bottom: 30px;
    font-size: 28px;
    font-weight: 700;
}

.subtitle {
    color: #718096;
    margin-bottom: 40px;
    font-size: 16px;
}

.form-group {
    margin-bottom: 25px;
    text-align: left;
}

label {
    display: block;
    color: #4a5568;
    font-weight: 600;
    margin-bottom: 8px;
    font-size: 14px;
}

input {
    width: 100%;
    padding: 16px 20px;
    border-radius: 12px;
    border: 2px solid #e2e8f0;
    font-size: 16px;
    transition: all 0.3s ease;
    background: #f8f9fa;
    box-sizing: border-box;
}

input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    background: white;
    transform: translateY(-2px);
}

button {
    width: 100%;
    padding: 18px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    border-radius: 12px;
    cursor: pointer;
    font-weight: 700;
    font-size: 16px;
    transition: all 0.3s ease;
    margin-top: 20px;
    position: relative;
    overflow: hidden;
}

button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

button:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
}

button:hover::before {
    left: 100%;
}

button:active {
    transform: translateY(-1px);
}

.demo-users {
    margin-top: 40px;
    padding: 20px;
    background: rgba(102, 126, 234, 0.05);
    border-radius: 12px;
    border: 1px solid rgba(102, 126, 234, 0.1);
}

.demo-users h3 {
    color: #2d3748;
    margin-bottom: 15px;
    font-size: 18px;
}

.demo-users p {
    color: #718096;
    font-size: 14px;
    margin-bottom: 10px;
}

.demo-users .user {
    display: inline-block;
    background: white;
    padding: 8px 16px;
    border-radius: 8px;
    margin: 5px;
    font-size: 14px;
    border: 1px solid #e2e8f0;
    color: #4a5568;
}

.footer {
    margin-top: 30px;
    color: #a0aec0;
    font-size: 14px;
}

.footer a {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
}

.footer a:hover {
    text-decoration: underline;
}

@media (max-width: 480px) {
    .container {
        width: 90%;
        padding: 30px 25px;
    }

    .logo {
        font-size: 36px;
    }

    h2 {
        font-size: 24px;
    }
}
</style>
</head>
<body>

<div class="container">
<div class="logo">🚀</div>
<h2>ERP 2026</h2>
<p class="subtitle">Sistema de Seguimiento Comercial</p>

<form method="POST">
    <div class="form-group">
        <label for="nombre">👤 Nombre</label>
        <input type="text" id="nombre" name="nombre" placeholder="Ingresa tu nombre" required>
    </div>

    <div class="form-group">
        <label for="apellido">📝 Apellido</label>
        <input type="text" id="apellido" name="apellido" placeholder="Ingresa tu apellido" required>
    </div>

    <button type="submit" name="ingresar">🚀 Iniciar Sesión</button>
</form>

<div class="demo-users">
<h3>👥 Usuarios de Prueba</h3>
<p>Usa cualquiera de estos usuarios para probar el sistema:</p>
<div class="user">Andrés Fangulom</div>
<div class="user">Sara González</div>
<div class="user">Miguel Rodríguez</div>
<div class="user">Valentina López</div>
<div class="user">Carlos Martínez</div>
</div>

<div class="footer">
<p>¿Necesitas ayuda? <a href="#contact">Contacta al administrador</a></p>
</div>
</div>

</body>
</html>