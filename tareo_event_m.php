<?php
include 'conectar_local.php';
$cox = ConectarLocalServer();

if(!$cox){
    die('No se puede conectar hay errores');
}

$query= "SELECT et.CodeEvent, et.Description from  [dbo].[EventsType]  as et(nolock)
where et.Type = 'M';";

$stmt = $cox->prepare($query);
$stmt->execute();

$numfilas = $stmt->rowCount();

if($numfilas != 0){
    $rows = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $rows[] = $row;
    }
    echo json_encode($rows);
}else {
    echo json_encode(array("error" => "No hay eventos tipo P"));
}

$stmt = null;
$cox = null;
exit();

?>












