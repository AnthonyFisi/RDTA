import {mostrarMensaje} from "./funciones.js";
import {mostrarSelector} from "./funciones.js";

(function() {    
    const $d = document;
    const tableSelector = $d.getElementById("select_table");

    //consultarDocumentos();
    
    $d.addEventListener("click",(e)=>{
        e.preventDefault();

        console.log(e.target);

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
            $d.getElementById("rdta_form").reset();
            $d.getElementById("rda").classList.toggle('oculto');

            $d.getElementById("chkSoleadoAm").removeAttribute("checked");
            $d.getElementById("chkNubladoAm").removeAttribute("checked");
            $d.getElementById("chkLluviosoAm").removeAttribute("checked");
            $d.getElementById("chkSoleadoPm").removeAttribute("checked");
            $d.getElementById("chkNubladoPm").removeAttribute("checked");
            $d.getElementById("chkLluviosoPm").removeAttribute("checked");

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

                $d.getElementById("cliente").value = data.datos[0].cliente;
                $d.getElementById("proyecto").value = data.datos[0].proyecto;

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

                $d.getElementById('tabla_actividades_body').innerHTML = data.actividades;
                $d.getElementById('tabla_personal_body').innerHTML = data.personal;
            })

            return false;
        }else if (e.target.matches(".button__login") ){
            $d.getElementById("modal__login").classList.toggle('oculto');
            consultarDocumentos();
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
    let days = ['DOMINGO', '', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO'];
  
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
        dato['desc']    = fila[i].cells[2].children[0].value;
        dato['grabar']  = fila[i].dataset.grabado;

        DATOS.push(dato);
    }

    return DATOS;
}

const limpiarTabla = (tabla) => {    
    tabla.innerHTML = "";
}

function consultarDocumentos(){
    let formData = new FormData();
    formData.append("funcion","consultarDocumentos");

    fetch('inc/consultar.inc.php',{
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data =>{
        data.filas.forEach(element => {

            let row = `<tr class="table___row__code" data-codigo="${element.idreg}">
                          <td class="texto_centro table_cell">${element.item}</td>
                          <td class="table_cell">${element.fecha}</td>
                          <td class="table_cell">${element.ubicacion}</td>
                          <td class="table_cell">${element.cliente}</td>
                          <td class="table_cell">${element.proyecto}</td>
                          <td class="table_cell">${element.fase}</td>
                          <td class="table_cell">${element.tipo}</td>
                          <td class="table_cell">0</td>
                          <td class="table_cell"><a href="#"></a> </td>
                      </tr>`;
  
            document.getElementById("document__list__body").insertRow(-1).outerHTML = row;
          });
    });
}
