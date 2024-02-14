import {mostrarMensaje} from "./funciones.js";
import {mostrarSelector} from "./funciones.js";

(function() {    
    const $d = document;
    const tabla_personal_body = $d.getElementById("tabla_personal_body");
    const tabla_materiales_body = $d.getElementById("tabla_materiales_body");
    const tabla_equipos_body = $d.getElementById("tabla_equipos_body");

    $d.addEventListener("click",(e)=>{
        e.preventDefault();

        //console.log(e.target);

         if ( e.target.matches(".table_cell_select") ){
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
            document.querySelector(".barra_derecha").style.right = "-100%";
        }else if(e.target.matches(".close_rda")){
            let tipo = $d.getElementById("tipo_firma").value;

            if (tipo === "22") {
                $d.getElementById("modal__firma_supervisor").classList.toggle('oculto');
            }else{
                $d.getElementById("modal__firma").classList.toggle('oculto');
            }

            $d.getElementById('img_encargado').src = "";
            $d.getElementById('img_jefatura').src = "";
            $d.getElementById('img_supervision').src = "";

        }else if ( e.target.matches(".table_cell") ){
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

                $d.getElementById("id_documento").value = data.datos[0].iddoc;

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

                $d.getElementById('diasemana').innerHTML = getWeekDay(dia);

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

                let imgEncargado = '',
                    imgJefeObra = '';

                if ( $d.getElementById('tipo_firma').value == "23" ){
                    if ( data.datos[0].firmaencargado !== null) {
                        imgEncargado = 'documentos/firmas/rdta_'+data.datos[0].iddoc+'_'+data.datos[0].firmaencargado+'.png';
                        $d.getElementById('img_encargado').setAttribute('src',imgEncargado);
                    }
                }else if ( $d.getElementById('tipo_firma').value == "24" ) {
                    if ( data.datos[0].firmaencargado !== null) {
                        imgEncargado = 'documentos/firmas/rdta_'+data.datos[0].iddoc+'_'+data.datos[0].firmaencargado+'.png';
                        $d.getElementById('img_encargado').setAttribute('src',imgEncargado);
                    }
                    
                    if ( data.datos[0].jefaturaobra !== null) {
                        imgJefeObra = 'documentos/firmas/rdta_'+data.datos[0].iddoc+'_'+data.datos[0].jefaturaobra+'.png';
                        $d.getElementById('img_jefatura').setAttribute('src',imgJefeObra);
                    }
                }
            })

            return false;
        }else if (e.target.matches(".button__login") ){
            $d.getElementById("modal__login").classList.toggle('oculto');
            $d.getElementById("login_doc").value;

            let formData = new FormData();
            formData.append("funcion","consultarFirma");
            formData.append("nrodoc",$d.getElementById("login_doc").value);

            fetch('inc/consultar.inc.php',{
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.respuesta) {
                    consultarDocumentos();

                    $d.getElementById("nombre_firma").value = data.docData[0].nombre;
                    $d.getElementById("tipo_firma").value = data.docData[0].tipo;
                    $d.getElementById("documento_firma").value = data.docData[0].documento;
                    

                    if ( data.docData[0].tipo === "22" ) {
                        document.getElementById("nombre_supervision").textContent = data.docData[0].nombre;
                        document.getElementById("firma__supervision").classList.toggle('oculto');
                    }else if ( data.docData[0].tipo === "23" ){
                        document.getElementById("nombre_jefatura").textContent = data.docData[0].nombre;
                        document.getElementById("firma__jefatura").classList.toggle('oculto');
                        
                    }else if ( data.docData[0].tipo === "24" ){
                        document.getElementById("nombre_encargado").textContent = data.docData[0].nombre;
                        document.getElementById("firma__encargado").classList.toggle('oculto');
                    }
                }
            })    
        }else if (e.target.matches(".button__devuelve_supervisor") ){
            let formData = new FormData();
            formData.append('funcion','observaSupervidor');
            formData.append('tipo',$d.getElementById('tipo_firma').value);
            formData.append('documento',$d.getElementById('documento_firma').value);
            formData.append('rtda',$d.getElementById('id_documento').value);
            formData.append('comentarios',$d.getElementById('observaciones').value);

            fetch('inc/firmar.inc.php',{
                method:"POST",
                body:formData
            })
            .then(response => response.json())
            .then(data => {
                cerrarRdta();
                $d.getElementById("modal__firma_supervisor").classList.toggle('oculto');
            });     
        }else if (e.target.matches(".button__autoriza_supervisor") ){

            let canvas = document.getElementById("firma__supervision");
            let formData = new FormData();

            formData.append('funcion','autorizaSupervision');
            formData.append('tipo',$d.getElementById('tipo_firma').value);
            formData.append('documento',$d.getElementById('documento_firma').value);
            formData.append('rtda',$d.getElementById('id_documento').value);
            formData.append('canvas',canvas.toDataURL());

            fetch('inc/firmar.inc.php',{
                method:"POST",
                body:formData
            })
            .then(response => response.json())
            .then(data => {
                cerrarRdta();
                $d.getElementById("modal__firma_supervisor").classList.toggle('oculto');
            }); 
        }else if (e.target.matches(".button__autoriza_sepcon") ){
            let formData = new FormData();

            let canvas = '';

            if ($d.getElementById('tipo_firma').value == "22"){
                canvas = document.getElementById("firma__supervision");
            }else if ($d.getElementById('tipo_firma').value == "23") {
                canvas = document.getElementById("firma__jefatura");
            }else if ($d.getElementById('tipo_firma').value == "24" ){
                canvas = document.getElementById("firma__encargado");
            }

            formData.append('funcion','autorizaSepcon');
            formData.append('tipo',$d.getElementById('tipo_firma').value);
            formData.append('documento',$d.getElementById('documento_firma').value);
            formData.append('rtda',$d.getElementById('id_documento').value);
            formData.append('canvas',canvas.toDataURL());

            fetch('inc/firmar.inc.php',{
                method:"POST",
                body:formData
            })
            .then(response => response.json())
            .then(data => {
                cerrarRdta();
                $d.getElementById("modal__firma").classList.toggle('oculto');
            }); 
        }else if(e.target.matches('.close__dialog__confirm')){

            if ( $d.getElementById('tipo_firma').value === "22"){
                $d.getElementById("modal__firma_supervisor").classList.toggle('oculto');
            }else if( $d.getElementById('tipo_firma').value == "23" ){
                $d.getElementById("modal__firma").classList.toggle('oculto');
            }else if( $d.getElementById('tipo_firma').value == "24" ){
                $d.getElementById("modal__firma").classList.toggle('oculto');
            }
            
            $d.getElementById("rda").classList.toggle('oculto');

            clearCanvas(document.getElementById("firma__supervision"));
            clearCanvas(document.getElementById("firma__jefatura"));
            clearCanvas(document.getElementById("firma__encargado"));
        }

        return false;
    })
})();

