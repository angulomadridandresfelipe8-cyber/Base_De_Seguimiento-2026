let usuario = localStorage.getItem("activo");
document.getElementById("welcome").innerText = "Bienvenido " + usuario;

// Sample data for testing
let datos = [
    {
        nombre: "Andrés",
        leads: 10,
        oportunidades: 5,
        cierres: 2,
        fecha: "2026-02-15"
    }
];

document.getElementById("fileInput").addEventListener("change", function(e) {
    let file = e.target.files[0];
    let reader = new FileReader();

    reader.onload = function(event) {
        let data = new Uint8Array(event.target.result);
        let workbook = XLSX.read(data, {type: 'array'});
        let sheet = workbook.Sheets[workbook.SheetNames[0]];
        let json = XLSX.utils.sheet_to_json(sheet);

        procesarDatos(json);
    };

    reader.readAsArrayBuffer(file);
});

function procesarDatos(data) {

    let oppMes = data.length;

    let efectivos = data.filter(d => d.Estado === "Efectivo").length;
    let total = data.length;

    let tasa = (efectivos / total) * 100;

    let leads = data.filter(d => d.Tipo === "Lead").length;

    // META
    let metaOpp = 29;
    let metaTasa = 60;
    let metaLeads = 12;
    let metaClientes = 5;

    let pesoOpp = 0.60;
    let pesoTasa = 0.20;
    let pesoLeads = 0.10;
    let pesoClientes = 0.10;

    let clientesNuevos = efectivos;

    let cumplimiento =
        ((oppMes/metaOpp)*pesoOpp +
        (tasa/metaTasa)*pesoTasa +
        (leads/metaLeads)*pesoLeads +
        (clientesNuevos/metaClientes)*pesoClientes) * 100;

    let base = 2660000;
    let comision = calcularComision(base, cumplimiento);

    document.getElementById("oppMes").innerText = oppMes;
    document.getElementById("tasa").innerText = tasa.toFixed(1) + "%";
    document.getElementById("leads").innerText = leads;
    document.getElementById("cumplimiento").innerText = cumplimiento.toFixed(0) + "%";
    document.getElementById("comision").innerText = "$" + comision.toLocaleString();
}

function calcularComision(base, cump) {

    if(cump <= 100) {
        return base * (cump/100);
    }

    if(cump > 100 && cump <= 250) {
        return base + (base * ((cump-100)/100) * 1.5);
    }

    if(cump > 250) {
        return base + (base * 1.5);
    }
}