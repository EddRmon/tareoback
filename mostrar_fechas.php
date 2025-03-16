<?php
include 'conectar_local.php';

$conect = ConectarLocalServer();

if(!$conect){
        die("No se pudo conectar, hay errores");
}

$fecha = $_GET['fecha'];
$operador = $_GET['id_operador'];


$query_fecha = "SELECT DISTINCT 
CONVERT(VARCHAR(7), FecIniProc, 120) AS MesDisponible -- Formato YYYY-MM
FROM PRODUCCION..TransaccionesEst (NOLOCK)
WHERE IDOperador = '$operador'
  AND FecIniProc >= DATEADD(MONTH, -5, GETDATE()) -- Últimos 6 meses
ORDER BY MesDisponible ASC";

$result = $conect->query($query_fecha);
$conteo = $result->rowCount();

if($conteo != 0) {
    $rows = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        $rows[] = $row;
    }
    echo json_encode($rows);
} else {
    echo json_encode(array("error" => "No hay datos para la fecha"));
}

$result = null;
$conect = null;

exit();
?>