<?php
  session_start();
/*Fichier PHP contenant la connexion à votre BDD include('../bd/connexionDB.php');
  
  $req = $DB->query("SELECT * 
    FROM forum
    ORDER BY ordre");
    
    $req = $req->fetchAll();
*/
?>
<table class="table table-striped">
  <tr>
    <th>ID</th>
    <th>Titre</th>
  </tr>
  <?php
    foreach($req as $r){ 
    ?>  
    <tr>
      <td><?= $r['id'] ?></td>
      <td><a href="forum/<?= $r['id'] ?>"><?= $r['titre'] ?></a></td>
    </tr>   
    <?php
    }
  ?>
</table>