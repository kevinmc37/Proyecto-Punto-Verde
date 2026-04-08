<?php session_start();
$_SESSION['accessibility'] = $_POST['accessibility'];
require_once('./classes/Usuaris.php');
require_once('./classes/Categories.php');
require_once('./classes/Municipis.php');
if (empty($_SESSION['login'])) { header('Location: '.'login.php'); } // Comprova si s'ha fet el login, si no redirigeix a ell ?>
<html lang="ca">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>Control de residus</title>
        <link rel="stylesheet" href="extra/bootstrap-jquery/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
        <link rel="stylesheet" href="extra/search.css">
        <link rel="stylesheet" href="extra/accessibility.css">
        <script src="extra/bootstrap-jquery/jquery.js"></script>      <!-- jQuery i Ajax -->
        <script src="extra/bootstrap-jquery/popper.min.js"></script>
        <script src="extra/bootstrap-jquery/bootstrap.min.js"></script>
        <script src="extra/search.js"></script>
        <script src="extra/accessibility.js"></script>
        <script type="text/javascript">
            $(document).ready( function () {
                $("#nifList a").click( function() { $("#nifList").next().attr('value', $(this).attr('value')); });
                $("#btn-4").click( function () {        // Guarda l'informació de l'usuari, modificacions i registres
                    $.ajax({
                        type: "POST",
                        url: "procesa.php",
                        data:  "guardar_usuari=" + $("#nifList").val() + "&nou_dni=" + $("#nifUsuari").val() + "&id_categoria=" + $("#categories").val() + "&nom=" + $("#nomUsuari").val() + "&cognom1=" + $("#cognom1Usuari").val() + "&cognom2=" + $("#cognom2Usuari").val() + "&id_municipi=" + $("#municipis").val() + "&carrer=" + $("#carrerUsuari").val() + "&pis=" + $("#pisos").val() + "&numCarrer=" + $("#numUsuari").val(),
                        success: function () { $("#btn-5").removeAttr('disabled'); }    // S'activa el botó 'Següent'
                    });
                    $("#registeredOkay").show();
                    setTimeout(function () { $("#registeredOkay").fadeOut(); }, 3000);
                });
                $("#categories a").click( function () {      // Comprova si ja hi han les dades necessàries per continuar amb el registre de residus
                    $("#categories").next().attr('value', $(this).attr('value'));
                    if ($("#categories").val() === 'EMPRESA' || $("#categories").val() === 'ADMINISTRACIÓ') {
                        $("#cognom1Usuari").removeAttr('required');
                        $("#cognom2Usuari").removeAttr('required');
                    }
                    else {
                        $("#cognom1Usuari").attr('required','required');
                        $("#cognom2Usuari").attr('required','required');
                    }
                    if (($("#categories").val() === 'PRIVATS') && $("#nomUsuari").val() && $("#cognom1Usuari").val() && $("#cognom2Usuari").val() && $("#municipis").val() && $("#nifUsuari").val() && $("#carrerUsuari").val()) { $("#btn-4").removeAttr('disabled'); }
                    else if (($("#categories").val() !== 'PRIVATS') && $("#nomUsuari").val() && $("#municipis").val() && $("#nifUsuari").val() && $("#carrerUsuari").val()) { $("#btn-4").removeAttr('disabled'); }
                    else { $("#btn-4").attr('disabled', 'disabled'); }
                    $("#btn-5").attr('disabled', 'disabled');
                });     // Comprova si ja hi han les dades necessàries per continuar amb el registre de residus
                $("#municipis a").click( function () {
                    $("#municipis").next().attr('value', $(this).attr('value'));
                    if (($("#categories").val() === 'PRIVATS') && $("#nomUsuari").val() && $("#cognom1Usuari").val() && $("#cognom2Usuari").val() && $("#municipis").val() && $("#nifUsuari").val() && $("#carrerUsuari").val()) { $("#btn-4").removeAttr('disabled'); }
                    else if (($("#categories").val() === 'EMPRESA' || $("#categories").val() === 'ADMINISTRACIÓ') && $("#nomUsuari").val() && $("#municipis").val() && $("#nifUsuari").val() && $("#carrerUsuari").val()) { $("#btn-4").removeAttr('disabled'); }
                    else { $("#btn-4").attr('disabled', 'disabled'); }
                    $("#btn-5").attr('disabled', 'disabled');
                });     // Comprova si ja hi han les dades necessàries per continuar amb el registre de residus
                $("#nomUsuari").on('input', function () {
                    if (($("#categories").val() === 'PRIVATS') && $("#nomUsuari").val() && $("#cognom1Usuari").val() && $("#cognom2Usuari").val() && $("#municipis").val() && $("#nifUsuari").val() && $("#carrerUsuari").val()) { $("#btn-4").removeAttr('disabled'); }
                    else if (($("#categories").val() === 'EMPRESA' || $("#categories").val() === 'ADMINISTRACIÓ') && $("#nomUsuari").val() && $("#municipis").val() && $("#nifUsuari").val() && $("#carrerUsuari").val()) { $("#btn-4").removeAttr('disabled'); }
                    else { $("#btn-4").attr('disabled', 'disabled'); }
                    $("#btn-5").attr('disabled', 'disabled');
                });     // Comprova si ja hi han les dades necessàries per continuar amb el registre de residus
                $("#cognom1Usuari").on('input', function () {
                    if (($("#categories").val() === 'PRIVATS') && $("#nomUsuari").val() && $("#cognom1Usuari").val() && $("#cognom2Usuari").val() && $("#municipis").val() && $("#nifUsuari").val() && $("#carrerUsuari").val()) { $("#btn-4").removeAttr('disabled'); }
                    else if (($("#categories").val() === 'EMPRESA' || $("#categories").val() === 'ADMINISTRACIÓ') && $("#nomUsuari").val() && $("#municipis").val() && $("#nifUsuari").val() && $("#carrerUsuari").val()) { $("#btn-4").removeAttr('disabled'); }
                    else { $("#btn-4").attr('disabled', 'disabled'); }
                    $("#btn-5").attr('disabled', 'disabled');
                });     // Comprova si ja hi han les dades necessàries per continuar amb el registre de residus
                $("#cognom2Usuari").on('input', function () {
                    if (($("#categories").val() === 'PRIVATS') && $("#nomUsuari").val() && $("#cognom1Usuari").val() && $("#cognom2Usuari").val() && $("#municipis").val() && $("#nifUsuari").val() && $("#carrerUsuari").val()) { $("#btn-4").removeAttr('disabled'); }
                    else if (($("#categories").val() === 'EMPRESA' || $("#categories").val() === 'ADMINISTRACIÓ') && $("#nomUsuari").val() && $("#municipis").val() && $("#nifUsuari").val() && $("#carrerUsuari").val()) { $("#btn-4").removeAttr('disabled'); }
                    else { $("#btn-4").attr('disabled', 'disabled'); }
                    $("#btn-5").attr('disabled', 'disabled');
                });     // Comprova si ja hi han les dades necessàries per continuar amb el registre de residus
                $("#nifUsuari").on('input', function () {
                    if (($("#categories").val() === 'PRIVATS') && $("#nomUsuari").val() && $("#cognom1Usuari").val() && $("#cognom2Usuari").val() && $("#municipis").val() && $("#nifUsuari").val() && $("#carrerUsuari").val()) { $("#btn-4").removeAttr('disabled'); }
                    else if (($("#categories").val() === 'EMPRESA' || $("#categories").val() === 'ADMINISTRACIÓ') && $("#nomUsuari").val() && $("#municipis").val() && $("#nifUsuari").val() && $("#carrerUsuari").val()) { $("#btn-4").removeAttr('disabled'); }
                    else { $("#btn-4").attr('disabled', 'disabled'); }
                    $("#btn-5").attr('disabled', 'disabled');
                });     // Comprova si ja hi han les dades necessàries per continuar amb el registre de residus
                $("#carrerUsuari").on('input', function () {
                    if (($("#categories").val() === 'PRIVATS') && $("#nomUsuari").val() && $("#cognom1Usuari").val() && $("#cognom2Usuari").val() && $("#municipis").val() && $("#nifUsuari").val() && $("#carrerUsuari").val()) { $("#btn-4").removeAttr('disabled'); }
                    else if (($("#categories").val() === 'EMPRESA' || $("#categories").val() === 'ADMINISTRACIÓ') && $("#nomUsuari").val() && $("#municipis").val() && $("#nifUsuari").val() && $("#carrerUsuari").val()) { $("#btn-4").removeAttr('disabled'); }
                    else { $("#btn-4").attr('disabled', 'disabled'); }
                    $("#btn-5").attr('disabled', 'disabled');
                });
                $("#numUsuari").on('input', function () {
                    if (($("#categories").val() === 'PRIVATS') && $("#nomUsuari").val() && $("#cognom1Usuari").val() && $("#cognom2Usuari").val() && $("#municipis").val() && $("#nifUsuari").val() && $("#carrerUsuari").val()) { $("#btn-4").removeAttr('disabled'); }
                    else if (($("#categories").val() === 'EMPRESA' || $("#categories").val() === 'ADMINISTRACIÓ') && $("#nomUsuari").val() && $("#municipis").val() && $("#nifUsuari").val() && $("#carrerUsuari").val()) { $("#btn-4").removeAttr('disabled'); }
                    else { $("#btn-4").attr('disabled', 'disabled'); }
                    $("#btn-5").attr('disabled', 'disabled');
                });
                $("#pisos").on('input', function () {
                    if (($("#categories").val() === 'PRIVATS') && $("#nomUsuari").val() && $("#cognom1Usuari").val() && $("#cognom2Usuari").val() && $("#municipis").val() && $("#nifUsuari").val() && $("#carrerUsuari").val()) { $("#btn-4").removeAttr('disabled'); }
                    else if (($("#categories").val() === 'EMPRESA' || $("#categories").val() === 'ADMINISTRACIÓ') && $("#nomUsuari").val() && $("#municipis").val() && $("#nifUsuari").val() && $("#carrerUsuari").val()) { $("#btn-4").removeAttr('disabled'); }
                    else { $("#btn-4").attr('disabled', 'disabled'); }
                    $("#btn-5").attr('disabled', 'disabled');
                });
            });
        </script>
    </head>
    <body class="bg-light"> <?php
        $_SESSION['current'] = "registrar";
        include 'menu.php'; // Inclou el menú navbar ?>
        <div class="container my-3">
            <h1 class="col-12 mb-3">Registre d'usuaris</h1>
            <form action="registrar.php" method="POST">
                <div class="form-row col-11">
                    <div class="form-group col-md-8">
                        <div class="dropdown">
                            <div aria-haspopup="listbox" class="dropbtn form-control text-left pl-3">Escull un usuari<i class="dropbtn fas fa-caret-down"></i></div>
                            <div tabindex="-1" role="listbox" id="nifList" class="dropdown-content">
                                <input role="search" tabindex="1" class="cerca form-control" type="text" placeholder="Buscar usuaris..." id="cercaUsuaris"> <?php
                                $dni = Usuaris::obtenirUsuaris();
                                foreach ($dni as $key_dni) { ?>       <!-- Carrega els usuaris de la BBDD -->
                                    <a role="option" tabindex="1" value="<?php echo $key_dni->getNif(); ?>" class="anchorOption chooseUser"> <?php
                                        echo $key_dni->getNif() . " | " . $key_dni->getCognom1() . " " . $key_dni->getCognom2() . " " . $key_dni->getNom(); ?>
                                    </a> <?php
                                } ?>
                            </div>
                            <input type="hidden" name="nifList">
                        </div>
                    </div>
                </div>
                <div class="form-row col-11">
                    <div class="form-group col-md-4">
                        <input tabindex="1" type="text" class="form-control" id="nomUsuari" name="nomUsuari" placeholder="Nom" required>
                    </div>
                    <div class="form-group col-md-4">
                        <input tabindex="1" type="text" class="form-control" id="cognom1Usuari" name="cognom1Usuari" placeholder="1r cognom" required>
                    </div>
                    <div class="form-group col-md-4">
                        <input tabindex="1" type="text" class="form-control" id="cognom2Usuari" name="cognom2Usuari" placeholder="2n cognom" required>
                    </div>
                </div>
                <div class="form-row col-11">
                    <div class="form-group col-md-3">
                        <input tabindex="1" type="text" class="form-control" name="nifUsuari" id="nifUsuari" placeholder="NIF" required>
                    </div>
                    <div class="dropdown form-group col-md-4">
                        <div tabindex="1" class="dropbtn form-control text-left pl-3">Escull una categoria<i class="dropbtn fas fa-caret-down"></i></div>
                        <div role="list" id="categories" class="dropdown-content">
                            <input role="search" tabindex="1" class="cerca form-control" type="text" placeholder="Buscar categories..." id="cercaCategories"> <?php
                            $categoria = Categories::obtenirCategories();
                            foreach ($categoria as $key_cat) { ?>     <!-- Carrega les categories de la BBDD -->
                                <a role="option" tabindex="1" value="<?php echo $key_cat->getCategoria(); ?>" class="anchorOption"> <?php
                                    echo $key_cat->getCategoria(); ?>
                                </a> <?php
                            } ?>
                        </div>
                        <input type="hidden" name="categories">
                    </div>
                    <div class="dropdown form-group col-md-5">
                        <div tabindex="1" class="dropbtn form-control text-left pl-3">Escull un municipi<i class="dropbtn fas fa-caret-down"></i></div>
                        <div role="listbox" id="municipis" class="dropdown-content">
                            <input role="search" tabindex="1" class="cerca form-control" type="text" placeholder="Buscar municipis..." id="cercaMunicipis"> <?php
                            $municipi = Municipis::obtenirMunicipis();
                            foreach ($municipi as $key_mun) { ?>     <!-- Carrega les categories de la BBDD -->
                                <a role="option" tabindex="1" value="<?php echo $key_mun->getNom(); ?>" class="anchorOption"> <?php
                                    echo $key_mun->getNom(); ?>
                                </a> <?php
                            } ?>
                        </div>
                        <input type="hidden" name="municipis">
                    </div>
                </div>
                <div class="form-row col-11">
                    <div class="form-group col-md-7">
                        <input tabindex="1" type="text" class="form-control" id="carrerUsuari" name="carrerUsuari" placeholder="C/" required>
                    </div>
                    <div class="form-group col-md-2">
                        <input tabindex="1" type="number" class="form-control" id="numUsuari" name="numUsuari" min="1" placeholder="Nº">
                    </div>
                    <div class="form-group col-md-3">
                        <input tabindex="1" type="text" class="form-control" id="pisos" name="pisos" placeholder="Pis">
                    </div>
                </div>
                <div class="form-row col-11" hidden>
                    <div class="form-group col-md-4">
                        <input tabindex="1" type="text" class="form-control" id="rao" name="rao" placeholder="Raó">
                    </div>
                    <div class="form-group col-md-4">
                        <input tabindex="1" type="text" class="form-control" id="telefon" name="telefon" placeholder="Telèfon">
                    </div>
                    <div class="form-group col-md-4">
                        <input tabindex="1" type="text" class="form-control" id="email" name="email" placeholder="E-mail">
                    </div>
                </div>
                <button tabindex="1" id="btn-3" class="btn btn-md btn-default m-2" type="button" onclick="window.location.reload();"> Natejar formulari </button>
                <input tabindex="1" id="btn-4" class="btn btn-md btn-success m-2" type="button" name="guardar" value=" Guardar  usuari " disabled>
                <button tabindex="1" id="btn-5" class="btn btn-md btn-primary m-2" type="submit" name="consulta" disabled> Registra residus > </button>
                <div id="registeredOkay" class="form-row col-11" style="display: none;">
                    <div autofocus class="alert alert-success mt-5 mx-auto" >Usuari registrat correctament.</div>
                </div> <?php
                if ($_SESSION['residusOkay'] === true) { ?>
                    <div class="form-row col-11">
                        <div autofocus class="alert alert-success mt-5 mx-auto" >Residus registrats correctament.</div>
                    </div> <?php
                    $_SESSION['residusOkay'] = false;
                } ?>
                <input type="hidden" id="accessibility" name="accessibility" value="<?php echo $_SESSION['accessibility']; ?>">
                <div>
                    <input role="search" tabindex="1" class="cerca cercaAccess form-control" type="text" placeholder="Buscar municipis..." id="cercaHola">
                    <select id="hola" class="form-control">
                        <option value="1">gmrg</option>
                        <option value="2">beif</option>
                        <option value="3">5t8ug</option>
                        <option value="4">gm957rg</option>
                    </select>
                </div>
            </form>
        </div> <?php
        if ($_SESSION['accessibility'] === "true") { ?>
            <script type="text/javascript">toggleAccessibility();</script> <?php
        } ?>
    </body>
</html>