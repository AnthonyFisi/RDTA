import {mostrarMensaje} from "./funciones.js";
import {mostrarSelector} from "./funciones.js";
import {mostrarSelectorResponsables} from "./funciones.js";

(function() {    
    const $d = document;
    const modal_esperar = $d.getElementById("espera");
    const menuList = $d.querySelector(".menu__main");
    const tablaActivity = $d.getElementById("dialog__table_id");
    const tableSelector = $d.getElementById("select_table");
    const selectorBody = tableSelector.querySelector(".select_table_body");
    const barra_derecha = $d.querySelector(".barra_derecha");
    const selectorPersonalBody = tableSelector.querySelector(".select_table_body");
    const barra_derecha_responsables = $d.querySelector(".barra_derecha_responsables");
    const campos_texto = $d.querySelectorAll(".section__click__input");
    const select_combos =  $d.querySelectorAll(".select_combo");
    const tabla_actividades_body = $d.getElementById("tabla_actividades_body");
    const tabla_personal_body = $d.getElementById("tabla_personal_body");
    const tabla_materiales_body = $d.getElementById("tabla_materiales_body");
    const tabla_equipos_body = $d.getElementById("tabla_equipos_body");

    consultarDocumentos();
    
    $d.addEventListener("click",(e)=>{
        e.preventDefault();

        //console.log(e.target);

        if (e.target.matches(".menu_icon")){
            menuList.classList.toggle('oculto');
        }else if (e.target.matches(".nav__link")) {
            menuList.classList.toggle('oculto');
            //seccion para llmar al menu de los modals
            if ( e.target.getAttribute("href") === 'actividades' ) {
                $d.getElementById("modal__actividades").classList.toggle('oculto');
                $d.getElementById("etapa").value = "";
                $d.getElementById("fase").value = "";
                $d.getElementById("zona").value = "";
            }else if ( e.target.getAttribute("href") === 'responsables'){
                $d.getElementById("modal__responsables").classList.toggle('oculto');

                let fases = obtenerFases();

            }else if ( e.target.getAttribute("href") === 'rtda'){
                $d.getElementById("rda").classList.toggle('oculto');
            }else if ( e.target.getAttribute("href") === 'printPdf'){
                let formData = new FormData();

                formData.append('funcion','generarPDF');
                formData.append('registro',19);

                fetch('inc/consultar.inc.php',{
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                })
            }
        }else if (e.target.matches(".close__dialog")) {
            e.target.closest("#modal__actividades").classList.toggle('oculto');
            barra_derecha.style.right = "-100%";
        }else if (e.target.matches(".close__dialog__personal")) {
            e.target.closest("#modal__responsables").classList.toggle('oculto');
            barra_derecha.style.right = "-100%";
            barra_derecha_responsables.style.right = "-100%";

            //limpiar los campos de texto;
            campos_texto.forEach(element => {
                element.value = "";
            })

            select_combos.forEach(element => {
                element.value = -1
            })

        }else if (e.target.matches(".section__click__option")) {
            //seccion para llAmar al menu de los modals
            if ( e.target.getAttribute("href") === 'agregar_etapa' ) {
                try {
                    if ( $d.getElementById("etapa").value === "") throw new Error("Indique el nombre de la etapa");
                    //registra las etapas
                    grabarGeneral('00',$d.getElementById("etapa").value,'grabarGeneral');  
                } catch (error) {
                    mostrarMensaje(error,"msj_error");
                }
            }else if (e.target.getAttribute("href") === "agregar_fase") {
                try {
                    if ( $d.getElementById("fase").value === "") throw new Error("Indique el nombre de la fase");
                    //registra las fases
                    grabarGeneral('01',$d.getElementById("fase").value,'grabarGeneral');  
                } catch (error) {
                    mostrarMensaje(error,"msj_error");
                }
            }else if  (e.target.getAttribute("href") === "agregar_zona"){
                try {
                    if ( $d.getElementById("zona").value === "") throw new Error("Indique el nombre de la zona");
                    //registra las fases
                    grabarGeneral('02',$d.getElementById("zona").value,'grabarGeneral');  
                } catch (error) {
                    mostrarMensaje(error,"msj_error");
                }
            }else if (e.target.getAttribute("href") === "buscar_etapa") {
                mostrarSelector("00","Etapas");
                $d.getElementById("codigo_activo").value = 0;
                verBarraDerecha(barra_derecha);
            }else if (e.target.getAttribute("href") === "buscar_fase") {
                mostrarSelector("01","Fases");
                $d.getElementById("codigo_activo").value = 1;
                verBarraDerecha(barra_derecha);
            }else if (e.target.getAttribute("href") === "buscar_zona") {
                mostrarSelector("02","Zonas");
                $d.getElementById("codigo_activo").value = 2;
                verBarraDerecha(barra_derecha);
            }else if (e.target.getAttribute("href") === "buscar_nrodoc"){
                mostrarSelectorResponsables()
                verBarraDerecha(barra_derecha_responsables);
                return false;
            }
        }else if  (e.target.getAttribute("href") === "primer_nivel"){
            try {
                let row = `<tr data-grabado="0"> 
                                <td><input type="text" class="input_table"></td>
                                <td><input type="text" class="input_table"></td>
                                <td class="texto_centro"><a href="delete" class="delete_activity_level1">X</a></td>
                            </tr>`;
                
                document.getElementById('dialog__table_body').insertRow(-1).outerHTML = row;
            } catch (error) {
                mostrarMensaje(error,"msj_error");
            }
        }else if(e.target.getAttribute("href") === "grabar_actividades") {
            let actividades = itemsList(tablaActivity);

            let formData = new FormData();
            formData.append("etapa",$d.getElementById("codigo_etapa").value);
            formData.append("fase",$d.getElementById("codigo_fase").value);
            formData.append("actividades",JSON.stringify(actividades));
            formData.append("funcion","grabarActividades");

            fetch('inc/grabar.inc.php',{
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                //console.log(data);
            })

        }else if ( e.target.matches(".table_cell_select") ){
            if ( $d.getElementById("codigo_activo").value == 0) {
                $d.getElementById("etapa").value = e.target.parentElement.dataset.descripcion;
                $d.getElementById("codigo_etapa").value = e.target.parentElement.dataset.codigo;
            }else if ( $d.getElementById("codigo_activo").value == 1) {
                $d.getElementById("fase").value = e.target.parentElement.dataset.descripcion;
                $d.getElementById("codigo_fase").value = e.target.parentElement.dataset.codigo;
            }else if ( $d.getElementById("codigo_activo").value == 2) {
                $d.getElementById("zona").value = e.target.parentElement.dataset.descripcion;
                $d.getElementById("codigo_zona").value = e.target.parentElement.dataset.codigo;
            }

            limpiarTabla(selectorBody);
            barra_derecha.style.right = "-100%";
        }else if(e.target.matches(".table_cell_select_responsable")){

            /*retrocede al padre y verifical el contenido dela celda console.log(e.target.parentElement.children[0].innerHTML);*/

            $d.getElementById('nro_doc').value = e.target.parentElement.children[0].innerHTML;
            $d.getElementById('nombres').value = e.target.parentElement.children[1].innerHTML
            $d.getElementById('responsable_ubicacion').value = e.target.parentElement.dataset.ubicacion;
            $d.getElementById('responsable_fase').value = e.target.parentElement.dataset.fase;
            $d.getElementById('tipo').value = e.target.parentElement.dataset.tipo;
        }else if(e.target.matches(".close_rda")){
            $d.getElementById("rdta_form").reset();
            $d.getElementById("rda").classList.toggle('oculto');

            $d.getElementById("chkSoleadoAm").removeAttribute("checked");
            $d.getElementById("chkNubladoAm").removeAttribute("checked");
            $d.getElementById("chkLluviosoAm").removeAttribute("checked");
            $d.getElementById("chkSoleadoPm").removeAttribute("checked");
            $d.getElementById("chkNubladoPm").removeAttribute("checked");
            $d.getElementById("chkLluviosoPm").removeAttribute("checked");

        }else if ( e.target.matches(".table_cell") ){

            /*carga los datos de la tabla*/ 
            let registro = e.target.parentElement.dataset.codigo;
            
            $d.getElementById("rda").classList.toggle('oculto');

            let formData = new FormData();
            formData.append('registro',registro);
            formData.append('funcion',"datosRdta");

            fetch('inc/consultar.inc.php',{
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {

                $d.getElementById("cliente").value = data.datos[0].cliente;
                $d.getElementById("proyecto").value = data.proyecto;

                if ( data.datos[0].climamaniana === "1" ){
                    $d.getElementById("chkSoleadoAm").setAttribute("checked", true);
                }else if ( data.datos[0].climamaniana === "2"){
                    $d.getElementById("chkNubladoAm").setAttribute("checked", true);
                }else if ( data.datos[0].climamaniana === "3") {
                    $d.getElementById("chkLluviosoAm").setAttribute("checked", true);
                }

                if ( data.datos[0].climatarde === "1" ){
                    $d.getElementById("chkSoleadoPm").setAttribute("checked", true);
                }else if ( data.datos[0].climatarde === "2"){
                    $d.getElementById("chkNubladoPm").setAttribute("checked", true);
                }else if ( data.datos[0].climatarde === "3") {
                    $d.getElementById("chkLluviosoPm").setAttribute("checked", true);
                }

                $d.getElementById('ubicacion').value = data.datos[0].ubicacion;
                $d.getElementById('rdtafase').value = data.datos[0].fase;

                let fechaseparada = data.datos[0].fecha.split('/');

                $d.getElementById('rtdadia').textContent = fechaseparada[0];
                $d.getElementById('rtdames').textContent = fechaseparada[1];
                $d.getElementById('rtdanio').textContent = fechaseparada[2];


                let dia = new Date(fechaseparada[2],fechaseparada[1]-1,fechaseparada[0]);

                $d.getElementById('diasemana').textContent = getWeekDay(dia);

                $d.getElementById('observaciones').value = data.datos[0].comentarios;
                $d.getElementById('horasInoperativas').value = data.datos[0].totalhorasinoperativas;
                $d.getElementById('horarioInoperativo').value = data.datos[0].horarioinoperativo;

                marcarCheck($d.getElementById('chkAdversidad'),data.datos[0].adversidadclimatica);
                marcarCheck($d.getElementById('chkFirma'),data.datos[0].faltafirma);
                marcarCheck($d.getElementById('chkLiberacion'),data.datos[0].faltaliberacion);
                marcarCheck($d.getElementById('chkProcedimiento'),data.datos[0].faltaprocedimiento);
                marcarCheck($d.getElementById('chkFallaEquipo'),data.datos[0].fallaequipo);
                marcarCheck($d.getElementById('chkFaltaMateriales'),data.datos[0].faltamateriales);
                marcarCheck($d.getElementById('chkParoGremial'),data.datos[0].parogremial);
                marcarCheck($d.getElementById('chkOtro'),data.datos[0].otro);

                marcarOpciones($d.getElementById('charla_si'),$d.getElementById('charla_no'),data.datos[0].charlaseguridad);
                marcarOpciones($d.getElementById('epp_si'),$d.getElementById('epp_no'),data.datos[0].eppcompleto);
                marcarOpciones($d.getElementById('permiso_si'),$d.getElementById('permiso_no'),data.datos[0].permisotrabajo);

                tabla_actividades_body.innerHTML = "";
                tabla_personal_body.innerHTML = "";
                tabla_materiales_body.innerHTML = "";
                tabla_equipos_body.innerHTML = "";

                let row = "";
                /*ACTIVIDADES*/
                data.actividades.forEach(element => {
                    row = `<tr><td>${element.idact}</td><td>${element.descrip}</td></tr>`;
                    tabla_actividades_body.insertRow(-1).outerHTML = row;
                })

                /*PERSONAL*/
                let item = 1;
                data.personal.forEach(element =>{
                    row = `<tr>
                                <td>${item++}</td>
                                <td>${element.nombres}</td>
                                <td>${element.cargo}</td>
                                <td>${element.actividad}</td>
                                <td>${element.horas}</td>
                                <td></td>
                                <td></td>
                            </tr>`;
                    tabla_personal_body.insertRow(-1).outerHTML = row;
                });

                /*MATERIALES*/
                data.materiales.forEach(element =>{
                    row = `<tr>
                                <td>'.${element.descrip}</td>
                                <td></td>
                                <td>'.${element.unidades}</td>
                                <td>'.${element.cantidad}</td>
                            </tr>`;
                    tabla_materiales_body.insertRow(-1).outerHTML = row;
                });

                /*EQUIPOS*/
                data.equipos.forEach(element =>{
                    row = `<tr>
                                <td>${element.descripcion}</td>
                                <td></td>
                                <td>${element.actividad}</td>
                                <td>${element.operativo}</td>
                                <td>${element.inoperativo}</td>
                                <td>${element.standby}</td>
                            </tr>`;
                    tabla_equipos_body.insertRow(-1).outerHTML = row;
                });

                let firma = "";
                $d.getElementById('img_encargado').src = "";

                if ( data.datos[0].firmaencargado !== null) {
                    firma = "documentos/firmas/rdta_"+data.datos[0].iddoc+"_"+data.datos[0].firmaencargado+".png";
                    $d.getElementById('img_encargado').src = firma;
                }

                if ( data.datos[0].jefaturaobra !== null) {
                    firma = "documentos/firmas/rdta_"+data.datos[0].iddoc+"_"+data.datos[0].jefaturaobra+".png";
                    $d.getElementById('img_jefatura').src = firma;
                }

                if ( data.datos[0].supervision !== null) {
                    firma = "documentos/firmas/rdta_"+data.datos[0].iddoc+"_"+data.datos[0].supervision+".png";
                    $d.getElementById('img_supervision').src = firma;
                }
            })

            return false;
        }else if (e.target.matches('.btn_grabar_responsables')){
            try {

                if ( $d.getElementById('nro_doc').value === '' ) throw new Error('Registre el N° de Documento');
                if ( $d.getElementById('nombres').value === '' ) throw new Error('Registre el nombre del responsable');
                if ( $d.getElementById('responsable_ubicacion').value === '-1' ) throw new Error('Registre la ubicación del responsable');
                if ( $d.getElementById('tipo').value === '-1' ) throw new Error('Registre el tipo de responsable');

                let formData = new FormData();
                formData.append('documento',$d.getElementById('nro_doc').value);
                formData.append('nombres',$d.getElementById('nombres').value);
                formData.append('ubicacion',$d.getElementById('responsable_ubicacion').value);
                formData.append('fase',$d.getElementById('responsable_fase').value);
                formData.append('tipo',$d.getElementById('tipo').value);
                formData.append('funcion','grabarResponsable');

                fetch('inc/grabar.inc.php',{
                    method:'POST',
                    body:formData
                })
                .then(response => response.json)
                .then(data =>{
                    if (data.respuesta) {
                        $d.getElementById('nro_doc').value = '';
                        $d.getElementById('nombres').value = ''
                        $d.getElementById('responsable_ubicacion').value = -1;
                        $d.getElementById('responsable_fase').value = -1
                        $d.getElementById('tipo').value = -1;
                        
                        mostrarMensaje('Registro grabado',"msj_correct");
                    }else {
                        mostrarMensaje("No se grabo el registro","msj_error");
                    }
                });
            } catch (error) {
                mostrarMensaje(error,"msj_error");
            }
        }else if (e.target.matches('.pdf__generator__view')){
            //;

            let indice = e.target.parentElement.getAttribute('href'),
                formData = new FormData();

                formData.append("funcion","generarPDF");
                formData.append("indice",indice);

            fetch("inc/consultar.inc.php",{
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data=>{
                $d.getElementById("iframe_preview").src ="documentos/pdf/emitidos/"+data.archivo;
                $d.getElementById("pdf_view").classList.toggle("oculto")
            });
        }else if(e.target.matches('.close_preview')) {
            $d.getElementById("pdf_view").classList.toggle("oculto");
        }

        return false;
    })

    $d.addEventListener("focusin",(e) => {
        e.preventDefault();

        if (e.target.matches('.section__click__input')){
            barra_derecha.style.right = "-100%";
            barra_derecha_responsables.style.right = "-100%";
        }

        return false;
    })
})();

const marcarCheck = (control,valor) =>{
    if ( valor === "1" ) {
        control.setAttribute("checked",true);
    }else{
        control.removeAttribute("checked");
    }
}

const marcarOpciones = (control1,control2,valor) => {
    if ( valor == "1" ) {
        control1.setAttribute('checked', 'checked');
        control2.removeAttribute('checked');
    }else {
        control2.setAttribute('checked', 'checked');
        control1.removeAttribute('checked');
    }
}

const getWeekDay = (date) => {
    let days = ['DOMINGO','LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO'];
  
    return days[date.getDay()];
  }

const grabarGeneral = (clase,detalle,funcion) =>{
    let formData = new FormData();
    formData.append("clase",clase);
    formData.append("detalle",detalle);
    formData.append("funcion",funcion);

    fetch('inc/grabar.inc.php',{
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data =>{
        detalle = "";
    });
}

const itemsList = (tabla) => {
    const fila = tabla.querySelector("#dialog__table_body").getElementsByTagName("tr");

    let nreg = fila.length,
        DATOS = [];

    for (let i = 0; i < nreg; i++) {
        let dato = {}

        dato['item']    = fila[i].cells[0].children[0].value;
        dato['desc']    = fila[i].cells[1].children[0].value;
        dato['grabar']  = fila[i].dataset.grabado;

        DATOS.push(dato);
    }

    return DATOS;
}

const limpiarTabla = (tabla) => {    
    tabla.innerHTML = "";
}

function consultarDocumentos(){
    let estado = '';
    let formData = new FormData();
    formData.append("funcion","consultarDocumentos");

    fetch('inc/consultar.inc.php',{
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data =>{
        data.filas.forEach(element => {

            if (element.avance == 0){
                estado = 'avance0';
            }else if(element.avance == 25){
                estado = 'avance25';
            }else if(element.avance == 50){
                estado = 'avance50';
            }else if(element.avance == 75){
                estado = 'avance75';
            }else if(element.avance == 100){
                estado = 'avance100';
            }

            let row = `<tr class="table___row__code" data-codigo="${element.idreg}">
                          <td class="table_cell">${element.item}</td>
                          <td class="table_cell">${element.fecha}</td>
                          <td class="table_cell">${element.ubicacion}</td>
                          <td class="table_cell">${element.cliente}</td>
                          <td class="table_cell">${element.proyecto}</td>
                          <td class="table_cell">${element.fase}</td>
                          <td class="table_cell">${element.tipo}</td>
                          <td class="table_cell texto_centro ${estado}">${element.avance}%</td>
                          <td class="table_cell"><a href="${element.idreg}" class="img__table"><img src="img/pdf.png" alt="vista_previa" class="pdf__generator__view"></a> </td>
                      </tr>`;
  
            document.getElementById("document__list__body").insertRow(-1).outerHTML = row;
          });

          document.getElementById("espera").classList.toggle('oculto');
    });
}

const verBarraDerecha = (barra) => {
    if ( barra.style.right !== "0px"){
        barra.style.right = 0;
    }else{
        barra.style.right = "-100%";
    }
}

const obtenerFases = () => {
    let formData = new FormData();
    formData.append("funcion","consultarFases");

    let select_fase = document.getElementById('responsable_fase');

    fetch('inc/consultar.inc.php',{
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        data.filas.forEach(element => {
            let option = document.createElement("OPTION");
            option.value = element.idreg;
            option.text = element.detalle;

            select_fase.add(option);
        });
    })
    
}