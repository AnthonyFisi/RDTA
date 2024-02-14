<?php
    $random = rand(0,999999);

    //require_once('inc/consultar.inc.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Control de Actividades -- Sepcon</title>

    <link rel="stylesheet" href="css/main.css?v<?php echo $random; ?>">
    <link rel="stylesheet" href="css/loader.css">
</head>
<body>
    <div class="modal" id="espera">
        <div class="modal__body">
            <div class="loader"></div>
            <p>Espere...</p>
        </div>
    </div>
    <div class="barra_derecha">
        <h3>Seleccionar</h3>
        <table id="select_table">
            <thead>
                <tr>
                    <th>Nro</th>
                    <th>Descripcion/Nombre</th>
                </tr>
            </thead>
            <tbody class="select_table_body">
                
            </tbody>
        </table>
    </div>
    <div class="barra_derecha_responsables">
        <h3>Seleccionar</h3>
        <table id="select_table_responsables">
            <thead>
                <tr>
                    <th>Nro</th>
                    <th>Descripcion/Nombre</th>
                    <th>Tipo Firma</th>
                </tr>
            </thead>
            <tbody class="select_table_body_responsables">
                
            </tbody>
        </table>
    </div>
    <div class="modal_mensaje msj_info" id="mensaje__sistema">
        <span id="mensaje_texto"></span>
    </div>
    <div class="modal oculto" id="modal__actividades">
        <div class="modal__body">
            <div class="modal__body__work">
                <input type="hidden" name="codigo_etapa" id="codigo_etapa">
                <input type="hidden" name="codigo_fase" id="codigo_fase">
                <input type="hidden" name="codigo_zona" id="codigo_zona">
                <input type="hidden" name="codigo_activo" id="codigo_activo">

                <div class="dialog__titulo">
                    <h3>Actividades</h3>
                    <a href="#" class="close__dialog" title="cerrar">
                        <svg xmlns="http://www.w3.org/2000/svg" height="32" width="32" class="sin__eventos" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path fill="#e8e8e8" d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"/></svg>
                    </a>
                </div>
                <div class="dialogo__cuerpo">
                    <div class="dialog__data">
                        <section class="dialog_section" class="section__click__option">
                            <label for="etapa" class="section__click__label">Etapa :</label>
                            <input type="text" name="etapa" id="etapa" class="section__click__input">
                            <a href="buscar_etapa" title="Buscar" class="section__click__option">
                                <svg xmlns="http://www.w3.org/2000/svg" class="sin__eventos" height="24" width="24" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                            </a>
                            <a href="agregar_etapa" title="Agregar" class="section__click__option">
                                <svg xmlns="http://www.w3.org/2000/svg" class="sin__eventos" height="24" width="24" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>
                            </a>
                        </section>
                        <section class="dialog_section">
                            <label for="fase" class="section__click__label">Fase :</label>
                            <input type="text" name="fase" id="fase" class="section__click__input">
                            <a href="buscar_fase" title="Buscar" class="section__click__option">
                                <svg xmlns="http://www.w3.org/2000/svg" class="sin__eventos" height="24" width="24" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                            </a>
                            <a href="agregar_fase" title="Agregar" class="section__click__option">
                                <svg xmlns="http://www.w3.org/2000/svg" class="sin__eventos" height="24" width="24" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>
                            </a>
                        </section>
                        <section class="dialog_section">
                            <label for="zona" class="section__click__label">Zona :</label>
                            <input type="text" name="zona" id="zona" class="section__click__input">
                            <a href="buscar_zona" title="Buscar" class="section__click__option">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                            </a>
                            <a href="agregar_zona" title="Agregar" class="section__click__option">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>
                            </a>
                        </section>
                    </div>
                    <div class="dialog__table_options">
                        <div>
                            <a href="primer_nivel" title="Agregar Primer Nivel" class="table__click__option ">
                                <svg xmlns="http://www.w3.org/2000/svg" height="32" width="32" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M40 48C26.7 48 16 58.7 16 72v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V72c0-13.3-10.7-24-24-24H40zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zM16 232v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V232c0-13.3-10.7-24-24-24H40c-13.3 0-24 10.7-24 24zM40 368c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V392c0-13.3-10.7-24-24-24H40z"/></svg>
                            </a>
                        </div>
                        <div>
                            <a href="grabar_actividades" title="Grabar Actividades" class="table__click__option">
                                <svg xmlns="http://www.w3.org/2000/svg" height="32" width="32" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M433.9 129.9l-83.9-83.9A48 48 0 0 0 316.1 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V163.9a48 48 0 0 0 -14.1-33.9zM224 416c-35.3 0-64-28.7-64-64 0-35.3 28.7-64 64-64s64 28.7 64 64c0 35.3-28.7 64-64 64zm96-304.5V212c0 6.6-5.4 12-12 12H76c-6.6 0-12-5.4-12-12V108c0-6.6 5.4-12 12-12h228.5c3.2 0 6.2 1.3 8.5 3.5l3.5 3.5A12 12 0 0 1 320 111.5z"/></svg>
                            </a>
                        </div>
                    </div>
                    <table id="dialog__table_id" class="dialog__table">
                        <thead class="dialog__table_head">
                            <tr class="dialog__table__tr">
                                <th width="5%">#</th>
                                <th>Descripcion</th>
                                <th width="5%">...</th>
                            </tr>
                        </thead>
                        <tbody id="dialog__table_body">
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal oculto" id="modal__responsables">
        <div class="modal__body">
            <div class="modal__body__work">
                <input type="hidden" name="codigo_etapa_responsable" id="codigo_etapa_responsable">
                <input type="hidden" name="codigo_fase_responsable" id="codigo_fase_responsable">
                <input type="hidden" name="codigo_zona_responsable" id="codigo_zona_responsable">
                <input type="hidden" name="codigo_activo_responsable" id="codigo_activo_responsable">
                <input type="hidden" name="codigo_tipo_responsable" id="codigo_tipo_responsable">

                <div class="dialog__titulo">
                    <h3>Responsables</h3>
                    <a href="#" class="close__dialog__personal" title="cerrar">
                        <svg xmlns="http://www.w3.org/2000/svg" height="32" width="32" class="sin__eventos" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path fill="#e8e8e8" d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"/></svg>
                    </a>
                </div>
                <div class="dialogo__cuerpo">
                    <div class="dialog__data">
                        <section class="dialog_section" class="section__click__option">
                            <label for="nro_doc" class="section__click__label">Documento :</label>
                            <input type="text" name="nro_doc" id="nro_doc" class="section__click__input">
                            <a href="buscar_nrodoc" title="Buscar" class="section__click__option">
                                <svg xmlns="http://www.w3.org/2000/svg" class="sin__eventos" height="24" width="24" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                            </a>
                        </section>
                        <section class="dialog_section">
                            <label for="nombres" class="section__click__label">Nombres :</label>
                            <input type="text" name="nombres" id="nombres" class="section__click__input">
                        </section>
                        <section class="dialog_section">
                            <label for="responsable_ubicacion" class="section__click__label">Ubicacion :</label>
                            <select name="responsable_ubicacion" id="responsable_ubicacion" class="select_combo">
                                <option value="-1">Seleccione opcion</option>
                                <option value="18">MALVINAS</option>
                            </select>
                        </section>
                        <section class="dialog_section">
                            <label for="responsable_fase" class="section__click__label">Fase/Area :</label>
                            <select name="responsable_fase" id="responsable_fase" class="select_combo">
                                <option value="-1">Seleccione opcion</option>
                            </select>
                        </section>
                        <section class="dialog_section">
                            <label for="tipo" class="section__click__label" >Tipo :</label>
                            <select name="tipo" id="tipo" class="select_combo">
                                <option value="-1">Seleccione opcion</option>
                                <option value="22">SUPERVISOR</option>
                                <option value="23">JEFATURA DE OBRA</option>
                                <option value="24">ENCARGADO DE SUPERVISION</option>
                            </select>
                        </section>
                    </div>
                </div>
                <div class="dialogo__opciones">
                    <button type="button" class="btn_grabar_responsables">Grabar Datos</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal oculto" id="rda">
        <div class="modal__body">
            <div class="modal__body__work">
                <a href="close_rda" class="close_button close_rda">X</a>
                <form method="post" id="rdta_form">
                    <input type="hidden" name="codigo_rda" id="codigo_rda">
                    
                    <div class="rtda__header">
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
                                <input type="text" name="cliente" id="cliente" readonly>
                            </div>
                            <div>
                                <label for="proyecto">PROYECTO/OBRA</label>
                                <input type="text" name="proyecto" id="proyecto" readonly>
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
                    </div>
                    <div class="data1">
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
                                <div><span><input type="text" name="ubicacion" id="ubicacion" readonly style="border:none;"></span>
                                    <span></span>
                                    <span></span>
                                </div>
                                <div><span></span><span></span><span></span></div>
                                <div><span></span><span></span><span></span></div>
                                <div><span></span><span></span><span></span></div>
                            </div>
                        </div>
                        <div class="fases">
                            <h3>FACES DEL TRABAJO</h3>
                            <div class="section3">
                                <div>
                                    <span><input type="checkbox" name="chkSupervicion" id="chkSupervicion"></span>
                                    <span>SUPERVICION Y CONTROL</span>
                                    <span><input type="checkbox" name="chkTrabajos" id="chkTrabajos"></span>
                                    <span>TRABAJOS GENERALES</span>
                                    <span><input type="checkbox" name="chkaMmtto" id="chkaMmtto"></span>
                                    <span>MANTENIMIENTOS DE EQUIPOS</span>
                                </div>
                                <div>
                                    <span><input type="checkbox" name="chkObras" id="chkObras"></span>
                                    <span>OBRAS CIVILES</span>
                                    <span><input type="checkbox" name="chkEstructuras" id="chkEstructuras"></span>
                                    <span>MECÁNICA DE ESTRUCTURAS</span>
                                    <span><input type="checkbox" name="chkPiping" id="chkPiping"></span>
                                    <span>MECÁNICA PIPING</span>
                                </div>
                                <div>
                                    <span><input type="checkbox" name="chkElectricidad" id="chkElectricidad"></span>
                                    <span>ELÉCTRICIDAD/INSTRUMENTACION</span>
                                    <span><input type="checkbox" name="chkIngenieria" id="chkIngenieria"></span>
                                    <span>INGENIERÍA</span>
                                    <span><input type="checkbox" name="chkOtro" id="chkOtro"></span>
                                    <span>OTRO:Campamento</span>
                                </div>
                                <div>
                                    <span>SUB-FASE</span>
                                    <span><input type="text" name="rdtafase" id="rdtafase" readonly style="border:none;"></span>
                                </div>
                            </div>
                        </div>
                        <div class="fecha">
                            <h3>FECHA</h3>
                            <div class="section4">
                                <div><span>DIA</span><span>MES</span><span>AÑO</span></div>
                                <div>
                                    <span id="rtdadia"></span>
                                    <span id="rtdames"></span>
                                    <span id="rtdanio"></span>
                                </div>
                                <div><span>Día de la semana</span></div>
                                <div>
                                    <span id="diasemana"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="actividades">
                        <table id="tabla_actividades">
                            <caption>
                                DESCRIPCION DE LOS TRABAJOS
                            </caption>
                            <thead>
                                <tr>
                                    <th>Nro.</th>
                                    <th>Actividad</th>
                                </tr>
                            </thead>
                            <tbody id="tabla_actividades_body">
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="data2">
                        <div>
                            <table id="tabla_personal">
                                <caption>
                                    PERSONAL
                                </caption>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NOMBRES Y APELLIDOS</th>
                                        <th>CARGO</th>
                                        <th>ACT</th>
                                        <th>H/H</th>
                                        <th>SB</th>
                                        <th>INOP</th>
                                    </tr>
                                </thead>
                                <tbody id="tabla_personal_body"> 
                                   
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <div>
                                <table id="tabla_equipos">
                                    <caption>
                                        EQUIPOS
                                    </caption>
                                    <thead>
                                        <tr>
                                            <th>CODIGO Y DESCRIPCION</th>
                                            <th>ACT</th>
                                            <th>H/E</th>
                                            <th>OP</th>
                                            <th>INO</th>
                                            <th>SB</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla_equipos_body">
                                        
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <table id="tabla_materiales">
                                    <caption>
                                        MATERIALES UTILIZADOS
                                    </caption>
                                    <thead>
                                        <tr>
                                            <th>CODIGO Y DESCRIPCION</th>
                                            <th>ACT</th>
                                            <th>UND</th>
                                            <th>CANT</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla_materiales_body">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="leyenda">
                        <span>REFERENCIA : ACT = ACTIVIDAD | D/D = DE DESCANSO | SB = STAND BY | OP = OPERATIVO | INO = INOPERATIVO</span>
                    </div>
                    <div class="comentarios">
                        <h3>PROBLEMAS/COMENTARIO/OBSERVACIONES</h3>
                        <textarea name="observaciones" id="observaciones"></textarea>
                    </div>
                    <div class="inoperatividad">
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
                            <span><input type="checkbox" name="chkOtro" id="chkOtro"></span>
                            <span>OTRO : </span>
                        </div>
                    </div>
                    <div class="hse">
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
                    </div>
                    <div class="sepcon">
                        <h3>SEPCON</h3>
                        <div>
                            <div class="cargo_descripcion">
                                <h5>ENCARGADO DE LA ACTIVIDAD</h5>
                                <img src="" alt="" id="img_encargado" class="firmas">
                            </div>
                            <div class="cargo_descripcion">
                                <h5>JEFATURA DE OBRA</h5>
                                <img src="" alt="" id="img_jefatura" class="firmas">
                            </div>
                            <div class="cargo_descripcion">
                                <h5>SUPERVISIÓN DEL CLIENTE</h5>
                                <img src="" alt="" id="img_supervision" class="firmas" >
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal oculto" id="pdf_view">
        <div class="modal__body">
            <div class="modal__body__work">
                <a href="close_preview" class="close_button close_preview">X</a>
                <div class="preview">
                    <iframe src="" class="preview__pdf__document" id="iframe_preview"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="wrap">
        <div class="wrap__header">
            <div class="wrap__header__logo">
                <img src="img/logo.png" alt="">
            </div>
            <div class="wrap__header_menu">
                <div class="menu ">
                    <a href="#" class="menu_icon">
                        <span class="sin__eventos">
                            <svg xmlns="http://www.w3.org/2000/svg" height="38" width="36" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path fill="#72767e" d="M16 132h416c8.8 0 16-7.2 16-16V76c0-8.8-7.2-16-16-16H16C7.2 60 0 67.2 0 76v40c0 8.8 7.2 16 16 16zm0 160h416c8.8 0 16-7.2 16-16v-40c0-8.8-7.2-16-16-16H16c-8.8 0-16 7.2-16 16v40c0 8.8 7.2 16 16 16zm0 160h416c8.8 0 16-7.2 16-16v-40c0-8.8-7.2-16-16-16H16c-8.8 0-16 7.2-16 16v40c0 8.8 7.2 16 16 16z"/></svg>
                        </span>
                    </a>
                    <ul class="menu__main oculto">
                        <li><a href="actividades" class="nav__link">Actividades</a></li>
                        <li><a class="nav__link">Ubicaciones</a></li>
                        <li><a class="nav__link">Clientes</a></li>
                        <li><a class="nav__link">Fases</a></li>
                        <hr>
                        <li><a href="responsables" class="nav__link">Responsables</a></li>
                        <hr>
                        <li><a  href="printPdf" class="nav__link">Imprimir RTDA</a></li>
                    </ul>
                </div>
                
            </div>
        </div>
        <div class="wrap__body">
            <table id="document_list">
                <thead class="document__list__thead">
                    <tr>
                        <th>Nro.</th>
                        <th>Fecha Emisión</th>
                        <th>Ubicación</th>
                        <th>Cliente</th>
                        <th>Proyecto/Obra</th>
                        <th>Sub Fase</th>
                        <th>Tipo</th>
                        <th>Avance</th>
                        <th>PDF</th>
                    </tr>
                </thead>
                <tbody id="document__list__body">
                    
                </tbody>
            </table>
        </div>
    </div>

    <script src="js/main.js?v<?php echo $random; ?>" type="module"></script>
</body>
</html>