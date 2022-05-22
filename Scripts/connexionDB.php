<?php

// Déclaration de la classe connexionDB

class connexionDB
{

    private $host = '54.37.9.77';   // Host

    private $name = 'zenemonie';     // nom de notre base de donnée

    private $user = 'ZenemonieUser';        // L'Utilisateur

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

?>


// Faire une connexion à votre fonction

$DB = new connexionDB();

