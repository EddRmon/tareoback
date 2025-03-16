<?php

include 'conectar.php';

$conn = ConectarServer(); // Abre la conexión

if (!$conn) {
    die("No se pudo conectar, hay errores"); // Manejo básico de error si la conexión falla
}

// Obtiene los parámetros uss y pass de la solicitud GET
$uss = $_GET['uss'];
$pass = $_GET['pass'];

// Prepara la consulta SQL para verificar el token
$query = "SELECT usuario FROM [PRODGENERAL].[dbo].[USER_TOKENS] 
WHERE usuario = :uss AND token = :pass AND estado = 1";

$stmt = $conn->prepare($query);
$stmt->bindParam(':uss', $uss); // Enlaza el parámetro :uss
$stmt->bindParam(':pass', $pass); // Enlaza el parámetro :pass

// Ejecuta la consulta preparada
$stmt->execute();

// Obtiene la fila con el resultado de la consulta
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Verifica si se encontró un usuario válido
if ($row) {
    $usuario = $row['usuario'];
    echo json_encode(array("valid" => true, "message" => "Token válido", "usuario" => $usuario));
} else {
    echo json_encode(array("valid" => false, "message" => "Token inválido"));
}

$conn = null; // Cierra la conexión

exit(); // Finaliza el script PHP
?>
