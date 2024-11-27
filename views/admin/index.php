<h1 class="nombre-pagina">Panel de Administrador</h1>

<?php
    include_once __DIR__ . "/../templates/barra.php";
?>

<h2>Buscar Cita</h2>
<div class="busqueda">
    <form class="formulario" method="POST">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" id="fecha" value="<?php echo  date("Y-m-d"); ?>">
        </div>
    </form> 
</div>
<div id="citas-admin">
    <h2>Citas</h2>
    <ul class="citas">
        <?php $idCita = 0; ?>
        <?php foreach ($citas as $cita) { ?>
            <?php if ($idCita !== $cita->id) { ?>
                <?php if ($idCita !== 0) { ?>
                    </div></li> <!-- Cierra el contenedor de la cita anterior -->
                <?php } ?>
                <li>
                    <div class="cita">
                        <p>ID: <span><?php echo $cita->id; ?></span></p>
                        <p>Hora: <span><?php echo $cita->hora; ?></span></p>
                        <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
                        <p>Email: <span><?php echo $cita->email; ?></span></p>
                        <p>Teléfono: <span><?php echo $cita->telefono; ?></span></p>
                        <h3>Servicios</h3>
                <?php $idCita = $cita->id; ?>
            <?php } ?>
            <p>Servicio: <span><?php echo $cita->servicio . " $" . $cita->precio; ?></span></p>
        <?php } ?>
        </div></li> <!-- Cierra la última cita -->
    </ul>
</div>
