<?php
function ConectarLocalServer(){
    $conn = null;
    $database = 'PRODUCCION';
    $server = "TI-04\DEV04";
    $user = "dev_user";
    $pass = 'eddmon18';

    try {
        $conn = new PDO('sqlsrv:Server='.$server.';Database='.$database, $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Conexión exitosa a la base de datos"; 
    } catch(PDOException $e) {
        die('Error de conexión: '.$e->getMessage());
    }
   return $conn;
}
ConectarLocalServer();
?>



