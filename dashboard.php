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

    $sqlInsert = $conexion->prepare("INSERT INTO resultados 
    (usuario_id, fecha, leads_dia, oportunidades_creadas, oportunidades_calificadas, cierres) 
    VALUES (?,?,?,?,?,?)");

    $sqlInsert->execute([$id,$fecha,$leads,$creadas,$calificadas,$cierres]);
}

/* DATOS DEL MES ACTUAL */
$mesActual = date('m');
$anioActual = date('Y');

$sqlMes = $conexion->prepare("
SELECT 
SUM(leads_dia) as total_leads,
SUM(oportunidades_creadas) as total_creadas,
SUM(oportunidades_calificadas) as total_calificadas,
SUM(cierres) as total_cierres
FROM resultados 
WHERE usuario_id=? 
AND MONTH(fecha)=? 
AND YEAR(fecha)=?
");

$sqlMes->execute([$id,$mesActual,$anioActual]);
$datosMes = $sqlMes->fetch();

$leadsMes = $datosMes['total_leads'] ?? 0;
$creadasMes = $datosMes['total_creadas'] ?? 0;
$calificadasMes = $datosMes['total_calificadas'] ?? 0;
$cierresMes = $datosMes['total_cierres'] ?? 0;

$conversionMes = $leadsMes > 0 ? round(($cierresMes/$leadsMes)*100,1) : 0;

/* META */
$sqlMeta = $conexion->prepare("SELECT meta_leads FROM usuarios WHERE id=?");
$sqlMeta->execute([$id]);
$meta = $sqlMeta->fetchColumn() ?? 100;

$porcentajeMeta = $meta > 0 ? round(($leadsMes/$meta)*100,1) : 0;

/* HISTORIAL */
$sqlHistorial = $conexion->prepare("SELECT * FROM resultados WHERE usuario_id=? ORDER BY fecha DESC");
$sqlHistorial->execute([$id]);
$resultados = $sqlHistorial->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Dashboard Comercial 2026</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<style>
body{
    font-family: Arial, sans-serif;
    margin:0;
    background:#f1f5f9;
}

.header{
    background:#0f172a;
    color:white;
    padding:20px;
    display:flex;
    justify-content:space-between;
}

.container{
    padding:30px;
}

.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:20px;
    margin-bottom:30px;
}

.card{
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.card h4{
    margin:0;
    color:#64748b;
}

.card h2{
    margin:10px 0 0 0;
}

.meta-bar{
    background:#e2e8f0;
    border-radius:10px;
    height:10px;
    margin-top:10px;
}

.meta-progress{
    background:#1e3a8a;
    height:10px;
    border-radius:10px;
}
table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
    background:white;
}

th,td{
    padding:10px;
    border:1px solid #ddd;
    text-align:center;
}

form input, form button{
    padding:8px;
    margin:5px;
}
</style>
</head>

<body>

<div class="header">
    <h2>Bienvenido <?php echo $_SESSION['nombre']; ?></h2>
    <a href="logout.php" style="color:white;">Cerrar sesión</a>
</div>

<div class="container">

<h3>Registrar Resultados</h3>

<form method="POST">
    <input type="date" name="fecha" required>
    <input type="number" name="leads" placeholder="Leads" required>
    <input type="number" name="creadas" placeholder="Oportunidades creadas" required>
    <input type="number" name="calificadas" placeholder="Calificadas" required>
    <input type="number" name="cierres" placeholder="Cierres" required>
    <button type="submit">Guardar</button>
</form>

<div class="cards">

<div class="card">
<h4>Leads del Mes</h4>
<h2><?php echo $leadsMes; ?></h2>
</div>

<div class="card">
<h4>Meta Mensual</h4>
<h2><?php echo $meta; ?></h2>
<p><?php echo $porcentajeMeta; ?>% cumplido</p>
<div class="meta-bar">
<div class="meta-progress" style="width:<?php echo $porcentajeMeta; ?>%"></div>
</div>
</div>

<div class="card">
<h4>Cierres del Mes</h4>
<h2><?php echo $cierresMes; ?></h2>
</div>

<div class="card">
<h4>Conversión</h4>
<h2><?php echo $conversionMes; ?>%</h2>
</div>

</div>

<h3>Gráfica Mensual</h3>
<canvas id="grafica"></canvas>

<h3>Historial</h3>

<table>
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

</div>

<script>
const ctx = document.getElementById('grafica');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Leads', 'Cierres'],
        datasets: [{
            label: 'Resumen del Mes',
            data: [<?php echo $leadsMes; ?>, <?php echo $cierresMes; ?>]
        }]
    }
});
</script>

</body>
</html>