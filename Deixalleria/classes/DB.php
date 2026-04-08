<?php require_once('./configmysql.php');        // Inclou la configuració de MySQL
header("Content-Type: text/html;charset=utf-8");
class DB {      // Classe de totes les funcions de l'aplicació
    public static function executaConsulta($sql) {       // Executa les consultes SQL que han de retornar files de valors, selects
        $opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");     // Permet utilitzar UTF-8 a les consultes
        $dsn = "mysql:host=".HOST.";dbname=".DATABASE."";       // Identifica el servidor i la BBDD
        $usuari = USER;     // Identifica l'usuari de la BBDD
        $contrasenya = PASSWORD;        // Identifica la contrasenya de la BBDD
        $dwes = new PDO($dsn, $usuari, $contrasenya, $opc);     // Accedeix a la BBDD
        $resultat = null;
        if (isset($dwes)) $resultat = $dwes->query($sql);       // Executa la consulta
        return $resultat;
    }
    
    public static function executaConsultaPrepare($sql, $array) {    // Executa les consultes SQL amb paràmetres desconeguts, inserts, updates i deletes
        $opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");     // Permet utilitzar UTF-8 a les consultes
        $dsn = "mysql:host=".HOST.";dbname=".DATABASE."";       // Identifica el servidor i la BBDD
        $usuari = USER;     // Identifica l'usuari de la BBDD
        $contrasenya = PASSWORD;        // Identifica la contrasenya de la BBDD
        $dwes = new PDO($dsn, $usuari, $contrasenya, $opc);     // Accedeix a la BBDD
        $resultat = null;
        if (isset($dwes)) {
            $cont = 1;
            $consulta = $dwes->prepare($sql);       // Prepara la consulta per ser executada
            foreach($array as $key) {       // Per cada valor a l'array...
                $consulta->bindValue($cont, $key);      // Substitueix el paràmetre '?' per el valor corresponent
                $cont++;        // Possició del paràmetre desconegut
            }
            $consulta->execute();      // Executa la consulta      
        }   
        return $consulta;
    }
    
}