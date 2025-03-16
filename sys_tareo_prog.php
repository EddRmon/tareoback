<?php

include 'conec/conn.php';
$con = OpenConnection();


$numOp= $_GET['numop'];
$idMap= $_GET['idmaq'];

$consulta = "SELECT s.MotFini, s.MotFfin , s.MotCodOdt, s.MotDescrip, s.MotNroElem, s.MotCodMaq ,s.MotTirRet ,s.MotTipoMaq ,s.SecuencyMachine, s.MotPliegos ,s.MotCant, s.MotEstado, s.MotNroComplem 
from [PRODUCCION].[dbo].[MaqOt] s (nolock)
where MotCodOdt = :numOp and MotCodMaq = :idMaq
order by s.SecuencyMachine asc";

$stmt = $con->prepare($consulta);
$stmt->bindParam(':numOp', $numOp);
$stmt->bindParam(':idMaq', $idMap);
$stmt->execute();


$filas = $stmt->rowCount();

if($filas != 0){
    $rows = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $rows[] = $row;
    }
    echo json_encode($rows);
}else {
    echo json_encode(array("error" => "No hay Op programado"));
}
$stmt = null;
$con = null;
exit();



?>