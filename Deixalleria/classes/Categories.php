<?php require_once('./classes/DB.php');
class Categories {        // Estructura de la taula 'categories' de la BBDD
    protected $idCategoria;
    protected $categoria;
    
    public function getIdCategoria() { return $this->idCategoria; }
    public function getCategoria() { return $this->categoria; }
    
    public static function obtenirCategories() {        // Utilitzada per obtenir totes les categories que poden tenir els usuaris
        $sql = "SELECT * FROM categories";
        $resultat = DB::executaConsulta($sql);        // Obté totes les dades de la taula 'categories'
        $obtenirCategories = array();
        if($resultat) {     // Si s'han trobat resultats...
            $row = $resultat->fetch();      // Obté el resultat de cada columna de la primera fila
            while ($row!=null) {        // Mentre s'obtingui un resultat...
                $obtenirCategories[] = new Categories($row);      // Inserta a l'array el resultat de la fila
                $row = $resultat->fetch();      // Obté el resultat de la següent fila
            }
        }
        return $obtenirCategories;     // Retorna l'array amb tots els resultats
    }
    
    public static function especificarCategories($nif) {        // Utilitzada per especificar quina categoria té un usuari concret
        $sql = "SELECT categories.* FROM categories, usuaris WHERE NIF = '$nif' AND categories.Categoria = usuaris.ID_Categoria";
        $resultat = DB::executaConsulta($sql);        // Obte totes les dades de la taula 'categories' que tingui un usuari amb NIF = paràmetre
        $especificarCategories = array();
        if($resultat) {     // Si s'han trobat resultats...
            $row = $resultat->fetch();      // Obté el resultat de cada columna de la primera fila
            while ($row!=null) {        // Mentre s'obtingui un resultat...
                $especificarCategories[] = new Categories($row);      // Inserta a l'array el resultat de la fila
                $row = $resultat->fetch();      // Obté el resultat de la següent fila
            }
        }
        return $especificarCategories;     // Retorna l'array amb tots els resultats
    }
    
    public function __construct($row) {
        $this->idCategoria=$row['ID_Categoria'];
        $this->categoria=$row['Categoria'];
    }
}