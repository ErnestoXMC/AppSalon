<h1 class="nombre-pagina">Panel de Administrador</h1>

<?php
    include_once __DIR__ . "/../templates/barra.php";
?>

<h2>Buscar Cita</h2>
<div class="busqueda">
    <form class="formulario" method="POST">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" id="fecha" value="<?php echo $fecha; ?>">
        </div>
    </form> 
</div>
<div id="citas-admin">
    <h2>Citas</h2>
    <ul class="citas">
        <?php if(count($citas) === 0) {?>
            <p class="text-center">No se encontraron citas</p>
            <?php } ?>
        <?php $idCita = 0; ?>
        <?php foreach ($citas as $key => $cita) { ?> <!-- Key es el indice del arreglo citas -->
            <?php if ($idCita !== $cita->id)  { 
                    $total = 0;?>
                <?php if ($idCita !== 0) { ?>
                    </div></li> <!-- Cierra el contenedor de la cita anterior -->
                <?php } ?>
                <li>
                    <div class="cita">
                        <p>N° Cita: <span><?php echo $cita->id; ?></span></p>
                        <p>Hora: <span><?php echo $cita->hora; ?></span></p>
                        <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
                        <p>Email: <span><?php echo $cita->email; ?></span></p>
                        <p>Teléfono: <span><?php echo $cita->telefono; ?></span></p>
                        <h3>Servicios</h3>
                <?php $idCita = $cita->id;?>
            <?php } ?>
            <?php $total += $cita->precio; ?>
            <p>Servicio: <span><?php echo $cita->servicio . " $" . $cita->precio; ?></span></p>
            <?php 
                $actual = $cita->id;//id actual
                $proximo = $citas[$key + 1]->id ?? 0;//siguiente id

                if(ultimoServicio($actual, $proximo)){?>
                    <p>Total: <span>$<?php echo $total; ?></span></p>

                    <form id="form" method="POST" action="/api/eliminar">
                        <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                        <input type="submit" class="boton-eliminar" value="Eliminar Cita">
                    </form>
                <?php  } ?>
        <?php } ?><!-- Fin del foreach -->
        </div></li> <!-- Cierra la última cita -->
        
    </ul>
</div>

<?php 
$script = "
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script src='build/js/buscador.js'></script>
"; 
?>
