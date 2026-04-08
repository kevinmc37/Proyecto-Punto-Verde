<?php session_start();
require_once('./classes/Municipis.php');
require_once('./classes/Usuaris.php');
if (empty($_SESSION['login'])) { header('Location: login.php'); } ?>
<html lang="ca"> <!-- Comprova si s'ha fet el login, si no, redirigeix a ell -->
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
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">        <!-- Activa l'estil del Datepicker -->
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>      <!-- Permet utilitzar el Datepicker -->
        <script type="text/javascript">
            $(document).ready(function () {
                $("#nifList a").click( function() { $("#nifList").next().attr('value', $(this).attr('value')); });
                $("#municipis a").click( function () { $("#municipis").next().attr('value', $(this).attr('value')); });     // Comprova si ja hi han les dades necessàries per continuar amb el registre de residus
                $("#consultaData1").change(function () {        // Si s'ha escollit una data inicial...
                    if ($("#consultaData1").val() && $("#consultaData2").val()) {       // Comprova si hi ha una data final
                        $("#btn-8").removeAttr('disabled');     // S'activa el botó 'Buscar >'
                        $("#consultaData1").removeAttr('required');
                        $("#consultaData2").removeAttr('required');
                    }       // Comprova si falta alguna data per activar el botó 'Buscar >'
                    else if ((!$("#consultaData1").val() && $("#consultaData2").val()) || ($("#consultaData1").val() && !$("#consultaData2").val())) {
                        if ($("#nifList").val() || $("#municipis").val()) { $("#btn-8").removeAttr('disabled'); } // Comprova si s'ha escollit un municipi o usuari
                        else if (!$("#nifList").val() && !$("#municipis").val()) { $("#btn-8").attr('disabled', 'disabled'); }
                    }
                    $("#consultaData2").attr('required', 'required');       // Si s'escull data inicial, requereix una data final
                    $("#consultaData1").removeAttr('required');     // No és requerida fins que s'esculli una data final
                    if (!$("#consultaData1").val() && !$("#consultaData2").val()) {     // Si no hi ha cap data, no són obligatòries
                        $("#consultaData1").removeAttr('required');
                        $("#consultaData2").removeAttr('required');
                    }
                });
                $("#consultaData2").change(function () {        // Si s'ha escollit una data final...
                    if ($("#consultaData1").val() && $("#consultaData2").val()) {       // Comprova si hi ha una data inicial
                        $("#btn-8").removeAttr('disabled');     // S'activa el botó 'Buscar >'
                        $("#consultaData1").removeAttr('required');
                        $("#consultaData2").removeAttr('required');
                    }       // Comprova si falta alguna data per activar el botó 'Buscar >'
                    else if ((!$("#consultaData1").val() && $("#consultaData2").val()) || ($("#consultaData1").val() && !$("#consultaData2").val())) {
                        if ($("#nifList").val() || $("#municipis").val()) { $("#btn-8").removeAttr('disabled'); } // Comprova si s'ha escollit un municipi o usuari
                        else if (!$("#nifList").val() && !$("#municipis").val()) { $("#btn-8").attr('disabled', 'disabled'); }
                    }
                    $("#consultaData1").attr('required', 'required');       // Si s'escull data final, requereix una data inicial
                    $("#consultaData2").removeAttr('required');     // No és requerida fins que s'esculli una data inicial
                    if (!$("#consultaData1").val() && !$("#consultaData2").val()) {     // Si no hi ha cap data, no són obligatòries
                        $("#consultaData1").removeAttr('required');
                        $("#consultaData2").removeAttr('required');
                    }
                }); // Si es fa la consulta per municipis comprova que s'hagi escollit un arxiu Excel
                $("#consultaData1").datepicker({
                    dateFormat: "dd/mm/yy",
                    autoclose: true,
                    changeMonth: true,
                    changeYear: true
                });
                $("#consultaData2").datepicker({
                    dateFormat: "dd/mm/yy",
                    autoclose: true,
                    changeMonth: true,
                    changeYear: true
                });
            }); // Si es fa la consulta per data és requerit una data inicial i una data final
        </script>
    </head>
    <body class="bg-light"> <?php
        $_SESSION['residusOkay'] = false;
        $_SESSION['current'] = "consultar";
        include 'menu.php'; ?> <!-- Inclou el menú navbar -->
        <div class="container my-3">
            <h1 class="col-12 mb-3">Consulta de registres</h1>
            <form action="consultarInfo.php" method="POST">
                <div class="form-row col-11">
                    <div class="form-group col-md-8">
                        <div class="dropdown">
                            <div tabindex="1" class="dropbtn form-control text-left pl-3">Escull un usuari<i class="dropbtn fas fa-caret-down"></i></div>
                            <div role="list" id="nifList" class="dropdown-content">
                                <input role="search" tabindex="1" class="cerca form-control" type="text" placeholder="Buscar usuaris..." id="cercaUsuaris"> <?php
                                $dni = Usuaris::obtenirUsuaris();
                                foreach ($dni as $key_dni) { ?>       <!-- Carrega els usuaris de la BBDD -->
                                    <a role="option" tabindex="1" value="<?php echo $key_dni->getNif(); ?>" class="anchorOption consultUser"> <?php
                                        echo $key_dni->getNif() . " | " . $key_dni->getCognom1() . " " . $key_dni->getCognom2() . " " . $key_dni->getNom(); ?>
                                    </a> <?php
                                } ?>
                            </div>
                            <input type="hidden" name="nifList">
                        </div>
                    </div>
                </div>
                <div class="form-row col-11">
                    <div class="form-group col-md-8">
                        <div class="dropdown">
                            <div tabindex="1" class="dropbtn form-control text-left pl-3">Escull un municipi<i class="dropbtn fas fa-caret-down"></i></div>
                            <div role="list" id="municipis" class="dropdown-content">
                                <input role="search" tabindex="1" class="cerca form-control" type="text" placeholder="Buscar municipis..." id="cercaMunicipis"> <?php
                                $municipi = Municipis::obtenirMunicipis();
                                foreach ($municipi as $key_mun) { ?>       <!-- Carrega els usuaris de la BBDD -->
                                    <a role="option" tabindex="1" value="<?php echo $key_mun->getNom(); ?>" class="anchorOption"> <?php
                                        echo $key_mun->getNom(); ?>
                                    </a> <?php
                                } ?>
                            </div>
                            <input type="hidden" name="municipis">
                        </div>
                    </div>
                </div>
                <div class="form-row col-11">
                    <div class="form-group col-md-4">
                        <input tabindex="1" type="text" class="form-control" id="consultaData1" name="consultaData1" placeholder="Data inicial">
                    </div>
                    <div class="form-group col-md-4">
                        <input tabindex="1" type="text" class="form-control" id="consultaData2" name="consultaData2" placeholder="Data final">
                    </div>
                </div>
                <button tabindex="1" id="btn-3" class="btn btn-md btn-default m-2" type="button" onclick="window.location.reload();"> Natejar formulari </button>
                <button tabindex="1" id="btn-8" class="btn btn-md btn-primary m-2" type="submit" name="consultaInfo"> Buscar residus > </button>
                <input type="hidden" id="accessibility" name="accessibility" value="false">
            </form>
        </div>
    </body>
</html>