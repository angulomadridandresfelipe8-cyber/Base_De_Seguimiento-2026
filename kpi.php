<?php
session_start();
require_once "conexion.php"; // tu archivo de conexión PDO

$analista = $_GET['analista'] ?? '';
$mes = $_GET['mes'] ?? '';

$where = "WHERE 1=1";

if($analista != ''){
    $where .= " AND Analista = :analista";
}

if($mes != ''){
    $where .= " AND MONTH(Fecha_Registro) = :mes";
}

$sql = "
SELECT 
COUNT(Consecutivo_Lead) as total_leads,
COUNT(Consecutivo_Opp) as total_opps,
SUM(CASE 
    WHEN Etapa_de_Ventas_Opp = 'Cierre exitoso' 
    THEN 1 ELSE 0 END) as cierres_exitosos
FROM datagrid
$where
";

$stmt = $pdo->prepare($sql);

if($analista != ''){
    $stmt->bindParam(":analista", $analista);
}

if($mes != ''){
    $stmt->bindParam(":mes", $mes);
}

$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);

$leads = $data['total_leads'];
$opps = $data['total_opps'];
$cierres = $data['cierres_exitosos'];

$tasa_conversion = $leads > 0 ? round(($opps / $leads) * 100, 2) : 0;
$tasa_cierre = $opps > 0 ? round(($cierres / $opps) * 100, 2) : 0;

echo json_encode([
    "leads" => $leads,
    "oportunidades" => $opps,
    "cierres" => $cierres,
    "tasa_conversion" => $tasa_conversion,
    "tasa_cierre" => $tasa_cierre
]);