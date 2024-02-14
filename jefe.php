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
</head>
<body>
    <div class="modal_mensaje msj_info" id="mensaje__sistema">
        <span id="mensaje_texto"></span>
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
                            <tbody>
                                
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
                                <tbody>
                                   
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
                                            <th>OP</th>
                                            <th>INO</th>
                                            <th>SB</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
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
                                            <th>OP</th>
                                            <th>INO</th>
                                            <th>SB</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
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
                            </div>
                            <div class="cargo_descripcion">
                                <h5>JEFATURA DE OBRA</h5>
                            </div>
                            <div class="cargo_descripcion">
                                <h5>SUPERVISIÓN DEL CLIENTE</h5>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal" id="modal__login">
        <div class="modal__body">
            <div class="modal__body__login">
                <div class="dialog__titulo">
                    <h3>Login</h3>
                    <a href="#" class="close__dialog" title="cerrar">
                        <svg xmlns="http://www.w3.org/2000/svg" height="32" width="32" class="sin__eventos" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path fill="#e8e8e8" d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"/></svg>
                    </a>
                </div>
                <div class="dialogo__cuerpo_login">
                    <h3>Nro. Documento</h3>
                    <input type="text" name="login_doc" id="login_doc">
                    <button type="submit" class="button__login">Ingresar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="wrap">
        <div class="wrap__header">
            <div class="wrap__header__logo">
                <img src="img/logo.png" alt="">
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
    <script src="js/jefe.js?v<?php echo $random; ?>" type="module"></script>
</body>
</html>