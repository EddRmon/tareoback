<?php

include 'conec/conn.php';

$conex2 = OpenConnection();
if (!$conex2) {
    die('no se puede conectar, hay errores');
}

$machine = $_GET['maquina'];

$query = 'SELECT T.OdtCod, 
  (SELECT TOP 1 CodEst 
   FROM produccion.dbo.transaccionesest WITH(NOLOCK) 
   WHERE OdtMaq IN (:maq) AND OdtCod = T.OdtCod 
   ORDER BY FecEst DESC) AS Estado
FROM produccion.dbo.transaccionesest T WITH(NOLOCK)
LEFT JOIN PRODUCCION.dbo.Operadores O ON O.IDOperador = T.IDOperador
WHERE 
  CAST(t.FecFinProc AS DATE) BETWEEN CAST(GETDATE() AS DATE) AND CAST(GETDATE() AS DATE)
  AND t.OdtMaq IN (:maq)
GROUP BY t.OdtCod 
ORDER BY t.OdtCod ASC';

$stmt = $conex2->prepare($query);
$stmt->bindParam(':maq', $machine);
$stmt->execute();

$conteo = $stmt->rowCount();

if ($conteo != 0) {
    $rows = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $rows[] = $row;
    }
    echo json_encode($rows);
} else {
    echo json_encode(array("error" => "No hay registros para esta fecha"));
}

$stmt = null;
$conex2 = null;

?>
