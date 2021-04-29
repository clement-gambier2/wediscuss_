<?php include('include/nav.php'); ?>

<?php
include('config.php');

// Initialize the session
session_start();
/* Attempt to connect to MySQL database */
try
{
  $bdd = new PDO('mysql:host=localhost;dbname=wediscus_;charset=utf8', 'makaque', '9^0h6Yfg');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

$id = $_SESSION['id'];
$nbLike = 0;
$nbDislike = 0;
?>


<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>profil</title>
    <link rel="stylesheet" href="/css/profil.css">
    <link rel="stylesheet" href="/css/hover.css">
  </head>
  <body>


    <div class="container-body">

      <div class="box-titre">
      <h3>
      <?php 
      $sql = 'SELECT username FROM users WHERE id = ' . $_SESSION['id'];
      $reponse = $bdd->query($sql);
      if($data = $reponse->fetch()){
        echo htmlspecialchars($data['username']);
      }
      $reponse->closeCursor();
      ?>
      </h3>
      
      </div>

      <div class="pfp">
      <a href="editProfil.php"><img id="icone-profil"src="images/profilePictures/default.svg" alt="icone profil"></a>
        
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
          $reponse->closeCursor();
          ?>

      </div>
    </div>


      <div class="line-bio">

        <div class="box">
          <h4 id="bio-h4">Bio :</h4>
          <p id="bio-p">
		<?php
          $sql = 'SELECT * FROM users WHERE id = ' . $id;
          $reponse = $bdd->query($sql);

          if($data = $reponse->fetch()){
            echo $data['bio'];
          }
          else{
            echo "null";
          }
          $reponse->closeCursor();
          ?>
          </p>
        </div>

      </div>

      <div class="line" id="line-tag">

        <?php 
          $array = array(
            1 => '<div class="tag tag-info"></div>',
            2 => '<div class="tag tag-math"></div>',
            3 => '<div class="tag tag-science"></div>',
            4 => '<div class="tag tag-culture"></div>',
            5 => '<div class="tag tag-droit"></div>',
            6 => '<div class="tag tag-actu"></div>',
            7 => '<div class="tag tag-newTech"></div>',
            8 => '<div class="tag tag-other"></div>'
          );

          $nombreDeTags = 0;
          
          $sql = 'SELECT COUNT(*) AS nbTags FROM tags';
          $reponse = $bdd->query($sql);
          if($data = $reponse->fetch()){
            $nombreDeTags = $data['nbTags'];
          }

          for($i = 1; $i < $nombreDeTags + 1; $i++){
            $sql = 'SELECT * FROM tagLink WHERE userId = '. $id . ' AND tagId =' . $i;
            $reponse = $bdd->query($sql);
            if($data = $reponse ->fetch()){
              echo $array[$i];
            }

          }
          $reponse->closeCursor();
          ?> 
      </div>
  </div>
  </body>
  <?php include('include/footer.php'); ?>
</html>

