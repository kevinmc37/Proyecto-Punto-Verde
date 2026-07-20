<?php session_start();      // Identifica la actual sessió
session_unset();
session_destroy();      // Destrueix la actual sessió
header('Location: login.php');      // Redirigeix a login.php per iniciar sessió