<?php 
    require_once ("connect.inc.php");

    if ( isset( $_POST )) {
        if ($_POST['funcion'] === "consultarGeneral") {
            echo json_encode(consultarGeneral($pdo,$_POST['clase'])); 
        }else  if ($_POST['funcion'] === "consultarDocumentos") {
            echo json_encode(consultarDocumentos($pdo)); 
        }else if ($_POST['funcion'] === "datosRdta") {
            echo json_encode(datosRdta($pdo,$_POST['registro'])); 
        }else if ($_POST['funcion'] === "consultarFirma") {
            echo json_encode(consultarFirma($pdo,$_POST['nrodoc'])); 
        }else if ($_POST['funcion'] === "consultarFases") {
            echo json_encode(consultarFases($pdo)); 
        }else if ($_POST['funcion'] === "consultarResponsables") {
            echo json_encode(consultarResponsables($pdo)); 
        }else if ($_POST['funcion'] === "generarPDF") {
            echo json_encode(generarPDF($pdo,$_POST['indice'])); 
        }else if ($_POST['funcion'] === "actividades") {
            echo json_encode(actividades($pdo)); 
        }else if ($_POST['funcion'] === "personal") {
            echo json_encode(personal()); 
        }else if ($_POST['funcion'] === "productos") {
            echo json_encode(productos()); 
        }else if ($_POST['funcion'] === "equipos") {
            echo json_encode(equipos()); 
        }
    }

    function productos(){
        try{
            $api = file_get_contents('http://sicalsepcon.net/api/proyectos/api_productos.php');

            $productos = json_decode($api);

            return $productos;
            
        }catch ( PDOException $e) {
            echo "Error: " . $e->getMessage;
            return false;
        }
    }

    function equipos(){
        try{
            $api = file_get_contents('http://sicalsepcon.net/api/proyectos/api_equipos.php');

            $equipos = json_decode($api);

            return $equipos;
            
        }catch ( PDOException $e) {
            echo "Error: " . $e->getMessage;
            return false;
        }
    }

    function personal(){
        try{
            $api = file_get_contents('http://sicalsepcon.net/api/workersnewapi.php');

            $nombres = json_decode($api);

            return $nombres;
            
        }catch ( PDOException $e) {
            echo "Error: " . $e->getMessage;
            return false;
        }
    }

    function actividades($pdo){
        try {

            $respuesta = false;
            $docData = [];

            $sql = "SELECT tb_actividades.idreg,
                            tb_actividades.idetapa,
                            tb_actividades.idfase,
                            tb_actividades.item,
                            tb_actividades.cdetalle
                    FROM tb_actividades
                    WHERE tb_actividades.nflgactivo = 1";
            
            $statement = $pdo->query($sql);
            $statement ->execute();
            $rowCount = $statement ->rowCount();

            if ($rowCount) {
                $respuesta = true;
                
                while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                    $docData[] = $row;
                }
            }

            return array("respuesta"=>$respuesta,
                         "datos"=>$docData);
            
        } catch ( PDOException $e) {
            echo "Error: " . $e->getMessage;
            return false;
        }
    }

    function consultarFirma($pdo,$ndoc){
        try {

            $respuesta = false;
            $docData = array();

            $sql = "SELECT
                    tabla_responsables.documento, 
                    tabla_responsables.nombre, 
                    tabla_responsables.idubicacion, 
                    tabla_responsables.idproyecto, 
                    tabla_responsables.tipo
                FROM
                    tabla_responsables
                WHERE
                    tabla_responsables.swactivo = 1 AND
                    tabla_responsables.documento = ?";
            

            $statement = $pdo->prepare($sql);
            $statement ->execute(array($ndoc));
            $rowCount = $statement ->rowCount();

            if ($rowCount) {
                $respuesta = true;
                
                while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                    $docData[] = $row;
                }
            }

            return array("respuesta"=>$respuesta,
                         "docData"=>$docData);
            
        } catch ( PDOException $e) {
            echo "Error: " . $e->getMessage;
            return false;
        }
    }

    function datosRdta($pdo,$registro){
        try {
            $datos = [];

            $sql = "SELECT
                        clientes.cdetalle AS cliente,
                        sepconcp.tabla_ubicacion.descripcion AS ubicacion,
                        sepconcp.tabla_documento.freg,
                        sepconcp.tabla_documento.iddoc,
                        fases.cdetalle AS fase,
                    IF
                        ( sepconcp.tabla_documento.tipodoc = 1, 'RDTA', 'RDO' ) AS tipo,
                        DATE_FORMAT( CAST( sepconcp.tabla_documento.freg AS DATE ), '%d/%m/%Y' ) AS fecha,
                        sepconcp.tabla_documento.climatarde,
                        sepconcp.tabla_documento.climamaniana,
                        sepconcp.tabla_documento.comentarios,
                        sepconcp.tabla_documento.totalhorasinoperativas,
                        sepconcp.tabla_documento.horarioinoperativo,
                        sepconcp.tabla_documento.adversidadclimatica,
                        sepconcp.tabla_documento.faltafirma,
                        sepconcp.tabla_documento.faltaliberacion,
                        sepconcp.tabla_documento.faltaprocedimiento,
                        sepconcp.tabla_documento.fallaequipo,
                        sepconcp.tabla_documento.faltamateriales,
                        sepconcp.tabla_documento.parogremial,
                        sepconcp.tabla_documento.otro,
                        sepconcp.tabla_documento.charlaseguridad,
                        sepconcp.tabla_documento.eppcompleto,
                        sepconcp.tabla_documento.permisotrabajo,
                        sepconcp.tabla_documento.firmaencargado,
                        sepconcp.tabla_documento.jefaturaobra,
                        sepconcp.tabla_documento.supervision,
                        sepconcp.tabla_documento.avance, 
	                    sepconcp.tabla_documento.idproyecto 
                    FROM
                        sepconcp.tabla_documento
                        LEFT JOIN sepconcp.tb_general AS clientes ON sepconcp.tabla_documento.idcliente = clientes.idreg
                        LEFT JOIN sepconcp.tabla_ubicacion ON sepconcp.tabla_documento.idubicacion = sepconcp.tabla_ubicacion.idreg
                        LEFT JOIN sepconcp.tb_general AS fases ON sepconcp.tabla_documento.idfase = fases.idreg 
                    WHERE
                        sepconcp.tabla_documento.swactivo = 1 
                        AND sepconcp.tabla_documento.iddoc = ? ";

        $statement = $pdo->prepare($sql);
        $statement ->execute(array($registro));
                
        $docData = array();

        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $docData[] = $row;
        }

        $salida = array("datos"=>$docData,
                        "actividades"=>actividadesRdta($pdo,$registro),
                        "personal"=>personalRtda($pdo,$registro),
                        "equipos"=>equiposRtda($pdo,$registro),
                        "materiales"=>materialesRtda($pdo,$registro),
                        "proyecto"=>llamarProyecto($docData[0]['idproyecto']));

            return $salida;
        } catch ( PDOException $e) {
            echo "Error: " . $e->getMessage;
            return false;
        }
    }

    function actividadesRdta($pdo,$registro){
        try {
            $salida = "";
            $sql = "SELECT
                        detalle_actividades.idreg,
                        detalle_actividades.iddoc,
                        detalle_actividades.idact,
                        detalle_actividades.descrip,
                        detalle_actividades.swactivo,
                        detalle_actividades.cantidad
                    FROM
                        detalle_actividades 
                    WHERE
                        detalle_actividades.swactivo = 1 
                        AND detalle_actividades.iddoc = ?";
                
                $statement = $pdo->prepare($sql);
                $statement ->execute(array($registro));
                $rowCount = $statement->rowCount();

            if ($rowCount) {
                while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                    $docData[] = $row;
                }
            }

            return $docData;
            
        } catch ( PDOException $e) {
            echo "Error: " . $e->getMessage;
            return false;
        }
    }

    function equiposRtda($pdo,$registro){
        try {
            $salida = "";
            $docData=[];
            $sql = "SELECT
                        detalle_equipos.idreg,
                        detalle_equipos.iddoc,
                        detalle_equipos.idequipo,
                        detalle_equipos.descripcion,
                        detalle_equipos.horas,
                        IFNULL( detalle_equipos.actividad, '' ) AS actividad,
                        IFNULL( detalle_equipos.operativo, '' ) AS operativo,
                        IFNULL( detalle_equipos.inoperativo, '' ) AS inoperativo,
                        IFNULL( detalle_equipos.standby, '' ) AS standby 
                    FROM
                        detalle_equipos 
                    WHERE
                        detalle_equipos.swactivo = 1 
                        AND detalle_equipos.iddoc = ?";
                
                $statement = $pdo->prepare($sql);
                $statement ->execute(array($registro));
                $rowCount = $statement->rowCount();

            if ($rowCount) {
                while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                    $docData[] = $row;
                }
            }

            return $docData;
            
        } catch ( PDOException $e) {
            echo "Error: " . $e->getMessage;
            return false;
        }
	}

    function personalRtda($pdo,$registro){
        try {
            $salida = "";
            $item = 1;
            $docData=[];
            $sql = "SELECT detalle_personal.nombres,
                            detalle_personal.actividad, 
                            detalle_personal.horas,
                            detalle_personal.cargo,
                            detalle_personal.horasextra
                    FROM detalle_personal
                    WHERE detalle_personal.swactivo = 1
                        AND detalle_personal.iddoc = ?";
                
                $statement = $pdo->prepare($sql);
                $statement ->execute(array($registro));
                $rowCount = $statement->rowCount();

            if ($rowCount) {
               

                while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                    $docData[] = $row;
                }
            }

            return $docData;
            
        } catch ( PDOException $e) {
            echo "Error: " . $e->getMessage;
            return false;
        }
    }

    function materialesRtda($pdo,$registro){
        try {
            $salida = "";
            $item = 1;
            $docData=[];
            $sql = "SELECT
                        detalle_materiales.descrip,
                        detalle_materiales.cantidad,
                        detalle_materiales.unidades 
                    FROM
                        detalle_materiales 
                    WHERE
                        detalle_materiales.swactivo = 1 
                        AND detalle_materiales.iddoc = ?";
                
                $statement = $pdo->prepare($sql);
                $statement ->execute(array($registro));
                $rowCount = $statement->rowCount();

            if ($rowCount) {
                while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                    $docData[] = $row;
                }
            }

            return $docData;
            
        } catch ( PDOException $e) {
            echo "Error: " . $e->getMessage;
            return false;
        }
    }

    function consultarDocumentos($pdo){
        try {
            $item = 1;
            $filas= [];

            $sql = "SELECT
                        sepconcp.tabla_documento.iddoc,
                        sepconcp.tabla_documento.idproyecto,
                        IFNULL( sepconcp.tabla_documento.avance,0) AS avance,
                        clientes.cdetalle AS cliente,
                        sepconcp.tabla_ubicacion.descripcion AS ubicacion,
                        fases.cdetalle AS fase,
                        IF(sepconcp.tabla_documento.tipodoc = 1,'RTDA','RDA') AS tipo,
                        DATE_FORMAT(CAST( sepconcp.tabla_documento.freg AS DATE ),'%d/%m/%Y') AS fecha
                    FROM
                        sepconcp.tabla_documento
                        LEFT JOIN sepconcp.tb_general AS clientes ON sepconcp.tabla_documento.idcliente = clientes.idreg
                        LEFT JOIN sepconcp.tabla_ubicacion ON sepconcp.tabla_documento.idubicacion = sepconcp.tabla_ubicacion.idreg
                        LEFT JOIN sepconcp.tb_general AS fases ON sepconcp.tabla_documento.idfase = fases.idreg
                    WHERE sepconcp.tabla_documento.swactivo = 1
                    ORDER BY sepconcp.tabla_documento.freg ASC";

            $statement = $pdo->prepare($sql);
            $statement ->execute();
            $rowCount = $statement ->rowCount();
            $results  = $statement ->fetchAll();

            if ($rowCount > 0){
                foreach ($results as $rs) {

                    $descripcion = llamarProyecto($rs['idproyecto']);

                    $fila = array("item" => $item++,
                                  "cliente" => $rs['cliente'],
                                  "tipo" => $rs['tipo'],
                                  "fecha"=>$rs['fecha'],
                                  "ubicacion"=>$rs['ubicacion'],
                                  "fase"=>$rs['fase'],
                                  "proyecto"=>$descripcion,
                                  "idreg"=>$rs['iddoc'],
                                  "avance"=>$rs['avance']);

                    array_push($filas,$fila);
                }
            }
            
            $salida = array("filas"=>$filas);

            return $salida;
        } catch ( PDOException $e) {
            echo "Error: " . $e->getMessage;
            return false;
        }
    }

    function llamarProyecto($cc) {

        $api = file_get_contents('http://localhost/apirest/api_sical.php?cc='.$cc);
        //$api = file_get_contents('http://localhost/api/proyectos/api_sical.php?cc='.$id);
        //$api = file_get_contents('http://192.168.110.16/api/proyectos/api_sical.php?cc='.$cc);
        //$api = file_get_contents('http://sicalsepcon.net/api/proyectos/api_sical.php?cc='.$cc);

        $proyecto = json_decode($api);

        return $proyecto->descripcion;
    }
    
    function consultarGeneral($pdo,$clase){
        $respuesta = false;
        $filas= [];

        try {
            $sql = "SELECT  tb_general.idreg,
                            tb_general.cclase,
                            tb_general.citem,
                            tb_general.cetapa,
                            tb_general.czona,
                            tb_general.cdetalle 
                    FROM
                        tb_general 
                    WHERE
                        tb_general.cclase = ? 
                        AND tb_general.nflgactivo = 1 
                        AND tb_general.citem != '00'
                    ORDER BY tb_general.citem";
                    
            $statement = $pdo->prepare($sql);
            $statement -> execute(array($clase));
            $rowCount  = $statement ->rowCount();
            $results   = $statement ->fetchAll();

            if ($rowCount > 0) {
                $respuesta = true;

                foreach ($results as $rs) {
                    $fila = array("idreg"   => $rs['idreg'],
                                  "clase"   => $rs['cclase'],
                                  "item"    => $rs['citem'],
                                  "etapa"   => $rs['cetapa'],
                                  "zona"    => $rs['czona'],
                                  "detalle" => $rs['cdetalle']);

                    array_push($filas,$fila);
                }
            }

            return array("respuesta" => $respuesta,
                        "filas" => $filas);

        } catch ( PDOException $e) {
            echo "Error: " . $e->getMessage;
            return false;
        }
        
    }

    function consultarResponsables($pdo){
        try {
            $respuesta = false;
            $docData=array();

            $sql = "SELECT
                        tabla_responsables.idreg,
                        tabla_responsables.tipo,
                        tabla_responsables.documento,
                        tabla_responsables.nombre,
                        tb_general.cdetalle,
                        tabla_responsables.fase, 
	                    tabla_responsables.idubicacion, 
	                    tabla_responsables.idproyecto 
                    FROM
                        tabla_responsables
                        INNER JOIN tb_general ON tabla_responsables.tipo = tb_general.idreg 
                    WHERE
                        tabla_responsables.swactivo = 1";
                    
            $statement = $pdo->prepare($sql);
            $statement -> execute();
            $rowCount  = $statement ->rowCount();
            
            if ($rowCount) {
                $respuesta = true;
                
                while($row = $statement->fetch(PDO::FETCH_ASSOC)){
                    $docData[] = $row;
                }
            }

            return array("respuesta"=>$respuesta,
                        "items"=>$rowCount,
                        "docData"=>$docData);
        } catch ( PDOException $e) {
            echo "Error: " . $e->getMessage;
            return false;
        }
    }

    function consultarFases($pdo){
        $respuesta = false;
        $filas= [];

        try {
            $sql = "SELECT
                    tb_general.idreg,
                    tb_general.cclase,
                    tb_general.citem,
                    tb_general.cetapa,
                    tb_general.czona,
                    tb_general.cdetalle 
                FROM
                    tb_general 
                WHERE
                    tb_general.cclase = '01' 
                    AND tb_general.nflgactivo = 1 
                    AND tb_general.citem != '00' 
                ORDER BY
                    tb_general.cdetalle";
                    
            $statement = $pdo->query($sql);
            $statement -> execute();
            $rowCount  = $statement ->rowCount();
            $results   = $statement ->fetchAll();

            if ($rowCount > 0) {
                $respuesta = true;

                foreach ($results as $rs) {
                    $fila = array("idreg"   => $rs['idreg'],
                                  "clase"   => $rs['cclase'],
                                  "item"    => $rs['citem'],
                                  "etapa"   => $rs['cetapa'],
                                  "zona"    => $rs['czona'],
                                  "detalle" => $rs['cdetalle']);

                    array_push($filas,$fila);
                }
            }

            return array("respuesta" => $respuesta,
                        "filas" => $filas);

        } catch ( PDOException $e) {
            echo "Error: " . $e->getMessage;
            return false;
        }
        
    }

    function generarPDF($pdo,$indice){
        require_once("../libs/fpdf/fpdf.php");

        $datos = datosRdta($pdo,$indice);

        $dias = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");

        $proyecto = llamarProyecto($datos["datos"][0]['idproyecto']);

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',7);
        $pdf->Image('../img/logo.png',12,10,25);
        $pdf->cell(30,5,"","TRL",0,0);
        $pdf->cell(125,5,"REPORTE DIARIO DE TRABAJO ADICIONAL","TRL",1,"C");
        $pdf->cell(30,5,"","RL",0,0);
        $pdf->cell(125,5,"(R.T.D.A)",'RL',1,"C");
        $pdf->cell(30,5,"","RL",0);
        $pdf->cell(30,5,"CLIENTE",'L',0);
        $pdf->cell(95,5,utf8_decode($datos["datos"][0]['cliente']),'R',1);
        $pdf->cell(30,5,"SEPCON S.A.C.","RLB",0,'C');
        $pdf->cell(30,5,"PROYECTO/OBRA",'LB',0);
        $pdf->cell(95,5,utf8_decode($proyecto),'RB',0,"L");
        $pdf->cell(35,5,"ANEXO 9","RLB",0,'C');
        $pdf->SetFont('Arial','',7);
        $pdf->setXY(165,10);
        $pdf->MultiCell(35,3.75,utf8_decode('PMAL-300-PC-X-001-Prot 09
Revision : 0
Emision: 30/01/2021
Página: 1 de 1'),1,'1',false);
        $pdf->setXY(10,30);

        $pdf->SetFont('Arial','',4.5);
        $pdf->SetFillColor(0, 92, 133);
        $pdf->cell(30,4,"CLIMA","LBR",0,'C',true);
        $pdf->cell(30,4,"UBICACION","RB",0,'C',true);
        $pdf->cell(95,4,"FACES TRABAJO","RB",0,'C',true);
        $pdf->cell(35,4,"FECHA","RB",1,'C',true);
        
        $pdf->cell(14,4,"","L",0,'L');
        $pdf->cell(8,4,"AM",0,0,'C');
        $pdf->cell(8,4,"PM","R",0,'C');

        $pdf->cell(30,4,$datos["datos"][0]['ubicacion'],"LR",0,'L'); /*datos*/

        $pdf->SetFont('ZapfDingbats','',7);
        $pdf->cell(4,4,chr(111),0,'L','C');
        $pdf->SetFont('Arial','',4.5);
        $pdf->cell(30,4,"SUPERVICION Y CONTROL",0,0,'L');

        $pdf->SetFont('ZapfDingbats','',7);
        $pdf->cell(4,4,chr(111),0,'L','C');
        $pdf->SetFont('Arial','',4.5);
        $pdf->cell(25,4,"TRABAJOS GENERALES",0,0,'L');

        $pdf->SetFont('ZapfDingbats','',7);
        $pdf->cell(4,4,chr(111),0,'L','C');
        $pdf->SetFont('Arial','',4.5);
        $pdf->cell(28,4,"MANTENIMIENTO DE EQUIPOS","R",0,'L');

        $pdf->cell(12,4,"DIA","RB",0,'C');
        $pdf->cell(12,4,"MES","RB",0,'C');
        $pdf->cell(11,4,utf8_decode("AÑO"),"RB",1,'C');

        //segunda linea

        $pdf->cell(14,4,"SOLEADO","L",0,'L');
        $pdf->SetFont('ZapfDingbats','',7);
        
        if ( $datos["datos"][0]['climamaniana'] === "1" && $datos["datos"][0]['climatarde'] === "1" ){
            $pdf->cell(8,4,chr(110),0,0,'C');
            $pdf->cell(8,4,chr(110),"R",0,'C');
        }else if ( $datos["datos"][0]['climamaniana'] === "1" && $datos["datos"][0]['climatarde'] !== "1" ){
            $pdf->cell(8,4,chr(110),0,0,'C');
            $pdf->cell(8,4,chr(111),"R",0,'C');
        }else if ( $datos["datos"][0]['climamaniana'] !== "1" && $datos["datos"][0]['climatarde'] === "1" ){
            $pdf->cell(8,4,chr(111),0,0,'C');
            $pdf->cell(8,4,chr(110),"R",0,'C');
        }else{
            $pdf->cell(8,4,chr(111),0,0,'C');
            $pdf->cell(8,4,chr(111),"R",0,'C');
        }
     
        $pdf->SetFont('Arial','',4.5);
        $pdf->cell(30,4,"","R",0,'L');

        $pdf->SetFont('ZapfDingbats','',7);
        $pdf->cell(4,4,chr(111),0,'L','C');
        $pdf->SetFont('Arial','',4.5);
        $pdf->cell(30,4,"OBRAS CIVILES",0,0,'L');

        $pdf->SetFont('ZapfDingbats','',7);
        $pdf->cell(4,4,chr(111),0,'L','C');
        $pdf->SetFont('Arial','',4.5);
        $pdf->cell(25,4,"MECANICAS DE ESTRUCTURA",0,0,'L');

        $pdf->SetFont('ZapfDingbats','',7);
        $pdf->cell(4,4,chr(111),0,'L','C');
        $pdf->SetFont('Arial','',4.5);
        $pdf->cell(28,4,"MECANICA PIPING","R",0,'L');

        $fecha = explode("/",$datos["datos"][0]['fecha']);

        $pdf->cell(12,4,$fecha[0],"RB",0,'C');
        $pdf->cell(12,4,$fecha[1],"RB",0,'C');
        $pdf->cell(11,4,$fecha[2],"RB",1,'C');

        //tercera linea linea

        $pdf->cell(14,4,"NUBLADO","L",0,'L');
        $pdf->SetFont('ZapfDingbats','',7);

        if ( $datos["datos"][0]['climamaniana'] === "2" && $datos["datos"][0]['climatarde'] === "2" ){
            $pdf->cell(8,4,chr(110),0,0,'C');
            $pdf->cell(8,4,chr(110),"R",0,'C');
        }else if ( $datos["datos"][0]['climamaniana'] === "2" && $datos["datos"][0]['climatarde'] !== "2" ){
            $pdf->cell(8,4,chr(110),0,0,'C');
            $pdf->cell(8,4,chr(111),"R",0,'C');
        }else if ( $datos["datos"][0]['climamaniana'] !== "2" && $datos["datos"][0]['climatarde'] === "2" ){
            $pdf->cell(8,4,chr(111),0,0,'C');
            $pdf->cell(8,4,chr(110),"R",0,'C');
        }else{
            $pdf->cell(8,4,chr(111),0,0,'C');
            $pdf->cell(8,4,chr(111),"R",0,'C');
        }

        $pdf->SetFont('Arial','',4.5);
        $pdf->cell(30,4,"","R",0,'L');

        $pdf->SetFont('ZapfDingbats','',7);
        $pdf->cell(4,4,chr(111),0,'L','C');
        $pdf->SetFont('Arial','',4.5);
        $pdf->cell(30,4,"ELECTRICIDAD/INSTRUMENTACION",0,0,'L');

        $pdf->SetFont('ZapfDingbats','',7);
        $pdf->cell(4,4,chr(111),0,'L','C');
        $pdf->SetFont('Arial','',4.5);
        $pdf->cell(25,4,"INGENIERIA",0,0,'L');

        $pdf->SetFont('ZapfDingbats','',7);
        $pdf->cell(4,4,chr(111),0,'L','C');
        $pdf->SetFont('Arial','',4.5);
        $pdf->cell(28,4,"OTRO","R",0,'L');

        $pdf->cell(35,4,"DIA DE LA SEMANA","RB",1,'C');

        //cuarta linea
        //tercera linea linea

        $pdf->cell(14,4,"LLUVIOSO","LB",0,'L');
        $pdf->SetFont('ZapfDingbats','',7);

        if ( $datos["datos"][0]['climamaniana'] === "3" && $datos["datos"][0]['climatarde'] === "3" ){
            $pdf->cell(8,4,chr(110),0,0,'C');
            $pdf->cell(8,4,chr(110),"R",0,'C');
        }else if ( $datos["datos"][0]['climamaniana'] === "3" && $datos["datos"][0]['climatarde'] !== "3" ){
            $pdf->cell(8,4,chr(110),0,0,'C');
            $pdf->cell(8,4,chr(111),"R",0,'C');
        }else if ( $datos["datos"][0]['climamaniana'] !== "3" && $datos["datos"][0]['climatarde'] === "3" ){
            $pdf->cell(8,4,chr(111),0,0,'C');
            $pdf->cell(8,4,chr(110),"R",0,'C');
        }else{
            $pdf->cell(8,4,chr(111),0,0,'C');
            $pdf->cell(8,4,chr(111),"R",0,'C');
        }

        $pdf->SetFont('Arial','',4.5);
        $pdf->cell(30,4,"","RB",0,'L');

        $pdf->cell(20,4,"SUB FASE",0,0,'L');
        $pdf->cell(75,4,"","R",0);

        //DIA DE LA SEMANAS

        $pdf->cell(35,4,diaSemana($datos["datos"][0]['fecha']),"BR",1,'C');

        $pdf->cell(190,4,"DESCRIPCION DE LOS TRABAJOS",1,1,'C',true);

        $pdf->cell(10,4,"Nro.",'LRB',0,'C');
        $pdf->cell(170,4,"Actividad","RB",0,'C');
        $pdf->cell(10,4,"Cant.","RB",1,'C');

        //blucle_actividades

        foreach( $datos['actividades'] as $row){
            $pdf->cell(10,4,$row['idact'],'LRB',0,'C');
            $pdf->cell(170,4,utf8_decode($row['descrip']),"RB",0,'L');
            $pdf->cell(10,4,$row['cantidad'],"RB",1,'C');
        }
        
        $pdf->cell(190,4,"PERSONAL",1,1,'C',true);
    
        $pdf->cell(10,4,"#",'LRB',0,'C');
        $pdf->cell(80,4,"NOMBRES Y APELLIDOS",'LRB',0,'C');
        $pdf->cell(60,4,"CARGO",'LRB',0,'C');
        $pdf->cell(10,4,"ACT",'LRB',0,'C');
        $pdf->cell(10,4,"H/H",'LRB',0,'C');
        $pdf->cell(10,4,"SB",'LRB',0,'C');
        $pdf->cell(10,4,"INOP",'LRB',1,'C');

        //bucle_personal
        $item = 1;

        foreach($datos['personal'] as $row){
            $pdf->cell(10,4,$item++,'LRB',0,'C');
            $pdf->cell(80,4,utf8_decode($row['nombres']),'LRB',0,'L');
            $pdf->cell(60,4,utf8_decode($row['cargo']),'LRB',0,'L');
            $pdf->cell(10,4,$row['actividad'],'LRB',0,'C');
            $pdf->cell(10,4,$row['horasextra'],'LRB',0,'C');
            $pdf->cell(10,4,"",'LRB',0,'C');
            $pdf->cell(10,4,"",'LRB',1,'C');
        }

        $pdf->cell(190,4,"EQUIPOS",1,1,'C',true);
        $pdf->cell(10,4,"#|",'LRB',0,'C');
        $pdf->cell(130,4,"CODIGO Y DESCRIPCION",'LRB',0,'C');
        $pdf->cell(10,4,"ACT",'LRB',0,'C');
        $pdf->cell(10,4,"H/E",'LRB',0,'C');
        $pdf->cell(10,4,"OP",'LRB',0,'C');
        $pdf->cell(10,4,"INOP",'LRB',0,'C');
        $pdf->cell(10,4,"SB",'LRB',1,'C');

        //bucle equipos
        $item = 1;
        foreach($datos['equipos'] as $row) {
            $pdf->cell(10,4,$item++,'LRB',0,'C');    
            $pdf->cell(130,4,utf8_decode($row['idequipo'].' '.$row['descripcion']),'LRB',0,'L');
            $pdf->cell(10,4,$row['actividad'],'LRB',0,'C');
            $pdf->cell(10,4,$row['horas'],'LRB',0,'C');
            $pdf->cell(10,4,$row['operativo'],'LRB',0,'C');
            $pdf->cell(10,4,$row['inoperativo'],'LRB',0,'C');
            $pdf->cell(10,4,$row['standby'],'LRB',1,'C');
        }

        $pdf->cell(190,4,"MATERIALES UTILIZADOS",1,1,'C');
        $pdf->cell(10,4,"#",'LRB',0,'C');
        $pdf->cell(150,4,"CODIGO Y DESCRIPCION",'LRB',0,'C');
        $pdf->cell(10,4,"ACT",'LRB',0,'C');
        $pdf->cell(10,4,"UND",'LRB',0,'C');
        $pdf->cell(10,4,"CANT",'LRB',1,'C');

        //buckle materiales
        $item = 1;
        foreach($datos['materiales'] as $row) {
            $pdf->cell(10,4,$item++,'LRB',0,'C');
            $pdf->cell(150,4,utf8_decode($row['idmaterial'].' '.$row['descrip']),'LRB',0,'L');
            $pdf->cell(10,4,"",'LRB',0,'C');
            $pdf->cell(10,4,$row['unidades'],'LRB',0,'C');
            $pdf->cell(10,4,$row['cantidad'],'LRB',1,'C');
        }

        $pdf->SetFont('Arial','',4);

        $pdf->cell(190,4,"REFERENCIA: ACT = ACTIVIDAD | D/D = DESCANSO | SB = STAND BY | OP = OPERATIVO | INO = INOPERATIVO",1,1,'L');

        $pdf->SetFont('Arial','',4.5);

        $pdf->cell(190,4,"PROBLEMAS/COMENTARIOS/OBSERVACIONES",1,1,'C',true);
        $pdf->cell(190,4,$datos["datos"][0]['comentarios'],1,1,'C');
        $pdf->cell(190,4,"INOPERATIVIDAD/IMPRODUCTIVIDAD",1,1,'C',true);

        $pdf->cell(30,4,"TOTAL HORAS INOPERATIVAS","L",0,'L');
        $pdf->cell(20,4,$datos["datos"][0]['totalhorasinoperativas'],"B",0,'C');
        $pdf->cell(50,4,"HORARIO INOPERATIVO/INPRODUCTIVO(desde/hasta)",0,0,'L');
        $pdf->cell(70,4,$datos["datos"][0]['horarioinoperativo'],"B",0,'L');
        $pdf->cell(20,4,"","R",1,'C');

        $pdf->SetFont('ZapfDingbats','',7);
        $datos["datos"][0]['adversidadclimatica'] === "1" ? $pdf->cell(4,4,chr(110),"L",0,'C') : $pdf->cell(4,4,chr(111),"L",0,'C');
        $pdf->SetFont('Arial','',4.5);
        $pdf->cell(44,4,"ADVERSIDAD CLIMATICA",0,0,'L');
        $pdf->SetFont('ZapfDingbats','',7);
        $datos["datos"][0]['faltafirma'] === "1" ? $pdf->cell(4,4,chr(110),0,0,'C') : $pdf->cell(4,4,chr(111),0,0,'C');
        $pdf->SetFont('Arial','',4.5);
        $pdf->cell(44,4,"FALTA FIRMA DE TRABAJO",0,0,'L');
        $pdf->SetFont('ZapfDingbats','',7);
        $datos["datos"][0]['faltaliberacion'] === "1" ? $pdf->cell(4,4,chr(110),0,0,'C') : $pdf->cell(4,4,chr(111),0,0,'C');
        $pdf->SetFont('Arial','',4.5);
        $pdf->cell(44,4,"FALTA LIBERACION DE AREA DE TRABAJO",0,0,'L');
        $pdf->SetFont('ZapfDingbats','',7);
        $datos["datos"][0]['faltaprocedimiento'] === "1" ? $pdf->cell(4,4,chr(110),0,0,'C') : $pdf->cell(4,4,chr(111),0,0,'C');
        $pdf->SetFont('Arial','',4.5);
        $pdf->cell(42,4,"FALTA DE PROCEDIMIENTO OPERATICO","R",1,'L');
        $pdf->SetFont('ZapfDingbats','',7);
        $datos["datos"][0]['fallaequipo'] === "1" ? $pdf->cell(4,4,chr(110),"L",0,'C') : $pdf->cell(4,4,chr(111),"L",0,'C');
        $pdf->SetFont('Arial','',4.5);
        $pdf->cell(44,4,"FALTA/FALLA DE EQUIPO/MAQUINARIA",0,0,'L');
        $pdf->SetFont('ZapfDingbats','',7);
        $datos["datos"][0]['faltamateriales'] === "1" ? $pdf->cell(4,4,chr(110),0,0,'C') : $pdf->cell(4,4,chr(111),0,0,'C');
        $pdf->SetFont('Arial','',4.5);
        $pdf->cell(44,4,"FALTA DE MATERIALES",0,0,'L');
        $pdf->SetFont('ZapfDingbats','',7);
        $datos["datos"][0]['parogremial'] === "1" ? $pdf->cell(4,4,chr(110),0,0,'C') : $pdf->cell(4,4,chr(111),0,0,'C');
        $pdf->SetFont('Arial','',4.5);
        $pdf->cell(44,4,"PARO GREMIAL",0,0,'L');
        $pdf->SetFont('ZapfDingbats','',7);
        $datos["datos"][0]['otro'] === "1" ? $pdf->cell(4,4,chr(110),0,0,'C') : $pdf->cell(4,4,chr(111),0,0,'C');
        $pdf->SetFont('Arial','',4.5);
        $pdf->cell(42,4,"OTRO:","R",1,'L');

        $pdf->cell(190,4,"HSE",1,1,'C',true);
        $pdf->cell(25,4,"CHARLA DE SEGURIDAD","L",0,'L');
        $pdf->SetFont('ZapfDingbats','',7);
        $datos["datos"][0]['charlaseguridad'] === "1" ? $pdf->cell(4,4,chr(108),0,0,'C') : $pdf->cell(4,4,chr(109),0,0,'C');
        $pdf->SetFont('Arial','',4.5);
        $pdf->cell(4,4,"Si",0,0,'L');
        $pdf->SetFont('ZapfDingbats','',7);
        $datos["datos"][0]['charlaseguridad'] === "2" ? $pdf->cell(4,4,chr(108),0,0,'C') : $pdf->cell(4,4,chr(109),0,0,'C');
        $pdf->SetFont('Arial','',4.5);
        $pdf->cell(20,4,"No",0,0,'L');

        $pdf->cell(25,4,"EPP COMPLETO",0,0,'L');
        $pdf->SetFont('ZapfDingbats','',7);
        $datos["datos"][0]['eppcompleto'] === "1" ? $pdf->cell(4,4,chr(108),0,0,'C') : $pdf->cell(4,4,chr(109),0,0,'C');
        $pdf->SetFont('Arial','',4.5);
        $pdf->cell(4,4,"Si",0,0,'L');
        $pdf->SetFont('ZapfDingbats','',7);
        $datos["datos"][0]['eppcompleto'] === "2" ? $pdf->cell(4,4,chr(108),0,0,'C') : $pdf->cell(4,4,chr(109),0,0,'C');
        $pdf->SetFont('Arial','',4.5);
        $pdf->cell(20,4,"No",0,0,'L');

        $pdf->cell(44,4,"PERMISO DE TRABAJO/ANALSIS DE RIESGOS",0,0,'L');
        $pdf->SetFont('ZapfDingbats','',7);
        $datos["datos"][0]['permisotrabajo'] === "1" ? $pdf->cell(4,4,chr(108),0,0,'C') : $pdf->cell(4,4,chr(109),0,0,'C');
        $pdf->SetFont('Arial','',4.5);
        $pdf->cell(4,4,"Si",0,0,'L');
        $pdf->SetFont('ZapfDingbats','',7);
        $datos["datos"][0]['permisotrabajo'] === "2" ? $pdf->cell(4,4,chr(108),0,0,'C') : $pdf->cell(4,4,chr(109),0,0,'C');
        $pdf->SetFont('Arial','',4.5);
        $pdf->cell(20,4,"No","R",1,'L');


        $pdf->cell(190,4,"SEPCON",1,1,'C',true);
        $pdf->SetFont('Arial','B',4.5);
        $pdf->cell(63.3,4,"ENCARGADO DE LA ACTIVIDAD","LB",0,'C');
        $pdf->cell(63.3,4,"JEFATURA DE OBRA","RLB",0,'C');
        $pdf->cell(63.5,4,"SUPERVISION DEL CLIENTE","RB",1,'C');

        $posX = $pdf->getX();
        $posY = $pdf->getY();

        for ($i=0; $i < 4; $i++) { 
            $pdf->cell(63.3,4,"","L",0,'C');
            $pdf->cell(63.3,4,"","RL",0,'C');
            $pdf->cell(63.5,4,"","R",1,'C');
        }

        $tipo = strtolower($datos['datos'][0]['tipo']);

        $firma_encargado = is_null($datos['datos'][0]['firmaencargado']) ? "":$tipo."_".$indice."_".$datos['datos'][0]['firmaencargado'].".png";
        $firma_jefatura = is_null($datos['datos'][0]['jefaturaobra']) ?  "":$tipo."_".$indice."_".$datos['datos'][0]['jefaturaobra'].".png";
        $firma_supervisor = is_null($datos['datos'][0]['supervision']) ? "":$tipo."_".$indice."_".$datos['datos'][0]['supervision'].".png";

        if ($firma_encargado !== ""){
            $pdf->Image("../documentos/firmas/".$firma_encargado,$posX+15,$posY+3,50);
        }

        if  ($firma_jefatura !== ""){
            $pdf->Image("../documentos/firmas/".$firma_jefatura,$posX+85,$posY+3,50);
        }

        if ($firma_supervisor !== ""){
            $pdf->Image("../documentos/firmas/".$firma_supervisor,$posX+145,$posY+3,50);
        }

        $pdf->cell(63.3,4,"","LB",0,'C');
        $pdf->cell(63.3,4,"","RLB",0,'C');
        $pdf->cell(63.5,4,"","RB",1,'C');

        $file = $indice.".pdf";
        $filename = "../documentos/pdf/emitidos/".$file;

        $pdf->Output($filename,'F');

        return array('archivo'=>$file,"firma_encargado"=>$firma_encargado);
    }

    function diaSemana($fecha){
        setlocale(LC_TIME, 'es_ES');

        $f = explode('/',$fecha);
        $dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
        
        return strtoupper($dias[jddayofweek (cal_to_jd(CAL_GREGORIAN, date($f[1]),date($f[0]),date($f[2])) , 0 )-1]);
    }
?>