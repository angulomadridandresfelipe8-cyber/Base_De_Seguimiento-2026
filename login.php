<?php
include("conexion.php");

if($_POST){
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $sql = $conexion->prepare("SELECT * FROM usuarios WHERE correo=?");
    $sql->execute([$correo]);
    $usuario = $sql->fetch();

    if($usuario && password_verify($password, $usuario['password'])){
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nombre'] = $usuario['nombre_completo'];
        $_SESSION['equipo'] = $usuario['equipo'];

        header("Location: dashboard.php");
    } else {
        echo "Datos incorrectos";
    }
}
?>

<form method="POST">
    <input type="email" name="correo" placeholder="Correo">
    <input type="password" name="password" placeholder="Contraseña">
    <button type="submit">Ingresar</button>
</form>
