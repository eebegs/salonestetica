let paso = 1; // Es la primera pagina que se muestra
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
});

function iniciarApp(){
    mostrarSeccion(); // Muestra y oculta las secciones
    tabs(); // Cambia la seccion cuando se presionen los tabs
    botonesPaginador(); // Agrega o quita los botones paginador
    paginaSiguiente();
    paginaAnterior();


    consultarAPI(); // Consulta la api en el backend de php

    idCliente();
    nombreCliente(); // anade el nombre del cliente al objeto de cita
    seleccionarFecha(); // // anade la fecha del cliente al objeto de cita
    seleccionarHora(); // anade la hora de la cita

    mostrarResumen(); // Muestra el resumen

}

function mostrarSeccion() {

    // Ocultar las secciones que tenga la clase de mostrar
    const seccionAnterior = document.querySelector('.mostrar');
    if(seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
    }
   
    
    //Seleccionar la seccion con el paso
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector)
    seccion.classList.add('mostrar');

    //Quita la clase actual al tab anterior
    const tabAnterior = document.querySelector('.actual');
    if(tabAnterior) {
        tabAnterior.classList.remove('actual');
    }

    //Resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');


}

function tabs(){
    const botones = document.querySelectorAll('.tabs button');
    botones.forEach( boton => {
        boton.addEventListener('click', function(e) {
            paso = parseInt( e.target.dataset.paso );
            mostrarSeccion();

            botonesPaginador();
        });
    })
}

function botonesPaginador() {
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    if(paso === 1) {
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    } else if (paso === 3) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');

        mostrarResumen();
    } else {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }

    mostrarSeccion();

}


function paginaAnterior(){
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function() {
        
        if(paso <= pasoInicial) return;
        paso--;

        botonesPaginador();
    })
}

function paginaSiguiente() {
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function() {
        
        if(paso >= pasoFinal) return;
        paso++;

        botonesPaginador();
    })
}

async function consultarAPI() {
    try {
        const url = 'http://localhost:3030/api/servicios';
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios);
    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios(servicios) { 
    servicios.forEach( servicio => {
        const {id, nombre, precio } = servicio;

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$${precio}`;

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = function() {
            seleccionarServicio(servicio);
        }

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);


        document.querySelector('#servicios').appendChild(servicioDiv);
        

    });
}

function seleccionarServicio(servicio) {
    const { id } = servicio;
    const { servicios } = cita;

    // identificar el elemento al que le hacemos click
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

    // comprobar si un servicio ya fue agregado
    if( servicios.some( agregado => agregado.id === id ) ) {
        //Eliminar seleccion
        cita.servicios = servicios.filter( agregado => agregado.id !== id );
        divServicio.classList.remove('seleccionado');
    } else {
        // Agregarlo seleccionarlo
        cita.servicios = [...servicios, servicio];
        divServicio.classList.add('seleccionado');
    }
}


function idCliente() {
    cita.id = document.querySelector('#id').value;
}


function nombreCliente() {
    cita.nombre = document.querySelector('#nombre').value;
    
}

function seleccionarFecha() {
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function(e) {

        const dia = new Date(e.target.value).getUTCDay();

        if ( [0].includes(dia) ) {
            e.target.value = '';
            mostrarAlerta('Domingos no laborables', 'error', '.formulario');
        }else{
            cita.fecha = e.target.value;
        }

    });
}

function seleccionarHora() { 
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function(e){
        //console.log(e.target.value);

        const horaCita = e.target.value;
        const hora = horaCita.split(":")[0];
        if(hora < 10 || hora > 18) {
            e.target.value = '';
            mostrarAlerta('Hora no valida', 'error', '.formulario');
        }else {
            cita.hora = e.target.value;
        }
    })
}


function mostrarAlerta(mensaje, tipo, elemento, desaparece = true) {

    // Previene que se repita mas de una alerta ya existente
    const alertaPrevia = document.querySelector('.alerta');
    if(alertaPrevia){
        alertaPrevia.remove();
    }

    // Scripting para agregar alerta
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    if(desaparece) {
        setTimeout(() => {
            alerta.remove();
        }, 6000);
    }

    //Elimina la alerta con el tiempo indicado
}

function mostrarResumen() {
    const resumen = document.querySelector('.contenido-resumen');
    
    //Limpiar contenido resumen
    while(resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
    }


    if( Object.values(cita).includes('') || cita.servicios.length === 0 ) {
        mostrarAlerta('Faltan datos de servicios, Fecha u Hora', 'error', '.contenido-resumen', false);

        return;

    }

    //formatear el div de resumen
    const { nombre, fecha, hora, servicios } = cita;

    //Heading para resumen de servicios

    const headingServicios = document.createElement('H3');
    headingServicios.textContent = 'Resumen de Servicios';
    resumen.appendChild(headingServicios);

    // Iterando y mostrando los servicios
    servicios.forEach(servicio => {
        const { id, precio, nombre } = servicio;
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio')

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);
    })

    //Heading para resumen de cita

    const headingCita = document.createElement('H3');
    headingCita.textContent = 'Resumen de Cita';
    resumen.appendChild(headingCita);

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;
    
    const SucursalCliente = document.createElement('P');
    SucursalCliente.innerHTML = `<span>Sucursal:</span> ${nombre}`;


    //Formatear fecha al espanol

    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2;
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date ( Date.UTC(year, mes, dia));

    const opciones = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'};
    const fechaFormateada = fechaUTC.toLocaleDateString('es-AR', opciones);

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora:</span> ${hora} Horas`;

    //Boton para Crear una cita

    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = reservarCita;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(SucursalCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);

    resumen.appendChild(botonReservar);

}

async function reservarCita() {
    
    const { nombre, fecha, hora, servicios, id } = cita; 

    const idServicios = servicios.map(servicio => servicio.id);
    //console.log(idServicios);

    const datos = new FormData();
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('usuarioId', id);
    datos.append('servicios', idServicios);

    console.log([...datos]);

    try {
        //Peticion par la api
        const url = 'http://localhost:3030/api/citas' 

        const respuesta = await fetch(url, {
        method: 'POST',
        body: datos
        });

        const resultado = await respuesta.json();

        console.log(resultado.resultado);

        if(resultado.resultado){
            Swal.fire({
                icon: "success",
                title: "Cita Creada",
                text: "Tu cita fue creada correctamente",
                button: 'OK'
            }).then( () => {
                setTimeout(() => {
                }, 3000);
                window.location.reload();
            } )
        }
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Hubo un error al crear la cita",           
          });
    }

}


