<?php session_start();
require_once './classes/Assimilables.php';
require_once './classes/Deixalles.php';
require_once './classes/Especials.php';
require_once './classes/Raes.php';
header("Content-Type: text/html;charset=utf-8"); // Es comprova l'informació entrada i s'assigna valors nuls a les que no han d'entrar
$raes2 = false;
$raes3 = false;
if (!isset($_POST['numPneumatics'])) { $_POST['numPneumatics'] = 0; }
if (!isset($_POST['numBateries'])) { $_POST['numBateries'] = 0; }
if (!isset($_POST['carrerRunes'])) { $_POST['carrerRunes'] = ""; }
if (!isset($_POST['nomAltres'])) { $_POST['nomAltres'] = ""; }
if (isset($_POST['paper'])) { $_POST['paper'] = 1; }
else { $_POST['paper'] = 0; }
if (isset($_POST['vidre'])) { $_POST['vidre'] = 1; }
else { $_POST['vidre'] = 0; }
if (isset($_POST['plastic'])) { $_POST['plastic'] = 1; }
else { $_POST['plastic'] = 0; }
if (isset($_POST['ferralla'])) { $_POST['ferralla'] = 1; }
else { $_POST['ferralla'] = 0; }
if (isset($_POST['textil'])) { $_POST['textil'] = 1; }
else { $_POST['textil'] = 0; }
if (isset($_POST['oliVegetal'])) { $_POST['oliVegetal'] = 1; }
else { $_POST['oliVegetal'] = 0; }
if (isset($_POST['fusta'])) { $_POST['fusta'] = 1; }
else { $_POST['fusta'] = 0; }
if (isset($_POST['volum'])) { $_POST['volum'] = 1; }
else { $_POST['volum'] = 0; }
if (isset($_POST['disolvent'])) { $_POST['disolvent'] = 1; }
else { $_POST['disolvent'] = 0; }
if (isset($_POST['pintura'])) { $_POST['pintura'] = 1; }
else { $_POST['pintura'] = 0; }
if (isset($_POST['oliMineral'])) { $_POST['oliMineral'] = 1; }
else { $_POST['oliMineral'] = 0; }
if (isset($_POST['amiant'])) { $_POST['amiant'] = 1; }
else { $_POST['amiant'] = 0; }
if (isset($_POST['verd'])) { $_POST['verd'] = 1; }
else { $_POST['verd'] = 0; }
if (isset($_POST['piles'])) { $_POST['piles'] = 1; }
else { $_POST['piles'] = 0; }
if (isset($_POST['aerosols'])) { $_POST['aerosols'] = 1; }
else { $_POST['aerosols'] = 0; }
if (isset($_POST['inflamables'])) { $_POST['inflamables'] = 1; }
else { $_POST['inflamables'] = 0; }
if (isset($_POST['hidrocarburs'])) { $_POST['hidrocarburs'] = 1; }
else { $_POST['hidrocarburs'] = 0; }
if (isset($_POST['capsules'])) { $_POST['capsules'] = 1; }
else { $_POST['capsules'] = 0; }
if (isset($_POST['nomRaes1']) && isset($_POST['nomRaes2']) && isset($_POST['nomRaes3'])) {
    $raes2 = true;
    $raes3 = true;
}
else if (!isset($_POST['nomRaes1']) && isset($_POST['nomRaes2'])) {
    $_POST['nomRaes1'] = $_POST['nomRaes2'];
    $_POST['subcategoriaRaes1'] = $_POST['subcategoriaRaes2'];
    $_POST['pes1'] = $_POST['pes2'];
    $_POST['marca1'] = $_POST['marca2'];
    $_POST['numSerie1'] = $_POST['numSerie2'];
    if (isset($_POST['nomRaes3'])) {
        $_POST['nomRaes2'] = $_POST['nomRaes3'];
        $_POST['subcategoriaRaes2'] = $_POST['subcategoriaRaes3'];
        $_POST['pes2'] = $_POST['pes3'];
        $_POST['marca2'] = $_POST['marca3'];
        $_POST['numSerie2'] = $_POST['numSerie3'];
        $raes2 = true;
        unset($_POST['nomRaes3']);
    }
    else { unset($_POST['nomRaes2']); }
}
else if (!isset($_POST['nomRaes1']) && isset($_POST['nomRaes3'])) {
    $_POST['nomRaes1'] = $_POST['nomRaes3'];
    $_POST['subcategoriaRaes1'] = $_POST['subcategoriaRaes3'];
    $_POST['pes1'] = $_POST['pes3'];
    $_POST['marca1'] = $_POST['marca3'];
    $_POST['numSerie1'] = $_POST['numSerie3'];
    unset($_POST['nomRaes3']);
}
else if (isset($_POST['nomRaes1']) && !isset($_POST['nomRaes2']) && isset($_POST['nomRaes3'])) {
    $_POST['nomRaes2'] = $_POST['nomRaes3'];
    $_POST['subcategoriaRaes2'] = $_POST['subcategoriaRaes3'];
    $_POST['pes2'] = $_POST['pes3'];
    $_POST['marca2'] = $_POST['marca3'];
    $_POST['numSerie2'] = $_POST['numSerie3'];
    $raes2 = true;
    unset($_POST['nomRaes3']);
}
if (isset($_POST['nomRaes1'])) {
    if (!isset($_POST['pes1'])) { $_POST['pes1'] = 0; }
    if (!isset($_POST['marca1'])) { $_POST['marca1'] = null; }
    else { $_POST['marca1'] = mb_strtoupper($_POST['marca1'], 'UTF-8'); }
    if (!isset($_POST['numSerie1'])) { $_POST['numSerie1'] = null; }
}
else {
    $_POST['nomRaes1'] = "";
    $_POST['subcategoriaRaes1'] = "";
    $_POST['pes1'] = 0;
    $_POST['marca1'] = null;
    $_POST['numSerie1'] = null;
}
if (isset($_POST['nomRaes2'])) {
    if (!isset($_POST['pes2'])) { $_POST['pes2'] = 0; }
    if (!isset($_POST['marca2'])) { $_POST['marca2'] = null; }
    else { $_POST['marca2'] = mb_strtoupper($_POST['marca2'], 'UTF-8'); }
    if (!isset($_POST['numSerie2'])) { $_POST['numSerie2'] = null; }
}
if (isset($_POST['nomRaes3'])) {
    if (!isset($_POST['pes3'])) { $_POST['pes3'] = 0; }
    if (!isset($_POST['marca3'])) { $_POST['marca3'] = null; }
    else { $_POST['marca3'] = mb_strtoupper($_POST['marca3'], 'UTF-8'); }
    if (!isset($_POST['numSerie3'])) { $_POST['numSerie3'] = null; }
}
$idResidu = Assimilables::comptarResidus();       // Assigna un nombre d'identificació als residus
if ($idResidu === NULL) { $idResidu = 1; }
$idDeix = Deixalles::comptarDeixalles();       // Assigna un nombre d'identificació a aquest registre
if ($idDeix === NULL) { $idDeix = 1; }
Assimilables::registrarAssimilables($idResidu, $_POST['paper'], $_POST['vidre'], $_POST['plastic'], $_POST['ferralla'], $_POST['textil'], $_POST['oliVegetal'], $_POST['fusta'], $_POST['volum']);
Especials::registrarEspecials($idResidu, $_POST['numPneumatics'], $_POST['numBateries'], $_POST['disolvent'], $_POST['pintura'], $_POST['oliMineral'], $_POST['amiant'], $_POST['verd'], $_POST['piles'], $_POST['aerosols'], $_POST['inflamables'], $_POST['hidrocarburs'], $_POST['carrerRunes'], $_POST['capsules'], $_POST['nomAltres']);
Raes::registrarRaes($idResidu, $idResidu, $_POST['nomRaes1'], $_POST['subcategoriaRaes1'], $_POST['pes1'], $_POST['marca1'], $_POST['numSerie1']);
Deixalles::registrarDeixalles($idDeix, $_SESSION['dni'], $idResidu, 1);
if ($raes2 === true) {
    Assimilables::registrarAssimilables($idResidu+1, 0, 0, 0, 0, 0, 0, 0, 0);
    Especials::registrarEspecials($idResidu+1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, "", 0, "");
    Raes::registrarRaes($idResidu+1, $idResidu, $_POST['nomRaes2'], $_POST['subcategoriaRaes2'], $_POST['pes2'], $_POST['marca2'], $_POST['numSerie2']);
    if ($raes3 === true) {
        Assimilables::registrarAssimilables($idResidu+2, 0, 0, 0, 0, 0, 0, 0, 0);
        Especials::registrarEspecials($idResidu+2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, "", 0, "");
        Raes::registrarRaes($idResidu+2, $idResidu, $_POST['nomRaes3'], $_POST['subcategoriaRaes3'], $_POST['pes3'], $_POST['marca3'], $_POST['numSerie3']);
    }
}
$_SESSION['residusOkay'] = true;
header('Location: '.'index.php'); // Comprova si s'ha escollit un usuari al qual registrar residus