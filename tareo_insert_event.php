<?php
include 'conectar_local.php';

$con = ConectarLocalServer();

if(!$con){
    die("error de conectase, hay erres");
}


$odtCod = $_POST['nrop'];
$odtComplem = $_POST['complemento'];
$odtElem = $_POST['elemento'];
$odtOrd = $_POST['secuencia'];
$odtMaq = $_POST['idmaquina'];
$codEst = $_POST['estadog'];
$operadorID =  $_POST['idoperador'];
$tipoProc =  $_POST['tipoproceso'];
$codEvent = $_POST['codeevento'];

try{
    $query = "INSERT INTO [PRODUCCION].[dbo].[TransaccionesEst] (OdtCod, OdtComplem, OdtEle, OdtOrd, OdtMaq, CodEst, FecEst, FecIniProc , IDOperador,EnProceso,  TipoProceso, CodeEvent) 
VALUES (:odtCod, :odtComplem , :odtElem, :odtOrd, :odtMaq,:codEst,getdate(),getdate(),:operadorID,1,:tipoProc, :codEvent);";

$stmt = $con->prepare($query);

$stmt-> bindParam(':odtCod',$odtCod);
$stmt-> bindParam(':odtComplem',$odtComplem);
$stmt-> bindParam(':odtElem',$odtElem);
$stmt-> bindParam(':odtOrd',$odtOrd);
$stmt-> bindParam(':odtMaq',$odtMaq);
$stmt-> bindParam(':codEst',$codEst);
$stmt-> bindParam(':operadorID',$operadorID);
$stmt-> bindParam(':tipoProc',$tipoProc);
$stmt-> bindParam(':codEvent',$codEvent);


if ($stmt->execute()){
    echo json_encode(array("status"=> "success", "message" => "registrado correctamente"));
} else {
    echo json_encode(array("status"=>"error", "message" => "error al insertar el evento"));
}

}catch (PDOException $e) {
    echo json_encode(array("error" => "Error de base de datos: " . $e->getMessage()));
}

$con = null;
exit();

?>