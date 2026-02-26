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
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    color: #333;
}

.sidebar {
    width: 280px;
    height: 100vh;
    background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
    position: fixed;
    color: white;
    padding: 30px 25px;
    box-shadow: 2px 0 20px rgba(0,0,0,0.1);
    z-index: 1000;
}

.sidebar h3 {
    color: #00d4ff;
    font-size: 24px;
    margin-bottom: 30px;
    text-align: center;
    border-bottom: 2px solid #00d4ff;
    padding-bottom: 15px;
}

.sidebar p {
    font-size: 14px;
    color: #b0b3c1;
    margin-bottom: 5px;
}

.sidebar strong {
    font-size: 18px;
    color: #ffffff;
    display: block;
    margin-bottom: 30px;
}

.sidebar a {
    color: #ff6b6b;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.sidebar a:hover {
    color: #ff5252;
}

.content {
    margin-left: 280px;
    padding: 40px;
    background: #f8f9fa;
}

.header {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    margin-bottom: 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header h2 {
    color: #2d3748;
    font-size: 32px;
    font-weight: 700;
}

.filters {
    display: flex;
    gap: 20px;
    align-items: center;
}

.card {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    margin-bottom: 25px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.15);
}

.card h3, .card h4 {
    color: #2d3748;
    margin-bottom: 20px;
    font-weight: 600;
}

.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
    margin-bottom: 30px;
}

.kpi-card {
    text-align: center;
    padding: 30px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px;
    position: relative;
    overflow: hidden;
}

.kpi-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255,255,255,0.1);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.kpi-card:hover::before {
    opacity: 1;
}

.kpi-card h4 {
    font-size: 16px;
    margin-bottom: 15px;
    opacity: 0.9;
}

.kpi {
    font-size: 36px;
    font-weight: bold;
    margin-bottom: 10px;
}

.kpi-trend {
    font-size: 14px;
    opacity: 0.8;
}

.progress-container {
    margin-top: 20px;
}

.progress {
    background: #e2e8f0;
    border-radius: 10px;
    height: 20px;
    margin-top: 15px;
    overflow: hidden;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
}

.progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #00d4ff, #0099cc);
    width: 0%;
    border-radius: 10px;
    transition: width 0.8s ease;
    position: relative;
}

.progress-bar::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    background: linear-gradient(90deg, rgba(255,255,255,0.3) 0%, transparent 50%, rgba(255,255,255,0.3) 100%);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

select, input {
    padding: 12px 16px;
    border-radius: 8px;
    border: 2px solid #e2e8f0;
    font-size: 14px;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
    background: white;
}

select:focus, input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

