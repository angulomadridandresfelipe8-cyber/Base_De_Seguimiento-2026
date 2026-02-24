<?php
include("conexion.php");

if(!isset($_SESSION['usuario_id'])){
    header("Location: login.php");
    exit();
}

$id = $_SESSION['usuario_id'];

/* GUARDAR RESULTADOS */
if($_POST){
    $fecha = $_POST['fecha'];
    $leads = $_POST['leads'];
    $creadas = $_POST['creadas'];
    $calificadas = $_POST['calificadas'];
    $cierres = $_POST['cierres'];

    $sql = $conexion->prepare("INSERT INTO resultados 
    (usuario_id, fecha, leads_dia, oportunidades_creadas, oportunidades_calificadas, cierres) 
    VALUES (?,?,?,?,?,?)");

    $sql->execute([$id,$fecha,$leads,$creadas,$calificadas,$cierres]);
}

/* TRAER RESULTADOS DEL USUARIO */
$sql = $conexion->prepare("SELECT * FROM resultados WHERE usuario_id=? ORDER BY fecha DESC");
$sql->execute([$id]);
$resultados = $sql->fetchAll();

/* CALCULAR TOTALES */
$totalLeads = 0;
$totalCierres = 0;

foreach($resultados as $r){
    $totalLeads += $r['leads_dia'];
    $totalCierres += $r['cierres'];
}

$tasa = $totalLeads > 0 ? round(($totalCierres/$totalLeads)*100,1) : 0;
?>

<h2>Bienvenido <?php echo $_SESSION['nombre']; ?></h2>
<h3>Equipo: <?php echo $_SESSION['equipo']; ?></h3>

<hr>

<h3>Registrar Resultados</h3>

<form method="POST">
    <input type="date" name="fecha" required>
    <input type="number" name="leads" placeholder="Leads del día" required>
    <input type="number" name="creadas" placeholder="Oportunidades creadas" required>
    <input type="number" name="calificadas" placeholder="Oportunidades calificadas" required>
    <input type="number" name="cierres" placeholder="Cierres" required>
    <button type="submit">Guardar</button>
</form>

<hr>

<h3>Resumen General</h3>
<p>Total Leads: <?php echo $totalLeads; ?></p>
<p>Total Cierres: <?php echo $totalCierres; ?></p>
<p>Tasa de Conversión: <?php echo $tasa; ?>%</p>

<hr>

<h3>Historial</h3>

<table border="1">
<tr>
    <th>Fecha</th>
    <th>Leads</th>
    <th>Creadas</th>
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

<br>
<a href="logout.php">Cerrar sesión</a>