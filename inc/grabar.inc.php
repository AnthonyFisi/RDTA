<?php 
    require_once ("connect.inc.php");

    if (isset($_POST)) {
        if ($_POST['funcion'] === "grabarGeneral") {
            echo json_encode(grabarGeneral($pdo,$_POST['clase'],$_POST['detalle'])); 
        }else if($_POST['funcion'] === "grabarActividades"){
            echo json_encode(grabarActividades($pdo,$_POST['etapa'],$_POST['fase'],$_POST['actividades']));
        }else if($_POST['funcion'] === "grabarResponsable"){
            echo json_encode(grabarResponsable($pdo,$_POST['documento'],$_POST['nombres'],$_POST['ubicacion'],$_POST['fase'],$_POST['tipo']));
        }else if($_POST['funcion'] === "grabarHoja"){
            echo json_encode(grabarHoja($pdo,$_POST));
        }
    }


    function grabarHoja($pdo,$parametros){
        $cabecera = json_decode($parametros['cabecera']);
        $actividades = json_decode($parametros['actividades']);
        $personal = json_decode($parametros['personal']);
        $equipos = json_decode($parametros['equipos']);
        $materiales = json_decode($parametros['materiales']);

        $climaManiana = 0;
        $climaTarde=0;

        try {
            $sql =("INSERT INTO tabla_documento 
                    SET tabla_documento.tipodoc =?,
                        tabla_documento.dni_elabora =?,
                        tabla_documento.idproyecto =?,
                        tabla_documento.idfase =?,
                        tabla_documento.idubicacion =?,
                        tabla_documento.ffechadoc =?,
                        tabla_documento.diasemana =?,
                        tabla_documento.comentarios =?,
                        tabla_documento.totalhorasinoperativas =?,
                        tabla_documento.horarioinoperativo =?,
                        tabla_documento.adversidadclimatica =?,
                        tabla_documento.faltafirma =?,
                        tabla_documento.faltaliberacion =?,
                        tabla_documento.faltaprocedimiento =?,
                        tabla_documento.fallaequipo =?,
                        tabla_documento.faltamateriales =?,
                        tabla_documento.parogremial =?,
                        tabla_documento.otro =?,
                        tabla_documento.charlaseguridad =?,
                        tabla_documento.eppcompleto =?,
                        tabla_documento.permisotrabajo =?,
                        tabla_documento.climatarde =?,
                        tabla_documento.climamaniana =?,
                        tabla_documento.idetapa =?,
                        tabla_documento.idcliente=?");

        if ( $cabecera->chkSoleadoAm->{'prop'} ) {
            $climaManiana = 1;
        }else if( $cabecera->chkNubladoAm->{'prop'} ) {
            $climaManiana = 2;
        }else if( $cabecera->chkLluviosoAm->{'prop'} ) {
            $climaManiana = 3;
        }

        if ( $cabecera->chkSoleadoPm->{'prop'} ) {
            $climaTarde = 1;
        }else if( $cabecera->chkNubladoPm->{'prop'} ) {
            $climaTarde = 2;
        }else if( $cabecera->chkLluviosoPm->{'prop'} ) {
            $climaTarde = 3;
        }

        $statement = $pdo->prepare($sql);
        $statement -> execute(array(2,
                                    $parametros['elabora'],
                                    $cabecera->proyecto->{'value'},
                                    20,
                                    $cabecera->ubicacion->{'value'},
                                    "",
                                    $parametros['diasemana'],
                                    $cabecera->observaciones->{'value'},
                                    $cabecera->horasInoperativas->{'value'},
                                    $cabecera->horarioInoperativo->{'value'},
                                    $cabecera->chkAdversidad->{'prop'},
                                    $cabecera->chkFirma->{'prop'},
                                    $cabecera->chkLiberacion->{'prop'},
                                    $cabecera->chkProcedimiento->{'prop'},
                                    $cabecera->chkFallaEquipo->{'prop'},
                                    $cabecera->chkFaltaMateriales->{'prop'},
                                    $cabecera->chkParoGremial->{'prop'},
                                    $cabecera->chkOtroII->{'prop'},
                                    $cabecera->charla->{'prop'},
                                    $cabecera->epp->{'prop'},
                                    $cabecera->permiso->{'prop'},
                                    $climaTarde,
                                    $climaManiana,
                                    19,
                                    $cabecera->cliente->{'value'}));

        $rowCount = $statement ->rowCount();

        if ($rowCount >0){
            $respuesta = true;
            $indice = lastInsert($pdo);
            grabarActividadesHoja($pdo,$indice,$actividades);
            grabarPersonalHoja($pdo,$indice,$personal);
            grabarEquiposHoja($pdo,$indice,$equipos);
        }else{
            var_dump($statement->errorInfo());
        }

        return array("respuesta" => $respuesta,
                    "indice" => $indice);
                       
        } catch ( PDOException $e) {
            echo "Error: " . $e->getMessage;
            return false;
        }

        /*$indice = lastInsert($pdo);
        //grabarActividadesHoja($pdo,$indice,$actividades);
        //grabarPersonalHoja($pdo,$indice,$personal);
        //grabarEquiposHoja($pdo,$indice,$equipos);
        grabarMaterialesHoja($pdo,$indice,$materiales);
        
        $respuesta = "";*/

        return array("respuesta" => $respuesta,
                    "indice" => $indice);

    }

    function lastInsert($pdo){
        $sql = "SELECT MAX(iddoc) AS nrodoc FROM tabla_documento";
        $statement = $pdo->query($sql);
        $statement->execute();

        $result = $statement = $statement->fetchAll();

        return $result[0]['nrodoc'];
    }

    function grabarActividadesHoja($pdo,$id,$actividades){
       
        foreach ($actividades as $value) {
            $sql = "INSERT INTO detalle_actividades 
                            SET detalle_actividades.iddoc=?,
                                detalle_actividades.idact=?,
                                detalle_actividades.descrip=?,
                                detalle_actividades.cantidad=?,
                                detalle_actividades.unidades=?";
            
            $statement = $pdo->prepare($sql);
            $statement->execute(array($id,
                                      $value->item,
                                      $value->desc,
                                      $value->cant,
                                      $value->und));
        }
    }


    function grabarPersonalHoja($pdo,$id,$personal){
        foreach ($personal as $value) {
            $sql = "INSERT INTO detalle_personal 
                            SET detalle_personal.iddoc=?,
                                detalle_personal.numero=?,
                                detalle_personal.nombres=?,
                                detalle_personal.actividad=?,
                                detalle_personal.horas=?,
                                detalle_personal.cargo=?,
                                detalle_personal.horasextra=?";
            
            $statement = $pdo->prepare($sql);
            $statement->execute(array($id,
                                        $value->documento,
                                        $value->nombres,
                                        $value->act,
                                        $value->hh,
                                        $value->cargo,
                                        $value->he));
        }
    }

    function grabarEquiposHoja($pdo,$id,$equipo){
        foreach ($equipo as $value) {
            $sql = "INSERT INTO detalle_equipos 
                            SET detalle_equipos.iddoc=?,
                                detalle_equipos.numero=?,
                                detalle_equipos.idequipo=?,
                                detalle_equipos.descripcion=?,
                                detalle_equipos.actividad=?,
                                detalle_equipos.operativo=?,
                                detalle_equipos.standby=?,
                                detalle_equipos.horas=?";
            
            $statement = $pdo->prepare($sql);
            $statement->execute(array($id,
                                "",
                                "",
                                $value->desc,
                                $value->act,
                                $value->op,
                                $value->sb,
                                $value->he));
        }
    }
   
    function grabarMaterialesHoja($pdo,$id,$materiales){
        foreach ($materiales as $value) {
            $sql = "INSERT INTO detalle_materiales 
                            SET detalle_materiales.iddoc=?,
                                detalle_materiales.numero=?,
                                detalle_materiales.idmaterial=?,
                                detalle_materiales.descrip=?,
                                detalle_materiales.cantidad=?,
                                detalle_materiales.unidades=?";
            
            $statement = $pdo->prepare($sql);
            $statement->execute(array($id,"","",$value->desc,$value->cant,$value->und));
        }
    }

    function grabarResponsable($pdo,$doc,$nombres,$ubicacion,$fase,$tipo){
        $respuesta = false;

        try {
            $sql= "INSERT INTO tabla_responsables 
                    SET tabla_responsables.tipo=?,
                        tabla_responsables.documento=?,
                        tabla_responsables.nombre=?,
                        tabla_responsables.fase=?,
                        tabla_responsables.idubicacion=?";

            $statement = $pdo->prepare($sql);
            $statement -> execute(array($tipo,$doc,$nombres,$fase,$ubicacion));
            $rowCount = $statement ->rowCount();

            //var_dump($statement->errorInfo());

            if ($rowCount >0){
                $respuesta = true;
            }

            return array("respuesta" => $respuesta);

        } catch ( PDOException $e) {
            echo "Error: " . $e->getMessage;
            return false;
        }
    }

    function grabarActividades($pdo,$etapa,$fase,$actividades){
        $respuesta = false;
        $items = 0;

        $datos = json_decode($actividades);
        $nreg = count($datos);

        try {
            for ($i=0; $i < $nreg; $i++) { 
                $sql = "INSERT INTO tb_actividades 
                        SET tb_actividades.idetapa=?,tb_actividades.idfase=?,
                            tb_actividades.item=?,tb_actividades.cdetalle=?";
                $statement = $pdo->prepare($sql);
                $statement -> execute(array($etapa,$fase,$datos[$i]->item,strtoupper($datos[$i]->desc)));
                $rowCount = $statement ->rowCount();

                $items++;
            }
        } catch ( PDOException $e) {
            echo "Error: " . $e->getMessage;
            return false;
        }

        if ($items > 0)
            $respuesta = true;

        return array("respuesta" => $respuesta == $items > 0 ? true : false,
                    "items" => $items);
    }

    function grabarGeneral($pdo,$clase,$detalle){
        $respuesta = false;

        $ultimo_item = devolverItemFinal($pdo,$clase);

        try {
            $sql = "INSERT INTO tb_general SET tb_general.cclase=?,tb_general.citem=?,tb_general.cdetalle=?";
            $statement = $pdo->prepare($sql);
            $statement -> execute(array($clase,str_pad($ultimo_item,2,0,STR_PAD_LEFT),strtoupper($detalle)));
            $rowCount = $statement ->rowCount();

            if ($rowCount > 0) {
                $respuesta = true;
            }

        } catch ( PDOException $e) {
            echo "Error: " . $e->getMessage;
            return false;
        }

        return array("respuesta" => $respuesta,
                    "item" => $ultimo_item);
    }

    function devolverItemFinal($pdo,$clase){
        try {
            $sql = "SELECT COUNT(*) AS item FROM tb_general WHERE tb_general.cclase = ?";
            $statement = $pdo->prepare($sql);
            $statement -> execute(array($clase));
            $result = $statement ->fetchAll();

            return $result[0]['item'];

        } catch ( PDOException $e) {
            echo "Error: " . $e->getMessage;
            return false;
        }
    }
?>