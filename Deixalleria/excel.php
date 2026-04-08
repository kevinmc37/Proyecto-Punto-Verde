<?php session_start();
require_once('./classes/Assimilables.php');
require_once('./classes/Categories.php');
require_once('./classes/Control.php');
require_once('./classes/Deixalles.php');
require_once('./classes/Especials.php');
require_once('./classes/Municipis.php');
require_once('./classes/Raes.php');
require_once('./extra/PHPExcel-1.8/Classes/PHPExcel.php');      // Inclou la llibreria de PHPExcel
try {       // Fa la conexió amb la BBDD
    $conexion = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USER , PASSWORD);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $columnsChar = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $objPHPExcel = new PHPExcel();      // Crea un objecte d'excel
    $objPHPExcel->getProperties()->setTitle("Taula de residus");        // Dóna un titol a l'objecte
    $objPHPExcel->getDefaultStyle()->getAlignment()     // Centra el text de les cel·les
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getDefaultStyle()->getAlignment()     // Centra el text verticalment
        ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    header('Content-Type: application/vnd.ms-excel');       // Indica l'exensió de l'arxiu
    if (isset($_POST['general'])) {      // Si s'ha escollit l'informació d'entrades...
        header('Content-Disposition: attachment; filename="informacio_entrades.xls"');      // Li dóna un nom a l'arxiu a descarregar
        $objPHPExcel->getActiveSheet()->getStyle("C1:G1")->getFont()->setBold(true);        // Converteix en negreta la primera fila d'informació
        $objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);       // Converteix en negreta la primera cel·la i la deixa seleccionada
        $y = 1;
        $columnsNum = "1234567";
        $deixalles;
        if (isset($_SESSION['nifConsulta'])) { $deixalles = Deixalles::buscarDeixallesUsuari($_SESSION['nifConsulta'], $_SESSION['consultaData1'], $_SESSION['consultaData2']); }
        else if (isset($_SESSION['municipisConsulta'])) { $deixalles = Deixalles::buscarDeixallesMunicipi($_SESSION['municipisConsulta'], $_SESSION['consultaData1'], $_SESSION['consultaData2']); }
        else { $deixalles = Deixalles::buscarDeixallesData($_SESSION['consultaData1'], $_SESSION['consultaData2']); }
        unset($_SESSION['nifConsulta']);
        unset($_SESSION['municipisConsulta']);
        $totalEntrades = count($deixalles);      // Compta totes les entrades que cumpleixen el criteri de cerca
        $municipis = Municipis::obtenirMunicipis();        // Obté tots els municipis de la BBDD
        $categories = Categories::obtenirCategories();      // Obté totes les categories d'usuari de la BBDD
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Total Entrades')      // Escriu a l'arxiu la primera fila (header)
                ->setCellValue('C1', 'Població')
                ->setCellValue('D1', 'Entrades')
                ->setCellValue('E1', 'Administració')
                ->setCellValue('F1', 'Empreses')
                ->setCellValue('G1', 'Privats')
                ->setCellValue('A2', $totalEntrades);
        foreach ($municipis as $key_muni) {     // Per cada municipi de la BBDD...
            $x = 4;
            $id_municipi = $key_muni->getIdMunicipi();      // Obté l'ID del municipi
            $nom_municipi = $key_muni->getNom();        // Obté el nom del municipi
            $entradesMun = Deixalles::entradesMunicipisExcel($id_municipi);        // Comprova del total d'entrades les que són d'aquest municipi
            $entradesTotalsMun = array_map('unserialize', array_intersect(array_map('serialize', $deixalles), array_map('serialize', $entradesMun)));
            foreach ($categories as $key_cats) {        // Per cada categoria d'usuari...
                    $rowChar = substr($columnsChar, $x, 1);     // Agafa la columna on insertar l'informació
                    $rowNum = substr($columnsNum, $y, 1);       // Agafa la fila on insertar l'informació
                    $row = $rowChar.$rowNum;        // Especifica la cel·la on insertar l'informació
                    $id_categoria = $key_cats->getIdCategoria();        // Obté l'ID de la categoria d'usuari
                    $entradesCat = Deixalles::entradesCategoriesExcel($id_municipi, $id_categoria); // Obté les entrades del municipi amb categoria corresponent
                    $entradesTotalsCat = array_map('unserialize', array_intersect(array_map('serialize', $deixalles), array_map('serialize', $entradesMun), array_map('serialize', $entradesCat)));
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($row, count($entradesTotalsCat));     // Inserta l'informació a la cel·la especificada
                    $x++;
            }
            for ($compt = $x-5; $compt < 4; $compt++) {     // Torna enrere unes cel·les per insertar el municipi i les entrades totals d'aquest
                $rowChar = substr($columnsChar, $compt, 1);
                $row = $rowChar.$rowNum;
                if ($rowChar === 'C') { $objPHPExcel->setActiveSheetIndex(0)->setCellValue($row, $nom_municipi); }
                elseif ($rowChar === 'D') { $objPHPExcel->setActiveSheetIndex(0)->setCellValue($row, count($entradesTotalsMun)); }
            }
            $y++;
        }
        $objPHPExcel->getActiveSheet()->setTitle("Informació d'entrades");      // Li dóna un títol a la pàgina excel
    }
    elseif (isset($_POST['entrades'])) {
        header('Content-Disposition: attachment; filename="informacio_global.xls"');        // Li dóna un nom a l'arxiu a descarregar
        $objPHPExcel->getActiveSheet()->getStyle("B1:AJ1")->getFont()->setBold(true);      // Converteix en negreta els noms dels RAES de la primera fila
        $objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);       // Converteix en negreta la primera cel·la i la deixa seleccionada
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'NIF')     // Escriu a l'arxiu la primera fila (header)
                ->setCellValue('B1', 'Categoria')
                ->setCellValue('C1', 'Població')
                ->setCellValue('D1', 'Raó')
                ->setCellValue('E1', 'Control')
                ->setCellValue('F1', 'Data')
                ->setCellValue('H1', 'Paper')
                ->setCellValue('I1', 'Vidre')
                ->setCellValue('J1', 'Plàstic')
                ->setCellValue('K1', 'Ferralla')
                ->setCellValue('L1', 'Tèxtil')
                ->setCellValue('M1', 'Oli Vegetal')
                ->setCellValue('N1', 'Fusta')
                ->setCellValue('O1', 'Volum')
                ->setCellValue('Q1', 'Pneumàtics')
                ->setCellValue('R1', 'Bateries')
                ->setCellValue('S1', 'Disolvent')
                ->setCellValue('T1', 'Pintura')
                ->setCellValue('U1', 'Oli Mineral')
                ->setCellValue('V1', 'Amiant')
                ->setCellValue('W1', 'Verd')
                ->setCellValue('X1', 'Piles')
                ->setCellValue('Y1', 'Aerosols')
                ->setCellValue('Z1', 'Inflamables')
                ->setCellValue('AA1', 'Hidrocarburs')
                ->setCellValue('AB1', 'Càpsules')
                ->setCellValue('AC1', 'Runes')
                ->setCellValue('AD1', 'Altres Especials')
                ->setCellValue('AF1', 'Nom RAES')
                ->setCellValue('AG1', 'Categoria')
                ->setCellValue('AH1', 'Pes')
                ->setCellValue('AI1', 'Marca')
                ->setCellValue('AJ1', 'Nº de Sèrie');
        $cells = 1;     // Emmagatzema la fila on insertar l'informació
        $entrada = array();
        for ($x = 0; $x < count($_SESSION['excelResiduId']); $x++) {        // Compta les entrades a insertar
            $cells++;
            $salt_linia = "";
            $entrada[28] = $salt_linia;
            $entrada[29] = $salt_linia;
            $entrada[30] = 0;
            $entrada[31] = $salt_linia;
            $entrada[32] = $salt_linia;
            $rowCharCompt = 0;
            $controlador = 0;
            $id_deix = Deixalles::consultarDeixalles($_SESSION['excelDeixId'][$x]);        // Obté l'ID de les deixalles
            foreach ($id_deix as $key_deix) {
                $id_control = Control::mostrarControl($_SESSION['excelDeixId'][$x]);     // Obté l'ID de control per cada deixalla
                foreach ($id_control as $key_cont) {
                    $controlador = $key_cont->getNom();     // Retorna el nom del controlador de l'entrada
                }
            }     // Obté el nom del controlador de l'entrada
            $entrada[0] = $_SESSION['excelNif'][$x];        // Guarda el NIF de l'usuari de l'entrada
            $entrada[1] = $_SESSION['excelCategoria'][$x];      // Guarda la categoria de l'usuari
            $entrada[2] = $_SESSION['excelPoblacio'][$x];       // Guarda el municipi de l'usuari
            $entrada[3] = $_SESSION['excelRao'][$x];     // Guarda la raó de l'usuari
            $entrada[4] = $controlador;     // Guarda el controlador de l'entrada
            $entrada[5] = $_SESSION['excelData'][$x];       // Guarda la data de l'entrada
            $id_assim = $_SESSION['excelResiduId'][$x];
            $residus_assims = Assimilables::mostrarAssimilables($id_assim);       // Obté tots els residus assimilables de l'entrada
            foreach ($residus_assims as $key_assim) {       // Per cada residu assimilable, si n'hi ha com a mínim 1...
                if ($key_assim->getPaper() != 0 || $key_assim->getVidre() != 0 || $key_assim->getPlastic() != 0 || $key_assim->getFerralla() != 0 || $key_assim->getTextil() != 0 || $key_assim->getOli() != 0 || $key_assim->getFusta() != 0 || $key_assim->getVolum() != 0) {
                    if ($key_assim->getPaper() === "1") { $entrada[6] = "Sí"; }
                    if ($key_assim->getVidre() === "1") { $entrada[7] = "Sí"; }
                    if ($key_assim->getPlastic() === "1") { $entrada[8] = "Sí"; }
                    if ($key_assim->getFerralla() === "1") { $entrada[9] = "Sí"; }
                    if ($key_assim->getTextil() === "1") { $entrada[10] = "Sí"; }
                    if ($key_assim->getOli() === "1") { $entrada[11] = "Sí"; }
                    if ($key_assim->getFusta() === "1") { $entrada[12] = "Sí"; }
                    if ($key_assim->getVolum() === "1") { $entrada[13] = "Sí"; }
                }       // Si no troba residus assimilables per aquesta entrada...
                else {
                    for ($compt = 6; $compt <= 13; $compt++) {
                        $entrada[$compt] = "";
                    }
                }
            }
            $id_esp = $_SESSION['excelResiduId'][$x];
            $residus_especials = Especials::mostrarEspecials($id_esp);     // Obté tots els residus especials de l'entrada
            foreach ($residus_especials as $key_esp) {      // Per cada residu especial, si n'hi ha com a mínim 1...
                if ($key_esp->getPneumatics() != 0 || $key_esp->getBateries() != 0 || $key_esp->getDisolvent() !== 0 || $key_esp->getPintura() != 0 || $key_esp->getOli() != 0 || $key_esp->getAmiant() != 0 || $key_esp->getCarrerRunes() != "" || $key_esp->getVerd() != 0 || $key_esp->getPiles() != 0 || $key_esp->getAerosols() != 0 || $key_esp->getInflamables() != 0 || $key_esp->getHidrocarburs() != 0 || $key_esp->getCapsules() != 0  || $key_esp->getAltres() != "") {
                    $entrada[14] = $key_esp->getPneumatics();
                    $entrada[15] = $key_esp->getBateries();
                    if ($key_esp->getDisolvent() === "1") { $entrada[16] = "Sí"; }
                    if ($key_esp->getPintura() === "1") { $entrada[17] = "Sí"; }
                    if ($key_esp->getOli() === "1") { $entrada[18] = "Sí"; }
                    if ($key_esp->getAmiant() === "1") { $entrada[19] = "Sí"; }
                    if ($key_esp->getVerd() === "1") { $entrada[20] = "Sí"; }
                    if ($key_esp->getPiles() === "1") { $entrada[21] = "Sí"; }
                    if ($key_esp->getAerosols() === "1") { $entrada[22] = "Sí"; }
                    if ($key_esp->getInflamables() === "1") { $entrada[23] = "Sí"; }
                    if ($key_esp->getHidrocarburs() === "1") { $entrada[24] = "Sí"; }
                    if ($key_esp->getCapsules() === "1") { $entrada[25] = "Sí"; }
                    if ($key_esp->getCarrerRunes() !== "") { $entrada[26] = $key_esp->getCarrerRunes(); }
                    if ($key_esp->getAltres() !== "") { $entrada[27] = $key_esp->getAltres(); }
                }
                else {      // Si no troba residus especials per aquesta entrada...
                    for ($compt = 14; $compt <= 27; $compt++) {
                        $entrada[$compt] = "";
                    }
                }
            }
            $id_raes = $_SESSION['excelResiduId'][$x];
            $raes = Raes::mostrarRaes($id_raes);      // Obté tots els residus RAES de l'entrada
            foreach ($raes as $key_rae) {       // Per cada residu RAES, si no és nul...
                if ($key_rae->getSubcategoria() !== '') {
                    $entrada[28] .= $salt_linia.$key_rae->getNom();
                    $entrada[29] .= $salt_linia.$key_rae->getSubcategoria();
                    $entrada[30] += $key_rae->getPes();
                    $entrada[31] .= $salt_linia.$key_rae->getMarca();
                    $entrada[32] .= $salt_linia.$key_rae->getNumSerie();
                }
                else {      // Si no troba el residu RAES per aquesta entrada...
                    for ($compt = 29; $compt <= 32; $compt++) {
                        $entrada[$compt] = "";
                    }
                }
                $salt_linia = "\n";
            }
            for ($compt = 0; $compt < 33; $compt++) {       // Per cada cel·la d'informació a insertar...
                if ($compt < 6) { $rowChar = substr($columnsChar, $compt, 1); }     // Agafa la columna on insertar l'informació
                elseif ($compt >= 6 && $compt < 14) { $rowChar = substr($columnsChar, $compt+1, 1); }       // Agafa la columna on insertar l'informació
                elseif ($compt >= 14 && $compt < 24) { $rowChar = substr($columnsChar, $compt+2, 1); }      // Agafa la columna on insertar l'informació
                elseif ( $compt >= 24 && $compt < 28 ) {      // Agafa la columna on insertar l'informació (al passar la columna Z)
                    $rowChar = "A".substr($columnsChar, $rowCharCompt, 1);
                    $rowCharCompt++;
                }
                else {      // Agafa la columna on insertar l'informació (al passar la columna Z)
                    $rowChar = "A".substr($columnsChar, $rowCharCompt+1, 1);
                    $rowCharCompt++;
                }
                $row = $rowChar.$cells;     // Especifica la cel·la on insertar l'informació
                if ($compt >= 28 || $compt <= 32) {
                    $objPHPExcel->getActiveSheet()->getStyle($row)->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getRowDimension($cells)->setRowHeight(50);
                }
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($row, $entrada[$compt]);     // Inserta l'informació a la cel·la especificada
            }
        }
        $objPHPExcel->getActiveSheet()->setTitle("Informació de residus");      // Li dóna un títol a la pàgina excel
    }
    foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {      // Per cada objecte d'excel creat...
        $objPHPExcel->setActiveSheetIndex($objPHPExcel->getIndex($worksheet));      // Selecciona la pàgina excel
        $sheet = $objPHPExcel->getActiveSheet();        // Guarda la pàgina
        $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();     // Estructura l'arxiu excel
        foreach ($cellIterator as $cell) { $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true); } // Dóna un tamany suficient a cada columna
    }
    $objPHPExcel->setActiveSheetIndex(0);       // Selecciona la primera pàgina excel
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');      // Crea l'arxiu excel
    $objWriter->save('php://output');       // Guarda l'arxiu amb l'informació
    exit;
}
catch(PDOException $e) { echo "Connection failed: " . $e->getMessage(); }