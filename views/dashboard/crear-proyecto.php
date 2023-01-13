<!-- Crear Proyectos -->


<!--Include Header -->
<?php include_once __DIR__ . '/header-dashboard.php'; ?>

    <div class="contenedor-sm">
        <!-- include Alertas -->
        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

        <form class="formulario" method="POST" action="/crear-proyecto">

            <?php include_once __DIR__ . '/formulario-proyecto.php'; ?>
            <input type="submit" value="Crear Proyecto">
        </form>
    </div>

<!-- Include Footer -->
<?php include_once __DIR__ . '/footer-dashboard.php'; ?>

  