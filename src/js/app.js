let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

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
    mostrarSeccion();
    botonesPaginador()
    paginaSiguiente();
    paginaAnterior();
    tabs();
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





