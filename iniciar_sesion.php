<?php
include 'conectar_local.php';

$con = ConectarLocalServer();

if(!$con){
    die("No se puedo conectar, hay errores");
}

$uss = $_GET['uss'];
$pass = $_GET['pass'];

$query = "SELECT OP.IDOperador , op.DNI_TRAB AS usuario, op.Login AS operador 
FROM [dbo].[Operadores] as op 
WHERE DNI_TRAB = :uss AND op.Password = :pass   AND estado = 1";


$stmt = $con->prepare($query);
$stmt->bindParam(':uss',$uss);
$stmt->bindParam(':pass', $pass);

$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);

if($row){
    $usuario = $row['usuario'];
    $operador = $row['operador'];
    $idOperador = $row['IDOperador'];
    echo json_encode(array("valid" => true, "message" => "válido", "usuario" => $usuario, "operador" => $operador, 'IDOperador' => $idOperador));
} else {
    echo json_encode(array("valid" => false, "message" => "usuario o contraseña no valida."));
}

$stmt = null;
$con = null;
exit();


?>