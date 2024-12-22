document.addEventListener("DOMContentLoaded", ()=>{
    iniciarApp();
})

function iniciarApp(){
    filtrarFecha();
    alertaEliminar();
}

function filtrarFecha(){
    const fechaInput = document.querySelector('#fecha');
    if(fechaInput){
        fechaInput.addEventListener('input', (e)=>{
            window.location = `?fecha=${e.target.value}`;
        })
    }
}

function alertaEliminar(){
    const formularios = document.querySelectorAll('#form');

    formularios.forEach(formulario =>{
        formulario.addEventListener('submit', (e)=>{
            e.preventDefault();
    
            Swal.fire({
                title: "¿Quieres eliminar este registro?",
                text: "No se podrá revertir esta acción",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, deseo eliminarlo!",
                customClass: {
                    popup: 'swal-custom-popup', // contenedor
                    icon: 'swal-custom-icon',  // ícono
                    title: 'swal-custom-title', // título
                    confirmButton: 'swal-custom-button' // botón
                }
              }).then((result) => {
                if (result.isConfirmed) {
                    formulario.submit();
                }
              });
        })
    })

    
}















