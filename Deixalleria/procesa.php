<?php require_once './classes/Deixalles.php';
require_once './classes/LlistaRaes.php';
require_once './classes/Usuaris.php';
header("Content-Type: text/html;charset=utf-8"); // Carrega tota la informació de l'usuari escollit a index.php
if (isset($_POST['categoria_usuari'])) {
    $consulta = Usuaris::mostrarUsuaris($_POST['categoria_usuari']);
    foreach ($consulta as $key_nif) {
        echo $key_nif->getIdCategoria();
    }
}
if (isset($_POST['nom_usuari'])) {      // Carrega el nom de l'usuari
    $consulta = Usuaris::mostrarUsuaris($_POST['nom_usuari']);
    foreach ($consulta as $key_nif) {
        echo $key_nif->getNom();
    }
}
if (isset($_POST['cognom1_usuari'])) {      // Carrega el primer cognom de l'usuari
    $consulta = Usuaris::mostrarUsuaris($_POST['cognom1_usuari']);
    foreach ($consulta as $key_nif) {
        echo $key_nif->getCognom1();
    }
}
if (isset($_POST['cognom2_usuari'])) {      // Carrega el segon cognom de l'usuari
    $consulta = Usuaris::mostrarUsuaris($_POST['cognom2_usuari']);
    foreach ($consulta as $key_nif) {
        echo $key_nif->getCognom2();
    }
}
if (isset($_POST['nif_usuari'])) {      // Carrega el NIF de l'usuari
    $consulta = Usuaris::mostrarUsuaris($_POST['nif_usuari']);
    foreach ($consulta as $key_nif) {
        echo $key_nif->getNif();
    }
}
if (isset($_POST['municipi_usuari'])) {     // Especifica el municipi del usuari, sortirà el primer de la llista
    $consulta = Usuaris::mostrarUsuaris($_POST['municipi_usuari']);
    foreach ($consulta as $key_nif) {
        echo $key_nif->getIdMunicipi();
    }
}
if (isset($_POST['carrer_usuari'])) {       // Carrega el carrer de l'usuari
    $consulta = Usuaris::mostrarUsuaris($_POST['carrer_usuari']);
    foreach ($consulta as $key_nif) {
        echo $key_nif->getCarrerNom();
    }
}
if (isset($_POST['pis_usuari'])) {     // Especifica el pis del usuari
    $consulta = Usuaris::mostrarUsuaris($_POST['pis_usuari']);
    foreach ($consulta as $key_nif) {
        echo $key_nif->getPisos();
    }
}
if (isset($_POST['num_usuari'])) {      // Carrega el nº de carrer de l'usuari
    $consulta = Usuaris::mostrarUsuaris($_POST['num_usuari']);
    foreach ($consulta as $key_nif) {
        echo $key_nif->getCarrerNum();
    }
}
if (isset($_POST['id_subcategoria'])) { // Carrega els residus de la categoria seleccionada a registrar.php
    $material = LlistaRaes::obtenirRaes($_POST['id_subcategoria']);
    foreach ($material as $key_mat) {
        echo $key_mat->getNom()."@";
    }
}
if (isset($_POST['id_residu'])) { // Carrega la categoria del residu seleccionat a registrar.php
    $material = LlistaRaes::obtenirLlistaRaes($_POST['id_residu']);
    foreach ($material as $key_mat) {
        echo $key_mat->getSubcategoria();
    }
}
if (isset($_POST['guardar_usuari'])) {      // Si es prem el botó 'Guardar' a index.php
    $_POST['nom'] = mb_strtoupper($_POST['nom'], 'UTF-8');
    $_POST['cognom1'] = mb_strtoupper($_POST['cognom1'], 'UTF-8');
    $_POST['cognom2'] = mb_strtoupper($_POST['cognom2'], 'UTF-8');
    $_POST['nou_dni'] = mb_strtoupper($_POST['nou_dni'], 'UTF-8');
    $_POST['carrer'] = mb_strtoupper($_POST['carrer'], 'UTF-8');
    $registrar = Usuaris::mostrarUsuaris($_POST['guardar_usuari']);
    if (empty($registrar)) {        // Si el NIF no és a la base de dades el registra. Si ja hi era l'actualitza
        $rao = $_POST['rao'] = $_POST['nom']." ".$_POST['cognom1']." ".$_POST['cognom2'];
        $rao = mb_strtoupper($rao, 'UTF-8');
        $telefon = NULL;
        $email = "";
        Usuaris::registrarUsuaris($_POST['id_categoria'], $_POST['nom'], $_POST['cognom1'], $_POST['cognom2'], $_POST['nou_dni'], $_POST['id_municipi'], $_POST['carrer'], $_POST['pis'], $_POST['numCarrer'], $rao, $telefon, $email);
    }
    else {
        Usuaris::actualitzarUsuaris($_POST['id_categoria'], $_POST['nom'], $_POST['cognom1'], $_POST['cognom2'], $_POST['id_municipi'], $_POST['nou_dni'], $_POST['carrer'], $_POST['pis'], $_POST['numCarrer'], $_POST['guardar_usuari']);
        Deixalles::actualitzarDeixalles($_POST['nou_dni'], $_POST['guardar_usuari']);
    }
}
if (isset($_POST['usuari_eliminat'])) {    // Al fer click en 'Eliminar Usuari' de administrar.php
    $usuaris = Usuaris::mostrarUsuaris($_POST['usuari_eliminat']);     // Identifica l'usuari seleccionat
    foreach ($usuaris as $identUser) { $nif = $identUser->getNif(); }
    echo "Estàs segur/a d'eliminar l'usuari amb NIF '".$nif."'?";     // Pop-up de seguretat
}