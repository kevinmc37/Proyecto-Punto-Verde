<?php require_once('./classes/DB.php');
class Subcategories {     // Estructura de la taula 'subcategories_r' de la BBDD
    protected $idSubcategoria;
    protected $nom;
    
    public function getIdSubcategoria() { return $this->idSubcategoria; }
    public function getNom() { return $this->nom; }
    
    public static function obtenirSubcategories() {     // Utilitzada per obtenir totes les categories existents de residus RAES
        $sql = "SELECT * FROM subcategories_r";
        $resultat = DB::executaConsulta($sql);        // Obté totes les dades de la taula 'subcategories_r'
        $obtenirSubcategories = array();
        if($resultat) {     // Si s'han trobat resultats...
            $row = $resultat->fetch();      // Obté el resultat de cada columna de la primera fila
            while ($row!=null) {        // Mentre s'obtingui un resultat...
                $obtenirSubcategories[] = new Subcategories($row);      // Inserta a l'array el resultat de la fila
                $row = $resultat->fetch();      // Obté el resultat de la següent fila
            }
        }
        return $obtenirSubcategories;     // Retorna l'array amb tots els resultats
    }
    
    public function __construct($row) {
        $this->idSubcategoria=$row['ID_Subcategoria'];
        $this->nom=$row['Nom'];
    }
}