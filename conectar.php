<?php
function ConectarServer(){
    $conn = null;
    $database = 'PRODGENERAL';
    $server = "TI-04\SQLEXPRESS";
    $user = "edd_user";
    $pass = 'ab145841$Pru';

    try {
        $conn = new PDO('sqlsrv:Server='.$server.';Database='.$database, $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Conexión exitosa a la base de datos"; 
    } catch(PDOException $e) {
        die('Error de conexión: '.$e->getMessage());
    }
   return $conn;
}
ConectarServer();
?>



