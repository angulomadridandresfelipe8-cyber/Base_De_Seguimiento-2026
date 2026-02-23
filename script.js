function aplicarFiltro() {
    const mes = document.getElementById("filtroMes").value;
    const anio = document.getElementById("filtroAnio").value;

    const datosFiltrados = datos.filter(item => {
        const fecha = new Date(item.fecha);
        return (
            fecha.getMonth() == mes &&
            fecha.getFullYear() == anio
        );
    });

    actualizarKPIs(datosFiltrados);
    actualizarGraficos(datosFiltrados);
    actualizarRanking(datosFiltrados);
}

function actualizarGraficos(data) {
    // Placeholder for updating graphs
    console.log("Updating graphs with", data.length, "records");
}

function actualizarRanking(data) {
    // Placeholder for updating ranking table
    console.log("Updating ranking with", data.length, "records");
}