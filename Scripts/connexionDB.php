<?php

// Nous déclarons la classe

class connexionDB
{

    private $host = '54.37.9.77';   // Pour se connecter à notre serveur

    private $name = 'zenemonie';     // nom de la base de donnée utilisée

    private $user = 'ZenemonieUser';        // Notre utilisateur créer spécialement pour

    private $pass = 'FrNyYYkGs344z9U';        // mot de passe

    private $connexion;


    function __construct($host = null, $name = null, $user = null, $pass = null)
    {

        if ($host != null) {

            $this->host = $host;

            $this->name = $name;

            $this->user = $user;

            $this->pass = $pass;

        }

        try {

            $this->connexion = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->name,

                $this->user, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',

                    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

        } catch (PDOException $e) {

            echo 'Erreur : Impossible de se connecter  à la BDD !';

            die();

        }

    }


    public function query($sql, $data = array())
    {

        $req = $this->connexion->prepare($sql);

        $req->execute($data);

        return $req;

    }


    public function insert($sql, $data = array())
    {

        $req = $this->connexion->prepare($sql);

        $req->execute($data);

    }

}

$DB = new connexionDB();

?>

