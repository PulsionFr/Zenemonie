<?php
session_start();
include('bd/connexionDB.php');

// Si session, pas de retour sur cette page
if (isset($_SESSION['id'])){
    header('Location: index.php');
    exit;
}

// On traite les info si elles sont bonnes
if(!empty($_POST)){
    extract($_POST);
    $valid = true;

    // On se place sur le formulaire d'inscription
    if (isset($_POST['inscription'])){
        $nom  = htmlentities(trim($nom)); // On récupère le nom
        $prenom = htmlentities(trim($prenom)); // on récupère le prénom
        $mail = htmlentities(strtolower(trim($mail))); // On récupère le mail
        $mdp = trim($mdp); // On récupère le mot de passe
        $confmdp = trim($confmdp); //  On récupère la confirmation du mot de passe

        //  Vérification du nom
        if(empty($nom)){
            $valid = false;
            $er_nom = ("Veuillez inscrire votre nom");
        }

        //  Vérification du prénom
        if(empty($prenom)){
            $valid = false;
            $er_prenom = ("Veuillez inscrire votre prénom");
        }

        // Vérification du mail
        if(empty($mail)){
            $valid = false;
            $er_mail = "Veuillez indiquer votre mail";

            // Vérification du format de l'adresse mail
        }elseif(!preg_match("/^[a-z0-9\-_.]+@[a-z]+\.[a-z]{2,3}$/i", $mail)){
            $valid = false;
            $er_mail = "Le format de votre mail est incorrect";

        }else{
            // Vérification d ela validité du mail
            $req_mail = $DB->query("SELECT mail FROM Client WHERE mail = ?",
                array($mail));

            $req_mail = $req_mail->fetch();

            if ($req_mail['mail'] <> ""){
                $valid = false;
                $er_mail = "Ce compte existe déjà !";
            }
        }

        // Vérification du mot de passe
        if(empty($mdp)) {
            $valid = false;
            $er_mdp = "Le mot de passe ne peut pas être vide";

        }elseif($mdp != $confmdp){
            $valid = false;
            $er_mdp = "Vos mots de passe ne correspondent pas :( ";
        }

        // On traite si toutes les conditions sont valides
        if($valid){

            $mdp = crypt($mdp, "$6$rounds=5000$JshtdyHDCB_UDOSOjshdhybf$"); // On chiffre le mot de passe.
            $date_creation_compte = date('Y-m-d H:i:s');

            // bin2hex(random_bytes($length))  On génère notre token
            $token = bin2hex(random_bytes(12));

            // On insert nos données dans la table client
            $DB->insert("INSERT INTO Client (mail, prenom, nom, mdp, date_creation_compte,token) VALUES 
                    (?, ?, ?, ?, ?,?)",
                array($mail, $prenom, $nom, $mdp, $date_creation_compte, $token));

            header('Location: index.php');
            exit;
        }
    }
}

$req = $DB->query("SELECT * ﻿  FROM Client
  WHERE mail = ?",
    array($mail));

$req = $req->fetch();

$mail_to = $req['mail'];

//===== Création du header de l'e-mail.
$header = "From: zenemonie@francemel.fr\n";
$header .= "MIME-version: 1.0\n";
$header .= "Content-type: text/html; charset=utf-8\n";
$header .= "Content-Transfer-ncoding: 8bit";
//=======

//===== Ajout du message au format HTML
$contenu = '<p>Bonjour ' . $req['nom'] . ',</p><br>
﻿  	<p>Veuillez confirmer votre compte <a href="https://www.zenémonie.eu/conf.php?id=' . $req['id'] . '&token=' . $token . '">Valider</a><p>';

mail($mail_to, 'Confirmation de votre compte', $contenu, $header);

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription</title>
</head>
<body>
<div>Inscription</div>
<form method="post">
    <?php
    // S'il y a une erreur sur le nom alors on affiche
    if (isset($er_nom)){
        ?>
        <div><?= $er_nom ?></div>
        <?php
    }
    ?>
    <input type="text" placeholder="Votre nom" name="nom" value="<?php if(isset($nom)){ echo $nom; }?>" required>
    <?php
    if (isset($er_prenom)){
        ?>
        <div><?= $er_prenom ?></div>
        <?php
    }
    ?>
    <input type="text" placeholder="Votre prénom" name="prenom" value="<?php if(isset($prenom)){ echo $prenom; }?>" required>
    <?php
    if (isset($er_mail)){
        ?>
        <div><?= $er_mail ?></div>
        <?php
    }
    ?>
    <input type="email" placeholder="Adresse mail" name="mail" value="<?php if(isset($mail)){ echo $mail; }?>" required>
    <?php
    if (isset($er_mdp)){
        ?>
        <div><?= $er_mdp ?></div>
        <?php
    }
    ?>
    <input type="password" placeholder="Mot de passe" name="mdp" value="<?php if(isset($mdp)){ echo $mdp; }?>" required>
    <input type="password" placeholder="Confirmer le mot de passe" name="confmdp" required>
    <button type="submit" name="inscription">Envoyer</button>
</form>
</body>
</html>