<?php
include 'conectar_local.php';

$conx = ConectarLocalServer();

if (!$conx) {
    die(json_encode(array("error" => "No se pudo conectar a la base de datos")));
}

$obs = $_POST['observ'];
$pliegosPar = $_POST['pliegosParcial'];
$pliegosMal = $_POST['plieghosParcMal'];
$op = $_POST['op'];
$codMaq = $_POST['codMaquina'];


try {
    $query_update = "UPDATE [PRODUCCION].[dbo].[TransaccionesEst]
SET FecEst = getdate(), OdtObs = :observ, FecFinProc = getdate(), EnProceso = 0, PliegosParc = :pliegosB , PLIEGOSPARCMAL = :pliegosM
WHERE OdtCod = :op and OdtMaq = :codMaqu;";

    $stmt_update = $conx->prepare($query_update);
    $stmt_update->bindParam(':observ', $obs,);
    $stmt_update->bindParam(':pliegosB', $pliegosPar);
    $stmt_update->bindParam(':pliegosM', $pliegosMal);
    $stmt_update->bindParam(':op', $op);
    $stmt_update->bindParam(':codMaqu', $codMaq);
   

    if ($stmt_update->execute()) {
        $filasAfectadas = $stmt_update->rowCount();
        echo json_encode(array("success" => "Datos actualizados correctamente", "filas_afectadas" => $filasAfectadas));
    } else {
        echo json_encode(array("error" => "Error al actualizar los datos"));
    }
} catch (PDOException $e) {
    echo json_encode(array("error" => "Error de base de datos: " . $e->getMessage()));
}

$conx = null;
exit();
?>