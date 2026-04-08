<?php if (isset($_SESSION)) { ?>
<nav class="navbar navbar-expand-md navbar-light menu" style="background-color: #e7e7e7;">
        <a class="navbar-brand" href="index.php" aria-label="Menú control de deixalleries">Control de deixalleries</a>
        <div id="accessibleButton" onclick="toggleAccessibility();" class="ml-auto"><i tabindex="1" role="button" title="Activar mode accessible" class="fas fa-universal-access" style="font-size: 35px; cursor: pointer;"></i></div>
        <button tabindex="1" class="navbar-toggler ml-3" type="button" data-toggle="collapse" data-target="#desplegar" aria-controls="desplegar" aria-expanded="false" aria-label="Desplegar opcions">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse col-md-10" id="desplegar">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item" > <?php
                    if ($_SESSION['current'] === "registrar") { ?> <a tabindex="1" class="nav-link" href="index.php"><strong>Registrar</strong><span class="sr-only">. Pàgina actual</span></a> <?php }
                    else { ?> <a tabindex="1" class="nav-link" href="index.php">Registrar</a> <?php } ?>
                </li>
                <li class="nav-item"> <?php
                    if ($_SESSION['current'] === "consultar") { ?> <a tabindex="1" class="nav-link" href="consultar.php"><strong>Consultar</strong><span class="sr-only">. Pàgina actual</span></a> <?php }
                    else { ?> <a tabindex="1" class="nav-link" href="consultar.php">Consultar</a> <?php } ?>
                </li> <?php
                if ($_SESSION['power'] >= 1) { ?>
                    <li class="nav-item"> <?php
                        if ($_SESSION['current'] === "administrar") { ?> <a tabindex="1" class="nav-link" href="administrar.php"><strong>Administrar</strong><span class="sr-only">. Pàgina actual</span></a> <?php }
                        else { ?> <a tabindex="1" class="nav-link" href="administrar.php">Administrar</a> <!-- Només disponible per administradors --> <?php } ?>
                    </li> <?php
                } ?>
                <li class="nav-item mx-5"></li>
                <li class="nav-item">
                    <a role="note" aria-label="Sessió iniciada, " class="nav-link" style="cursor: auto;" href="#"><i class="fas fa-user"></i> <?php echo $_SESSION['username']; ?></a> <!-- Redirigeix a logout.php i destrueix la sessió, començant de zero -->
                </li>
                <li class="nav-item">
                    <a tabindex="1" class="nav-link" href="logout.php">Sortir</a> <!-- Redirigeix a logout.php i destrueix la sessió, començant de zero -->
                </li>
            </ul>
        </div>
    </nav>
<?php }