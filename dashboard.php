<?php
session_start();
if(!isset($_SESSION['nombre'])){
header("Location: login.php");
exit();
}
$nombre=$_SESSION['nombre'];
$apellido=$_SESSION['apellido'];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ERP Comercial 2026</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>

<style>
body{margin:0;font-family:Segoe UI;background:#f1f5f9;}
.sidebar{
width:230px;height:100vh;background:#0f172a;
position:fixed;color:white;padding:20px;
}
.sidebar h2{font-size:18px;}
.content{margin-left:250px;padding:30px;}
.header{font-size:24px;font-weight:bold;margin-bottom:20px;}
.card{
background:white;padding:20px;border-radius:14px;
box-shadow:0 4px 12px rgba(0,0,0,0.06);
margin-bottom:20px;
}
.grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
gap:20px;
}
.kpi{font-size:30px;font-weight:bold;color:#0f172a;}
.progress{background:#e5e7eb;border-radius:10px;height:14px;margin-top:10px;}
.progress-bar{
height:100%;background:linear-gradient(90deg,#2563eb,#1e40af);
width:0%;border-radius:10px;
}
select,input{padding:8px;border-radius:6px;border:1px solid #ccc;}
button{
padding:8px 16px;background:#2563eb;
border:none;color:white;border-radius:8px;cursor:pointer;
}
button:hover{background:#1e40af;}
</style>
</head>
<body>

<div class="sidebar">
<h2>ERP Comercial</h2>
<p>Analista:</p>
<strong><?php echo $nombre." ".$apellido; ?></strong>
<br><br>
<a href="logout.php" style="color:#94a3b8;">Cerrar sesión</a>
</div>

<div class="content">

<div class="header">Dashboard Comercial 2026</div>

<div class="card">
<h3>Filtro de Mes</h3>
<select id="selectorMes"></select>
</div>

<div class="card">
<h3>Cargar Excel</h3>
<input type="file" id="excelFile">
</div>

<div class="grid">
<div class="card"><h4>Leads</h4><div class="kpi" id="leads">0</div></div>
<div class="card"><h4>Oportunidades</h4><div class="kpi" id="oportunidades">0</div></div>
<div class="card"><h4>Cierres</h4><div class="kpi" id="cierres">0</div></div>
<div class="card"><h4>Conversión</h4><div class="kpi" id="conversion">0%</div></div>
</div>

<div class="card">
<h4>Meta Mensual</h4>
<input type="number" id="metaInput" placeholder="Meta">
<button onclick="guardarMeta()">Guardar</button>
<div class="progress"><div class="progress-bar" id="barra"></div></div>
</div>

<div class="card">
<canvas id="grafica"></canvas>
</div>

</div>

<script>

let datosGlobal=[];
let leads=0,oportunidades=0,cierres=0,meta=0;

const nombreSesion="<?php echo $nombre;?>";
const apellidoSesion="<?php echo $apellido;?>";

const meses=["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
const selector=document.getElementById("selectorMes");

meses.forEach((m,i)=>{
let op=document.createElement("option");
op.value=i;op.text=m;
selector.appendChild(op);
});
selector.value=new Date().getMonth();
selector.onchange=recalcular;

const añoActual=new Date().getFullYear();

const ctx=document.getElementById('grafica').getContext('2d');
const grafica=new Chart(ctx,{
type:'bar',
data:{
labels:['Leads','Oportunidades','Cierres'],
datasets:[{
data:[0,0,0],
backgroundColor:['#2563eb','#f59e0b','#10b981']
}]
},
options:{plugins:{legend:{display:false}}}
});

document.getElementById('excelFile').addEventListener('change',function(e){
const reader=new FileReader();
reader.readAsBinaryString(e.target.files[0]);
reader.onload=function(e){
const workbook=XLSX.read(e.target.result,{type:'binary'});
const hoja=workbook.Sheets[workbook.SheetNames[0]];
datosGlobal=XLSX.utils.sheet_to_json(hoja);
recalcular();
}
});

function recalcular(){
leads=0;oportunidades=0;cierres=0;
let leadsMesAnterior=0;
const mesSel=parseInt(selector.value);

datosGlobal.forEach(d=>{
if(!d.Fecha)return;
const fecha=new Date(d.Fecha);
const mes=fecha.getMonth();
const año=fecha.getFullYear();

if(d.Nombre==nombreSesion && d.Apellido==apellidoSesion && año==añoActual){

if(mes==mesSel){
leads++;
if(d.Estado=="Oportunidad")oportunidades++;
if(d.Estado=="Cierre")cierres++;
}

if(mes==mesSel-1)leadsMesAnterior++;

}
});

actualizar(leadsMesAnterior);
}

function actualizar(prev){
document.getElementById("leads").innerText=leads;
document.getElementById("oportunidades").innerText=oportunidades;
document.getElementById("cierres").innerText=cierres;
let conv=leads>0?((cierres/leads)*100).toFixed(1):0;
document.getElementById("conversion").innerText=conv+"%";

grafica.data.datasets[0].data=[leads,oportunidades,cierres];
grafica.update();

if(meta>0){
let progreso=(leads/meta)*100;
document.getElementById("barra").style.width=progreso+"%";
}

if(prev!==undefined){
if(leads>prev)document.getElementById("leads").innerHTML=leads+" 🔼";
if(leads<prev)document.getElementById("leads").innerHTML=leads+" 🔽";
}
}

function guardarMeta(){
meta=document.getElementById("metaInput").value;
recalcular();
}

</script>

</body>
</html>