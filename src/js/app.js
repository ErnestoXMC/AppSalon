let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
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

    consultarAPI();
    //Llenando el obj cita
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

async function consultarAPI(){
    try {
        const url = 'http://localhost:3000/api/servicios';
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

    console.log(cita);
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
            mostrarAlerta('Fines de semana no Atendemos', 'error');
        }else{
            cita.fecha = e.target.value;
            removerAlerta();
        }
        console.log(cita);
    });
}

function seleccionarHora(){

    const horaInput = document.querySelector('#hora');

    horaInput.addEventListener('input', (e)=>{
        const hora = e.target.value.split(':')[0];

        if(hora < 8 || hora >= 20){
            e.target.value = '';
            cita.hora = '';
            mostrarAlerta('Hora no valida', 'error');
        }else{
            removerAlerta();
            cita.hora = e.target.value;
        }
    })
}

function mostrarAlerta(mensaje, tipo){
    //Evitamos que se creen más alertas
    const alertaPrevia = document.querySelector('.alerta');
    if(alertaPrevia) return;

    //Creamos una alerta
    const divAlerta = document.createElement('DIV');
    divAlerta.classList.add('alerta', `${tipo}`);
    divAlerta.textContent = mensaje;

    const formulario = document.querySelector('#paso-2 .formulario');
    formulario.parentNode.insertBefore(divAlerta, formulario);
}

function removerAlerta(){
    const alerta = document.querySelector('.alerta');
    if(alerta){
        alerta.remove();
    }
}




