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