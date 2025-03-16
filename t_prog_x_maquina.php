<?php
include 'conec/conn.php';

$conc = OpenConnection();

if(!$conc){
        die("No se pudo conectar, hay errores");
}

$cbomaquina = $_GET['maquina'];



$query = "SET NOCOUNT ON;
if OBJECT_ID('tempdb..#TMPMaqOt') IS NOT NULL DROP TABLE #TMPMaqOt;
                                SELECT * 
                                into #TMPMaqOt 
                                from produccion.dbo.MaqOt
                                Where MotCodMaq in (:maquina) 
                                and CAST(MotFini as date) BETWEEN cast((getdate()) as date) AND cast(getdate() as date) and MotEstado not in ('E','+','-','C','D','E','F','N','X')
                                
                                if OBJECT_ID('tempdb..#TMPestados1') IS NOT NULL DROP TABLE #TMPestados1;
                                    select estado,motenlace,area,id
                                    into #TMPestados1 
                                    from INTEGRA.SYSPRO.REGISTRO_ESTADOS (nolock) where motenlace in (select MotEnlace from #TMPMaqOt)

                                select MaqNro,MotCodOdt,MotEnlace,
                            CONVERT(VARCHAR(10), MotFini, 103) as INIPROC,
                            CONVERT(VARCHAR(10), MotFini, 108) as HoraINProc,CONVERT(VARCHAR(10), MotFfin, 103) as FINPROC,
                            CONVERT(VARCHAR(10), MotFfin, 108) as HoraFinProc,
                            C.Clides,MotDescrip,MotTipoMaq,MotCant,MotPliegos,
                            CONVERT(VARCHAR(10), MotFecOfr, 103) as FECOFREC,Enlace,mottirret,
                            (select TOP 1(er.estado) from  #TMPestados1  er where er.motenlace=m.MotEnlace and er.area='ALMACEN MP' ORDER BY er.id DESC --and flag=(SELECT MAX(flag) from INTEGRA.SYSPRO.REGISTRO_ESTADOS with(nolock)) --WHERE area='ALMACEN MP' )
                            ) as estadoALM,
                            (select TOP 1(er.estado) from #TMPestados1  er where er.motenlace=m.MotEnlace and er.area='POST PRENSA' ORDER BY er.id DESC -- and flag=(SELECT MAX(flag) from INTEGRA.SYSPRO.REGISTRO_ESTADOS with(nolock) WHERE area='MATRI')
                            ) as estadoMATRI,
                            (select TOP 1(er.estado) from  #TMPestados1 er where er.motenlace=m.MotEnlace and er.area='PRE PRENSA' ORDER BY er.id DESC --and flag=(SELECT MAX(flag) from INTEGRA.SYSPRO.REGISTRO_ESTADOS with(nolock) WHERE area='CTP')
                            ) as estadoCTP,
                            (select TOP 1(er.estado) from  #TMPestados1  er where er.motenlace=m.MotEnlace and er.area='IMPRESIÓN' ORDER BY er.id DESC) as estadoMATIZ
                                                    
                            --,'Estado' =   
                              --    CASE   
                                --     WHEN CONVERT(VARCHAR(10), MotFini, 103) = CONVERT(VARCHAR(10), MotFecOfr, 103) THEN 'FECHA LIMITE'  
                                  --   ELSE 'NORMAL'  
                                  --END   
                            From #TMPMaqOt m with(nolock)
                             LEFT join siograf.dbo.Impresora J with(nolock) on J.MaqNro=motcodmaq
                             LEFT join SIOGRAF.dbo.clientes C with(nolock) on ( C.Clicod=MotCliente) 
                             order by MotFini asc";
$stmt = $conc->prepare($query);
$stmt->bindParam(':maquina', $cbomaquina);

$stmt->execute();




$conteo = $stmt->rowCount();

if($conteo != 0) {
    $rows = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        $rows[] = $row;
    }
    echo json_encode($rows);
} else {
    echo json_encode(array("error" => "No hay Orden de produccion disponibles"));
}

$result = null;
$conc = null;

exit();
?>