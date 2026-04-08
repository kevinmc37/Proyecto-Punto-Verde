<?php require_once('./classes/DB.php');
class Control {       // Estructura de la taula 'control' de la BBDD
    protected $idControl;
    protected $nom;
    protected $any_;
    
    public function getIdControl() { return $this->idControl; }
    public function getNom() { return $this->nom; }
    public function getAny_() { return $this->any_; }
    
    public static function comptarControl() {     // Utilitzada per donar una ID nova a un controlador registrat
        $sql = "SELECT MAX(ID_Control)+1 FROM control";
        $resultat = DB::executaConsulta($sql);        // Selecciona l'ID més alta de la taula 'control' i n'afegeix 1
        $comptarControl = array();
        if($resultat) {     // Si s'han trobat resultats...
            $comptarControl = $resultat->fetch();     // Obté el resultat i l'inserta en l'array
        }
        return $comptarControl[0];      // Retorna l'array amb el resultat
    }
    
    public static function obtenirControl() {       // Utilitzada per obtenir les ID i els noms dels controladors
        $sql = "SELECT * FROM control";
        $resultat = DB::executaConsulta($sql);        // Obté totes les dades de la taula 'control'
        $obtenirControl = array();
        if($resultat) {     // Si s'han trobat resultats...
            $row = $resultat->fetch();      // Obté el resultat de cada columna de la primera fila
            while ($row!=null) {        // Mentre s'obtingui un resultat...
                $obtenirControl[] = new Control($row);      // Inserta a l'array el resultat de la fila
                $row = $resultat->fetch();      // Obté el resultat de la següent fila
            }
        }
        return $obtenirControl;     // Retorna l'array amb tots els resultats
    }
    
    public static function identificarControl($id_ctrl) {       // Utilitzada per identificar el controlador a eliminar en configuracio.php
        $sql = "SELECT * FROM control WHERE ID_Control = '$id_ctrl'";
        $resultat = DB::executaConsulta($sql);        // Obté totes les dades de la taula 'control' que tenen ID = paràmetre
        $identificarControl = array();
        if($resultat) {     // Si s'han trobat resultats...
            $row = $resultat->fetch();      // Obté el resultat de cada columna de la primera fila
            while ($row!=null) {        // Mentre s'obtingui un resultat...
                $identificarControl[] = new Control($row);      // Inserta a l'array el resultat de la fila
                $row = $resultat->fetch();      // Obté el resultat de la següent fila
            }
        }
        return $identificarControl;     // Retorna l'array amb tots els resultats
    }
    
    public static function mostrarControl($id_deix) {       // Utilitzada per mostrar el nom del controlador en l'arxiu excel
        $sql = "SELECT control.* FROM control, deixalles WHERE ID_Deix = '$id_deix' AND Control = ID_Control";
        $resultat = DB::executaConsulta($sql);        // Obté totes les dades de la taula 'control' on les deixalles tenen tenen ID = paràmetre
        $mostrarControl = array();
        if($resultat) {     // Si s'han trobat resultats...
            $row = $resultat->fetch();      // Obté el resultat de cada columna de la primera fila
            while ($row!=null) {        // Mentre s'obtingui un resultat...
                $mostrarControl[] = new Control($row);      // Inserta a l'array el resultat de la fila
                $row = $resultat->fetch();      // Obté el resultat de la següent fila
            }
        }
        return $mostrarControl;     // Retorna l'array amb tots els resultats
    }
    
    public static function registrarControl($idControl, $nom, $any_) {      // Utilitzada per registrar un nou controlador
        $sql = "INSERT INTO control(ID_Control, Nom, Any_) VALUES(?, ?, ?)";
        $registrarControl = array($idControl, $nom, $any_);
        $resultat = DB::executaConsultaPrepare($sql, $registrarControl);
    }
    
    public static function eliminarControl($idControl) {        // Utilitzada per eliminar un controlador de la BBDD
        $sql = "DELETE FROM control WHERE ID_Control = ?";
        $eliminarControl = array($idControl);
        $resultat = DB::executaConsultaPrepare($sql, $eliminarControl);
    }
    
    public function __construct($row) {
        $this->idControl=$row['ID_Control'];
        $this->nom=$row['Nom'];
        $this->any_=$row['Any_'];
    }
}
