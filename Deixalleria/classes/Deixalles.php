<?php require_once('./classes/DB.php');
class Deixalles {     // Estructura de la taula 'deixalles' de la BBDD
    protected $idDeix;
    protected $data_;
    protected $nif;
    protected $idAssimilables;
    protected $idEspecials;
    protected $idRaes;
    protected $control;
    
    public function getIdDeix() { return $this->idDeix; }
    public function getData_() { return $this->data_; }
    public function getNif() { return $this->nif; }
    public function getIdAssimilables() { return $this->idAssimilables; }
    public function getIdEspecials() { return $this->idEspecials; }
    public function getIdRaes() { return $this->idRaes; }
    public function getControl() { return $this->control; }
    
    public static function comptarDeixalles() {     // Utilitzada per donar una ID nova a una deixalla registrada
        $sql = "SELECT MAX(ID_Deix)+1 FROM deixalles";
        $resultat = DB::executaConsulta($sql);        // Selecciona l'ID més alta de la taula 'deixalles' i n'afegeix 1
        $comptarDeixalles = array();
        if($resultat) {     // Si s'han trobat resultats...
            $comptarDeixalles = $resultat->fetch();     // Obté el resultat i l'inserta en l'array
        }
        return $comptarDeixalles[0];        // Retorna l'array amb el resultat
    }
    
    public static function totalDeixalles() {       // Utilitzada per comptar totes les entrades de deixalles d'usuaris amb categoria i municipi vàlids
        $sql = "SELECT COUNT(*) FROM deixalles WHERE NIF NOT IN (SELECT NIF FROM usuaris WHERE ID_Categoria NOT IN (SELECT Categoria FROM categories) OR ID_Municipi NOT IN (SELECT Nom FROM municipis))";
        $resultat = DB::executaConsulta($sql);        // Obté el nombre d'entrades de la taula 'deixalles' que són d'usuaris vàlids
        $totalDeixalles = array();
        if($resultat) {     // Si s'han trobat resultats...
            $totalDeixalles = $resultat->fetch();     // Obté el resultat i l'inserta en l'array
        }
        return $totalDeixalles[0];        // Retorna l'array amb el resultat
    }
    // Utilitzar per registrar una nova deixalla d'un usuari
    public static function registrarDeixalles($idDeix, $nif, $idResidu, $control) {
        $sql = "INSERT INTO deixalles(ID_Deix, Data_, NIF, ID_Assimilables, ID_Especials, ID_Raes, Control) VALUES(?,current_date,?,?,?,?,?)";
        $registrarDeixalles = array($idDeix, $nif, $idResidu, $idResidu, $idResidu, $control);
        $resultat = DB::executaConsultaPrepare($sql, $registrarDeixalles);
    }
    
    public static function mostrarDeixalles() {       // Utilitzada per obtenir totes les deixalles de la BBDD
        $sql = "SELECT * FROM deixalles";
        $resultat = DB::executaConsulta($sql);        // Obté totes les dades de la taula 'deixalles'
        $mostrarDeixalles = array();
        if ($resultat) {     // Si s'han trobat resultats...
            $row = $resultat->fetch();      // Obté el resultat de cada columna de la primera fila
            while ($row!=null) {        // Mentre s'obtingui un resultat...
                $mostrarDeixalles[] = new Deixalles($row);      // Inserta a l'array el resultat de la fila
                $row = $resultat->fetch();      // Obté el resultat de la següent fila
            }
        }
        return $mostrarDeixalles;     // Retorna l'array amb tots els resultats
    }
    
    public static function consultarDeixalles($id_deix) {       // Utilitzada per obtenir l'ID de cada deixalla a outputExcel.php
        $sql = "SELECT * FROM deixalles WHERE ID_Deix = '$id_deix'";
        $resultat = DB::executaConsulta($sql);        // Obté totes les dades de la taula 'deixalles' amb ID = paràmetre
        $consultarDeixalles = array();
        if ($resultat) {     // Si s'han trobat resultats...
            $row = $resultat->fetch();      // Obté el resultat de cada columna de la primera fila
            while ($row!=null) {        // Mentre s'obtingui un resultat...
                $consultarDeixalles[] = new Deixalles($row);      // Inserta a l'array el resultat de la fila
                $row = $resultat->fetch();      // Obté el resultat de la següent fila
            }
        }
        return $consultarDeixalles;     // Retorna l'array amb tots els resultats
    }
    
    public static function buscarDeixallesData($dataInicial, $dataFinal) {      // Utilitzada per fer consultes de deixalles per data
        $sql = "SELECT * FROM deixalles WHERE Data_ >= '$dataInicial' AND Data_ <= '$dataFinal' ORDER BY ID_Deix, Data_, NIF ASC";
        $resultat = DB::executaConsulta($sql);        // Obté totes les dades de la taula 'deixalles' compreses entre 2 dates concretes
        $buscarDeixallesData = array();
        if($resultat) {     // Si s'han trobat resultats...
            $row = $resultat->fetch();      // Obté el resultat de cada columna de la primera fila
            while ($row!=null) {        // Mentre s'obtingui un resultat...
                $buscarDeixallesData[] = new Deixalles($row);      // Inserta a l'array el resultat de la fila
                $row = $resultat->fetch();      // Obté el resultat de la següent fila
            }
        }
        return $buscarDeixallesData;     // Retorna l'array amb tots els resultats
    }
    
