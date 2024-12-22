let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

document.addEventListener('DOMContentLoaded', ()=>{
    eliminarAlerta();
    
   if(window.location.pathname.includes("citas")){
        iniciarApp();
   }
});

function eliminarAlerta(){
    const alertas = document.querySelectorAll('.alerta');
    
    alertas.forEach(alerta => {
        if(alerta.classList.contains('error')){
            setTimeout(() => {
                alerta.remove();
            }, 10000);
        }else{
            setTimeout(() => {
                alerta.remove();
            }, 7000);
        }
    });
}

function iniciarApp(){
    tabs();
    mostrarSeccion();

    botonesPaginador()
    paginaSiguiente();
    paginaAnterior();

    obtenerAPI();
    //Llenando el obj cita
    capturarIdUsuario();
    nombreCliente();
    seleccionarFecha();
    seleccionarHora();

}

function tabs(){
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach(boton =>{

        boton.addEventListener('click', (e)=>{
            paso = parseInt(e.target.dataset.paso);
            mostrarSeccion();
            botonesPaginador();
        })
    });
}

function mostrarSeccion(){
    const seccionAnterior = document.querySelector('.mostrar');
    if(seccionAnterior){
        seccionAnterior.classList.remove('mostrar');
    }
    const seccion = document.querySelector(`#paso-${paso}`);
    seccion.classList.add('mostrar');

    const tabAnterior = document.querySelector('.actual');
    if(tabAnterior){
        tabAnterior.classList.remove('actual');
    }

    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');

}

function botonesPaginador(){
    const pagAnterior = document.querySelector('#anterior');
    const pagSiguiente = document.querySelector('#siguiente');

    if(paso === 1){
        pagAnterior.classList.add('ocultar');
        pagSiguiente.classList.remove('ocultar')
    }else if(paso === 3){
        pagSiguiente.classList.add('ocultar');
        pagAnterior.classList.remove('ocultar');
        mostrarResumen();
    }else{
        pagSiguiente.classList.remove('ocultar');
        pagAnterior.classList.remove('ocultar');
    }
    mostrarSeccion();
}

function paginaAnterior(){
    const pagAnterior = document.querySelector('#anterior');

    pagAnterior.addEventListener('click', ()=>{
        if(paso <= pasoInicial) return;
        paso--;
        botonesPaginador();
    })
    
}

function paginaSiguiente(){
    const pagSiguiente = document.querySelector('#siguiente');

    pagSiguiente.addEventListener('click', ()=>{
        if(paso >= pasoFinal) return;
        paso++;
        botonesPaginador();
    })
    
}

