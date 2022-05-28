<?php

$id = (int) $_GET['id'];

$token = (String) htmlentities($_GET['token']);

if(!isset($id)){
    $valid = false;
    $err_mess = "Le lien est erroné";

}elseif(!isset($token)){
    $valid = false;
    $err_mess = "Le lien est erroné";
}

if($valid){
    $req = $DB->query("SELECT id_client 
		FROM Client
		WHERE id_client = ? AND token = ?",
        array($id, $token));

    $req = $req->fetch();

    if(!isset($req['id'])){
        $valid = false;
        $err_mess = "Le lien est erroné";
    }else{
        $DB->insert("UPDATE Client SET token = NULL, confirmation_token = ? WHERE id_client = ?",
            array(date('Y-m-d H:i:s'), $req['id']));

        $info_mess = "Votre compte a bien été validé";
    }
}