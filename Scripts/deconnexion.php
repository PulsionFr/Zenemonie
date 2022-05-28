<?php

session_start();

session_destroy();

header('location: index.php'); // On redirige sur la page d'accueil

exit;

?>