<?php
include("conexion.php");

if($_POST){
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $equipo = $_POST['equipo'];

    $sql = $conexion->prepare("INSERT INTO usuarios 
    (nombre_completo, correo, password, equipo) 
    VALUES (?,?,?,?)");

    $sql->execute([$nombre,$correo,$password,$equipo]);

    echo "Usuario creado correctamente";
}
?>

<form method="POST">
    <input type="text" name="nombre" placeholder="Nombre completo" required>
    <input type="email" name="correo" placeholder="Correo" required>
    <input type="password" name="password" placeholder="Contraseña" required>

    <select name="equipo">
        <option value="Prospecto">Prospecto</option>
        <option value="Base Instalada">Base Instalada</option>
    </select>

    <button type="submit">Crear Usuario</button>
</form>