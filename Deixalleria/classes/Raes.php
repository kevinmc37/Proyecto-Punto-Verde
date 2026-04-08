<?php require_once('./classes/DB.php');
class Raes {      // Estructura de la taula 'residus_raes' de la BBDD
    protected $idRaes;
    protected $grupDeixalla;
    protected $nom;
    protected $subcategoria;
    protected $pes;
    protected $marca;
    protected $numSerie;
    
    public function getIdRaes() { return $this->idRaes; }
    public function getGrupDeixalla() { return $this->grupDeixalla; }
    public function getNom() { return $this->nom; }
    public function getSubcategoria() { return $this->subcategoria; }
    public function getPes() { return $this->pes; }
    public function getMarca() { return $this->marca; }
    public function getNumSerie() { return $this->numSerie; }
    
    public static function mostrarRaes($idDeix) {       // Utilitzada per mostrar tots els residus RAES amb una ID específica
        $sql = "SELECT * FROM residus_raes WHERE grup_deixalla = '$idDeix'";
        $resultat = DB::executaConsulta($sql);        // Obté totes les dades de la taula 'residus_raes' que tenen ID = paràmetre
        $mostrarRaes = array();
        if($resultat) {     // Si s'han trobat resultats...
            $row = $resultat->fetch();      // Obté el resultat de cada columna de la primera fila
            while ($row!=null) {        // Mentre s'obtingui un resultat...
                $mostrarRaes[] = new Raes($row);      // Inserta a l'array el resultat de la fila
                $row = $resultat->fetch();      // Obté el resultat de la següent fila
            }
        }
        return $mostrarRaes;     // Retorna l'array amb tots els resultats
    }
    // Utilitzada per registrar els residus RAES de l'entrada registrada a la taula 'deixalles'
    public static function registrarRaes($idRaes, $idDeix, $nom, $subcategoria, $pes, $marca, $numSerie) {
        $sql = "INSERT INTO residus_raes(ID_Raes, grup_deixalla, Nom, Subcategoria, Pes, Marca, Num_Serie) VALUES(?,?,?,?,?,?,?)";
        $registrarRaes = array($idRaes, $idDeix, $nom, $subcategoria, $pes, $marca, $numSerie);
        $resultat = DB::executaConsultaPrepare($sql, $registrarRaes);
    }
    
    public function __construct($row) {
        $this->idRaes=$row['ID_Raes'];
        $this->grupDeixalla=$row['grup_deixalla'];
        $this->nom=$row['Nom'];
        $this->subcategoria=$row['Subcategoria'];
        $this->pes=$row['Pes'];
        $this->marca=$row['Marca'];
        $this->numSerie=$row['Num_Serie'];
    }
}