button {
    padding: 12px 24px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.chart-container {
    position: relative;
    height: 400px;
    margin-top: 20px;
}

.comparison-card {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
}

.comparison-card .kpi {
    color: white;
}

.trend-up { color: #10b981; }
.trend-down { color: #ef4444; }
.trend-neutral { color: #6b7280; }

@media (max-width: 768px) {
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
    }
    .content {
        margin-left: 0;
        padding: 20px;
    }
    .header {
        flex-direction: column;
        gap: 20px;
        text-align: center;
    }
    .filters {
        justify-content: center;
    }
}
</style>
</head>
<body>

<div class="sidebar">
<h3>🚀 ERP 2026</h3>
<p>Analista Activo:</p>
<strong><?php echo $nombre." ".$apellido; ?></strong>
<br><br>
<a href="logout.php">🚪 Cerrar Sesión</a>
</div>

<div class="content">

<div class="header">
<h2>📊 Dashboard Comercial 2026</h2>
<div class="filters">
<select id="selectorMes"></select>
<select id="selectorAño">
<option value="2026">2026</option>
<option value="2025">2025</option>
</select>
</div>
</div>

<div class="card">
<h3>📁 Cargar Datos Excel</h3>
<input type="file" id="excelFile" accept=".xlsx,.xls">
<p style="color: #666; font-size: 14px; margin-top: 10px;">Selecciona un archivo Excel con columnas: Nombre, Apellido, Fecha, Estado</p>
</div>

<div class="grid">
<div class="kpi-card">
<h4>🎯 Leads Generados</h4>
<div class="kpi" id="leads">0</div>
<div class="kpi-trend" id="leads-trend"></div>
</div>
<div class="kpi-card">
<h4>💼 Oportunidades</h4>
<div class="kpi" id="oportunidades">0</div>
<div class="kpi-trend" id="oportunidades-trend"></div>
</div>
<div class="kpi-card">
<h4>✅ Cierres Exitosos</h4>
<div class="kpi" id="cierres">0</div>
<div class="kpi-trend" id="cierres-trend"></div>
</div>
<div class="kpi-card">
<h4>📈 Tasa de Conversión</h4>
<div class="kpi" id="conversion">0%</div>
<div class="kpi-trend" id="conversion-trend"></div>
</div>
</div>

<div class="grid">
<div class="card comparison-card">
<h4>📊 Comparativo vs Mes Anterior</h4>
<div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-top: 20px;">
<div style="text-align: center;">
<h5>Mes Actual</h5>
<div style="font-size: 24px; font-weight: bold;" id="mes-actual-leads">0</div>
<small>Leads</small>
</div>
<div style="text-align: center;">
<h5>Mes Anterior</h5>
<div style="font-size: 24px; font-weight: bold;" id="mes-anterior-leads">0</div>
<small>Leads</small>
</div>
</div>
<div style="margin-top: 20px;">
<div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
<span>Diferencia:</span>
<span id="diferencia-leads" style="font-weight: bold;">0</span>
</div>
<div style="display: flex; justify-content: space-between;">
<span>% Cambio:</span>
<span id="cambio-porcentual" style="font-weight: bold;">0%</span>
</div>
</div>
</div>

<div class="card">
<h4>🎯 Meta Mensual</h4>
<div style="display: flex; gap: 15px; margin-bottom: 20px;">
<input type="number" id="metaInput" placeholder="Establecer meta de leads" style="flex: 1;">
<button onclick="guardarMeta()">💾 Guardar Meta</button>
</div>
<div class="progress-container">
<div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
<span>Progreso: <strong id="progreso-texto">0%</strong></span>
<span id="meta-actual">0 / 0</span>
</div>
<div class="progress">
<div class="progress-bar" id="barra"></div>
</div>
</div>
</div>
</div>

<div class="card">
<h4>📈 Gráfica Empresarial</h4>
<div class="chart-container">
<canvas id="grafica"></canvas>
</div>
</div>

</div>

<script>

let datosGlobal = [];
let leads = 0, oportunidades = 0, cierres = 0, meta = 0;
let leadsMesActual = 0, leadsMesAnterior = 0;

const nombreSesion = "<?php echo $nombre;?>";
const apellidoSesion = "<?php echo $apellido;?>";

const meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
const selector = document.getElementById("selectorMes");
const selectorAño = document.getElementById("selectorAño");

// Initialize month selector
meses.forEach((m, i) => {
    let op = document.createElement("option");
    op.value = i;
    op.text = m;
    selector.appendChild(op);
});

// Set current month and year
const fechaActual = new Date();
selector.value = fechaActual.getMonth();
selectorAño.value = fechaActual.getFullYear();

// Event listeners
selector.onchange = recalcular;
selectorAño.onchange = recalcular;

// Initialize Chart
const ctx = document.getElementById('grafica').getContext('2d');
const grafica = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Leads', 'Oportunidades', 'Cierres'],
        datasets: [{
            label: 'Métricas del Mes',
            data: [0, 0, 0],
            backgroundColor: [
                'rgba(102, 126, 234, 0.8)',
                'rgba(245, 158, 11, 0.8)',
                'rgba(16, 185, 129, 0.8)'
            ],
            borderColor: [
                'rgba(102, 126, 234, 1)',
                'rgba(245, 158, 11, 1)',
                'rgba(16, 185, 129, 1)'
            ],
            borderWidth: 2,
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    font: {
                        size: 14,
                        weight: 'bold'
                    }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0,0,0,0.8)',
                titleColor: 'white',
                bodyColor: 'white',
                callbacks: {
                    label: function(context) {
                        return context.dataset.label + ': ' + context.parsed.y;
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0,0,0,0.1)'
                },
                ticks: {
                    font: {
                        size: 12
                    }
                }
            },
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    font: {
                        size: 12,
                        weight: 'bold'
                    }
                }
            }
        },
        animation: {
            duration: 1000,
            easing: 'easeInOutQuart'
        }
    }
});

