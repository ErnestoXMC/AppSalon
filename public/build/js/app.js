function eliminarAlerta(){document.querySelectorAll(".alerta").forEach((e=>{e.classList.contains("error")?setTimeout((()=>{e.remove()}),9e3):setTimeout((()=>{e.remove()}),3e3)}))}document.addEventListener("DOMContentLoaded",(()=>{eliminarAlerta()}));