    public static function buscarDeixallesUsuari($nif, $dataInicial, $dataFinal) {      // Utilitzada per fer consultes de deixalles per usuaris
        $sql = "SELECT deixalles.* FROM deixalles, usuaris WHERE deixalles.NIF = usuaris.NIF AND usuaris.NIF = '$nif' AND Data_ >= '$dataInicial' AND Data_<= '$dataFinal' ORDER BY ID_Deix, Data_, NIF ASC";
        $resultat = DB::executaConsulta($sql);        // Obté totes les dades de la taula 'deixalles' entrades per un usuari amb NIF = paràmetre
        $buscarDeixallesUsuari = array();
        if($resultat) {     // Si s'han trobat resultats...
            $row = $resultat->fetch();      // Obté el resultat de cada columna de la primera fila
            while ($row!=null) {        // Mentre s'obtingui un resultat...
                $buscarDeixallesUsuari[] = new Deixalles($row);      // Inserta a l'array el resultat de la fila
                $row = $resultat->fetch();      // Obté el resultat de la següent fila
            }
        }
        return $buscarDeixallesUsuari;     // Retorna l'array amb tots els resultats
    }
    
    public static function buscarDeixallesMunicipi($municipi, $dataInicial, $dataFinal) {   // Utilitzada per fer consultes de deixalles per municipis
        $sql = "SELECT deixalles.* FROM deixalles, usuaris WHERE deixalles.NIF = usuaris.NIF AND usuaris.ID_Municipi = '$municipi' AND Data_ >= '$dataInicial' AND Data_ <= '$dataFinal' ORDER BY ID_Deix, Data_, NIF ASC";
        $resultat = DB::executaConsulta($sql);        // Obté totes les dades de la taula 'deixalles' que corresponen al municipi = paràmetre
        $buscarDeixallesMunicipi = array();
        if($resultat) {     // Si s'han trobat resultats...
            $row = $resultat->fetch();      // Obté el resultat de cada columna de la primera fila
            while ($row!=null) {        // Mentre s'obtingui un resultat...
                $buscarDeixallesMunicipi[] = new Deixalles($row);      // Inserta a l'array el resultat de la fila
                $row = $resultat->fetch();      // Obté el resultat de la següent fila
            }
        }
        return $buscarDeixallesMunicipi;     // Retorna l'array amb tots els resultats
    }
    
    public static function actualitzarDeixalles($nouNif, $nif) {
        $sql = "UPDATE deixalles SET NIF = ? WHERE NIF = ?";
        $actualitzarDeixalles = array($nouNif, $nif);
        $resultat = DB::executaConsultaPrepare($sql, $actualitzarDeixalles);
    }
    
    public static function entradesMunicipisExcel($municipi) {      // Utilitzada per obtenir el nombre d'entrades que s'han fet en un municipi
        $sql = "SELECT * FROM (SELECT deixalles.* FROM deixalles, usuaris, municipis WHERE usuaris.NIF = deixalles.NIF AND usuaris.ID_Municipi = municipis.Nom AND municipis.ID_Municipi = $municipi AND deixalles.NIF NOT IN (SELECT NIF FROM usuaris WHERE ID_Categoria NOT IN (SELECT Categoria FROM categories))) AS inst1";
        $resultat = DB::executaConsulta($sql);        // Compta totes les entrades que han fet usuaris d'un municipi amb categoria vàlida
        $entradesMunicipisExcel = array();
        if($resultat) {     // Si s'han trobat resultats...
            $row = $resultat->fetch();     // Obté el resultat i l'inserta en l'array
            while ($row!=null) {        // Mentre s'obtingui un resultat...
                $entradesMunicipisExcel[] = new Deixalles($row);      // Inserta a l'array el resultat de la fila
                $row = $resultat->fetch();      // Obté el resultat de la següent fila
            }
        }
        return $entradesMunicipisExcel;        // Retorna l'array amb el resultat
    }
    // Utilitzada per obtenir el nombre d'entrades fet per usuaris d'una categoria en un municipi concret
    public static function entradesCategoriesExcel($municipi, $categoria) {
        $sql = "SELECT * FROM (SELECT deixalles.* FROM deixalles, usuaris, municipis, categories WHERE usuaris.NIF = deixalles.NIF AND usuaris.ID_Municipi = municipis.Nom AND municipis.ID_Municipi = $municipi AND usuaris.ID_Categoria = categories.Categoria AND categories.ID_Categoria = $categoria) AS inst1";
        $resultat = DB::executaConsulta($sql);        // Compta totes les entrades que han fet usuaris d'una categoria específica en un municipi
        $entradesCategoriesExcel = array();
        if($resultat) {     // Si s'han trobat resultats...
            $row = $resultat->fetch();     // Obté el resultat i l'inserta en l'array
            while ($row!=null) {        // Mentre s'obtingui un resultat...
                $entradesCategoriesExcel[] = new Deixalles($row);      // Inserta a l'array el resultat de la fila
                $row = $resultat->fetch();      // Obté el resultat de la següent fila
            }
        }
        return $entradesCategoriesExcel;        // Retorna l'array amb el resultat
    }
    
    public function __construct($row) {
        $this->idDeix=$row['ID_Deix'];
        $this->data_=$row['Data_'];
        $this->nif=$row['NIF'];
        $this->idAssimilables=$row['ID_Assimilables'];
        $this->idEspecials=$row['ID_Especials'];
        $this->idRaes=$row['ID_Raes'];
        $this->control=$row['Control'];
    }
}
