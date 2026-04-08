<?php require_once('./classes/DB.php');
class Usuaris {       // Estructura de la taula 'usuaris' de la BBDD
    protected $idCategoria;
    protected $nom;
    protected $cognom1;
    protected $cognom2;
    protected $rao;
    protected $carrerNom;
    protected $pisos;
    protected $carrerNum;
    protected $idMunicipi;
    protected $nif;
    protected $telefon;
    protected $email;
    
    public function getIdCategoria() { return $this->idCategoria; }
    public function getNom() { return $this->nom; }
    public function getCognom1() { return $this->cognom1; }
    public function getCognom2() { return $this->cognom2; }
    public function getRao() { return $this->rao;}
    public function getCarrerNom() { return $this->carrerNom; }
    public function getPisos() { return $this->pisos; }
    public function getCarrerNum() { return $this->carrerNum; }
    public function getIdMunicipi() { return $this->idMunicipi; }
    public function getNif() { return $this->nif; }
    public function getTelefon() { return $this->telefon; }
    public function getEmail() { return $this->email; }
    
    public static function obtenirUsuaris() {   // Utilitzada per obtenir principalment els NIFs i els noms de tots els usuaris
        $sql = "SELECT * FROM usuaris ORDER BY CASE WHEN cognom1 = '' THEN 1 ELSE 0 END, cognom1"; // Ordena per el primer cognom, ignorant els nuls
        $resultat = DB::executaConsulta($sql);        // Obté totes les dades de la taula 'usuaris'
        $obtenirUsuaris = array();
        if($resultat) {     // Si s'han trobat resultats...
            $row = $resultat->fetch();      // Obté el resultat de cada columna de la primera fila
            while ($row!=null) {        // Mentre s'obtingui un resultat...
                $obtenirUsuaris[] = new Usuaris($row);      // Inserta a l'array el resultat de la fila
                $row = $resultat->fetch();      // Obté el resultat de la següent fila
            }
        }
        return $obtenirUsuaris;     // Retorna l'array amb tots els resultats
    }
    
    public static function mostrarUsuaris($nif) {       // Utilitzada per mostrar el nom de l'usuari que té aquest NIF
        $sql = "SELECT * FROM usuaris WHERE NIF = '$nif'";
        $resultat = DB::executaConsulta($sql);        // Obté totes les dades de la taula 'usuaris' que tinguin com a NIF el paràmetre
        $mostrarUsuaris = array();
        if($resultat) {     // Si s'han trobat resultats...
            $row = $resultat->fetch();      // Obté el resultat de cada columna de la primera fila
            while ($row!=null) {        // Mentre s'obtingui un resultat...
                $mostrarUsuaris[] = new Usuaris($row);      // Inserta a l'array el resultat de la fila
                $row = $resultat->fetch();      // Obté el resultat de la següent fila
            }
        }
        return $mostrarUsuaris;     // Retorna l'array amb tots els resultats
    }
    // Utilitzada per registrar nous usuaris des de index.php
    public static function registrarUsuaris($idCategoria, $nom, $cognom1, $cognom2, $nif, $idMunicipi, $carrerNom, $pis, $carrerNum, $rao, $telefon, $email) {
        $sql = "INSERT INTO usuaris(ID_Categoria, Nom, Cognom1, Cognom2, NIF, ID_Municipi, Carrer_Nom, Pisos, Carrer_Num, Rao, Telefon, Email)VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        $registrarUsuaris = array($idCategoria, $nom, $cognom1, $cognom2, $nif, $idMunicipi, $carrerNom, $pis, $carrerNum, $rao, $telefon, $email);
        $resultat = DB::executaConsultaPrepare($sql, $registrarUsuaris);
    }
    // Utilitzada per canviar dades d'usuaris ja registrats, com municipis, carrers, etc.
    public static function actualitzarUsuaris($idCategoria, $nom, $cognom1, $cognom2, $idMunicipi, $nouNif, $carrerNom, $pis, $carrerNum, $nif) {
        $sql = "UPDATE usuaris SET ID_Categoria = ?, Nom = ?, Cognom1 = ?, Cognom2 = ?, ID_Municipi = ?, NIF = ?, Carrer_Nom = ?, Pisos = ?, Carrer_Num = ? WHERE NIF = ?";
        $actualitzarUsuaris = array($idCategoria, $nom, $cognom1, $cognom2, $idMunicipi, $nouNif, $carrerNom, $pis, $carrerNum, $nif);
        $resultat = DB::executaConsultaPrepare($sql, $actualitzarUsuaris);
    }
    
    public static function eliminarUsuari($nif) {        // Utilitzada per eliminar un usuari de la BBDD
        $sql = "DELETE FROM usuaris WHERE NIF = ?";
        $eliminarUsuari = array($nif);
        $resultat = DB::executaConsultaPrepare($sql, $eliminarUsuari);
    }
    
    public function __construct($row) {
        $this->idCategoria=$row['ID_Categoria'];
        $this->nom=$row['Nom'];
        $this->cognom1=$row['Cognom1'];
        $this->cognom2=$row['Cognom2'];
        $this->rao=$row['Rao'];
        $this->carrerNom=$row['Carrer_Nom'];
        $this->pisos=$row['Pisos'];
        $this->carrerNum=$row['Carrer_Num'];
        $this->idMunicipi=$row['ID_Municipi'];
        $this->nif=$row['NIF'];
        $this->telefon=$row['Telefon'];
        $this->email=$row['Email'];
    }
}