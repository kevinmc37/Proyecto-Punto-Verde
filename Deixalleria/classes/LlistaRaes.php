<?php require_once('./classes/DB.php');
class LlistaRaes {        // Estructura de la taula 'llista_raes' de la BBDD
    protected $idNom;
    protected $nom;
    protected $subcategoria;
    
    public function getIdNom() { return $this->idNom; }
    public function getNom() { return $this->nom; }
    public function getSubcategoria() { return $this->subcategoria; }
    
    public static function mostrarLlistaRaes() {     // Utilitzada per obtenir tots els materials de la BBDD
        $sql = "SELECT * FROM llista_raes";
        $resultat = DB::executaConsulta($sql);        // Obté totes les dades de la taula 'llista_raes'
        $mostrarLlistaRaes = array();
        if ($resultat) {     // Si s'han trobat resultats...
            $row = $resultat->fetch();      // Obté el resultat de cada columna de la primera fila
            while ($row!=null) {        // Mentre s'obtingui un resultat...
                $mostrarLlistaRaes[] = new LlistaRaes($row);      // Inserta a l'array el resultat de la fila
                $row = $resultat->fetch();      // Obté el resultat de la següent fila
            }
        }
        return $mostrarLlistaRaes;     // Retorna l'array amb tots els resultats
    }
    
    public static function obtenirLlistaRaes($residu) {       // Utilitzada per obtenir la categoria d'un residu específic
        $sql = "SELECT * FROM llista_raes WHERE Nom = ?";
        $array = array($residu);
        $resultat = DB::executaConsultaPrepare($sql, $array);     // Obté totes les dades de la taula 'llista_raes' amb Nom = paràmetre
        $obtenirLlistaRaes = array();
        if ($resultat) {     // Si s'han trobat resultats...
            $row = $resultat->fetch();      // Obté el resultat de cada columna de la primera fila
            while ($row!=null) {        // Mentre s'obtingui un resultat...
                $obtenirLlistaRaes[] = new LlistaRaes($row);      // Inserta a l'array el resultat de la fila
                $row = $resultat->fetch();      // Obté el resultat de la següent fila
            }
        }
        return $obtenirLlistaRaes;     // Retorna l'array amb tots els resultats
    }
    
    public static function comptarLlistaResidus() {     // Utilitzada per donar una ID nova a un residu nou registrat
        $sql = "SELECT MAX(ID_Nom)+1 FROM llista_raes";
        $resultat = DB::executaConsulta($sql);        // Selecciona l'ID més alta de la taula 'llista_raes' i n'afegeix 1
        $comptarLlistaResidus = array();
        if ($resultat) {     // Si s'han trobat resultats...
            $comptarLlistaResidus = $resultat->fetch();     // Obté el resultat i l'inserta en l'array
        }
        return $comptarLlistaResidus[0];      // Retorna l'array amb el resultat
    }
    
    public static function registrarResidus($id_nom, $nom, $subcategoria) {       // Utilitzada per registrar nous residus
        $sql = "INSERT INTO llista_raes(ID_Nom, Nom, Subcategoria) VALUES(?,?,?)";
        $registrarResidus = array($id_nom, $nom, $subcategoria);
        $resultat = DB::executaConsultaPrepare($sql, $registrarResidus);
    }
    
    public static function obtenirRaes($id) {       // Utilitzada per obtenir tots els residus considerats RAES que són d'una categoria específica
        $sql = "SELECT * FROM llista_raes WHERE subcategoria = ?";
        $array = array($id);
        $resultat = DB::executaConsultaPrepare($sql, $array);     // Obté totes les dades de la taula 'llista_raes' amb categoria = paràmetre
        $obtenirRaes = array();
        if ($resultat) {     // Si s'han trobat resultats...
            $row = $resultat->fetch();      // Obté el resultat de cada columna de la primera fila
            while ($row!=null) {        // Mentre s'obtingui un resultat...
                $obtenirRaes[] = new LlistaRaes($row);      // Inserta a l'array el resultat de la fila
                $row = $resultat->fetch();      // Obté el resultat de la següent fila
            }
        }
        return $obtenirRaes;     // Retorna l'array amb tots els resultats
    }
    
    public function __construct($row) {
        $this->idNom=$row['ID_Nom'];
        $this->nom=$row['Nom'];
        $this->subcategoria=$row['Subcategoria'];
    }
}