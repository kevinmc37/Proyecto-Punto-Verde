<?php session_start();
require_once('./classes/Deixalles.php');
require_once('./classes/Municipis.php');
require_once('./classes/Usuaris.php');
require_once('./extra/fpdf181/fpdf.php');
$quantPneumatics = 0;
$quantBateries = 0;
$runes = "";
$altres = "";
$llistaResidus = array();
if (!empty($_POST['numPneumatics'])) {
    array_push($llistaResidus, "PNEUMÀTICS");
    $quantPneumatics = $_POST['numPneumatics'];
}
if (!empty($_POST['numBateries'])) {
    array_push($llistaResidus, "BATERIES");
    $quantBateries = $_POST['numBateries'];
}
//
if (!empty($_POST['paper'])) { array_push($llistaResidus, "PAPER"); }
if (!empty($_POST['vidre'])) { array_push($llistaResidus, "VIDRE"); }
if (!empty($_POST['plastic'])) { array_push($llistaResidus, "PLÀSTIC"); }
if (!empty($_POST['ferralla'])) { array_push($llistaResidus, "FERRALLA"); }
if (!empty($_POST['textil'])) { array_push($llistaResidus, "TÈXTIL"); }
if (!empty($_POST['oliVegetal'])) { array_push($llistaResidus, "OLI VEGETAL"); }
if (!empty($_POST['fusta'])) { array_push($llistaResidus, "FUSTA"); }
if (!empty($_POST['volum'])) { array_push($llistaResidus, "VOLUM"); }
//
if (!empty($_POST['disolvent'])) { array_push($llistaResidus, "DISOLVENT"); }
if (!empty($_POST['pintura'])) { array_push($llistaResidus, "PINTURA"); }
if (!empty($_POST['oliMineral'])) { array_push($llistaResidus, "OLI MINERAL"); }
if (!empty($_POST['amiant'])) { array_push($llistaResidus, "AMIANT"); }
if (!empty($_POST['verd'])) { array_push($llistaResidus, "VERD"); }
if (!empty($_POST['piles'])) { array_push($llistaResidus, "PILES"); }
if (!empty($_POST['aerosols'])) { array_push($llistaResidus, "AEROSOLS"); }
if (!empty($_POST['inflamables'])) { array_push($llistaResidus, "INFLAMABLES"); }
if (!empty($_POST['hidrocarburs'])) { array_push($llistaResidus, "HIDROCARBURS"); }
if (!empty($_POST['capsules'])) { array_push($llistaResidus, "CÀPSULES"); }
if (!empty($_POST['carrerRunes'])) {
    $runes = "RUNES, ".mb_strtoupper($_POST['carrerRunes'], 'UTF-8');
    array_push($llistaResidus, $runes);
}
if (!empty($_POST['nomAltres'])) {
    $altres = mb_strtoupper($_POST['nomAltres'], 'UTF-8');
    array_push($llistaResidus, $altres);
}
//
if (!empty($_POST['nomRaes1'])) {
    $raes = $_POST['nomRaes1'];
    if (!empty($_POST['marca1'])) { $raes = $raes.", ".$_POST['marca1']; }
    array_push($llistaResidus, mb_strtoupper($raes, 'UTF-8'));
}
if (!empty($_POST['nomRaes2'])) {
    $raes = $_POST['nomRaes2'];
    if (!empty($_POST['marca2'])) { $raes = $raes.", ".$_POST['marca2']; }
    array_push($llistaResidus, mb_strtoupper($raes, 'UTF-8'));
}
if (!empty($_POST['nomRaes3'])) {
    $raes = $_POST['nomRaes3'];
    if (!empty($_POST['marca3'])) { $raes = $raes.", ".$_POST['marca3']; }
    array_push($llistaResidus, mb_strtoupper($raes, 'UTF-8'));
}
$rao = "";
$adreça = "";
$poblacio = "";
$usuari = Usuaris::mostrarUsuaris($_SESSION['dni']);
foreach ($usuari as $user) {
    $rao = $user->getRao();
    if ($user->getPisos() !== NULL && $user->getPisos() !== "") { $adreça = $user->getCarrerNom().", nº".$user->getCarrerNum().". Pis: ".$user->getPisos(); }
    else { $adreça = $user->getCarrerNom().", nº".$user->getCarrerNum(); }
    $municipi = Municipis::especificarMunicipis($_SESSION['dni']);
    foreach ($municipi as $muni) {
        $poblacio = $muni->getCodiPostal()." ".$muni->getNom();
    }
}
$idDeix = Deixalles::comptarDeixalles();       // Assigna un nombre d'identificació a aquest registre
if ($idDeix === NULL) { $idDeix = 1; }
$pdf = new FPDF();
$pdf->AddPage();
$pdf->Image('./imatges/logo.png', 15, 10, 80, 30);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, 32, "", 0, 1);
$pdf->Cell(10, 5, "", 0, 0);
//
$str = "AJUNTAMENT LES MASIES DE VOLTREGÀ,\nDeixalleria Municipal\nN.I.F: P0811600F\nC/ Onze de Setembre, 42\n08508 LES MASIES DE VOLTREGÀ\nTel.: 938 570 028\nmasiesv@diba.cat";
$str = iconv('UTF-8', 'windows-1252', $str);
$x=$pdf->GetX();
$y=$pdf->GetY();
$pdf->Multicell(90, 5, $str, 0, 'L');
$pdf->SetXY($x+90, $y);
//
$rao = iconv('UTF-8', 'windows-1252', $rao);
$adreça = iconv('UTF-8', 'windows-1252', $adreça);
$poblacio = iconv('UTF-8', 'windows-1252', $poblacio);
$pdf->MultiCell(90, 5, $rao."\n".$adreça."\n".$poblacio."\nBARCELONA\nN.I.F: ".$_SESSION['dni']."\n \n ", 1, 'L');
//
$pdf->Cell(190, 5, "_________________________________________________________________________________________________", 0, 1);
$str = "Nº albarà: ";
$str = iconv('UTF-8', 'windows-1252', $str);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 5, $str, 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, 5, $idDeix, 0, 0);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(13, 5, "Data: ", 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(20, 5, date("d/m/y"), 0, 1);
$pdf->Cell(190, 5, "", 0, 1);
$str = "DESCRIPCIÓ                                                                                  QUANTITAT";
$str = iconv('UTF-8', 'windows-1252', $str);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(190, 5, $str, 1, 1);
$pdf->SetFont('Arial', '', 10);
foreach ($llistaResidus as $residu) {
    $nomResidu = $residu;
    $residu = iconv('UTF-8', 'windows-1252', $residu);
    if (strlen($residu) <= 40) {
        $pdf->Cell(102.4, 5, $residu, 0, 0);
        if ($nomResidu === "PNEUMÀTICS") { $pdf->Cell(87, 5, $quantPneumatics, 0, 1); }
        elseif ($nomResidu === "BATERIES") { $pdf->Cell(87, 5, $quantBateries, 0, 1); }
        else {
            if ($nomResidu === "PAPER" || $nomResidu === "VIDRE" || $nomResidu === "PLÀSTIC" || $nomResidu === "FERRALLA" || $nomResidu === "TÈXTIL" || $nomResidu === "OLI VEGETAL" || $nomResidu === "FUSTA" || $nomResidu === "VOLUM" || $nomResidu === "DISOLVENT" || $nomResidu === "PINTURA" || $nomResidu === "OLI MINERAL" || $nomResidu === "AMIANT" || $nomResidu === "VERD" || $nomResidu === "PILES" || $nomResidu === "AEROSOLS" || $nomResidu === "INFLAMABLES" || $nomResidu === "HIDROCARBURS" || $nomResidu === "CÀPSULES" || $nomResidu === $runes || $nomResidu === $altres) {
                $pdf->Cell(87, 5, " -", 0, 1);
            }
            else { $pdf->Cell(87, 5, "1", 0, 1); }
        }
    }
    else {
        $nouNom = explode(" ", $residu);
        $part1 = "";
        $part2 = "";
        for ($compt = 0; $compt < round(count($nouNom)/2); $compt++) {
            $part1 .= $nouNom[$compt]." ";
        }
        for ($compt = round(count($nouNom)/2); $compt < count($nouNom); $compt++) {
            $part2 .= $nouNom[$compt]." ";
        }
        $pdf->Cell(102.4, 5, "", 0, 0);
        $pdf->Cell(87, 5, "", 0, 1);
        $pdf->Cell(102.4, 5, $part1, 0, 0);
        $pdf->Cell(87, 5, "", 0, 1);
        $pdf->Cell(102.4, 5, $part2, 0, 0);
        $pdf->Cell(87, 5, "1", 0, 1);
    }
}
$pdf->SetFont('Arial', 'BU', 10);
$pdf->Cell(190, 25, "", 0, 1);
$x=$pdf->GetX();
$y=$pdf->GetY();
$pdf->Multicell(90, 5, "Segell\n\n\n\n\n\n", 1, 'L');
$pdf->SetXY($x+90, $y);
$pdf->Multicell(90, 5, "Firma\n\n\n\n\n\n", 1, 'L');
$pdf->Output();