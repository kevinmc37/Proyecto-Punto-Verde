<?php session_start();
require_once('./classes/Administracio.php');
require_once('./classes/LlistaRaes.php');
require_once('./classes/Subcategories.php');
require_once('./classes/Usuaris.php');
if (empty($_SESSION['login'])) { header('Location: login.php'); } // Comprova si s'ha fet el login, si no, redirigeix a ell
if ($_SESSION['power'] < 1) { header('Location: index.php'); } // Comprova si l'usuari té poders d'administrador per accedir ?>
<html lang="ca">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>Ajuntament de Les Masies de Voltregà</title>
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
                $("#nifList a").click( function() {
                    $("#nifList").next().attr('value', $(this).attr('value'));
                    $("#btn-11").removeAttr('disabled');
                });
                $("#subcategoriaRaes a").click( function () {      // Comprova si ja hi han les dades necessàries per continuar amb el registre de residus
                        $("#subcategoriaRaes").next().attr('value', $(this).attr('value'));
                        if ($("#subcategoriaRaes").next().val() && $("#nomResidu").val()) { $("#btn-12").removeAttr('disabled'); }
                        else { $("#btn-12").attr('disabled', 'disabled'); }
                });
                $("#nomResidu").on('input', function () {
                    if ($("#subcategoriaRaes").next().val()) { $("#btn-12").removeAttr('disabled'); }
                    else { $("#btn-12").attr('disabled', 'disabled'); }
                });
            });
            function deleteUser() {     // Al fer click en 'Eliminar Usuari' de administrar.php
                $.ajax({
                    type: "POST",
                    url: "procesa.php",
                    data: "usuari_eliminat=" + $("#nifList").next().val(), // Identifica l'usuari mitjançant el seu DNI
                    success: function (opciones) {
                        if (confirm(opciones)) { $("#formEliminarUser").submit(); }      // Envia el pop-up i s'envia el formulari si s'accepta
                    }
                });
            }
            function showPass() { // Checkbox per mostrar i ocultar les contrasenyes
                if ($("#show").is(":checked")) {        // Si s'ha activat la checkbox les contrasenyes es tornen de tipus 'text'
                    $("#currentPass").prop('type', 'text');
                    $("#newPass").prop('type', 'text');
                    $("#repeatPass").prop('type', 'text');
                }
                else { // Si la checkbox està desactivada, les contrasenyes seran de tipus 'password'
                    $("#currentPass").prop('type', 'password');
                    $("#newPass").prop('type', 'password');
                    $("#repeatPass").prop('type', 'password');
                }
            }
        </script>
    </head>
    <body class="bg-light"> <?php
        $_SESSION['residusOkay'] = false;
        $_SESSION['current'] = "administrar";
        include 'menu.php'; ?> <!-- Inclou el menú navbar -->
        <div class="container my-3">
            <h1 class="col-12 mb-3">Administrar usuaris/residus</h1> <?php
            if (isset($_POST['nifList'])) {
                Usuaris::eliminarUsuari($_POST['nifList']); ?>
                <div class="form-row col-11">
                    <div autofocus class="alert alert-success mt-5 mx-auto" >Usuari <strong>eliminat</strong> correctament.</div>
                </div> <?php
            }
            elseif (isset($_POST['addResidu'])) {       // Si s'afegeix un residu el registra a la BBDD, i si la categoria no hi és, també
                $id_nom = LlistaRaes::comptarLlistaResidus();
                LlistaRaes::registrarResidus($id_nom, $_POST['nomResidu'], $_POST['subcategoriaRaes']); ?>
                <div class="form-row col-11">
                    <div autofocus class="alert alert-success mt-5 mx-auto" >Residu <strong>afegit</strong> correctament.</div>
                </div> <?php
            }
            elseif (isset($_POST['addAdmin'])) { // Afegeix un nou administrador
                $power = 1;
                if ($_POST['newPass'] === $_POST['repeatPass']) {     // Comprova que les contrasenyes siguin iguals
                    $dadesAdmin = Administracio::dadesAdminRegistre($_POST['admin']);       // Comprova si existeix...
                    if (empty($dadesAdmin)) {
                        Administracio::registrarAdmin($_POST['admin'], $_POST['newPass'], $power); ?>
                        <div class="form-row col-11">
                            <div autofocus class="alert alert-success mt-5 mx-auto" >Administrador <strong>registrat</strong> correctament.</div>
                        </div> <?php
                    } // Registra l'administrador
                    else {
                        Administracio::canviarPoders($_POST['admin']); ?>
                        <div class="form-row col-11">
                            <div autofocus class="alert alert-success mt-5 mx-auto" >Poders d'administració <strong>concedits</strong> correctament.</div>
                        </div> <?php
                    } // Si ja existeix li canvia els poders
                }
                else { ?>
                    <div class="form-row col-11">
                        <div autofocus class="alert alert-danger mt-5 mx-auto" >Les contrasenyes noves <strong>no coincideixen</strong>.</div>
                    </div> <?php
                }
            }
            elseif (isset($_POST['changePass'])) {     // Si es vol canviar la contrasenya d'administrador...
                $dadesAdmin = Administracio::dadesAdminLogin($_POST['admin'], $_POST['currentPass']);   // Comprova que existeixi...
                if (!empty($dadesAdmin)) {
                    if ($_POST['newPass'] === $_POST['repeatPass']) {
                        Administracio::canviarAdmin($_POST['newPass'], $_POST['admin']); ?>
                        <div class="form-row col-11">
                            <div autofocus class="alert alert-success mt-5 mx-auto" >Contrasenya <strong>canviada</strong> correctament.</div>
                        </div> <?php
                    }
                    else { ?>
                        <div class="form-row col-11">
                            <div autofocus class="alert alert-danger mt-5 mx-auto" >Les contrasenyes noves <strong>no coincideixen</strong>.</div>
                        </div> <?php
                    }
                }
                else { ?>
                    <div class="form-row col-11">
                        <div autofocus class="alert alert-danger mt-5 mx-auto" >L'usuari <strong>no existeix</strong>.</div>
                    </div> <?php
                }
            } ?>
            <form class="form-row" action="administrar.php" method="POST" id="formEliminarUser">
                <div class="form-group col-md-8">
                    <div class="dropdown">
                        <div tabindex="1" class="dropbtn form-control text-left pl-3">Escull un usuari<i class="dropbtn fas fa-caret-down"></i></div>
                        <div role="list" id="nifList" class="dropdown-content">
                            <input role="search" tabindex="1" class="cerca form-control" type="text" placeholder="Buscar usuaris..." id="cercaUsuaris"> <?php
                            $dni = Usuaris::obtenirUsuaris();
                            foreach ($dni as $key_dni) { ?>       <!-- Carrega els usuaris de la BBDD -->
                                <a role="option" tabindex="1" value="<?php echo $key_dni->getNif(); ?>" class="anchorOption"> <?php
                                    echo $key_dni->getNif() . " | " . $key_dni->getCognom1() . " " . $key_dni->getCognom2() . " " . $key_dni->getNom(); ?>
                                </a> <?php
                            } ?>
                        </div>
                        <input type="hidden" name="nifList">
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <button tabindex="1" class="btn btn-md btn-danger" type="button" id="btn-11" onclick="deleteUser();" disabled> Eliminar usuari </button>
                </div>
            </form>
            <br>
            <form class="form-row" action="administrar.php" method="POST">
                <div class="form-group col-md-4">
                    <input tabindex="1" type="text" class="form-control" id="nomResidu" name="nomResidu" placeholder="Nom del residu">
                </div>
                <div class="form-group col-md-4">
                    <div class="dropdown">
                        <div tabindex="1" class="dropbtn form-control text-left pl-3">Escull una categoria<i class="dropbtn fas fa-caret-down"></i></div>
                        <div role="list" id="subcategoriaRaes" class="dropdown-content">
                            <input role="search" tabindex="1" class="cerca form-control" type="text" placeholder="Buscar categories..." id="cercaCategories"> <?php
                            $subcategoria = Subcategories::obtenirSubcategories();
                            foreach ($subcategoria as $key_sub) { ?>       <!-- Carrega els usuaris de la BBDD -->
                                <a role="option" tabindex="1" value="<?php echo $key_sub->getNom(); ?>" class="anchorOption"> <?php
                                    echo $key_sub->getNom(); ?>
                                </a> <?php
                            } ?>
                        </div>
                        <input type="hidden" name="subcategoriaRaes">
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <button tabindex="1" class="btn btn-md btn-success" type="submit" id="btn-12" name="addResidu" disabled> Afegir residu </button>
                </div>
            </form>
            <br>
            <form class="form-row" action="administrar.php" method="POST">
                <div class="form-group col-md-6">
                    <input tabindex="1" type="text" class="form-control" id="admin" name="admin" required placeholder="Nom d'usuari">
                </div>
                <div class="form-group col-md-6">
                    <input tabindex="1" type="password" class="form-control" id="currentPass" name="currentPass" required placeholder="Contrasenya actual">
                </div>
                <div class="form-group col-md-6">
                    <input tabindex="1" type="password" class="form-control" id="newPass" name="newPass" required placeholder="Nova contrasenya">
                </div>
                <div class="form-group col-md-6">
                    <input tabindex="1" type="password" class="form-control" id="repeatPass" name="repeatPass" required placeholder="Repetir nova contrasenya">
                </div>
                <div class="form-group m-2">
                    <button tabindex="1" class="btn btn-md btn-success" type="submit" id="btn-13" name="changePass"> Canviar contrasenya </button>
                </div>
                <div class="form-group m-2">
                    <button tabindex="1" class="btn btn-md btn-success" type="submit" id="btn-14" name="addAdmin"> Afegir administrador </button>
                </div>
                <div class="checkbox mt-3">
                    <label><input tabindex="1" type="checkbox" id="show" onclick="showPass();"> Mostrar contrasenyes</label>
                </div>
            </form>
        </div>
    </body>
</html>