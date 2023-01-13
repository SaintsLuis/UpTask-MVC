<!-- Index Dashboard con los Proyectos -->


<!--Include Header -->
<?php include_once __DIR__ . '/header-dashboard.php'; ?>

    <!-- Proyectos -->

    <!-- Si hay 0 Proyectos -->
    <?php if(count($proyectos) === 0 ) { ?>
        <p class="no-proyectos">No Hay Proyectos Aún <a href="/crear-proyecto">Comienza creando uno</a></p>

        <!-- Si hay Proyectos -->
    <?php } else { ?>
        <ul class="listado-proyectos">
            <!-- Iterar -->
            <?php foreach($proyectos as $proyecto) { ?>
                <li class="proyecto">
                    <a href="/proyecto?id=<?php echo $proyecto->url; ?>">
                        <?php echo $proyecto->proyecto; ?>
                    </a>
                </li>

            <?php } ?>
        </ul>
    <?php } ?>

<!-- Include Footer -->
<?php include_once __DIR__ . '/footer-dashboard.php'; ?>

  