<?php session_start();
$_SESSION['accessibility'] = $_POST['accessibility'];
require_once('./classes/Administracio.php');       // Inclou les funcions de l'aplicació
if (isset($_POST['entrar'])) {        // Si s'intenta entrar amb una compta...
    $dades = Administracio::dadesAdminLogin($_POST['username'], $_POST['password']);      // Busca a la BBDD si aquest usuari existeix
    if (!empty($dades)) {       // Si l'ha trobat emmagatzema en variable global el nom, la contrasenya i els poders que té
        $_SESSION['error'] = 0;
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['password'] = $_POST['password'];
        foreach ($dades as $key_pow) { $_SESSION['power'] = $key_pow->getPoders(); }
        $_SESSION['login'] = true;      // Permet continuar amb el login
        header('Location: index.php');      // Redirigeix a index.php
    }
    else { $_SESSION['error'] = 1; }
}
if (isset($_POST['registrar'])) {       // Si s'intenta registrar una compta nova...
    $power = 0;
    $dades = Administracio::dadesAdminRegistre($_POST['username']);
    if ($_POST['password'] == $_POST['confirm']) {
        if (empty($dades)) { // Comprova si existeix l'usuari i si les contrasenyes donades son iguals
            $_SESSION['error'] = 0;
            Administracio::registrarAdmin($_POST['username'], $_POST['password'], $power);        // Si tot és correcte registra l'usuari
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['password'] = $_POST['password'];
            foreach ($dades as $key_pow) { $_SESSION['power'] = $key_pow->getPoders(); }
            $_SESSION['login'] = true;      // Permet continuar amb el login
            header('Location: index.php');      // Redirigeix a index.php
        }
        else { $_SESSION['error'] = 3; }
    }
    else { $_SESSION['error'] = 2; }
} ?>
<html lang="ca">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>Control de residus</title>
        <link rel="stylesheet" href="extra/bootstrap-jquery/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
        <link rel="stylesheet" href="extra/accessibility.css">
        <script src="extra/bootstrap-jquery/jquery.js"></script>      <!-- jQuery i Ajax -->
        <script src="extra/bootstrap-jquery/popper.min.js"></script>
        <script src="extra/bootstrap-jquery/bootstrap.min.js"></script>
        <script src="extra/accessibility.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                if ($("#confirm").attr("hidden")) {       // Comprova a quina pestanya es troba en el moment (Inici o Registre)
                    $(".col-sm-6").addClass("col-sm-12");
                    $(".col-sm-6").removeClass("col-sm-6");
                    $("#username").on('input', function () {       // Al escriure el nom d'usuari comprova que la resta de inputs tinguin informació
                        if ($("#username").val() && $("#password").val()) { $("#btn-1").removeAttr('disabled'); }
                        else { $("#btn-1").attr('disabled', 'disabled'); }      // Si no es desactiva el botó corresponent
                        if ($("#username").val() && $("#password").val() && $("#confirm").val()) { $("#btn-2").removeAttr('disabled'); }
                        else { $("#btn-2").attr('disabled', 'disabled'); }
                    });
                    $("#password").on('input', function () {        // Al escriure la contrasenya comprova que la resta de inputs tinguin informació
                        if ($("#username").val() && $("#password").val()) { $("#btn-1").removeAttr('disabled'); }
                        else { $("#btn-1").attr('disabled', 'disabled'); }      // Si no es desactiva el botó corresponent
                        if ($("#username").val() && $("#password").val() && $("#confirm").val()) { $("#btn-2").removeAttr('disabled'); }
                        else { $("#btn-2").attr('disabled', 'disabled'); }
                    });
                    $("#confirm").on('input', function () {      // Al confirmar la contrasenya comprova que la resta de inputs tinguin informació
                        if ($("#username").val() && $("#password").val() && $("#confirm").val()) { $("#btn-2").removeAttr('disabled'); }
                        else { $("#btn-2").attr('disabled', 'disabled'); }  // Si no es desactiva el botó 'Registrar'
                    });
                }
            });
        </script>
    </head>
    <body class="bg-light">
        <div id="accessibleButton" onclick="toggleAccessibility();" class="d-flex"><i tabindex="1" role="button" title="Activar mode accessible" class="fas fa-universal-access ml-auto m-4" style="font-size: 45px; cursor: pointer;"></i></div>
        <div class="container d-flex" style="height: 85vh;">
            <form class="form-signin mx-auto align-self-center" action="login.php" method="POST" style="width: 100%; max-width: 445px;">
                <div class="row mx-auto justify-content-center">
                    <a tabindex="1" role="button" href="#" class="h3 mb-3 font-weight-normal mx-2" style="text-decoration: underline;" id="iniciar" onclick="iniciar(); return false;">Iniciar Sessió</a>
                    <a tabindex="1" role="button" href="#" class="h3 mb-3 font-weight-normal mx-2" id="registrar" onclick="registrar(); return false;">Registrar-se</a>
                </div>
                <input tabindex="1" type="text" name="username" id="username" class="form-control" placeholder="Nom d'usuari" required aria-label="Iniciar sessió, nom d'usuari.">
                <div class="row my-1">
                    <div class="col-sm-6 mb-1"><input tabindex="1" type="password" name="password" id="password" class="form-control" placeholder="Contrasenya" required aria-label="Inici de sessió, contrasenya."></div>
                    <div class="col-sm-6 mb-3"><input tabindex="1" hidden type="password" name="confirm" id="confirm" class="form-control" placeholder="Confirmar contrasenya" aria-label="Registrar-se, confirmar contrasenya."></div>
                </div>
                <div class="checkbox mb-3">
                    <label><input tabindex="1" type="checkbox" id="show" onclick="changePass();"> Mostrar contrasenya</label>
                </div>
                <button tabindex="1" class="btn btn-lg btn-primary btn-block" id="btn-1" type="submit" name="entrar" disabled>Entrar</button>
                <button tabindex="1" class="btn btn-lg btn-primary btn-block" id="btn-2" type="submit" name="registrar" disabled hidden>Registrar-se</button> <?php
                if ($_SESSION['error'] === 1) { ?> <div autofocus class="alert alert-danger mt-5"><strong>Error:</strong> Nom d'usuari o contrasenya incorrectes.</div> <?php }
                if ($_SESSION['error'] === 2) { ?> <div autofocus class="alert alert-danger mt-5"><strong>Error:</strong> La contrasenya no coincideix.</div> <?php }
                if ($_SESSION['error'] === 3) { ?> <div autofocus class="alert alert-danger mt-5"><strong>Error:</strong> Nom d'usuari ja existent.</div> <?php } ?>
                <input type="hidden" id="accessibility" name="accessibility" value="">
            </form>
        </div>
        <script type="text/javascript">
            function iniciar() {        // Al fer click en Iniciar Sessió
                $(".col-sm-6").addClass("col-sm-12");
                $(".col-sm-6").removeClass("col-sm-6");
                $("#confirm").attr('hidden', 'hidden');    // S'amaga la confirmació de contrasenya
                $("#confirm").removeAttr('required');       // Deixa de ser necessària
                $("#iniciar").attr('style', 'text-decoration: underline');      // Es subratlla el text per indicar la pestanya
                $("#registrar").removeAttr('style');       // Es treu l'estil a la pestanya de registre
                $("#btn-1").removeAttr('hidden');       // S'activa el botó 'Entrar'
                $("#btn-2").attr('hidden', 'hidden');   // S'amaga el botó 'Registrar'
                $("#iniciar").css('cursor', 'pointer');
                $("#registrar").css('cursor', 'pointer');
                $("#username").attr('aria-label', "Iniciar sessió, nom d'usuari.");
                $("#password").attr('aria-label', "Iniciar sessió, contrasenya.");
            }
            function registrar() {      // Al fer click en Registrar-se
                $(".col-sm-12").addClass("col-sm-6");
                $(".col-sm-12").removeClass("col-sm-12");
                $("#confirm").removeAttr('hidden');        // S'activa la confirmació de contrasenya
                $("#confirm").attr('required', 'required');       // Obligàtoria per avançar
                $("#registrar").attr('style', 'text-decoration: underline');       // Es subratlla el text per indicar la pestanya
                $("#iniciar").removeAttr('style');        // Es treu l'estil a la pestanya d'inici de sessió
                $("#btn-2").removeAttr('hidden');       // S'activa el botó Registrar
                $("#btn-1").attr('hidden', 'hidden');       // S'amaga el boto 'Entrar'
                $("#iniciar").css('cursor', 'pointer');
                $("#registrar").css('cursor', 'pointer');
                $("#username").attr('aria-label', "Registrar-se, nom d'usuari.");
                $("#password").attr('aria-label', "Registrar-se, contrasenya.");
            }
            function changePass() { // Checkbox per mostrar i ocultar les contrasenyes
                if ($("#show").is(":checked")) {        // Si s'ha activat la checkbox les contrasenyes es tornen de tipus 'text'
                    $("#password").prop('type', 'text');
                    $("#confirm").prop('type', 'text');
                }
                else { // Si la checkbox està desactivada, les contrasenyes seran de tipus 'password'
                    $("#password").prop('type', 'password');
                    $("#confirm").prop('type', 'password');
                }
            }
        </script>
    </body>
</html>