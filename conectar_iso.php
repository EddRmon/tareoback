<?php
function ConectarLocalServerSiograf(){
    $conne = null;
    $database = 'SIOGRAF';
    $server = "TI-04\DEV04";
    $user = "dev_user";
    $pass = 'eddmon18';

    try {
        $conne = new PDO('sqlsrv:Server='.$server.';Database='.$database, $user, $pass);
        $conne->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Conexión exitosa a la base de datos"; 
    } catch(PDOException $e) {
        die('Error de conexión: '.$e->getMessage());
    }
   return $conne;
}
ConectarLocalServerSiograf();
?>

