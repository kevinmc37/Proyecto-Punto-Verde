<?php require_once('./classes/DB.php');
class Especials {     // Estructura de la taula 'residus_esp' de la BBDD
    protected $idEsp;
    protected $carrerRunes;
    protected $pneumatics;
    protected $bateries;
    protected $disolvent;
    protected $pintura;
    protected $oli;
    protected $amiant;
    protected $verd;
    protected $piles;
    protected $aerosols;
    protected $inflamables;
    protected $hidrocarburs;
    protected $capsules;
    protected $altres;
    
    public function getIdEsp() { return $this->idEsp; }
    public function getCarrerRunes() { return $this->carrerRunes; }
    public function getPneumatics() { return $this->pneumatics; }
    public function getBateries() { return $this->bateries; }
    public function getDisolvent() { return $this->disolvent; }
    public function getPintura() { return $this->pintura; }
    public function getOli() { return $this->oli; }
    public function getAmiant() { return $this->amiant; }
    public function getVerd() { return $this->verd; }
    public function getPiles() { return $this->piles; }
    public function getAerosols() { return $this->aerosols; }
    public function getInflamables() { return $this->inflamables; }
    public function getHidrocarburs() { return $this->hidrocarburs; }
    public function getCapsules() { return $this->capsules; }
    public function getAltres() { return $this->altres; }
    
    public static function mostrarEspecials($idEsp) {       // Utilitzada per mostrar tots els residus especials amb una ID específica
        $sql = "SELECT * FROM residus_esp WHERE ID_Esp = '$idEsp'";
        $resultat = DB::executaConsulta($sql);        // Obté totes les dades de la taula 'residus_esp' que tenen ID = paràmetre
        $mostrarEspecials = array();
        if($resultat) {     // Si s'han trobat resultats...
            $row = $resultat->fetch();      // Obté el resultat de cada columna de la primera fila
            while ($row!=null) {        // Mentre s'obtingui un resultat...
                $mostrarEspecials[] = new Especials($row);      // Inserta a l'array el resultat de la fila
                $row = $resultat->fetch();      // Obté el resultat de la següent fila
            }
        }
        return $mostrarEspecials;     // Retorna l'array amb tots els resultats
    }
    // Utilitzada per registrar els residus especials de l'entrada registrada a la taula 'deixalles'
    public static function registrarEspecials($idEsp, $pneumatics, $bateries, $disolvent, $pintura, $oli, $amiant, $verd, $piles, $aerosols, $inflamables, $hidrocarburs, $carrerRunes, $capsules, $altres) {
        $sql = "INSERT INTO residus_esp(ID_Esp, Pneumatics, Bateries, Disolvent, Pintura, Oli, Amiant, Verd, Piles, Aerosols, Inflamables, Hidrocarburs, Carrer_Runes, Capsules, Altres) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $registrarEspecials = array($idEsp, $pneumatics, $bateries, $disolvent, $pintura, $oli, $amiant, $verd, $piles, $aerosols, $inflamables, $hidrocarburs, $carrerRunes, $capsules, $altres);
        $resultat = DB::executaConsultaPrepare($sql, $registrarEspecials);
    }
    
    public function __construct($row) {
        $this->idEsp=$row['ID_Esp'];
        $this->carrerRunes=$row['Carrer_Runes'];
        $this->pneumatics=$row['Pneumatics'];
        $this->bateries=$row['Bateries'];
        $this->disolvent=$row['Disolvent'];
        $this->pintura=$row['Pintura'];
        $this->oli=$row['Oli'];
        $this->amiant=$row['Amiant'];
        $this->verd=$row['Verd'];
        $this->piles=$row['Piles'];
        $this->aerosols=$row['Aerosols'];
        $this->inflamables=$row['Inflamables'];
        $this->hidrocarburs=$row['Hidrocarburs'];
        $this->capsules=$row['Capsules'];
        $this->altres=$row['Altres'];
    }
}
