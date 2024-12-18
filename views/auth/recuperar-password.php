<h1 class="nombre-pagina">Reestablecer Password</h1>
<p class="descripcion-pagina">Ingresa tu nuevo password</p>

<?php
    include_once __DIR__ . '/../templates/alertas.php';
?>
<?php if($error) return; ?>
<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Ingresa tu Nuevo Password">
    </div>
    <input type="submit" class="boton" value="Guardar Password">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crea una</a>
</div>

<?php $script = "<script src='build/js/app.js'></script>"; ?>
