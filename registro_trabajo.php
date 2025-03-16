<?php
include 'conectar_local.php';

$conex = ConectarLocalServer();

if(!$conex){
    die("No se pudo conectar, hay errores");

}

$fecha = $_GET['fecha'];
$idUsuario = $_GET['idusuario'];

$query = "SELECT te.OdtCod ,te.OdtEle ,  et.Description, te.FecIniProc, te.FecFinProc, te.PliegosParc,  te.PLIEGOSPARCMAL, te.OdtObs  from PRODUCCION..TransaccionesEst te (nolock) 
left JOIN [PRODUCCION].[dbo].[EventsType] et  (nolock) on te.CodeEvent = et.CodeEvent
where cast(FecIniProc as date) = :fecha and te.IDOperador = :idUsuario
order by FecIniProc asc";

$stmt = $conex->prepare($query);
$stmt->bindParam(':fecha', $fecha);
$stmt->bindParam(':idUsuario', $idUsuario);
$stmt->execute();


$conteo = $stmt->rowCount();

if($conteo != 0){
    $rows = array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $rows[] = $row;
    }
    echo json_encode($rows);
} else {
    echo json_encode(array("error" => "No hay registros para esta fecha"));
}

$stmt = null;
$conex = null;

exit();



?>