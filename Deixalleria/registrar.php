<?php session_start();
$_SESSION['accessibility'] = $_POST['accessibility'];
require_once('./classes/LlistaRaes.php');
require_once('./classes/Subcategories.php');
if (empty($_SESSION['login'])) { header('Location: '.'login.php'); }      // Comprova si s'ha fet el login, si no redirigeix a ell
if (empty($_POST)) { header('Location: '.'registrar.php'); }      // Comprova si s'ha escollit un usuari al qual registrar residus ?>
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
                function checkRegistrar() {
                    if ($("#numPneumatics").val() || $("#numBateries").val() || $("#carrerRunes").val() || $("#altresResidus").val() || ($("input[type='checkbox']").filter(':checked').length > 0)) {
                        $("#btn-9").removeAttr('disabled');
                        $("#btn-10").removeAttr('disabled');
                    }
                    else {
                        $("#btn-9").attr('disabled', 'disabled');
                        $("#btn-10").attr('disabled', 'disabled');
                    }
                    if ($("#subcategoriaRaes1").next().val()) {
                        if ($("#nomRaes1").next().attr('value') !== '') {
                            $("#btn-9").removeAttr('disabled');
                            $("#btn-10").removeAttr('disabled');
                        }
                        else {
                            $("#btn-9").attr('disabled', 'disabled');
                            $("#btn-10").attr('disabled', 'disabled');
                        }
                    }
                    if ($("#subcategoriaRaes2").next().val()) {
                        if ($("#nomRaes2").next().attr('value') !== '') {
                            $("#btn-9").removeAttr('disabled');
                            $("#btn-10").removeAttr('disabled');
                        }
                        else {
                            $("#btn-9").attr('disabled', 'disabled');
                            $("#btn-10").attr('disabled', 'disabled');
                        }
                    }
                    if ($("#subcategoriaRaes3").next().val()) {
                        if ($("#nomRaes3").next().attr('value') !== '') {
                            $("#btn-9").removeAttr('disabled');
                            $("#btn-10").removeAttr('disabled');
                        }
                        else {
                            $("#btn-9").attr('disabled', 'disabled');
                            $("#btn-10").attr('disabled', 'disabled');
                        }
                    }
                }
                $("#subcategoriaRaes1 a").click( function () {    // Al escollir una categoria de residu es carreguen els seus residus
                    $("#subcategoriaRaes1").next().attr('value', $(this).attr('value'));
                    $("#nomRaes1").children('a').each(function () {
                        $(this).empty();
                        $(this).attr('value', '');
                    });
                    $.ajax({
                        type: "POST",
                        url: "procesa.php",
                        data: "id_subcategoria=" + $(this).attr('value'),        // Identifica el residu mitjançant el valor del seu Nom
                        success: function (opciones) {
                            $("#nomRaes1 a").html(opciones);
                            $("#nomRaes1").next().val('');
                            $("#nomRaes1").prev().html('Escull un residu<i class="dropbtn fas fa-caret-down"></i>');
                            $("#nomRaes1").children('a').each(function (index) {
                                var array = this.innerHTML.split('@');
                                if ((index in array) && index !== array.length-1) {
                                    this.innerHTML = array[index];
                                    $(this).attr('value', array[index]);
                                }
                                else {
                                    $(this).empty();
                                    $(this).attr('hidden', 'true');
                                }
                            });
                            $('#pes1').attr('disabled', 'disabled');
                            $('#marca1').attr('disabled', 'disabled');
                            $('#numSerie1').attr('disabled', 'disabled');
                            $("#btn-9").attr('disabled', 'disabled');
                            $("#btn-10").attr('disabled', 'disabled');
                        }
                    });
                });
                $("#nomRaes1 a").click( function () {    // Al escollir un residu es carregua la seva categoria
                    $("#nomRaes1").next().attr('value', $(this).attr('value'));
                    $.ajax({
                        type: "POST",
                        url: "procesa.php",
                        data: "id_residu=" + $(this).attr('value'),
                        success: function (opciones) {
                            $("#subcategoriaRaes1").val(opciones);
                            $("#subcategoriaRaes1").next().val(opciones);
                            $("#subcategoriaRaes1").prev().html(opciones + '<i class="dropbtn fas fa-caret-down"></i>');
                            $('#pes1').removeAttr('disabled');
                            $('#marca1').removeAttr('disabled');
                            $('#numSerie1').removeAttr('disabled');
                            $("#btn-9").removeAttr('disabled');
                            $("#btn-10").removeAttr('disabled');
                        }
                    });
                });
                $("#subcategoriaRaes2 a").click( function () {    // Al escollir una categoria de residu es carreguen els seus residus
                    $("#subcategoriaRaes2").next().attr('value', $(this).attr('value'));
                    $("#nomRaes2").children('a').each(function () {
                        $(this).empty();
                        $(this).attr('value', '');
                    });
                    $.ajax({
                        type: "POST",
                        url: "procesa.php",
                        data: "id_subcategoria=" + $(this).attr('value'),        // Identifica el residu mitjançant el valor del seu Nom
                        success: function (opciones) {
                            $("#nomRaes2 a").html(opciones);
                            $("#nomRaes2").next().val('');
                            $("#nomRaes2").prev().html('Escull un residu<i class="dropbtn fas fa-caret-down"></i>');
                            $("#nomRaes2").children('a').each(function (index) {
                                var array = this.innerHTML.split('@');
                                if ((index in array) && index !== array.length-1) {
                                    this.innerHTML = array[index];
                                    $(this).attr('value', array[index]);
                                }
                                else {
                                    $(this).empty();
                                    $(this).attr('hidden', 'true');
                                }
                            });
                            $('#pes2').attr('disabled', 'disabled');
                            $('#marca2').attr('disabled', 'disabled');
                            $('#numSerie2').attr('disabled', 'disabled');
                            $("#btn-9").attr('disabled', 'disabled');
                            $("#btn-10").attr('disabled', 'disabled');
                        }
                    });
                });
                $("#nomRaes2 a").click( function () {    // Al escollir un residu es carregua la seva categoria
                    $("#nomRaes2").next().attr('value', $(this).attr('value'));
                    $.ajax({
                        type: "POST",
                        url: "procesa.php",
                        data: "id_residu=" + $(this).attr('value'),
                        success: function (opciones) {
                            $("#subcategoriaRaes2").val(opciones);
                            $("#subcategoriaRaes2").next().val(opciones);
                            $("#subcategoriaRaes2").prev().html(opciones + '<i class="dropbtn fas fa-caret-down"></i>');
                            $('#pes2').removeAttr('disabled');
                            $('#marca2').removeAttr('disabled');
                            $('#numSerie2').removeAttr('disabled');
                            $("#btn-9").removeAttr('disabled');
                            $("#btn-10").removeAttr('disabled');
                        }
                    });
                });
                $("#subcategoriaRaes3 a").click( function () {    // Al escollir una categoria de residu es carreguen els seus residus
                    $("#subcategoriaRaes3").next().attr('value', $(this).attr('value'));
                    $("#nomRaes3").children('a').each(function () {
                        $(this).empty();
                        $(this).attr('value', '');
                    });
                    $.ajax({
                        type: "POST",
                        url: "procesa.php",
                        data: "id_subcategoria=" + $(this).attr('value'),        // Identifica el residu mitjançant el valor del seu Nom
                        success: function (opciones) {
                            $("#nomRaes3 a").html(opciones);
                            $("#nomRaes3").next().val('');
                            $("#nomRaes3").prev().html('Escull un residu<i class="dropbtn fas fa-caret-down"></i>');
                            $("#nomRaes3").children('a').each(function (index) {
                                var array = this.innerHTML.split('@');
                                if ((index in array) && index !== array.length-1) {
                                    this.innerHTML = array[index];
                                    $(this).attr('value', array[index]);
                                }
                                else {
                                    $(this).empty();
                                    $(this).attr('hidden', 'true');
                                }
                            });
                            $('#pes3').attr('disabled', 'disabled');
                            $('#marca3').attr('disabled', 'disabled');
                            $('#numSerie3').attr('disabled', 'disabled');
                            $("#btn-9").attr('disabled', 'disabled');
                            $("#btn-10").attr('disabled', 'disabled');
                        }
                    });
                });
                $("#nomRaes3 a").click( function () {    // Al escollir un residu es carregua la seva categoria
                    $("#nomRaes3").next().attr('value', $(this).attr('value'));
                    $.ajax({
                        type: "POST",
                        url: "procesa.php",
                        data: "id_residu=" + $(this).attr('value'),
                        success: function (opciones) {
                            $("#subcategoriaRaes3").val(opciones);
                            $("#subcategoriaRaes3").next().val(opciones);
                            $("#subcategoriaRaes3").prev().html(opciones + '<i class="dropbtn fas fa-caret-down"></i>');
                            $('#pes3').removeAttr('disabled');
                            $('#marca3').removeAttr('disabled');
                            $('#numSerie3').removeAttr('disabled');
                            $("#btn-9").removeAttr('disabled');
                            $("#btn-10").removeAttr('disabled');
                        }
                    });
                });
                $("#numPneumatics").on('input', function () { checkRegistrar(); });
                $("#numBateries").on('input', function () { checkRegistrar(); });
                $("#carrerRunes").on('input', function () { checkRegistrar(); });
                $("#altresResidus").on('input', function () { checkRegistrar(); });
                $("input[type='checkbox']").change( function () { checkRegistrar(); });
                $(".checkbox-grid .col-sm-12 label:has(input[type='checkbox']):first-child").css({
                    "float": "left",
                    "width": "47%"
                });
            });
            function creaAlbaran() {
                $("#registrarResidus").removeAttr('action');
                $("#registrarResidus").attr('action','albaran.php');
                $("#registrarResidus").attr('target','_blank');
                $("#registrarResidus").submit();
            }
            function registrarResidus() {
                $("#registrarResidus").removeAttr('target');
                $("#registrarResidus").removeAttr('action');
                $("#registrarResidus").attr('action','registrarResidus.php');
                $("#registrarResidus").submit();
            }
            function disableEmptyInputs(form) {
                var controls = form.elements;
                for (var i = 0, iLen = controls.length; i < iLen; i++) {
                    controls[i].disabled = controls[i].value === '';
                }
            }
        </script>
    </head>
    <body class="bg-light"> <?php
        $_SESSION['residusOkay'] = false;
        include 'menu.php'; ?> <!-- Inclou el menú navbar -->
        <div class="container my-3">
            <h1 class="col-12 mb-3">Registre de residus</h1> <?php
            if (empty($_POST['nomUsuari'])) { $_POST['nomUsuari'] = ""; }
            if (empty($_POST['cognom1Usuari'])) { $_POST['cognom1Usuari'] = ""; }
            if (empty($_POST['cognom2Usuari'])) { $_POST['cognom2Usuari'] = ""; }
            if (empty($_POST['carrerUsuari'])) { $_POST['carrerUsuari'] = ""; }
            if (empty($_POST['rao'])) { $_POST['rao'] = $_POST['nomUsuari']." ".$_POST['cognom1Usuari']." ".$_POST['cognom2Usuari']; }
            if (empty($_POST['telefon'])) { $_POST['telefon'] = null; }
            if (empty($_POST['email'])) { $_POST['email'] = ""; }
            if (!empty($_POST['numUsuari'])) {
                $_SESSION['numCarrer'] = $_POST['numUsuari'];
                $_POST['carrerUsuari'] .= ", nº ".$_SESSION['numCarrer'];
            }
            if (!empty($_POST['pisos'])) {
                $_SESSION['numPis'] = $_POST['pisos'];
                $_POST['carrerUsuari'] .= ", pis ".$_SESSION['numPis'];
            }
            $_SESSION['dni'] = $_POST['nifUsuari']; ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">1r Cognom</th>
                            <th scope="col">2n Cognom</th>
                            <th scope="col">NIF</th>
                            <th scope="col">Categoria</th>
                            <th scope="col">Municipi</th>
                            <th scope="col">Carrer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $_POST['nomUsuari']; ?></td>
                            <td><?php echo $_POST['cognom1Usuari']; ?></td>
                            <td><?php echo $_POST['cognom2Usuari']; ?></td>
                            <td><?php echo $_POST['nifUsuari']; ?></td>
                            <td><?php echo $_POST['categories']; ?></td>
                            <td><?php echo $_POST['municipis']; ?></td>
                            <td><?php echo $_POST['carrerUsuari']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <form action="registrarResidus.php" method="POST" id="registrarResidus" onsubmit="disableEmptyInputs(this)">
                <div class="form-row col-12">
                    <div class="col-sm-5 form-group">
                        <h2>Residus assimilables</h2>
                        <div class="row checkbox-grid">
                            <div class="col-sm-12">
                                <label><input tabindex="1" type="checkbox" name="paper" id="paper"> Paper</label>
                                <label><input tabindex="1" type="checkbox" name="vidre" id="vidre"> Vidre</label>
                            </div>
                            <div class="col-sm-12">
                                <label><input tabindex="1" type="checkbox" name="plastic" id="plastic"> Plàstic</label>
                                <label><input tabindex="1" type="checkbox" name="ferralla" id="ferralla"> Ferralla</label>
                            </div>
                            <div class="col-sm-12">
                                <label><input tabindex="1" type="checkbox" name="textil" id="textil"> Tèxtil</label>
                                <label><input tabindex="1" type="checkbox" name="oliVegetal" id="oliVegetal"> Oli vegetal</label>
                            </div>
                            <div class="col-sm-12">
                                <label><input tabindex="1" type="checkbox" name="fusta" id="fusta"> Fusta</label>
                                <label><input tabindex="1" type="checkbox" name="volum" id="volum"> Volum</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 form-group">
                        <h2>Residus especials</h2> <!-- à, è, ò, é, í, ó, ú -->
                        <div class="row checkbox-grid">
                            <div class="col-sm-12">
                                <label><input tabindex="1" type="checkbox" name="disolvent" id="disolvent"> Disolvent</label>
                                <label><input tabindex="1" type="checkbox" name="piles" id="piles"> Piles</label>
                            </div>
                            <div class="col-sm-12">
                                <label><input tabindex="1" type="checkbox" name="pintura" id="pintura"> Pintura</label>
                                <label><input tabindex="1" type="checkbox" name="aerosols" id="aerosols"> Aerosols</label>
                            </div>
                            <div class="col-sm-12">
                                <label><input tabindex="1" type="checkbox" name="oliMineral" id="oliMineral"> Oli mineral</label>
                                <label><input tabindex="1" type="checkbox" name="inflamables" id="inflamables"> Inflamables</label>
                            </div>
                            <div class="col-sm-12">
                                <label><input tabindex="1" type="checkbox" name="amiant" id="amiant"> Amiant</label>
                                <label><input tabindex="1" type="checkbox" name="hidrocarburs" id="hidrocarburs"> Hidrocarburs</label>
                            </div>
                            <div class="col-sm-12">
                                <label><input tabindex="1" type="checkbox" name="verd" id="verd"> Verd</label>
                                <label><input tabindex="1" type="checkbox" name="capsules" id="capsules"> Càpsules</label><br>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label><input class="form-control" tabindex="1" type="number" name="numPneumatics" id="numPneumatics" min="1" placeholder="Pneumàtics"></label>
                                <label><input class="form-control pr-4" tabindex="1"type="text" name="carrerRunes" id="carrerRunes" placeholder="Runes"></label>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label><input class="form-control" tabindex="1"type="number" name="numBateries" id="numBateries" min="1" placeholder="Bateries"></label>
                                <label><input class="form-control pr-4" tabindex="1"type="text" name="nomAltres" id="nomAltres" placeholder="Altres residus"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row col-12">
                    <h2 class="form-group col-12">Residus RAES</h2>
                    <div class="form-group col-4">
                        <div class="dropdown">
                            <div tabindex="1" class="dropbtn form-control text-left pl-3">Escull una categoria<i class="dropbtn fas fa-caret-down"></i></div>
                            <div role="list" id="subcategoriaRaes1" class="dropdown-content">
                                <input role="search" tabindex="1" class="cerca form-control" type="text" placeholder="Buscar categories..." id="cercaCategories1"> <?php
                                $subcategoria = Subcategories::obtenirSubcategories();
                                foreach ($subcategoria as $key_sub) { ?>       <!-- Carrega els usuaris de la BBDD -->
                                    <a role="option" tabindex="1" value="<?php echo $key_sub->getNom(); ?>" class="anchorOption"> <?php
                                        echo $key_sub->getNom(); ?>
                                    </a> <?php
                                } ?>
                            </div>
                            <input type="hidden" name="subcategoriaRaes1">
                        </div>
                    </div>
                    <div class="form-group col-8">
                        <div class="dropdown">
                            <div tabindex="1" class="dropbtn form-control text-left pl-3">Escull un residu<i class="dropbtn fas fa-caret-down"></i></div>
                            <div role="list" id="nomRaes1" class="dropdown-content">
                                <input role="search" tabindex="1" class="cerca form-control" type="text" placeholder="Buscar residus..." id="cercaResidus1"> <?php
                                $material = LlistaRaes::mostrarLlistaRaes();
                                foreach ($material as $key_mat) { ?>       <!-- Carrega els usuaris de la BBDD -->
                                    <a role="option" tabindex="1" value="<?php echo $key_mat->getNom(); ?>" class="anchorOption"> <?php
                                        echo $key_mat->getNom(); ?>
                                    </a> <?php
                                } ?>
                            </div>
                            <input type="hidden" name="nomRaes1">
                        </div>
                    </div>
                </div>
                <div class="form-row col-12">
                    <div class="form-group col-4">
                        <input tabindex="1" type="number" class="form-control" id="pes1" name="pes1" min="0" placeholder="Pes" disabled>
                    </div>
                    <div class="form-group col-4">
                        <input tabindex="1" type="text" class="form-control" id="marca1" name="marca1" placeholder="Marca" disabled>
                    </div>
                    <div class="form-group col-4">
                        <input tabindex="1" type="text" class="form-control" id="numSerie1" name="numSerie1" placeholder="Nº de sèrie" disabled>
                    </div>
                </div>
                <div class="form-row col-12 mt-4">
                    <div class="form-group col-4">
                        <div class="dropdown">
                            <div tabindex="1" class="dropbtn form-control text-left pl-3">Escull una categoria<i class="dropbtn fas fa-caret-down"></i></div>
                            <div role="list" id="subcategoriaRaes2" class="dropdown-content">
                                <input role="search" tabindex="1" class="cerca form-control" type="text" placeholder="Buscar categories..." id="cercaCategories2"> <?php
                                $subcategoria = Subcategories::obtenirSubcategories();
                                foreach ($subcategoria as $key_sub) { ?>       <!-- Carrega els usuaris de la BBDD -->
                                    <a role="option" tabindex="1" value="<?php echo $key_sub->getNom(); ?>" class="anchorOption"> <?php
                                        echo $key_sub->getNom(); ?>
                                    </a> <?php
                                } ?>
                            </div>
                            <input type="hidden" name="subcategoriaRaes2">
                        </div>
                    </div>
                    <div class="form-group col-8">
                        <div class="dropdown">
                            <div tabindex="1" class="dropbtn form-control text-left pl-3">Escull un residu<i class="dropbtn fas fa-caret-down"></i></div>
                            <div role="list" id="nomRaes2" class="dropdown-content">
                                <input role="search" tabindex="1" class="cerca form-control" type="text" placeholder="Buscar residus..." id="cercaResidus2"> <?php
                                $material = LlistaRaes::mostrarLlistaRaes();
                                foreach ($material as $key_mat) { ?>       <!-- Carrega els usuaris de la BBDD -->
                                    <a role="option" tabindex="1" value="<?php echo $key_mat->getNom(); ?>" class="anchorOption"> <?php
                                        echo $key_mat->getNom(); ?>
                                    </a> <?php
                                } ?>
                            </div>
                            <input type="hidden" name="nomRaes2">
                        </div>
                    </div>
                </div>
                <div class="form-row col-12">
                    <div class="form-group col-4">
                        <input tabindex="1" type="number" class="form-control" id="pes2" name="pes2" min="0" placeholder="Pes" disabled>
                    </div>
                    <div class="form-group col-4">
                        <input tabindex="1" type="text" class="form-control" id="marca2" name="marca2" placeholder="Marca" disabled>
                    </div>
                    <div class="form-group col-4">
                        <input tabindex="1" type="text" class="form-control" id="numSerie2" name="numSerie2" placeholder="Nº de sèrie" disabled>
                    </div>
                </div>
                <div class="form-row col-12 mt-4">
                    <div class="form-group col-4">
                        <div class="dropdown">
                            <div tabindex="1" class="dropbtn form-control text-left pl-3">Escull una categoria<i class="dropbtn fas fa-caret-down"></i></div>
                            <div role="list" id="subcategoriaRaes3" class="dropdown-content">
                                <input role="search" tabindex="1" class="cerca form-control" type="text" placeholder="Buscar categories..." id="cercaCategories3"> <?php
                                $subcategoria = Subcategories::obtenirSubcategories();
                                foreach ($subcategoria as $key_sub) { ?>       <!-- Carrega els usuaris de la BBDD -->
                                    <a role="option" tabindex="1" value="<?php echo $key_sub->getNom(); ?>" class="anchorOption"> <?php
                                        echo $key_sub->getNom(); ?>
                                    </a> <?php
                                } ?>
                            </div>
                            <input type="hidden" name="subcategoriaRaes3">
                        </div>
                    </div>
                    <div class="form-group col-8">
                        <div class="dropdown">
                            <div tabindex="1" class="dropbtn form-control text-left pl-3">Escull un residu<i class="dropbtn fas fa-caret-down"></i></div>
                            <div role="list" id="nomRaes3" class="dropdown-content">
                                <input role="search" tabindex="1" class="cerca form-control" type="text" placeholder="Buscar residus..." id="cercaResidus3"> <?php
                                $material = LlistaRaes::mostrarLlistaRaes();
                                foreach ($material as $key_mat) { ?>       <!-- Carrega els usuaris de la BBDD -->
                                    <a role="option" tabindex="1" value="<?php echo $key_mat->getNom(); ?>" class="anchorOption"> <?php
                                        echo $key_mat->getNom(); ?>
                                    </a> <?php
                                } ?>
                            </div>
                            <input type="hidden" name="nomRaes3">
                        </div>
                    </div>
                </div>
                <div class="form-row col-12">
                    <div class="form-group col-4">
                        <input tabindex="1" type="number" class="form-control" id="pes3" name="pes3" min="0" placeholder="Pes" disabled>
                    </div>
                    <div class="form-group col-4">
                        <input tabindex="1" type="text" class="form-control" id="marca3" name="marca3" placeholder="Marca" disabled>
                    </div>
                    <div class="form-group col-4">
                        <input tabindex="1" type="text" class="form-control" id="numSerie3" name="numSerie3" placeholder="Nº de sèrie" disabled>
                    </div>
                </div>
                <button tabindex="1" id="btn-3" class="btn btn-md btn-default m-2" type="button" onclick="window.location.reload();"> Natejar formulari </button>
                <input tabindex="1" id="btn-9" class="btn btn-md btn-success m-2" type="button" onclick="creaAlbaran();" value=" Fer albarà " disabled>
                <input tabindex="1" id="btn-10" class="btn btn-md btn-primary m-2" type="button" name="residus" onclick="registrarResidus();" value=" Registrar residus " disabled>
                <input type="hidden" id="accessibility" name="accessibility" value="false">
            </form>
        </div>
    </body>
</html>