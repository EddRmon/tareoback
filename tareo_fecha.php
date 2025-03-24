<?php
include 'conectar_local.php';

$connection = ConectarLocalServer();

if(!$connection){
    die("no se puedo conectar, hay errores");
}

$numOp = $_GET['numOp'];
//$fechaEst = $_GET['fechaEstimada'];

try{
    $query = "SELECT OdtCod, OdtOrd, FecEst, EnProceso FROM PRODUCCION..TransaccionesEst (nolock)
WHERE OdtCod = :op;"; //AND FecEst = :fecha;

$stmt = $connection->prepare($query);
$stmt->bindParam(':op',$numOp);
//$stmt->bindParam(':fecha', $fechaEst);
$stmt->execute();

$filas = $stmt->rowCount();

if($filas != 0){
    $rows = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $rows[] = $row;
    }
    echo json_encode($rows);
} else {
    echo json_encode(array("error" => "No hay fechas para esa op"));
}


} catch(PDOException $e) {
    echo json_encode(array("error" => "Error de base de datos: ".$e->getMessage()));
}

$connection=null;
exit();




?>