// File upload handler
document.getElementById('excelFile').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.readAsBinaryString(file);
    reader.onload = function(e) {
        try {
            const workbook = XLSX.read(e.target.result, { type: 'binary' });
            const hoja = workbook.Sheets[workbook.SheetNames[0]];
            datosGlobal = XLSX.utils.sheet_to_json(hoja);

            // Validate data structure
            if (datosGlobal.length > 0) {
                const requiredColumns = ['Nombre', 'Apellido', 'Fecha', 'Estado'];
                const sampleRow = datosGlobal[0];
                const hasRequiredColumns = requiredColumns.every(col => col in sampleRow);

                if (!hasRequiredColumns) {
                    alert('⚠️ El archivo Excel debe contener las columnas: Nombre, Apellido, Fecha, Estado');
                    return;
                }
            }

            recalcular();
            alert('✅ Datos cargados correctamente');
        } catch (error) {
            alert('❌ Error al procesar el archivo Excel');
            console.error(error);
        }
    };
});

function recalcular() {
    leads = 0;
    oportunidades = 0;
    cierres = 0;
    leadsMesActual = 0;
    leadsMesAnterior = 0;

    const mesSel = parseInt(selector.value);
    const añoSel = parseInt(selectorAño.value);

    datosGlobal.forEach(d => {
        if (!d.Fecha || !d.Nombre || !d.Apellido) return;

        // Parse date - handle different date formats
        let fecha;
        try {
            if (typeof d.Fecha === 'number') {
                // Excel date serial number
                fecha = new Date((d.Fecha - 25569) * 86400 * 1000);
            } else {
                fecha = new Date(d.Fecha);
            }

            if (isNaN(fecha.getTime())) return;
        } catch (e) {
            return;
        }

        const mes = fecha.getMonth();
        const año = fecha.getFullYear();

        // Filter by current analyst
        if (d.Nombre === nombreSesion && d.Apellido === apellidoSesion) {
            if (año === añoSel) {
                if (mes === mesSel) {
                    leads++;
                    if (d.Estado && d.Estado.toLowerCase().includes('oportunidad')) oportunidades++;
                    if (d.Estado && d.Estado.toLowerCase().includes('cierre')) cierres++;
                    leadsMesActual++;
                }

                // Calculate previous month (handle year change)
                let mesAnterior = mesSel - 1;
                let añoAnterior = añoSel;
                if (mesAnterior < 0) {
                    mesAnterior = 11;
                    añoAnterior = añoSel - 1;
                }

                if (mes === mesAnterior && año === añoAnterior) {
                    leadsMesAnterior++;
                }
            }
        }
    });

    actualizarKPIs();
}

function actualizarKPIs() {
    // Update main KPIs
    document.getElementById("leads").innerText = leads.toLocaleString();
    document.getElementById("oportunidades").innerText = oportunidades.toLocaleString();
    document.getElementById("cierres").innerText = cierres.toLocaleString();

    // Calculate conversion rate
    let conversion = leads > 0 ? ((cierres / leads) * 100) : 0;
    document.getElementById("conversion").innerText = conversion.toFixed(1) + "%";

    // Update trends
    actualizarTendencias();

    // Update comparison card
    actualizarComparativo();

    // Update chart
    grafica.data.datasets[0].data = [leads, oportunidades, cierres];
    grafica.update();

    // Update progress bar
    actualizarProgreso();
}

function actualizarTendencias() {
    const diferenciaLeads = leadsMesActual - leadsMesAnterior;
    const diferenciaOportunidades = oportunidades - (oportunidades * 0.8); // Simplified
    const diferenciaCierres = cierres - (cierres * 0.7); // Simplified

    // Leads trend
    const leadsTrend = document.getElementById("leads-trend");
    if (diferenciaLeads > 0) {
        leadsTrend.innerHTML = `📈 +${diferenciaLeads} vs mes anterior`;
        leadsTrend.className = "kpi-trend trend-up";
    } else if (diferenciaLeads < 0) {
        leadsTrend.innerHTML = `📉 ${diferenciaLeads} vs mes anterior`;
        leadsTrend.className = "kpi-trend trend-down";
    } else {
        leadsTrend.innerHTML = `➡️ Sin cambio`;
        leadsTrend.className = "kpi-trend trend-neutral";
    }

    // Oportunidades trend (simplified)
    const opTrend = document.getElementById("oportunidades-trend");
    opTrend.innerHTML = oportunidades > 0 ? `🎯 ${((oportunidades/leads)*100).toFixed(1)}% de conversión` : "Sin datos";

    // Cierres trend (simplified)
    const cierresTrend = document.getElementById("cierres-trend");
    cierresTrend.innerHTML = cierres > 0 ? `✅ ${((cierres/oportunidades)*100).toFixed(1)}% de cierre` : "Sin datos";

    // Conversion trend
    const convTrend = document.getElementById("conversion-trend");
    const convRate = leads > 0 ? ((cierres / leads) * 100) : 0;
    convTrend.innerHTML = convRate >= 20 ? "🔥 Excelente" : convRate >= 10 ? "👍 Bueno" : "📊 Mejorar";
}

