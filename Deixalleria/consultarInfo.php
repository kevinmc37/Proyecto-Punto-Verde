<?php session_start();
require_once('./classes/Assimilables.php');
require_once('./classes/Deixalles.php');
require_once('./classes/Especials.php');
require_once('./classes/Raes.php');
require_once('./classes/Usuaris.php');
if (empty($_SESSION['login'])) { header('Location: login.php'); } ?> <!-- Comprova si s'ha fet el login, si no, redirigeix a ell -->
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
            $(document).ready(function () { // Remarca els residus que sí s'han registrat al passar per sobre de la taula
                $(".table").css('text-align', 'center');
                $('.hover').hover(function() {
                    $('td:has(i.fa-check)').css('background-color', 'greenyellow');
                    $('td:has(i.fa-check)').css('transition', '1s');
                },
                function() {        // Al treure el ratolí dels residus la taula torna a la normalitat
                    $('td:has(i.fa-check)').css('background-color', '');
                    $('td:has(i.fa-check)').css('transition', '1s');
                });
            });
        </script>
    </head>
    <body class="bg-light"> <?php
        include 'menu.php'; ?> <!-- Inclou el menú navbar -->
        <div class="container my-3"> <?php
            if (empty($_POST['consultaData1'])) {       // Si no hi ha consulta per data
                $_POST['consultaData1'] = '01/01/2000';
                $_POST['consultaData2'] = '01/01/2100';
            }       //  Passa les dates al format de la BBDD i es fa la consulta depenent de si es per data, usuari o municipi
            $date1 = DateTime::createFromFormat('d/m/Y', $_POST['consultaData1']);
            $date2 = DateTime::createFromFormat('d/m/Y', $_POST['consultaData2']);
            $_POST['consultaData1'] = $date1->format('Y/m/d');
            $_POST['consultaData2'] = $date2->format('Y/m/d');
            if (!empty($_POST['nifList'])) {
                $dadesDeixalles = Deixalles::buscarDeixallesUsuari($_POST['nifList'], $_POST['consultaData1'], $_POST['consultaData2']);
                $_SESSION['nifConsulta'] = $_POST['nifList'];
            }
            else if (!empty($_POST['municipis'])) {
                $dadesDeixalles = Deixalles::buscarDeixallesMunicipi($_POST['municipis'], $_POST['consultaData1'], $_POST['consultaData2']);
                $_SESSION['municipisConsulta'] = $_POST['municipis'];
            }
            else if (!empty($_POST['consultaData1']) && !empty($_POST['consultaData2'])) { $dadesDeixalles = Deixalles::buscarDeixallesData($_POST['consultaData1'], $_POST['consultaData2']); }
            else { $dadesDeixalles = Deixalles::mostrarDeixalles(); }
            $_SESSION['consultaData1'] = $_POST['consultaData1'];
            $_SESSION['consultaData2'] = $_POST['consultaData2']; ?>
            <div class="row">
                <form action="excel.php" method="POST">
                    <button tabindex="1" class="btn btn-primary m-2" type="submit" name="general"> Informacio general </button>
                    <button tabindex="1" class="btn btn-success m-2" type="submit" name="entrades"> Llista d'entrades</button>
                </form>
            </div>
            <h1>Residus assimilables</h1>
            <div class="row table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>NIF</th>
                            <th>Data</th>
                            <th>Paper</th>
                            <th>Vidre</th>
                            <th>Plàstic</th>
                            <th>Ferralla</th>
                            <th>Tèxtil</th>
                            <th>Oli Vegetal</th>
                            <th>Fusta</th>
                            <th>Volum</th>
                        </tr>
                    </thead>
                    <tbody class="hover"> <!-- S'inserta l'informació a la taula de residus assimilables --><?php
                    $_SESSION['excelResiduId'] = array();
                    $_SESSION['excelDeixId'] = array();
                    $_SESSION['excelNif'] = array();
                    $_SESSION['excelCategoria'] = array();
                    $_SESSION['excelPoblacio'] = array();
                    $_SESSION['excelData'] = array();
                    $x = 0;     // Per cada entrada de la consulta...
                    foreach ($dadesDeixalles as $key_dat) {     // Es guarda l'informació general i l'ID dels residus assimilables
                        $idAssim = $key_dat->getIdAssimilables();
                        $idDeix = $key_dat->getIdDeix();
                        $_SESSION['excelResiduId'][$x] = $idAssim;
                        $_SESSION['excelDeixId'][$x] = $idDeix;
                        $_SESSION['excelNif'][$x] = $key_dat->getNif();
                        $dadesUsuari = Usuaris::mostrarUsuaris($_SESSION['excelNif'][$x]);
                        foreach ($dadesUsuari as $key_data) {
                            $_SESSION['excelCategoria'][$x] = $key_data->getIdCategoria();
                            $_SESSION['excelPoblacio'][$x] = $key_data->getIdMunicipi();
                            $_SESSION['excelRao'][$x] = $key_data->getRao();
                        }
                        $data = $key_dat->getData_();
                        $_SESSION['excelData'][$x] = date("d/m/Y", strtotime($data));
                        $dadesAssim = Assimilables::mostrarAssimilables($idAssim); // Es busca cada residu assimilable de l'entrada... 
                        foreach ($dadesAssim as $key_assim) {       // I la mostra si té com a mínim 1 residu
                            if ($key_assim->getPaper() != 0 || $key_assim->getVidre() != 0 || $key_assim->getPlastic() != 0 || $key_assim->getFerralla() != 0 || $key_assim->getTextil() != 0 || $key_assim->getOli() != 0 || $key_assim->getFusta() != 0 || $key_assim->getVolum() != 0) { ?>
                                <tr>
                                    <td><?php echo $key_dat->getNif(); ?></td>
                                    <td><?php echo $_SESSION['excelData'][$x] ?></td>
                                    <?php $img = $key_assim->getPaper();        // Si el residu està registrat per l'usuari...
                                    if ($img === "1") { ?> <td><i class="fas fa-check"></i></td> <?php }
                                    else { ?> <td><i class="fas fa-times"></i></td> <?php }
                                    $img = $key_assim->getVidre();
                                    if ($img === "1") { ?> <td><i class="fas fa-check"></i></td> <?php }
                                    else { ?> <td><i class="fas fa-times"></i></td> <?php }
                                    $img = $key_assim->getPlastic();
                                    if ($img === "1") { ?> <td><i class="fas fa-check"></i></td> <?php }
                                    else { ?> <td><i class="fas fa-times"></i></td> <?php }
                                    $img = $key_assim->getFerralla();
                                    if ($img === "1") { ?> <td><i class="fas fa-check"></i></td> <?php }
                                    else { ?> <td><i class="fas fa-times"></i></td> <?php }
                                    $img = $key_assim->getTextil();
                                    if ($img === "1") { ?> <td><i class="fas fa-check"></i></td> <?php }
                                    else { ?> <td><i class="fas fa-times"></i></td> <?php }
                                    $img = $key_assim->getOli();
                                    if ($img === "1") { ?> <td><i class="fas fa-check"></i></td> <?php }
                                    else { ?> <td><i class="fas fa-times"></i></td> <?php }
                                    $img = $key_assim->getFusta();
                                    if ($img === "1") { ?> <td><i class="fas fa-check"></i></td> <?php }
                                    else { ?> <td><i class="fas fa-times"></i></td> <?php }
                                    $img = $key_assim->getVolum();
                                    if ($img === "1") { ?> <td><i class="fas fa-check"></i></td> <?php }
                                    else { ?> <td><i class="fas fa-times"></i></td> <?php } ?>
                                </tr> <?php
                            }
                        }
                        $x++;
                    } ?>
                    </tbody>
                </table>
            </div>
            <h1>Residus especials</h1>
            <div class="row table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>NIF</th>
                            <th>Data</th>
                            <th>Pneumàtics</th>
                            <th>Bateries</th>
                            <th>Disolvent</th>
                            <th>Pintura</th>
                            <th>Oli Mineral</th>
                            <th>Amiant</th>
                            <th>Runes</th>
                            <th>Verd</th>
                            <th>Piles</th>
                            <th>Aerosols</th>
                            <th>Inflamables</th>
                            <th>Hidrocarburs</th>
                            <th>Càpsules</th>
                            <th>Altres</th>
                        </tr>
                    </thead>
                    <tbody class="hover"> <?php // S'inserta l'informació a la taula de residus especials -->
                    $x = 0;
                    foreach ($dadesDeixalles as $key_dat) {     // Per cada entrada de la consulta es busquen les ID dels residus especials
                        $idEsp = $key_dat->getIdEspecials();
                        $dadesEsp = Especials::mostrarEspecials($idEsp);       // Es busca cada residu especial de l'entrada...
                        foreach ($dadesEsp as $key_esp) {       // I la mostra si té com a mínim 1 residu
                            if ($key_esp->getPneumatics() != 0 || $key_esp->getBateries() != 0 || $key_esp->getDisolvent() != 0 || $key_esp->getPintura() != 0 || $key_esp->getOli() != 0 || $key_esp->getAmiant() != 0 || $key_esp->getCarrerRunes() != "" || $key_esp->getVerd() != 0 || $key_esp->getPiles() != 0 || $key_esp->getAerosols() != 0 || $key_esp->getInflamables() != 0 || $key_esp->getHidrocarburs() != 0 || $key_esp->getCapsules() != 0 || $key_esp->getAltres() != null) { ?>
                                <tr>
                                    <td><?php echo $key_dat->getNif() ?></td>
                                    <td><?php echo $_SESSION['excelData'][$x] ?></td>
                                    <?php $pneum = $key_esp->getPneumatics();       // Si el residu està registrat per l'usuari...
                                    if ($pneum > 0) { ?> <td><?php echo $key_esp->getPneumatics() ?></td> <?php }
                                    else { ?> <td><?php echo $key_esp->getPneumatics() ?></td> <?php }
                                    $bat = $key_esp->getBateries();
                                    if ($bat > 0) { ?> <td><?php echo $key_esp->getBateries() ?></td> <?php }
                                    else { ?> <td><?php echo $key_esp->getBateries() ?></td> <?php }
                                    $img = $key_esp->getDisolvent();
                                    if ($img === "1") { ?> <td><i class="fas fa-check"></i></td> <?php }
                                    else { ?> <td><i class="fas fa-times"></i></td> <?php }
                                    $img = $key_esp->getPintura();
                                    if ($img === "1") { ?> <td><i class="fas fa-check"></i></td> <?php }
                                    else { ?> <td><i class="fas fa-times"></i></td> <?php }
                                    $img = $key_esp->getOli();
                                    if ($img === "1") { ?> <td><i class="fas fa-check"></i></td> <?php }
                                    else { ?> <td><i class="fas fa-times"></i></td> <?php }
                                    $img = $key_esp->getAmiant();
                                    if ($img === "1") { ?> <td><i class="fas fa-check"></i></td> <?php }
                                    else { ?> <td><i class="fas fa-times"></i></td> <?php }
                                    $runes = $key_esp->getCarrerRunes();
                                    if ($runes !== "") { ?> <td><i class="fas fa-check"></i></td> <?php }
                                    else { ?> <td><i class="fas fa-times"></i></td> <?php }
                                    $img = $key_esp->getVerd();
                                    if ($img === "1") { ?> <td><i class="fas fa-check"></i></td> <?php }
                                    else { ?> <td><i class="fas fa-times"></i></td> <?php }
                                    $img = $key_esp->getPiles();
                                    if ($img === "1") { ?> <td><i class="fas fa-check"></i></td> <?php }
                                    else { ?> <td><i class="fas fa-times"></i></td> <?php }
                                    $img = $key_esp->getAerosols();
                                    if ($img === "1") { ?> <td><i class="fas fa-check"></i></td> <?php }
                                    else { ?> <td><i class="fas fa-times"></i></td> <?php }
                                    $img = $key_esp->getInflamables();
                                    if ($img === "1") { ?> <td><i class="fas fa-check"></i></td> <?php }
                                    else { ?> <td><i class="fas fa-times"></i></td> <?php }
                                    $img = $key_esp->getHidrocarburs();
                                    if ($img === "1") { ?> <td><i class="fas fa-check"></i></td> <?php }
                                    else { ?> <td><i class="fas fa-times"></i></td> <?php }
                                    $img = $key_esp->getCapsules();
                                    if ($img === "1") { ?> <td><i class="fas fa-check"></i></td> <?php }
                                    else { ?> <td><i class="fas fa-times"></i></td> <?php }
                                    $img = $key_esp->getAltres();
                                    if ($img !== "") { ?> <td><i class="fas fa-check"></i></td> <?php }
                                    else { ?> <td><i class="fas fa-times"></i></td> <?php } ?>
                                </tr> <?php
                            }
                        }
                        $x++;
                    } ?>
                    </tbody>
                </table>
            </div>
            <div class="row table-responsive">
                <br><h1>Residus RAES</h1>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>NIF</th>
                            <th>Data</th>
                            <th>Nom</th>
                            <th>Categoria</th>
                            <th>Pes</th>
                            <th>Marca</th>
                            <th>Nº de sèrie</th>
                        </tr>
                    </thead>
                    <tbody> <?php
                        $x = 0;
                        foreach ($dadesDeixalles as $key_dat) { // Per cada entrada de la consulta es busquen les ID dels residus RAES
                            $idRaes = $key_dat->getIdRaes();
                            $dadesRaes = Raes::mostrarRaes($idRaes);
                            foreach ($dadesRaes as $key_raes) { // Es busca cada residu de l'entrada
                                if ($key_raes->getSubcategoria() != '') { // Mostra els residus RAES que no són nuls ?>
                                    <tr> <!-- S'inserta l'informació a la taula de residus RAES -->
                                        <td><?php echo $key_dat->getNif(); ?></td>
                                        <td><?php echo $_SESSION['excelData'][$x]; ?></td>
                                        <td><?php echo $key_raes->getNom(); ?></td>
                                        <td><?php echo $key_raes->getSubcategoria(); ?></td>
                                        <td><?php echo $key_raes->getPes(); ?></td>
                                        <td><?php echo $key_raes->getMarca(); ?></td>
                                        <td><?php echo $key_raes->getNumSerie(); ?></td>
                                    </tr> <?php
                                }
                            }
                            $x++;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>