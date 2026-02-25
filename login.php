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
<title>Login ERP Comercial</title>
<style>
body{
margin:0;
font-family:Segoe UI;
background:linear-gradient(135deg,#0f172a,#1e293b);
display:flex;
justify-content:center;
align-items:center;
height:100vh;
}
.card{
background:white;
padding:40px;
border-radius:16px;
width:320px;
box-shadow:0 10px 25px rgba(0,0,0,0.3);
}
input{
width:100%;
padding:10px;
margin-bottom:15px;
border-radius:8px;
border:1px solid #ccc;
}
button{
width:100%;
padding:12px;
background:#2563eb;
border:none;
color:white;
font-weight:bold;
border-radius:8px;
cursor:pointer;
}
button:hover{background:#1e40af;}
h2{text-align:center;}
</style>
</head>
<body>

<form method="POST" class="card">
<h2>Ingreso Analista</h2>
<input type="text" name="nombre" placeholder="Nombre" required>
<input type="text" name="apellido" placeholder="Apellido" required>
<button name="ingresar">Ingresar</button>
</form>

</body>
</html>