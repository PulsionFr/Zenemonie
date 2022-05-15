<!doctype html>

<?php session_start(); ?>
<html lang="fr">

  <head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/connexion.css">
  </head>

<body>

<form method="POST" action="./comptes/login.php">

  <main class="form-signin">
    <form>
      <img class="form-signin" src="./styles/images/Logo.png" alt="logo_connexion">
      <h1 class="H1">Connexion</h1>
      <div class="form-floating">
        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
        <label for="floatingInput">Adresse email</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
        <label for="floatingPassword">Mot de passe</label>
      </div>

      <div class="inscription mb-3">
        <a href="./comptes/inscription.php" class="redirection"> Vous n'avez pas encore de compte</a>
      </div>

      <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
    </form>
  </main>

</body>
</html>