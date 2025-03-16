<?php

include 'conectar.php';

$conn = ConectarServer(); // Abre la conexión

if (!$conn) {
    die("No se pudo conectar, hay errores"); // Manejo básico de error si la conexión falla
}


$u_uss = $_GET['uss'];


// Prepara la consulta SQL para verificar el token
$query = "SELECT OP.IDOperador , op.DNI_TRAB AS usuario, op.Login AS operador 
FROM [dbo].[Operadores] as op WHERE DNI_TRAB = :uss  AND estado = 1";

$stmt = $conn->prepare($query);
$stmt->bindParam(':uss', $u_uss); // Enlaza el parámetro :uss


// Ejecuta la consulta preparada
$stmt->execute();

// Obtiene la fila con el resultado de la consulta
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Verifica si se encontró un usuario válido
if ($row) {
    $usuario = $row['usuario'];
    echo json_encode(array("valid" => true, "message" => "token válido", "usuario" => $usuario));
} else {
    echo json_encode(array("valid" => false, "message" => "Token invalido"));
}

$conn = null; // Cierra la conexión

exit(); // Finaliza el script PHP
?>
