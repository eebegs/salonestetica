
<h1 class="nombre-pagina">Iniciar Sesion</h1>
<p class="descripcion-pagina">Inicia sesion con tus datos</p>

<?php 

    include_once __DIR__ . "/../templates/alertas.php";

?>

<form class="formulario" method="POST" action="/">
    <div class="campo">
        <label for="email">Email</label>
        <input 
            type="email"
            id="email"
            placeholder="Ingresa tu Email"
            name="email"
        />
    </div>

    <div class="campo">
        <label class="password">Password</label>
        <input
            type="password"
            id="password"
            placeholder="Ingresa tu contraseña"
            name="password"
        />
    </div>

    <input type="submit" class="boton" value="Iniciar Sesion">

</form>

<div class="acciones">
    <a class="acciones-enlaces" href="/crear-cuenta">Aun no tienes una cuenta? Crear una</a>
    <a class="acciones-enlaces" href="/olvide">Olvidaste tu password?</a>
</div>

<?php 

    include_once __DIR__ . "/../templates/footer.php";

?>

<?php 

    include_once __DIR__ . "/../templates/footer.php";

?>