function cerrarRdta(){
    document.getElementById("rdta_form").reset();
    document.getElementById("rda").classList.toggle('oculto');
    document.getElementById("chkSoleadoAm").removeAttribute("checked");
    document.getElementById("chkNubladoAm").removeAttribute("checked");
    document.getElementById("chkLluviosoAm").removeAttribute("checked");
    document.getElementById("chkSoleadoPm").removeAttribute("checked");
    document.getElementById("chkNubladoPm").removeAttribute("checked");
    document.getElementById("chkLluviosoPm").removeAttribute("checked");
}

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
    let days = ['DOMINGO', 'LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO'];
  
    return days[date.getDay()];
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
                          <td class="texto_centro table_cell">${element.item}</td>
                          <td class="table_cell">${element.fecha}</td>
                          <td class="table_cell">${element.ubicacion}</td>
                          <td class="table_cell">${element.cliente}</td>
                          <td class="table_cell">${element.proyecto}</td>
                          <td class="table_cell">${element.fase}</td>
                          <td class="table_cell">${element.tipo}</td>
                          <td class="table_cell texto_centro ${estado}">${element.avance}%</td>
                          <td class="table_cell"><a href="#"></a> </td>
                      </tr>`;
  
            document.getElementById("document__list__body").insertRow(-1).outerHTML = row;
          });
    });
}

function clearCanvas(canvas) {
    canvas.width = canvas.width;
}