async function obtenerAPI(){
    try {
        const url = `${location.origin}/api/servicios`;
        const resultado = await fetch(url);
        const servicios = await resultado.json();

        mostrarServicios(servicios);

    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios(servicios){
    servicios.forEach(servicio =>{
        const {id, nombre, precio} = servicio;

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$${precio}`;

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;

        servicioDiv.onclick = function(){
            seleccionarServicio(servicio);
        }

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        const contServicios = document.querySelector('#servicios');
        contServicios.appendChild(servicioDiv);
        
    });
}

function seleccionarServicio(servicio){
    const {id} = servicio;
    const {servicios} = cita;

    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

    //
    const existe = servicios.some(serv => serv.id === id);

    if(existe){
        cita.servicios = servicios.filter( serv => serv.id !== id);
        divServicio.classList.remove('seleccionado');

    } else{
        cita.servicios = [...servicios, servicio];
        divServicio.classList.add('seleccionado');
    }
}

function nombreCliente(){
    cita.nombre = document.querySelector('#nombre').value;
}

function seleccionarFecha(){
    const inputFecha = document.querySelector('#fecha');

    inputFecha.addEventListener('input', (e)=>{

        const dia = new Date(e.target.value).getUTCDay();

        if([6, 0].includes(dia)){
            cita.fecha = '';
            e.target.value = '';
            mostrarAlerta('Fines de semana no Atendemos', 'error', '#paso-2 .formulario');
        }else{
            cita.fecha = e.target.value;
            removerAlerta();
        }
    });
}

function seleccionarHora(){

    const horaInput = document.querySelector('#hora');

    horaInput.addEventListener('input', (e)=>{
        const hora = e.target.value.split(':')[0];

        if(hora < 8 || hora >= 20){
            e.target.value = '';
            cita.hora = '';
            mostrarAlerta('Hora no valida', 'error', '#paso-2 .formulario');
        }else{
            removerAlerta();
            cita.hora = e.target.value;
        }
        console.log(cita);

    })
}

function capturarIdUsuario(){
    cita.id = document.querySelector("#usuarioId").value;
}

function mostrarAlerta(mensaje, tipo, elemento){
    //Evitamos que se creen más alertas
    removerAlerta();
    //Creamos una alerta
    const divAlerta = document.createElement('DIV');
    divAlerta.classList.add('alerta', `${tipo}`);
    divAlerta.textContent = mensaje;

    const referencia = document.querySelector(elemento);
    referencia.parentNode.insertBefore(divAlerta, referencia);
}

function removerAlerta(){
    const alerta = document.querySelector('.alerta');
    if(alerta){
        alerta.remove();
    }
}

function mostrarResumen(){
    const resumen = document.querySelector('.contenido-resumen');

    while(resumen.firstChild){
        resumen.removeChild(resumen.lastChild);
    }

    if(Object.values(cita).includes('')){
        mostrarAlerta('Debes Seleccionar un fecha y hora', 'error', '.contenido-resumen');
        return;
    }else if( cita.servicios.length === 0){
        mostrarAlerta('No hay servicios seleccionados', 'error', '.contenido-resumen');
        return;
    }

    removerAlerta();

    const {nombre, fecha, hora, servicios} = cita;

    const encabezado = document.createElement('DIV');

    const textoResumen = document.createElement('H2');
    textoResumen.textContent = 'Resumen'

    const parrafoResumen = document.createElement('P');
    parrafoResumen.classList.add('text-center');
    parrafoResumen.textContent = 'Verifica que la información sea correcta';

    encabezado.appendChild(textoResumen);
    encabezado.appendChild(parrafoResumen);

    const tituloDatos = document.createElement('H3');
    tituloDatos.textContent = "Información de la cita";

    const nombreCita = document.createElement('P');
    nombreCita.innerHTML = `<span>Nombre: </span>${nombre}`;

    //Formatar fecha
    const fechaObj = new Date(fecha);

    const dia = fechaObj.getDate() + 2;
    const mes = fechaObj.getMonth();
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date(Date.UTC(year, mes, dia));
    const opciones = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    }
    const fechaFormateada = fechaUTC.toLocaleDateString('es-MX', opciones);

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha: </span>${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora: </span>${hora}`;

    const tituloServicios = document.createElement('h3');
    tituloServicios.textContent = "Servicios Seleccionados";

    resumen.appendChild(encabezado);
    resumen.appendChild(tituloDatos);
    resumen.appendChild(nombreCita);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);
    resumen.appendChild(tituloServicios);

    let total = 0;

    servicios.forEach(servicio =>{
        const {id, nombre, precio} = servicio;

        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        const nombreServicio = document.createElement('P');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio: </span>$${precio}`;

        let nuevoPrecio = parseFloat(precio);
        total += nuevoPrecio;

        contenedorServicio.appendChild(nombreServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);

    })

    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = reservarCita;

    const totalPagar = document.createElement('P');
    totalPagar.classList.add('total');
    totalPagar.innerHTML = `<span>Total a Pagar: </span> $${total}.00`;

    resumen.appendChild(totalPagar);
    resumen.appendChild(botonReservar);
}

async function reservarCita(){
    const {id, fecha, hora, servicios} = cita;
    const idServicios = servicios.map(servicio => servicio.id);

    const datos = new FormData();
    datos.append('usuarioId', id);
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('servicios', idServicios);

    console.log([...datos]);

    try{
        const url = `${location.origin}/api/citas`;

        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        })
    
        const resultado = await respuesta.json();
        console.log(resultado);

        if(resultado.cita && resultado.citaServicio){
            Swal.fire({
                icon: "success",
                title: "Cita Creada",
                text: "¡Tu cita fue creada correctamente!",
                customClass: {
                    popup: 'swal-custom-popup', // contenedor
                    icon: 'swal-custom-icon',  // ícono
                    title: 'swal-custom-title', // título
                    confirmButton: 'swal-custom-button' // botón
                }
            }).then(() => {
                window.location.reload();
            });
            
        }
    
    }catch(error){
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Hubo un error al crear la cita",
            customClass: {
                popup: 'swal-custom-popup', // contenedor
                icon: 'swal-custom-icon',  // ícono
                title: 'swal-custom-title', // título
                confirmButton: 'swal-custom-button' // botón
            }
          }).then(()=>{
            setTimeout(() => {
                window.location.reload();
            }, 3000);
        });
        console.log(error);
    }
    
}


























