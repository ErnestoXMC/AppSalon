function iniciarApp(){filtrarFecha(),alertaEliminar()}function filtrarFecha(){const t=document.querySelector("#fecha");t&&t.addEventListener("input",(t=>{window.location=`?fecha=${t.target.value}`}))}function alertaEliminar(){document.querySelectorAll("#form").forEach((t=>{t.addEventListener("submit",(e=>{e.preventDefault(),Swal.fire({title:"¿Quieres eliminar este registro?",text:"No se podrá revertir esta acción",icon:"warning",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Si, deseo eliminarlo!",customClass:{popup:"swal-custom-popup",icon:"swal-custom-icon",title:"swal-custom-title",confirmButton:"swal-custom-button"}}).then((e=>{e.isConfirmed&&t.submit()}))}))}))}document.addEventListener("DOMContentLoaded",(()=>{iniciarApp()}));