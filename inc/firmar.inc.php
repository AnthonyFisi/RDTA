<?php 
    require_once ("connect.inc.php");

    if (isset($_POST)) {
        if ($_POST['funcion'] === "autorizaSepcon") {
            echo json_encode(autorizaSepcon($pdo,$_POST['tipo'],$_POST['documento'],$_POST['rtda'])); 
        }else if ($_POST['funcion'] === "observaSupervidor") {
            echo json_encode(observaSupervidor($pdo,$_POST['tipo'],$_POST['documento'],$_POST['rtda'],$_POST['comentarios'])); 
        }else if ($_POST['funcion'] === "autorizaSupervision") {
            echo json_encode(autorizaSupervision($pdo,$_POST['tipo'],$_POST['documento'],$_POST['rtda'])); 
        }
    }

    function autorizaSepcon($pdo,$tipo,$documento,$rtda){
        try {
            $respuesta = false;
            $mensaje = "Ya autorizo el documento";

            if ($tipo === "24"){
                $sql = "UPDATE tabla_documento 
                        SET tabla_documento.firmaencargado = ?,
                            tabla_documento.avance = ? 
                        WHERE tabla_documento.iddoc = ? 
                        LIMIT 1";
                $avance = 25;
            }else {
                $sql = "UPDATE tabla_documento 
                        SET tabla_documento.jefaturaobra = ?,
                            tabla_documento.avance = ? 
                        WHERE tabla_documento.iddoc = ? 
                        LIMIT 1";
                $avance = 50;     
            }
               

            $statement = $pdo->prepare($sql);
            $statement ->execute(array($documento,$avance,$rtda));
            $rowCount = $statement->rowCount();

            if ($rowCount > 0 ) {
                $respuesta = true;
                $mensaje = "RTDA autorizado";

                if ( array_key_exists('canvas',$_REQUEST) ){
                    $file_name = "rdta_".$rtda."_".$documento;
                    $dir = "../documentos/firmas/";
    
                    $imgData = base64_decode(substr($_REQUEST['canvas'],22));
                    $file = $dir.$file_name.'.png';
    
                    if (file_exists($file)) { unlink($file); }
    
                    $fp = fopen($file, 'w');
                    fwrite($fp, $imgData);
                    fclose($fp);
    
                }
            }

            return array("respuesta" => $respuesta,
            "mensaje"    => $mensaje );

            
        } catch ( PDOException $e) {
            echo "Error: " . $e->getMessage;
            return false;
        }

       
    }

    function autorizaSupervision($pdo,$tipo,$documento,$rtda){
        try {
            $respuesta = false;
            $mensaje = "Ya autorizo el documento";

            $sql = "UPDATE tabla_documento 
                        SET tabla_documento.supervision = ?,
                            tabla_documento.avance = ? 
                        WHERE tabla_documento.iddoc = ? 
                        LIMIT 1";
            $avance = 100;

            $statement = $pdo->prepare($sql);
            $statement ->execute(array($documento,$avance,$rtda));
            $rowCount = $statement->rowCount();

            if ($rowCount > 0 ) {
                $respuesta = true;
                $mensaje = "RTDA autorizado";

                if ( array_key_exists('canvas',$_REQUEST ) ){
                    $file_name = "rdta_".$rtda."_".$documento;
                    $dir = "../documentos/firmas/";
    
                    $imgData = base64_decode(substr($_REQUEST['canvas'],22));
                    $file = $dir.$file_name.'.png';
    
                    if (file_exists($file)) { unlink($file); }
    
                    $fp = fopen($file, 'w');
                    fwrite($fp, $imgData);
                    fclose($fp);
                }
            }

            return array("respuesta" => $respuesta,
                         "mensaje"    => $mensaje );    
        } catch ( PDOException $e) {
            echo "Error: " . $e->getMessage;
            return false;
        }
    }

    function observaSupervidor($pdo,$tipo,$documento,$rtda,$comentarios){
        try {
            $respuesta = false;
            $mensaje = "Documento observado!!!";
            $avance = 75;

            $sql = "UPDATE tabla_documento 
                        SET tabla_documento.supervision = ?,
                            tabla_documento.avance = ?,
                            tabla_documento.comentarios = ?  
                        WHERE tabla_documento.iddoc = ? 
                        LIMIT 1";

            $statement = $pdo->prepare($sql);
            $statement ->execute(array($documento,$avance,$comentarios,$rtda));
            $rowCount = $statement->rowCount();

            if ($rowCount > 0 ) {
                $respuesta = true;
                $mensaje = "RTDA observado";
            }

            return array("respuesta" => $respuesta,
                         "mensaje"    => $mensaje );
            
        } catch ( PDOException $e) {
            echo "Error: " . $e->getMessage;
            return false;
        }
    }
?>