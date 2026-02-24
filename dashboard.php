<?php
include("conexion.php");

if(!isset($_SESSION['usuario_id'])){
    header("Location: login.php");
    exit();
}

$id = $_SESSION['usuario_id'];

$sql = $conexion->prepare("SELECT * FROM resultados WHERE usuario_id=?");
$sql->execute([$id]);
$resultados = $sql->fetchAll();
?>

<h2>Bienvenido <?php echo $_SESSION['nombre']; ?></h2>
<h3>Equipo: <?php echo $_SESSION['equipo']; ?></h3>

<table border="1">
<tr>
    <th>Fecha</th>
    <th>Leads</th>
    <th>Oportunidades</th>
    <th>Calificadas</th>
    <th>Cierres</th>
</tr>

<?php foreach($resultados as $r){ ?>
<tr>
    <td><?php echo $r['fecha']; ?></td>
    <td><?php echo $r['leads_dia']; ?></td>
    <td><?php echo $r['oportunidades_creadas']; ?></td>
    <td><?php echo $r['oportunidades_calificadas']; ?></td>
    <td><?php echo $r['cierres']; ?></td>
</tr>
<?php } ?>

</table>

<a href="logout.php">Cerrar sesión</a>