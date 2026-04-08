<?php require_once('./classes/DB.php');
class Municipis {     // Estructura de la taula 'municipis' de la BBDD
    protected $idMunicipi;
    protected $nom;
    protected $codiPostal;
    
    public function getIdMunicipi() { return $this->idMunicipi; }
    public function getNom() { return $this->nom; }
    public function getCodiPostal() { return $this->codiPostal; }
    
    public static function obtenirMunicipis() {     // Utilitzada per obtenir els noms dels municipis registrats
        $sql = "SELECT * FROM municipis";
        $resultat = DB::executaConsulta($sql);        // Obté totes les dades de la taula 'municipis'
        $obtenirMunicipis = array();
        if($resultat) {     // Si s'han trobat resultats...
            $row = $resultat->fetch();      // Obté el resultat de cada columna de la primera fila
            while ($row!=null) {        // Mentre s'obtingui un resultat...
                $obtenirMunicipis[] = new Municipis($row);      // Inserta a l'array el resultat de la fila
                $row = $resultat->fetch();      // Obté el resultat de la següent fila
            }
        }
        return $obtenirMunicipis;     // Retorna l'array amb tots els resultats
    }
    
    public static function especificarMunicipis($nif) {     // Utilitzada per especificar a quin municipi viu un usuari concret
        $sql = "SELECT municipis.* FROM municipis, usuaris WHERE NIF = '$nif' AND municipis.Nom = usuaris.ID_Municipi";
        $resultat = DB::executaConsulta($sql);        // Obte totes les dades de la taula 'municipis' que tingui un usuari amb NIF = paràmetre
        $especificarMunicipis = array();
        if($resultat) {     // Si s'han trobat resultats...
            $row = $resultat->fetch();      // Obté el resultat de cada columna de la primera fila
            while ($row!=null) {        // Mentre s'obtingui un resultat...
                $especificarMunicipis[] = new Municipis($row);      // Inserta a l'array el resultat de la fila
                $row = $resultat->fetch();      // Obté el resultat de la següent fila
            }
        }
        return $especificarMunicipis;     // Retorna l'array amb tots els resultats
    }
    
    public function __construct($row) {
        $this->idMunicipi=$row['ID_Municipi'];
        $this->nom=$row['Nom'];
        $this->codiPostal=$row['Codi_Postal'];
    }
}
