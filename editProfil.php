<?php include('include/nav.php'); ?>

<?php

include('config.php');

// Initialize the session
session_start();
/* Attempt to connect to MySQL database */
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=clement8_;charset=utf8', 'clement_bd', 'F~ih43i5');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$id = $_SESSION['id'];
$lastUsername = "";

$sql = 'SELECT username FROM users WHERE id = ' . $_SESSION['id'];
$reponse = $bdd->query($sql);
if($data = $reponse->fetch()){
  $lastUsername = $data['username'];
}
$reponse->closeCursor();

?>


<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>edit profil</title>
    <link rel="stylesheet" href="/css/profil.css">
    <link rel="stylesheet" href="/css/hover.css">
  </head>
  <body>

    <form class="form" action="edit.php" method="post">

    <div class="container-body">

      <div class="box-titre">
        <h3><input id = "username" name = "username" type = "text" value=<?php echo htmlspecialchars($lastUsername); ?>></h3>

      </div>

      <div class="pfp">
        <img id="icone-profil"src="images/profilePictures/default.svg" alt="icone profil">
      </div>

    <div class="line-stats">

      <div class="box box-h">

        <h4>Nombre de posts</h4>

        <?php

         $sql = 'SELECT COUNT(autor_id) AS nb FROM article WHERE autor_id = '. $id;
         $reponse = $bdd->query($sql);
         if($data = $reponse->fetch()){
           echo $data['nb'];
           $nbPost = $data['nb'];
         }
         else{
           echo "null";
         }
         $reponse->closeCursor();
         ?>

      </div>

      <div class="box box-h box-stats">

        <h4>Score de fiabilité</h4>
        <?php

                $sql = 'SELECT COUNT(id_likes) AS nb FROM article a JOIN likes l ON a.id_article = l.id_article WHERE autor_id = '. $id;
                $reponse = $bdd->query($sql);
                if($data = $reponse->fetch()){
                $nbLike = $data['nb'];
                }

                $sql = 'SELECT COUNT(id_dislike) AS nb FROM article a JOIN dislike d ON a.id_article = d.id_article WHERE autor_id = '. $id;
                $reponse = $bdd->query($sql);
                if($data = $reponse->fetch()){
                $nbDislike = $data['nb'];
                }
                $total = $nbDislike + $nbLike;

                if($total == 0){
                echo 0;
            }
            else{
                echo round((($nbLike) / ($total)) * 100) . "%";
            }


            $reponse->closeCursor();



            ?>
      </div>

      <div class="box box-h">

        <h4>Date d'inscription</h4>
          <?php
          $sql = 'SELECT DAY(created_at) AS day, MONTH(created_at) AS month, YEAR(created_at) AS year FROM users WHERE id = ' . $id;
          $reponse = $bdd->query($sql);

          if($data = $reponse->fetch()){
            echo $data['day'] . "/" . $data['month'] . "/" . $data['year'];
          }
          ?>

      </div>
    </div>


      <div class="line-bio">

        <div class="box">
          <h4 id="bio-h4">Bio :</h4>

          <?php
          $sql = 'SELECT * FROM users WHERE id = ' . $id;
          $reponse = $bdd->query($sql);
          $data = $reponse->fetch();
          $bio = $data['bio'];
          ?>
          <textarea id = "bio" name="bio" type = "text" rows="8" cols="60"><?php echo htmlspecialchars($bio); ?></textarea>
        </div>

      </div>

      
      <input class="submitButton" type="submit" name="Modifier" id="Submit" value="Submit">
  </div>
</form>

  </body>
  <?php include('include/footer.php'); ?>

</html>
