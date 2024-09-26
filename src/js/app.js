document.addEventListener('DOMContentLoaded', ()=>{
    eliminarAlerta();
});

function eliminarAlerta(){
    const alertas = document.querySelectorAll('.alerta');
    
    alertas.forEach(alerta => {
        if(alerta.classList.contains('error')){
            setTimeout(() => {
                alerta.remove();
            }, 9000);
        }else{
            setTimeout(() => {
                alerta.remove();
            }, 3000);
        }
    });
}













