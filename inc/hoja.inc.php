<?php 

    require_once("connect.inc.php");

    function getClientes($pdo){

        $docData = [];

        $sql = "SELECT tb_general.idreg,tb_general.cdetalle
                FROM tb_general
                WHERE tb_general.nflgactivo = 1
                    AND tb_general.cclase = '03'
                    AND tb_general.citem !='00'";

        $statement = $pdo->query($sql);
        $statement ->execute();
        $rowCount = $statement ->rowCount();

        if ($rowCount) {
            $respuesta = true;
            
            while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                $docData[] = $row;
            }
        }

        return $docData;
    }

    function getLocate($pdo){
        $docData = [];

        $sql = "SELECT tabla_ubicacion.idreg,tabla_ubicacion.descripcion
                FROM tabla_ubicacion
                WHERE tabla_ubicacion.swactivo = 1";

        $statement = $pdo->query($sql);
        $statement ->execute();
        $rowCount = $statement ->rowCount();

        if ($rowCount) {
            $respuesta = true;
            
            while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                $docData[] = $row;
            }
        }

        return $docData;
    }

    function diaSemana($fecha){
        setlocale(LC_TIME, 'es_ES');

        $f = explode('/',$fecha);
        $dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
        
        return strtoupper($dias[jddayofweek (cal_to_jd(CAL_GREGORIAN, date($f[1]),date($f[0]),date($f[2])) , 0 )-1]);
    }

?>