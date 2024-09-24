<h1 class="nombre-pagina">Olvide Password</h1>
<p class="descripcion-pagina">Recupera tu password escribiendo tu email a continuación</p>

<form action="/olvide" method="POST" class="formulario">
<div class="campo">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Ingresa tu Email">
    </div>
    <input type="submit" class="boton" value="Enviar Instrucciones">
</form>
<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crea una</a>
</div>
