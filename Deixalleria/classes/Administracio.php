<?php require_once('./classes/DB.php');
class Administracio {     // Estructura de la taula 'administracio' de la BBDD
    protected $nomUsuari;
    protected $contrasenya;
    protected $poders;
    
    public function getNomUsuari() { return $this->nomUsuari; }
    public function getContrasenya() { return $this->contrasenya; }
    public function getPoders() { return $this->poders; }
    
    public static function dadesAdminLogin($username, $password) {  // Utilitzada per comprovar el nom d'usuari i la contrasenya i permetre el login
        $sql = "SELECT * FROM administracio WHERE nom_usuari = '$username' AND contrasenya = '$password'";
        $resultat = DB::executaConsulta($sql);        // Obté totes les dades de la taula 'administracio' amb nom d'usuari i contrasenya = paràmetres
        $dadesAdminLogin = array();
        if($resultat) {     // Si s'han trobat resultats...
            $row = $resultat->fetch();      // Obté el resultat de cada columna de la primera fila
            while ($row!=null) {        // Mentre s'obtingui un resultat...
                $dadesAdminLogin[] = new Administracio($row);      // Inserta a l'array el resultat de la fila
                $row = $resultat->fetch();      // Obté el resultat de la següent fila
            }
        }
        return $dadesAdminLogin;     // Retorna l'array amb tots els resultats
    }
    
    public static function dadesAdminRegistre($username) {      // Utilitzada per registrar un nou usuari de l'aplicació
        $sql = "SELECT * FROM administracio WHERE nom_usuari = '$username'";
        $resultat = DB::executaConsulta($sql);        // Obté totes les dades de la taula 'administracio' que tenen nom d'usuari = paràmetre
        $dadesAdminRegistre = array();
        if($resultat) {     // Si s'han trobat resultats...
            $row = $resultat->fetch();      // Obté el resultat de cada columna de la primera fila
            while ($row!=null) {        // Mentre s'obtingui un resultat...
                $dadesAdminRegistre[] = new Administracio($row);      // Inserta a l'array el resultat de la fila
                $row = $resultat->fetch();      // Obté el resultat de la següent fila
            }
        }
        return $dadesAdminRegistre;     // Retorna l'array amb tots els resultats
    }
    
    public static function registrarAdmin($user, $pass, $power) {       // Utilitzada per registrar un administrador de l'aplicació
        $sql = "INSERT INTO administracio(nom_usuari, contrasenya, poders) VALUES(?,?,?)";
        $registrarAdmin = array($user, $pass, $power);
        $resultat = DB::executaConsultaPrepare($sql, $registrarAdmin);
    }
    
    public static function canviarAdmin($pass, $user) {     // Utilitzada per canviar la contrasenya d'un usuari de l'aplicació
        $sql = "UPDATE administracio SET contrasenya = ? WHERE nom_usuari = ?";
        $canviarAdmin = array($pass, $user);
        $resultat = DB::executaConsultaPrepare($sql, $canviarAdmin);
    }
    
    public static function canviarPoders($user) {     // Utilitzada per canviar els poders d'un usuari de l'aplicació
        $sql = "UPDATE administracio SET poders = 1 WHERE nom_usuari = ?";
        $canviarPoders = array($user);
        $resultat = DB::executaConsultaPrepare($sql, $canviarPoders);
    }
    
    public function __construct($row) {
        $this->nomUsuari=$row['nom_usuari'];
        $this->contrasenya=$row['contrasenya'];
        $this->poders=$row['poders'];
    }
}