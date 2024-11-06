<div class="barra">
    <p class="user">Hola: <?php echo $nombre ?? ''; ?></p>
    <a class="botonsesion" href="/logout">Cerrar Sesion</a>
</div>

<?php if(isset($_SESSION['admin'])) { ?>
    <div class="barra-servicios">
        <a class="boton" href="/admin">Ver citas</a>
        <a class="boton" href="/servicios">Ver servicios</a>
        <a class="boton" href="/servicios/crear">Añadir Servicio</a>
    </div>

<?php } ?>