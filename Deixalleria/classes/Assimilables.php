<?php require_once('./classes/DB.php');
class Assimilables {      // Estructura de la taula 'residus_assim' de la BBDD
    protected $idAssim;
    protected $paper;
    protected $vidre;
    protected $plastic;
    protected $ferralla;
    protected $textil;
    protected $oli;
    protected $fusta;
    protected $volum;
    
    public function getIdAssim() { return $this->idAssim; }
    public function getPaper() { return $this->paper; }
    public function getVidre() { return $this->vidre; }
    public function getPlastic() { return $this->plastic; }
    public function getFerralla() { return $this->ferralla; }
    public function getTextil() { return $this->textil; }
    public function getOli() { return $this->oli; }
    public function getFusta() { return $this->fusta; }
    public function getVolum() { return $this->volum; }
    
    public static function mostrarAssimilables($idAssim) {      // Utilitzada per mostrar tots els residus assimilables amb una ID específica
        $sql = "SELECT * FROM residus_assim WHERE ID_Assim = '$idAssim'";
        $resultat = DB::executaConsulta($sql);        // Obté totes les dades de la taula 'residus_assim' que tenen ID = paràmetre
        $mostrarAssimilables = array();
        if($resultat) {     // Si s'han trobat resultats...
            $row = $resultat->fetch();      // Obté el resultat de cada columna de la primera fila
            while ($row!=null) {        // Mentre s'obtingui un resultat...
                $mostrarAssimilables[] = new Assimilables($row);      // Inserta a l'array el resultat de la fila
                $row = $resultat->fetch();      // Obté el resultat de la següent fila
            }
        }
        return $mostrarAssimilables;     // Retorna l'array amb tots els resultats
    }
    // Utilitzada per registrar els residus assimilables de l'entrada registrada a la taula 'deixalles'
    public static function registrarAssimilables($idAssim, $paper, $vidre, $plastic, $ferralla, $textil, $oli, $fusta, $volum) {
        $sql = "INSERT INTO residus_assim(ID_Assim, Paper, Vidre, Plastic, Ferralla, Textil, Oli, Fusta, Volum) VALUES(?,?,?,?,?,?,?,?,?)";
        $registrarAssimilables = array($idAssim, $paper, $vidre, $plastic, $ferralla, $textil, $oli, $fusta, $volum);
        $resultat = DB::executaConsultaPrepare($sql, $registrarAssimilables);
    }
    
    public static function comptarResidus() {     // Utilitzada per donar una ID nova a un residus assimilables registrats
        $sql = "SELECT MAX(ID_Assim)+1 FROM residus_assim";
        $resultat = DB::executaConsulta($sql);        // Selecciona l'ID més alta de la taula 'residus_assim' i n'afegeix 1
        $comptarResidus = array();
        if($resultat) {     // Si s'han trobat resultats...
            $comptarResidus = $resultat->fetch();     // Obté el resultat i l'inserta en l'array
        }
        return $comptarResidus[0];        // Retorna l'array amb el resultat
    }
    
    public function __construct($row) {
        $this->idAssim=$row['ID_Assim'];
        $this->paper=$row['Paper'];
        $this->vidre=$row['Vidre'];
        $this->plastic=$row['Plastic'];
        $this->ferralla=$row['Ferralla'];
        $this->textil=$row['Textil'];
        $this->oli=$row['Oli'];
        $this->fusta=$row['Fusta'];
        $this->volum=$row['Volum'];
    }
}
