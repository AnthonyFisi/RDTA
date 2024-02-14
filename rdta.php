<?php
    require_once('inc/hoja.inc.php');

    $clientes = getClientes($pdo);
    $ubicaciones = getLocate($pdo);

    $api = file_get_contents('http://sicalsepcon.net/api/proyectos/api_proyectos.php');
    $proyectos = json_decode($api);
    //$proyectos = array();

    $fechaActual = date('d/m/Y');
    $fechaSeparada = explode('/', $fechaActual);

    $diaSemana = diaSemana($fechaActual);

    $random = rand(0,999999);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/_hoja.css?v<?php echo $random; ?>">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/_modal.css?v<?php echo $random; ?>">
    <title>Reporte de Diario de Trabajo Adicional - Hoja Preliminar</title>
</head>
<body>
    <div class="modal oculto" id="pregunta">
        <h1>Pregunta</h1>
    </div>
    <div class="modal oculto" id="esperar">
        <h1>esperar</h1>
    </div>
    <div class="modal oculto" id="actividades">
        <div class="modal__body">
            <div class="modal__body__list">
                <div class="modal__body__list__title">
                    <h1>Actividades</h1>
                    <a href="#" class="close_activity"><i class="fas fa-times-circle"></i></a>
                </div>
                <div class="modal__body__list__body">
                    <input type="search" name="buscar" id="buscar__actividad" placeholder="Buscar..." class="busqueda_actividad">
                    <div class="container__table">
                        <table class="table_list_act">
                            <thead>
                                <tr>
                                    <th width="5%">Nro.</th>
                                    <th>Actividad</th>
                                </tr>
                            </thead>
                            <tbody id="table_list_act_body">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal oculto" id="personal">
        <div class="modal__body">
            <div class="modal__body__list">
                <div class="modal__body__list__title">
                    <h1>Personal</h1>
                    <a href="#" class="close_personal"><i class="fas fa-times-circle"></i></a>
                </div>
                <div class="modal__body__list__body">
                    <input type="search" name="buscar" id="buscar" placeholder="Buscar...">
                    <div class="container__table">
                        <table class="table_list_pers">
                            <thead>
                                <tr>
                                    <th width="5%">Nro. Doc</th>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tbody id="table_list_pers_body">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal oculto" id="equipos">
        <div class="modal__body">
            <div class="modal__body__list">
                <div class="modal__body__list__title">
                    <h1>Equipos</h1>
                    <a href="#" class="close_equipos"><i class="fas fa-times-circle"></i></a>
                </div>
                <div class="modal__body__list__body">
                    <input type="search" name="buscar" id="buscar" placeholder="Buscar...">
                    <div class="container__table">
                        <table class="table_list_equ">
                            <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Descripcion</th>
                                </tr>
                            </thead>
                            <tbody id="table_list_equ_body">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal oculto" id="materiales">
        <div class="modal__body">
            <div class="modal__body__list">
                <div class="modal__body__list__title">
                    <h1>Materiales</h1>
                    <a href="#" class="close_material"><i class="fas fa-times-circle"></i></a>
                </div>
                <div class="modal__body__list__body">
                    <input type="search" name="buscar" id="buscar" placeholder="Buscar...">
                    <div class="container__table">
                        <table class="table_list_mat">
                            <thead>
                                <tr>
                                    <th width="5%">Nro. Doc</th>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tbody id="table_list_mat_body">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="modal__login">
        <div class="modal__body">
            <div class="modal__body__login">
                <div class="dialog__titulo">
                    <h3>Registro</h3>
                </div>
                <div class="dialogo__cuerpo_login">
                    <h3>Nro. Documento</h3>
                    <input type="text" name="login_doc" id="login_doc">
                    <button type="submit" class="button__login">Ingresar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="main">
        <div class="sheet">
            <form method="post" id="sheet_form">
                <section class="sheet_form_header">
                    <div class="logo">
                        <img src="img/logo.png" alt="">
                        <p class="texto_centro">SEPCON S.A.C.</p>
                    </div>
                    <div class="titulo_rda">
                        <div>
                            <p>REPORTE DIARIO DE TRABAJO ADICIONAL</p>
                            <p>(R.D.T.A)</p> 
                        </div>
                        <div>
                            <label for="cliente">CLIENTE:</label>
                            <select name="cliente" id="cliente" class="datos_hoja">
                                <?php foreach($clientes as $cliente){ ?>
                                    <option value="<?php echo $cliente['idreg'] ?>"><?php echo $cliente['cdetalle']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div>
                            <label for="proyecto">PROYECTO/OBRA</label>
                            <select name="proyecto" id="proyecto" class="datos_hoja">
                                <?php foreach($proyectos->data as $proyecto){ ?>
                                    <option value="<?php echo $proyecto->id ?>"><?php echo $proyecto->nombre?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="sgi_code">
                        <div>
                            <p>PMAL-300-PC-X-001-Prot 09</p>
                            <p>Revision : 0</p>
                            <p>Emision: 30/01/2021</p>
                            <p>Página: 1 de 1</p>
                        </div>
                        <p class="texto_centro">Anexo 09</p>
                    </div>
                </section>
                <section class="data1">
                        <div class="clima">
                            <h3>CLIMA</h3>
                            <div class="section1">
                                <div><span></span><span>AM</span><span>PM</span></div>
                                <div>
                                    <span>SOLEADO</span>
                                    <span><input type="checkbox" name="chkSoleadoAm" id="chkSoleadoAm"></span>
                                    <span><input type="checkbox" name="chkSoleadoPm" id="chkSoleadoPm"></span>
                                </div>
                                <div>
                                    <span>NUBLADO</span>
                                    <span><input type="checkbox" name="chkNubladoAm" id="chkNubladoAm"></span>
                                    <span><input type="checkbox" name="chkNubladoPm" id="chkNubladoPm"></span>
                                </div>
                                <div>
                                    <span>LLUVIOSO</span>
                                    <span><input type="checkbox" name="chkLluviosoAm" id="chkLluviosoAm"></span>
                                    <span><input type="checkbox" name="chkLluviosoPm" id="chkLluviosoPm"></span>
                                </div>
                            </div>
                        </div>
                        <div class="ubicacion">
                            <h3>UBICACION</h3>
                            <div class="section2">
                                    <select name="ubicacion" id="ubicacion">
                                    <?php foreach($ubicaciones as $ubicacion){ ?>
                                        <option value="<?php echo $ubicacion['idreg'] ?>"><?php echo $ubicacion['descripcion']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="fases">
                            <h3>FACES DEL TRABAJO</h3>
                            <div>
                                <div>
                                    <span>FASE</span>
                                    <select name="fases_trabajo" id="fases_trabajo"> </select>
                                </div>
                                <div>
                                    <span>SUB-FASE</span>
                                    <span><input type="text" name="rdtafase" id="rdtafase"></span>
                                </div>
                            </div>
                        </div>
                        <div class="fecha">
                            <h3>FECHA</h3>
                            <div class="section4">
                                <div><span>DIA</span><span>MES</span><span>AÑO</span></div>
                                <div>
                                    <span id="rtdadia"><?php echo $fechaSeparada[0]?></span>
                                    <span id="rtdames"><?php echo $fechaSeparada[1]?></span>
                                    <span id="rtdanio"><?php echo $fechaSeparada[2]?></span>
                                </div>
                                <div><span>Día de la semana</span></div>
                                <div>
                                    <span id="diasemana"><?php echo $diaSemana?></span>
                                </div>
                            </div>
                        </div>
                </section>
                <section class="actividades">
                    <div>
                    <h4>
                        <span>DESCRIPCION DE LOS TRABAJOS</span>
                        <a href="#" class="add_table_activity"><i class="fas fa-plus"></i></a>
                    </h4>
                    <h5 id="message_actividades"class="error_message" >
                    </h5>
                    <table id="tabla_actividades" class="table_sheet">
                        <thead>
                            <tr>
                                <th width="5%">Nro.</th>
                                <th width="65%">Actividad</th>
                                <th width="15%">Cantidad</th>
                                <th width="15%">Unidad</th>
                                <th width="5%">...</th>
                            </tr>
                        </thead>
                        <tbody id="tabla_actividades_body">
                            
                        </tbody>
                    </table>

                    </div>
                </section>
                <section class="data2">
                    <div>
                        <h4>
                            <span>PERSONAL</span>
                            <a href="#" class="add_table_personal"><i class="fas fa-plus"></i></a>
                        </h4>
                        <h5 id="message_personal" class="error_message" >
                        </h5>
                        <table id="tabla_personal" class="table_sheet">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="35%">NOMBRES Y APELLIDOS</th>
                                    <th width="35%">CARGO</th>
                                    <th width="5%">ACT</th>
                                    <th width="5%">H/H</th>
                                    <th width="5%">H/E</th>
                                    <th width="5%">SB</th>
                                    <th width="5%">INOP</th>
                                    <th width="5%">...</th>
                                </tr>
                            </thead>
                            <tbody id="tabla_personal_body"> 
                               
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <div>
                            <h4>
                                <span>EQUIPOS</span>
                                <a href="#" class="add_table_equips"><i class="fas fa-plus"></i></a>
                            </h4>
                            <h5 id="message_equipos" class="error_message" >
                            </h5>
                            <table id="tabla_equipos" class="table_sheet">
                                <thead>
                                    <tr>
                                        <th width="50%">CODIGO Y DESCRIPCION</th>
                                        <th width="10%">ACT</th>
                                        <th width="10%">H/E</th>
                                        <th width="10%">OP</th>
                                        <th width="10%">INO</th>
                                        <th width="10%">SB</th>
                                        <th width="5%">...</th>
                                    </tr>
                                </thead>
                                <tbody id="tabla_equipos_body">
                                    
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <h4>
                                <span>MATERIALES UTILIZADOS</span>
                                <a href="#" class="add_table_materials"><i class="fas fa-plus"></i></a>
                            </h4>
                            <h5 id="message_materiales" class="error_message" >
                            </h5>
                            <table id="tabla_materiales" class="table_sheet">
                                <thead>
                                    <tr>
                                        <th width="50%">CODIGO Y DESCRIPCION</th>
                                        <th width="10%">ACT</th>
                                        <th width="10%">UND</th>
                                        <th width="10%">CANT</th>
                                        <th width="5%">...</th>
                                    </tr>
                                </thead>
                                <tbody id="tabla_materiales_body">
                                    
                                </tbody>
                            </table>
                        </div>
                        </div>
                </section>
                <section class="leyenda">
                        <span>REFERENCIA : ACT = ACTIVIDAD | D/D = DE DESCANSO | SB = STAND BY | OP = OPERATIVO | INO = INOPERATIVO</span>
                </section>
                <section class="comentarios">
                    <h3>PROBLEMAS/COMENTARIO/OBSERVACIONES</h3>
                    <textarea name="observaciones" id="observaciones"></textarea>
                </section>
                <section class="inoperatividad">
                    <h3>INOPERATIVIDAD/IMPRODUCTIVIDAD</h3>
                    <div>
                        <span>TOTAL DE HORAS INOPERATIVAS</span>
                        <span><input type="text" name="horasInoperativas" id="horasInoperativas" style="border:none;border-bottom:1px solid #000000"></span>
                        <span>HORARIO INOPERATIVO/INPRODUCTIVO(desde/hasta)</span>
                        <span><input type="text" name="horarioInoperativo" id="horarioInoperativo" style="border:none;border-bottom:1px solid #000000"></span>
                    </div>
                    <div>
                        <span><input type="checkbox" name="chkAdversidad" id="chkAdversidad"></span>
                        <span>ADVERSIDAD CLIMATICA</span>
                        <span><input type="checkbox" name="chkFirma" id="chkFirma"></span>
                        <span>FALTA FIRMA DE TRABAJO</span>
                        <span><input type="checkbox" name="chkLiberacion" id="chkLiberacion"></span>
                        <span>FALTA LIBERACIÓN DE ÁREA DE TRABAJO</span>
                        <span><input type="checkbox" name="chkProcedimiento" id="chkProcedimiento"></span>
                        <span>FALTA DE PROCEDIMIENTO OPERATIVO</span>
                    </div>
                    <div>
                        <span><input type="checkbox" name="chkFallaEquipo" id="chkFallaEquipo"></span>
                        <span>FALTA/FALLA DE EQUIPO/MAQUINARIA</span>
                        <span><input type="checkbox" name="chkFaltaMateriales" id="chkFaltaMateriales"></span>
                        <span>FALTA DE MATERIALES</span>
                        <span><input type="checkbox" name="chkParoGremial" id="chkParoGremial"></span>
                        <span>PARO GREMIAL</span>
                        <span><input type="checkbox" name="chkOtroII" id="chkOtroII"></span>
                        <span>OTRO : </span>
                    </div>
                </section>
                <section class="hse">
                    <h3>HSE</h3>
                    <div>
                        <div>
                            <label>CHARLA DE SEGURIDAD</label>
                            <input type="radio" name="charla" id="charla_si" value="1" checked="checked">
                            <label for="charla_si">Si</label>
                            <input type="radio" name="charla" id="charla_no" value="2">
                            <label for="charla_no">No</label>
                        </div>
                        <div>
                            <label>EPP COMPLETO</label>
                            <input type="radio" name="epp" id="epp_si" value="1">
                            <label for="epp_si">Si</label>
                            <input type="radio" name="epp" id="epp_no" value="2">
                            <label for="epp_no">No</label>
                        </div>
                        <div>
                            <label>PERMISO DE TRABAJO/ANÁLISIS DE RIESGOS</label>
                            <input type="radio" name="permiso" id="permiso_si" value="1">
                            <label for="permiso_si">Si</label>
                            <input type="radio" name="permiso" id="permiso_no" value="2">
                            <label for="permiso_no">No</label>
                        </div>
                    </div>
                </section>
                <section class="options">
                    <button type="button" class="button__click_save"><i class="fas fa-save"></i> Grabar</button>
                    <button type="button" class="button__click_delete"><i class="fas fa-ban"></i> Cancelar</button>
                </section>
            </form>
        </div>
    </div>
    <script src="js/hoja.js?v<?php echo $random; ?>" type="module"></script>
</body>
</html>