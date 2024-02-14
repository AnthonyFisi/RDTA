import {mostrarMensaje} from "./funciones.js";
import {mostrarSelector} from "./funciones.js";

const $ = document;
const modal_actividades = $.getElementById("actividades");
const modal_personal = $.getElementById("personal");
const modal_equipos = $.getElementById("equipos");
const modal_material = $.getElementById("materiales");

/**PARA ELIMINAR LAS FILAS*/
const enlaces = $.querySelectorAll(".table_sheet tbody");
enlaces.forEach((f)=>{
    f.addEventListener("click",(e)=>{
        e.target.closest("tr").remove();
    })
})

/*BUSQUEDA EN LOS CUADROS DE DIALOGO */
$.addEventListener("keyup", (e) => {
    if (e.target.matches(".busqueda_actividad")){
        if (e.key === 'Enter') {
            $.getElementById("table_list_act_body").innerHTML = "";
        }
    }
});


$.addEventListener("click",(e)=>{
    //e.preventDefault();

    //console.log(e.target);

    if(e.target.matches(".add_table_activity *")){
        modal_actividades.classList.toggle("oculto");
        
        let formData = new FormData();
        formData.append("funcion","actividades");

        fetch('inc/consultar.inc.php',{
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data =>{
            data.datos.forEach(element =>{
                let row = `<tr class="activity_row_click" data-idreg="${element.idreg}" data-etapa="${element.idetapa}" data-fase="${element.idfase}" > 
                                <td>${element.item}</td>
                                <td>${element.cdetalle}</td>
                            </tr>`;

                $.getElementById("table_list_act_body").insertRow(-1).outerHTML = row;
            });
        })
    }else if(e.target.matches(".activity_row_click *")){
        let item = e.target.parentElement.children[0].innerHTML,
             act = e.target.parentElement.children[1].innerHTML,
             id  = e.target.parentElement.dataset.idreg,
             row =`<tr data-grabado="0">
                    <td>${item}</td>
                    <td>${act}</td>
                    <td><input type="number"></td>
                    <td><input type="number"></td>
                    <td><a href="#" class="item_click_remove texto_centro" ><i class="fas fa-trash-alt"></i></a></td>
                </tr>`;

        $.getElementById("tabla_actividades_body").insertRow(-1).outerHTML = row;
    }else if(e.target.matches(".close_activity *")){
        modal_actividades.classList.toggle("oculto");
        $.getElementById("table_list_act_body").innerHTML = "";
    }else if(e.target.matches(".add_table_personal *")){
        modal_personal.classList.toggle("oculto");

        let formData = new FormData();
        formData.append("funcion","personal");

        fetch('inc/consultar.inc.php',{
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            data.forEach(element => {
                let nombres = element.paterno+' '+element.materno+' '+element.nombres,
                row = `<tr class="personal_row_click" data-documento="${element.dni}" data-cargo="${element.cargo}">
                                <td>${element.dni}</td>
                                <td>${nombres}</td>
                            </tr>`;
                $.getElementById("table_list_pers_body").insertRow(-1).outerHTML = row;
            });
            
        })
    }else if(e.target.matches(".close_personal *")){
        modal_personal.classList.toggle("oculto");
        $.getElementById("table_list_pers_body").innerHTML = "";
    }else if(e.target.matches(".personal_row_click *")){
        let dni = e.target.parentElement.children[0].innerHTML,
            nombre = e.target.parentElement.children[1].innerHTML,
            cargo  = e.target.parentElement.dataset.cargo,
            row =`<tr data-grabado="0">
                    <td>${dni}</td>
                    <td>${nombre}</td>
                    <td>${cargo}</td>
                    <td><input type="text"></td>
                    <td><input type="number"></td>
                    <td><input type="number"></td>
                    <td><input type="number"></td>
                    <td><input type="checkbox"></td>
                    <td><a href="#" class="item_click_remove texto_centro" ><i class="fas fa-trash-alt"></i></a></td>
                </tr>`;

        $.getElementById("tabla_personal_body").insertRow(-1).outerHTML = row;
    }else if(e.target.matches(".add_table_equips *")){
        modal_equipos.classList.toggle("oculto");

        let formData = new FormData();
        formData.append("funcion","equipos");

        fetch('inc/consultar.inc.php',{
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            data.equipos.forEach(element => {
                let row = `<tr class="equipo_row_click" data-id="${element.id}">
                                <td>${element.cod}</td>
                                <td>${element.desc}</td>
                            </tr>`;
                $.getElementById("table_list_equ_body").insertRow(-1).outerHTML = row;
            });
        })
    }else if(e.target.matches(".close_equipos *")){
        modal_equipos.classList.toggle("oculto");
        $.getElementById("table_list_equ_body").innerHTML = "";
    }else if(e.target.matches(".equipo_row_click *")){
        let descripcion = e.target.parentElement.children[0].innerHTML+' '+e.target.parentElement.children[1].innerHTML,
            id = e.target.parentElement.dataset.id,
            row =`<tr data-grabado="0">
                    <td>${descripcion}</td>
                    <td><input type="text"></td>
                    <td><input type="number"></td>
                    <td><input type="checkbox"></td>
                    <td><input type="checkbox"></td>
                    <td><input type="text"></td>
                    <td><a href="#" class="item_click_remove texto_centro" ><i class="fas fa-trash-alt"></i></a></td>
                </tr>`;

        $.getElementById("tabla_equipos_body").insertRow(-1).outerHTML = row;
    }else if(e.target.matches(".add_table_materials *")){
        modal_material.classList.toggle("oculto");

        let formData = new FormData();
        formData.append("funcion","productos");

        fetch('inc/consultar.inc.php',{
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            data.productos.forEach(element => {
                let row = `<tr class="producto_row_click" data-id="${element.id}" data-und="${element.unid}">
                                <td>${element.cod}</td>
                                <td>${element.desc}</td>
                            </tr>`;
                $.getElementById("table_list_mat_body").insertRow(-1).outerHTML = row;
            });
        })
    }else if(e.target.matches(".close_material *")){
        modal_material.classList.toggle("oculto");
        $.getElementById("table_list_mat_body").innerHTML = "";
    }else if(e.target.matches(".producto_row_click *")){
        let descripcion = e.target.parentElement.children[0].innerHTML+' '+e.target.parentElement.children[1].innerHTML,
            id = e.target.parentElement.dataset.id,
            und = e.target.parentElement.dataset.und,
            row =`<tr data-grabado="0">
                    <td>${descripcion}</td>
                    <td><input type="text"></td>
                    <td>${und}</td>
                    <td><input type="number"></td>
                    <td><a href="#" class="item_click_remove texto_centro" ><i class="fas fa-trash-alt"></i></a></td>
                </tr>`;

        $.getElementById("tabla_materiales_body").insertRow(-1).outerHTML = row;
    }else if(e.target.matches(".button__click_save")){
        let actividades   = datosActividades($.getElementById("tabla_actividades")),
            personal        = datosPersonal($.getElementById("tabla_personal")),
            equipos         = datosEquipos($.getElementById("tabla_equipos")),
            materiales      = datosMaterial($.getElementById("tabla_materiales")),
            dataToSend      = document.querySelector("form").serialize(),
            formData        = new FormData();
            formData.append("cabecera",dataToSend);
            formData.append("elabora",$.getElementById("login_doc").value);
            formData.append("funcion",'grabarHoja');
            formData.append("actividades",JSON.stringify(actividades));
            formData.append("personal",JSON.stringify(personal));
            formData.append("equipos",JSON.stringify(equipos));
            formData.append("materiales",JSON.stringify(materiales));
            formData.append("dia",$.getElementById("rtdadia").innerHTML);
            formData.append("mes",$.getElementById("rtdames").innerHTML);
            formData.append("anio",$.getElementById("rtdanio").innerHTML);
            formData.append("diasemana",$.getElementById("diasemana").innerHTML);


        fetch('inc/grabar.inc.php',{
            method: 'POST',
            body:formData
        })
        .then(response => response.json())
        .then(data =>{
            // add mensage error
            // 
            console.log(data);
        })

    }else if (e.target.matches(".button__login") ){
        $.getElementById("modal__login").classList.toggle('oculto');
    }

    return false;
})

const datosActividades = (tabla) => {
    const fila = tabla.querySelector("#tabla_actividades_body").getElementsByTagName("tr");
   
    let nreg = fila.length,
        DATOS = [];
    
    for (let i = 0; i < nreg; i++) {
        let dato = {}

        dato['item']    = fila[i].cells[0].innerHTML;
        dato['desc']    = fila[i].cells[1].innerHTML;
        dato['cant']    = fila[i].cells[2].children[0].value;
        dato['und']     = fila[i].cells[3].children[0].value;

        DATOS.push(dato);
    }

    return DATOS;
}

const datosPersonal = (tabla) => {
    const fila = tabla.querySelector("#tabla_personal_body").getElementsByTagName("tr");
   
    let nreg = fila.length,
        DATOS = [];
    
    for (let i = 0; i < nreg; i++) {
        let dato = {}

        dato['documento']   = fila[i].cells[0].innerHTML;
        dato['nombres']     = fila[i].cells[1].innerHTML;
        dato['cargo']       = fila[i].cells[2].innerHTML;
        dato['act']         = fila[i].cells[3].children[0].value;
        dato['hh']          = fila[i].cells[4].children[0].value;
        dato['he']          = fila[i].cells[5].children[0].value;
        dato['sb']          = fila[i].cells[6].children[0].value;
        dato['inop']        = fila[i].cells[7].children[0].value;

        DATOS.push(dato);
    }

    return DATOS;
}

const datosEquipos =(tabla) => {
    const fila = tabla.querySelector("#tabla_equipos_body").getElementsByTagName("tr");
   
    let nreg = fila.length,
        DATOS = [];
    
    for (let i = 0; i < nreg; i++) {
        let dato = {}

        dato['desc']    = fila[i].cells[0].innerHTML;
        dato['act']     = fila[i].cells[1].children[0].value;
        dato['he']      = fila[i].cells[2].children[0].value;
        dato['op']      = fila[i].cells[3].children[0].checked;
        dato['io']      = fila[i].cells[4].children[0].value;
        dato['sb']      = fila[i].cells[5].children[0].value;
       

        DATOS.push(dato);
    }

    return DATOS;
}

const datosMaterial = (tabla) => {
    const fila = tabla.querySelector("#tabla_materiales_body").getElementsByTagName("tr");
   
    let nreg = fila.length,
        DATOS = [];
    
    for (let i = 0; i < nreg; i++) {
        let dato = {}

        dato['desc']    = fila[i].cells[0].innerHTML;
        dato['act']     = fila[i].cells[1].children[0].value;
        dato['und']     = fila[i].cells[2].innerHTML;
        dato['cant']    = fila[i].cells[3].children[0].value;

        DATOS.push(dato);
    }

    return DATOS;
}


HTMLElement.prototype.serialize = function(){
    var obj = {};
    var elements = this.querySelectorAll( "input, select, textarea" );
    for( var i = 0; i < elements.length; ++i ) {
        var element = elements[i];
        var name = element.name;
        var value = element.value;
        var prop = element.checked;

        if( name ) {
            obj[ name ] = {value,prop};
        }
    }
    return JSON.stringify( obj );
}

function validateTableFields(nameTable){

    var t = document.getElementById(nameTable);
    var trs = t.getElementsByTagName("tr");
    var tds = null;

    for (var i=0; i<trs.length; i++)
    {
        tds = trs[i].getElementsByTagName("td");
        for (var n=0; n<tds.length;n++)
        {
            tds[n].onclick=function() { 
                let actividades   = datosActividades($.getElementById("tabla_actividades"));
                if(isThereEmptyFields(actividades)){
                    // rebuild table with data 
                    console.log("true")
                    fillDataActividades(actividades);
                }
            }
        }
    }
}

function isThereEmptyFields(actividades){
    var result = false;
    for( var i= 0; i < actividades.length; i++){
        if(actividades[i]["cant"] == ""){
            result = true;
        }
    }
    return result;
}

function fillDataActividades(actividades){
    $.getElementById("tabla_actividades_body").innerHTML = "";
    var data = "";
    for( var i= 0; i < actividades.length; i++){
        let row = "";
        if(actividades[i]["cant"] == ""){
            row =`<tr data-grabado="0">
            <td>${actividades[i]["item"]}</td>
            <td>${actividades[i]["desc"]}</td>
            <td><input type="number" style="background-color:red;" value="${actividades[i]["cant"]}"></td>
            <td><input type="number"   value="${actividades[i]["und"]}"></td>
            <td><a href="#" class="item_click_remove texto_centro" ><i class="fas fa-trash-alt"></i></a></td>
        </tr>`;
        }else{
            row =`<tr data-grabado="0">
                    <td>${actividades[i]["item"]}</td>
                    <td>${actividades[i]["desc"]}</td>
                    <td><input type="number"  value="${actividades[i]["cant"]}"></td>
                    <td><input type="number"  value="${actividades[i]["und"]}"></td>
                    <td><a href="#" class="item_click_remove texto_centro" ><i class="fas fa-trash-alt"></i></a></td>
                </tr>`;
        }
            
                data += row;
    }
   

    $.getElementById("tabla_actividades_body").insertRow(-1).outerHTML = data;
    validateTableFields("tabla_actividades_body");
}
