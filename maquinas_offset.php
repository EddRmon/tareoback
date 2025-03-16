<?php
include 'conectar_iso.php';


$conx = ConectarLocalServerSiograf();

if(!$conx){
    die("No se pudo conectar, hay errores");
}

$query = "SELECT  si.MaqNro,  si.MaqDes from [SIOGRAF].[dbo].[Impresora] (nolock) si
where si.MaqEstado = ''";

$resultado = $conx->query($query);
$conteo = $resultado->rowCount();

if($conteo != 0){
    $rows = array();

    while ($row = $resultado->fetch(PDO::FETCH_ASSOC)){
        $rows[] = $row;
    }
    echo json_encode($rows);
} else {
    echo json_encode(array("error" => "No existe datos"));
}

$resultado = null;
$conx = null;

exit();

?>