function actualizarComparativo() {
    document.getElementById("mes-actual-leads").innerText = leadsMesActual.toLocaleString();
    document.getElementById("mes-anterior-leads").innerText = leadsMesAnterior.toLocaleString();

    const diferencia = leadsMesActual - leadsMesAnterior;
    const elementoDiferencia = document.getElementById("diferencia-leads");

    if (diferencia > 0) {
        elementoDiferencia.innerHTML = `+${diferencia} 📈`;
        elementoDiferencia.style.color = "#10b981";
    } else if (diferencia < 0) {
        elementoDiferencia.innerHTML = `${diferencia} 📉`;
        elementoDiferencia.style.color = "#ef4444";
    } else {
        elementoDiferencia.innerHTML = "0 ➡️";
        elementoDiferencia.style.color = "#6b7280";
    }

    // Calculate percentage change
    const cambioPorcentual = leadsMesAnterior > 0 ? ((diferencia / leadsMesAnterior) * 100) : 0;
    const elementoCambio = document.getElementById("cambio-porcentual");

    if (cambioPorcentual > 0) {
        elementoCambio.innerHTML = `+${cambioPorcentual.toFixed(1)}%`;
        elementoCambio.style.color = "#10b981";
    } else if (cambioPorcentual < 0) {
        elementoCambio.innerHTML = `${cambioPorcentual.toFixed(1)}%`;
        elementoCambio.style.color = "#ef4444";
    } else {
        elementoCambio.innerHTML = "0%";
        elementoCambio.style.color = "#6b7280";
    }
}

function actualizarProgreso() {
    if (meta > 0) {
        let progreso = Math.min((leads / meta) * 100, 100);
        document.getElementById("barra").style.width = progreso + "%";
        document.getElementById("progreso-texto").innerText = progreso.toFixed(1) + "%";
        document.getElementById("meta-actual").innerText = leads.toLocaleString() + " / " + meta.toLocaleString();

        // Color coding based on progress
        const barra = document.getElementById("barra");
        if (progreso >= 100) {
            barra.style.background = "linear-gradient(90deg, #10b981, #059669)";
        } else if (progreso >= 75) {
            barra.style.background = "linear-gradient(90deg, #00d4ff, #0099cc)";
        } else if (progreso >= 50) {
            barra.style.background = "linear-gradient(90deg, #f59e0b, #d97706)";
        } else {
            barra.style.background = "linear-gradient(90deg, #ef4444, #dc2626)";
        }
    } else {
        document.getElementById("barra").style.width = "0%";
        document.getElementById("progreso-texto").innerText = "0%";
        document.getElementById("meta-actual").innerText = "0 / 0";
    }
}

function guardarMeta() {
    const input = document.getElementById("metaInput");
    const nuevaMeta = parseInt(input.value);

    if (nuevaMeta > 0) {
        meta = nuevaMeta;
        input.value = "";
        actualizarProgreso();

        // Save to localStorage for persistence
        localStorage.setItem(`meta_${nombreSesion}_${apellidoSesion}_${selectorAño.value}_${selector.value}`, meta);

        alert(`✅ Meta guardada: ${meta} leads para ${meses[selector.value]} ${selectorAño.value}`);
    } else {
        alert("⚠️ Ingresa una meta válida (número mayor a 0)");
    }
}

// Load saved meta on page load
window.onload = function() {
    const savedMeta = localStorage.getItem(`meta_${nombreSesion}_${apellidoSesion}_${selectorAño.value}_${selector.value}`);
    if (savedMeta) {
        meta = parseInt(savedMeta);
        actualizarProgreso();
    }
};

// Auto-save meta when changing filters
selector.onchange = function() {
    const savedMeta = localStorage.getItem(`meta_${nombreSesion}_${apellidoSesion}_${selectorAño.value}_${selector.value}`);
    if (savedMeta) {
        meta = parseInt(savedMeta);
    } else {
        meta = 0;
    }
    recalcular();
};

selectorAño.onchange = function() {
    const savedMeta = localStorage.getItem(`meta_${nombreSesion}_${apellidoSesion}_${selectorAño.value}_${selector.value}`);
    if (savedMeta) {
        meta = parseInt(savedMeta);
    } else {
        meta = 0;
    }
    recalcular();
};

</script>

</body>
</html>