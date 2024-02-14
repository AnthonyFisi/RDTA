export function mostrarMensaje(mensaje,clase){
    const $ventana_mensaje = document.getElementById("mensaje__sistema");
    const $mensaje_ventana = document.getElementById("mensaje_texto");

    $mensaje_ventana.innerHTML = mensaje;
    $ventana_mensaje.className = "modal_mensaje " + clase;
    $ventana_mensaje.style.right = 0;

    setTimeout(function() {
        $ventana_mensaje.style.right = "-100%";
    },3500)
}

export function mostrarSelector(clase,titulo){
    const barraSelector = document.querySelector(".barra_derecha");
    const tablaSelector = document.getElementById("select_table");
    const bodySelector =  tablaSelector.querySelector('.select_table_body');

    
    bodySelector.innerHTML = "";
    barraSelector.querySelector('h3').innerHTML = titulo;
    
    let formData = new FormData();
        formData.append("clase",clase);
        formData.append("funcion","consultarGeneral");

    fetch('inc/consultar.inc.php',{
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data =>{
        data.filas.forEach(element => {
            let row = `<tr class="table___row__code" data-codigo="${element.idreg}" data-descripcion="${element.detalle}">
                        <td class="texto_centro table_cell_select">${element.item}</td>
                        <td class="table_cell_select">${element.detalle}</td>
                    </tr>`;

            bodySelector.insertRow(-1).outerHTML = row;
        });
    });
}

export function mostrarSelectorResponsables() {
    const barraSelector = document.querySelector(".barra_derecha_responsables");
    const tablaSelector = document.getElementById("select_table_responsables");
    const bodySelector =  tablaSelector.querySelector('.select_table_body_responsables');

    
    bodySelector.innerHTML = "";
    barraSelector.querySelector('h3').innerHTML = "Responsables";

    let formData = new FormData();
        formData.append("funcion","consultarResponsables");

        fetch('inc/consultar.inc.php',{
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data =>{
            data.docData.forEach(element => {
                let row = `<tr class="table___row__code" 
                             data-codigo="${element.idreg}"
                             data-tipo="${element.tipo}"
                             data-fase="${element.fase}"
                             data-ubicacion="${element.idubicacion}"
                             data-proyecto="${element.idproyecto}">
                            <td class="table_cell_select_responsable">${element.documento}</td>
                            <td class="table_cell_select_responsable">${element.nombre}</td>
                            <td class="table_cell_select_resposanble">${element.cdetalle}</td>
                        </tr>`;
    
                bodySelector.insertRow(-1).outerHTML = row;
            });
        });
}