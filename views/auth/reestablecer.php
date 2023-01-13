

<div class="contenedor reestablecer">

    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <!-- contenedor SM -->
    <div class="contenedor-sm">
        
        <p class="descripcion-pagina">Coloca tu nuevo Password</p>

        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

        <?php if($mostrar) { ?>

            <form class="formulario" method="POST">
            
                <div class="campo">
                    <label for="password">Password</label>
                    <input type="password" id="password" placeholder="Tu Password" name="password">
                </div>

                <input type="submit" class="boton" value="Guardar Password" >

            </form>

        <?php } ?>

        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta? Iniciar Sesión.</a>
            <a href="/crear">¿Aun no tienes una cuenta? Crear una.</a>
            
        </div>
    </div>
</div>