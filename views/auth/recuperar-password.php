<h1 class="nombre-pagina">Recuperar Password</h1>
<p class="descripcion-pagina">Coloca tu nueva contrasena a continuacion</p>

<?php 

    include_once __DIR__ . "/../templates/alertas.php";

?>

<?php if($error) return; ?>
<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Contrasena</label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="Tu nueva contrasena"
        />
    </div>

    <input type="submit" class="boton" value="Guardar nueva contrasena">

</form>


<div class="acciones">
    <a href="/">Ya tienes cuenta? Iniciar Sesion</a>
    <a href="/crear-cuenta">Aun no tienes tu cuenta? Obtener una</a>

</div>

<?php 

    include_once __DIR__ . "/../templates/footer.php";

?>