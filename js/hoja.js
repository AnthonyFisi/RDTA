import { mostrarMensaje } from "./funciones.js";
import { mostrarSelector } from "./funciones.js";

const $ = document;
const modal_actividades = $.getElementById("actividades");
const modal_personal = $.getElementById("personal");
const modal_equipos = $.getElementById("equipos");
const modal_material = $.getElementById("materiales");

/**PARA ELIMINAR LAS FILAS*/
/*const enlaces = $.querySelectorAll(".table_sheet tbody");
enlaces.forEach((f) => {
    f.addEventListener("click", (e) => {
        e.target.closest("tr").remove();
    })
})*/

/*BUSQUEDA EN LOS CUADROS DE DIALOGO */
$.addEventListener("keyup", (e) => {
    if (e.target.matches(".busqueda_actividad")) {
        if (e.key === 'Enter') {
            $.getElementById("table_list_act_body").innerHTML = "";
        }
    }
});

fetchFases();


$.addEventListener("click", (e) => {
    //e.preventDefault();

    //console.log(e.target);

    if (e.target.matches(".add_table_activity *")) {
        modal_actividades.classList.toggle("oculto");

        let formData = new FormData();
        formData.append("funcion", "actividades");

        fetch('inc/consultar.inc.php', {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                data.datos.forEach(element => {
                    let row = `<tr class="activity_row_click" data-idreg="${element.idreg}" data-etapa="${element.idetapa}" data-fase="${element.idfase}" > 
                                <td>${element.item}</td>
                                <td>${element.cdetalle}</td>
                            </tr>`;

                    $.getElementById("table_list_act_body").insertRow(-1).outerHTML = row;
                });
            })
    } else if (e.target.matches(".activity_row_click *")) {
        let item = e.target.parentElement.children[0].innerHTML,
            act = e.target.parentElement.children[1].innerHTML,
            id = e.target.parentElement.dataset.idreg,
            row = `<tr data-grabado="0">
                    <td>${item}</td>
                    <td>${act}</td>
                    <td><input type="number"></td>
                    <td><input type="number"></td>
                    <td><a href="#" class="item_click_remove texto_centro" ><i class="fas fa-trash-alt"></i></a></td>
                </tr>`;

        $.getElementById("tabla_actividades_body").insertRow(-1).outerHTML = row;

        hiddenEmptyMessageRows(datosActividades($.getElementById("tabla_actividades")), "actividades");

    } else if (e.target.matches(".close_activity *")) {
        modal_actividades.classList.toggle("oculto");
        $.getElementById("table_list_act_body").innerHTML = "";
    } else if (e.target.matches(".add_table_personal *")) {
        modal_personal.classList.toggle("oculto");

        let formData = new FormData();
        formData.append("funcion", "personal");

        fetch('inc/consultar.inc.php', {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                data.forEach(element => {
                    let nombres = element.paterno + ' ' + element.materno + ' ' + element.nombres,
                        row = `<tr class="personal_row_click" data-documento="${element.dni}" data-cargo="${element.cargo}">
                                <td>${element.dni}</td>
                                <td>${nombres}</td>
                            </tr>`;
                    $.getElementById("table_list_pers_body").insertRow(-1).outerHTML = row;
                });

            })
    } else if (e.target.matches(".close_personal *")) {
        modal_personal.classList.toggle("oculto");
        $.getElementById("table_list_pers_body").innerHTML = "";
    } else if (e.target.matches(".personal_row_click *")) {
        let dni = e.target.parentElement.children[0].innerHTML,
            nombre = e.target.parentElement.children[1].innerHTML,
            cargo = e.target.parentElement.dataset.cargo,
            row = `<tr data-grabado="0">
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
        hiddenEmptyMessageRows(datosPersonal($.getElementById("tabla_personal")), "personal");

    } else if (e.target.matches(".add_table_equips *")) {
        modal_equipos.classList.toggle("oculto");

        let formData = new FormData();
        formData.append("funcion", "equipos");

        fetch('inc/consultar.inc.php', {
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
    } else if (e.target.matches(".close_equipos *")) {
        modal_equipos.classList.toggle("oculto");
        $.getElementById("table_list_equ_body").innerHTML = "";
    } else if (e.target.matches(".equipo_row_click *")) {
        let descripcion = e.target.parentElement.children[0].innerHTML + ' ' + e.target.parentElement.children[1].innerHTML,
            id = e.target.parentElement.dataset.id,
            row = `<tr data-grabado="0">
                    <td>${descripcion}</td>
                    <td><input type="text"></td>
                    <td><input type="number"></td>
                    <td><input type="checkbox"></td>
                    <td><input type="checkbox"></td>
                    <td><input type="text"></td>
                    <td><a href="#" class="item_click_remove texto_centro" ><i class="fas fa-trash-alt"></i></a></td>
                </tr>`;

        $.getElementById("tabla_equipos_body").insertRow(-1).outerHTML = row;
        hiddenEmptyMessageRows(datosEquipos($.getElementById("tabla_equipos")), "equipos");
    } else if (e.target.matches(".add_table_materials *")) {
        modal_material.classList.toggle("oculto");

        let formData = new FormData();
        formData.append("funcion", "productos");

        fetch('inc/consultar.inc.php', {
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
    } else if (e.target.matches(".close_material *")) {
        modal_material.classList.toggle("oculto");
        $.getElementById("table_list_mat_body").innerHTML = "";
    } else if (e.target.matches(".producto_row_click *")) {
        let descripcion = e.target.parentElement.children[0].innerHTML + ' ' + e.target.parentElement.children[1].innerHTML,
            id = e.target.parentElement.dataset.id,
            und = e.target.parentElement.dataset.und,
            row = `<tr data-grabado="0">
                    <td>${descripcion}</td>
                    <td><input type="text"></td>
                    <td>${und}</td>
                    <td><input type="number"></td>
                    <td><a href="#" class="item_click_remove texto_centro" ><i class="fas fa-trash-alt"></i></a></td>
                </tr>`;

        $.getElementById("tabla_materiales_body").insertRow(-1).outerHTML = row;
        hiddenEmptyMessageRows(datosMaterial($.getElementById("tabla_materiales")), "materiales");
    } else if (e.target.matches(".button__click_save")) {
        let actividades = datosActividades($.getElementById("tabla_actividades")),
            personal = datosPersonal($.getElementById("tabla_personal")),
            equipos = datosEquipos($.getElementById("tabla_equipos")),
            materiales = datosMaterial($.getElementById("tabla_materiales")),
            dataToSend = document.querySelector("form").serialize(),
            formData = new FormData();
        formData.append("cabecera", dataToSend);
        formData.append("elabora", $.getElementById("login_doc").value);
        formData.append("funcion", 'grabarHoja');
        formData.append("actividades", JSON.stringify(actividades));
        formData.append("personal", JSON.stringify(personal));
        formData.append("equipos", JSON.stringify(equipos));
        formData.append("materiales", JSON.stringify(materiales));
        formData.append("dia", $.getElementById("rtdadia").innerHTML);
        formData.append("mes", $.getElementById("rtdames").innerHTML);
        formData.append("anio", $.getElementById("rtdanio").innerHTML);
        formData.append("diasemana", $.getElementById("diasemana").innerHTML);

        console.log(hasFormRequiredFields(actividades, personal, equipos, materiales))

        if (hasFormRequiredFields(actividades, personal, equipos, materiales)) {
            console.log(formData);

            fetch('inc/grabar.inc.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.respuesta){
                        console.log("succes");
                    }else{
                        console.log("fail");
                    }
                })
        } else {
            showEmptyMessageRows(actividades, personal, equipos, materiales)
            rebuilFormWithErrors(actividades, personal, equipos, materiales)
        }


    } else if (e.target.matches(".button__login")) {
        $.getElementById("modal__login").classList.toggle('oculto');
    }

    return false;
})

function fetchFases(){
    let formData = new FormData();
    formData.append("funcion", "consultarFases");
    let row = ``;
    fetch('inc/consultar.inc.php', {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            data.filas.forEach(element => {
                row += `<option value="${element.idreg}">${element.detalle}</option>`;
            });
            $.getElementById("fases_trabajo").innerHTML = row;
        })
}

const datosActividades = (tabla) => {
    const fila = tabla.querySelector("#tabla_actividades_body").getElementsByTagName("tr");

    let nreg = fila.length,
        DATOS = [];

    for (let i = 0; i < nreg; i++) {
        let dato = {}

        dato['item'] = fila[i].cells[0].innerHTML;
        dato['desc'] = fila[i].cells[1].innerHTML;
        dato['cant'] = fila[i].cells[2].children[0].value;
        dato['und'] = fila[i].cells[3].children[0].value;

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

        dato['documento'] = fila[i].cells[0].innerHTML;
        dato['nombres'] = fila[i].cells[1].innerHTML;
        dato['cargo'] = fila[i].cells[2].innerHTML;
        dato['act'] = fila[i].cells[3].children[0].value;
        dato['hh'] = fila[i].cells[4].children[0].value;
        dato['he'] = fila[i].cells[5].children[0].value;
        dato['sb'] = fila[i].cells[6].children[0].value;
        dato['inop'] = fila[i].cells[7].children[0].value;

        DATOS.push(dato);
    }

    return DATOS;
}

const datosEquipos = (tabla) => {
    const fila = tabla.querySelector("#tabla_equipos_body").getElementsByTagName("tr");

    let nreg = fila.length,
        DATOS = [];

    for (let i = 0; i < nreg; i++) {
        let dato = {}

        dato['desc'] = fila[i].cells[0].innerHTML;
        dato['act'] = fila[i].cells[1].children[0].value;
        dato['he'] = fila[i].cells[2].children[0].value;
        dato['op'] = fila[i].cells[3].children[0].checked;
        dato['io'] = fila[i].cells[4].children[0].checked;
        dato['sb'] = fila[i].cells[5].children[0].value;


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

        dato['desc'] = fila[i].cells[0].innerHTML;
        dato['act'] = fila[i].cells[1].children[0].value;
        dato['und'] = fila[i].cells[2].innerHTML;
        dato['cant'] = fila[i].cells[3].children[0].value;

        DATOS.push(dato);
    }

    return DATOS;
}


HTMLElement.prototype.serialize = function () {
    var obj = {};
    var elements = this.querySelectorAll("input, select, textarea");
    for (var i = 0; i < elements.length; ++i) {
        var element = elements[i];
        var name = element.name;
        var value = element.value;
        var prop = element.checked;

        if (name) {
            obj[name] = { value, prop };
        }
    }
    return JSON.stringify(obj);
}

function hasFormRequiredFields(actividades, personal, equipos, materiales){
    var result = true;
    if(isThereEmptyFields(actividades, personal, equipos, materiales) || isThereEmptyRows(actividades, personal, equipos, materiales)){
        result = false;
    }
    return result;
}

function isThereEmptyFields(actividades, personal, equipos, materiales) {
    var result = false;
    for (var i = 0; i < actividades.length; i++) {
        if (actividades[i]["cant"] == "") {
            result = true;
        }
    }

    for (var i = 0; i < personal.length; i++) {
        if (personal[i]["act"] == "" || personal[i]["hh"] == "") {
            result = true;
        }
    }

    for (var i = 0; i < equipos.length; i++) {
        if (equipos[i]["act"] == "" || equipos[i]["he"] == "" ) {
            result = true;
        }
    }

    for (var i = 0; i < materiales.length; i++) {
        if (materiales[i]["act"] == "") {
            result = true;
        }
    }
    
    return result;
}

function isThereEmptyRows(actividades, personal, equipos, materiales){
    var result = false;
    if(actividades.length == 0 || personal.length == 0 || equipos.length == 0 || materiales.length == 0){
        result = true;
    }
    return result;
}

function showEmptyMessageRows(actividades, personal, equipos, materiales){
    if(actividades.length == 0){
        $.getElementById("message_actividades").innerHTML =  `<span>Es necesario agregar un registro</span>`;
    }
    if(personal.length == 0){
        $.getElementById("message_personal").innerHTML =  `<span>Es necesario agregar un registro</span>`;
    }
    if(equipos.length == 0){
        $.getElementById("message_equipos").innerHTML =  `<span>Es necesario agregar un registro</span>`;
    }
    if(materiales.length == 0){
        $.getElementById("message_materiales").innerHTML =  `<span>Es necesario agregar un registro</span>`;
    }
}

function hiddenEmptyMessageRows(tableContent, nameTable){
    if(tableContent.length > 0){
        $.getElementById(`message_${nameTable}`).innerHTML =  ``;
    }
}

function rebuilFormWithErrors(actividades, personal, equipos, materiales){
    rebuildTableActividades(actividades)
    rebuildTablePersonal(personal)
    rebuildTableEquipos(equipos)
    rebuildTableMateriales(materiales)
}

function rebuildTableActividades(actividades) { 
    $.getElementById("tabla_actividades_body").innerHTML = "";
    var data = ``,
        columnCant = ``;

    for (var i = 0; i < actividades.length; i++) {
        columnCant = `<td><input type="number" value="${actividades[i]["cant"]}"></td>`;
        
        if (actividades[i]["cant"] == "") {
            columnCant = `<td><input type="number" class="error_input"></td>`;
        }
        data += `<tr data-grabado="0">
                    <td>${actividades[i]["item"]}</td>
                    <td>${actividades[i]["desc"]}</td>
                    ${columnCant}
                    <td><input type="number"  value="${actividades[i]["und"]}"></td>
                    <td><a href="#" class="item_click_remove texto_centro" ><i class="fas fa-trash-alt"></i></a></td>
               </tr>`;

    }
    $.getElementById("tabla_actividades_body").insertRow(-1).outerHTML = data;
}

function rebuildTablePersonal(personal){
    $.getElementById("tabla_personal_body").innerHTML = "";

    var data = ``,
    columnAct = ``,
    columnHH = ``;

    personal.forEach((element) => {
        columnAct =  `<td><input type="text"  value="${element["act"]}"></td> `;
        columnHH = `<td><input type="text"  value="${element["hh"]}"></td> `;

        if(element["act"] == ""){
            columnAct =  `<td><input type="text"  class="error_input"></td> `;
        }
        if(element["hh"] == ""){
            columnHH =  `<td><input type="text"  class="error_input"></td> `;
        }
        data += `<tr data-grabado="0">
                    <td>${element["documento"]}</td>
                    <td>${element["nombres"]}</td>
                    <td>${element["cargo"]}</td>
                    ${columnAct}
                    ${columnHH}
                    <td><input type="number" value="${element["he"]}"></td>
                    <td><input type="number" value="${element["sb"]}"></td>
                    <td><input type="checkbox"  ${element["inop"] == "" ? `` : `checked`}></td>
                    <td><a href="#" class="item_click_remove texto_centro" ><i class="fas fa-trash-alt"></i></a></td>
                </tr>`;
    });

    $.getElementById("tabla_personal_body").insertRow(-1).outerHTML = data;
}

function rebuildTableEquipos(equipos){
    $.getElementById("tabla_equipos_body").innerHTML = "";

    var data = ``,
    columnAct = ``,
    columnHe = ``;

    equipos.forEach((element) => {

        columnAct = `<td><input type="text"  value="${element["act"]}"></td> `;
        columnHe = `<td><input type="number"  value="${element["he"]}"></td> `;


        if(element["act"] == ""){
            columnAct =  `<td><input type="number"  class="error_input"></td> `;
        }
        if(element["he"] == ""){
            columnHe =  `<td><input type="number"  class="error_input"></td> `;
        }

        data += `<tr data-grabado="0">
                    <td>${element["desc"]}</td>
                    ${columnAct}
                    ${columnHe}
                    <td><input type="checkbox"  ${element["op"] == "" ? `` : `checked`}></td>
                    <td><input type="checkbox"  ${element["io"] == "" ? `` : `checked`}></td>
                    <td><input type="text" value="${element["sb"]}"></td>
                    <td><a href="#" class="item_click_remove texto_centro" ><i class="fas fa-trash-alt"></i></a></td>
                </tr>`;
    });

    $.getElementById("tabla_equipos_body").insertRow(-1).outerHTML = data;
}

function rebuildTableMateriales(materiales){

    $.getElementById("tabla_materiales_body").innerHTML = "";

    var data = ``,
    columnAct = ``;

    materiales.forEach((element) => {
        columnAct = `<td><input type="text"  value="${element["act"]}"></td> `;

        if(element["act"] == ""){
            columnAct = `<td><input type="text" class="error_input"></td> `;
        }
        
        data += `<tr data-grabado="0">
                    <td>${element["desc"]}</td>
                    ${columnAct}
                    <td>${element["und"]}</td>
                    <td><input type="number" value="${element["cant"]}"></td>
                    <td><a href="#" class="item_click_remove texto_centro" ><i class="fas fa-trash-alt"></i></a></td>
                </tr>`;
    });

    $.getElementById("tabla_materiales_body").insertRow(-1).outerHTML = data;
}