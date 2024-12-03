document.addEventListener("DOMContentLoaded", ()=>{
    iniciarApp();
})

function iniciarApp(){
    filtrarFecha();
}

function filtrarFecha(){
    const fechaInput = document.querySelector('#fecha');
    fechaInput.addEventListener('input', (e)=>{
        window.location = `?fecha=${e.target.value}`;
    })
}

















