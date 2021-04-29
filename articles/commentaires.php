<?php include('../include/nav.php'); ?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <title>wediscuss</title>
	<link href="style.css" rel="stylesheet" />
    <link href="../css/tagLook.css" rel="stylesheet" />

    <style>
    .article{
        border: solid;
        
    }
    .back{
        background-color: #1d3557;
        padding: 20% 20%;
        border-radius: 5%;
        margin-top: 10%;
        color:white;
    }
    
    
    
    </style>
    </head>

    <body>
        <p><a href="afficher_articles.php">Retour à la liste des infos</a></p>

<?php
// Connexion à la base de données
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=wediscus_;charset=utf8', 'makaque', '9^0h6Yfg');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

// Récupération de l'article
$req = $bdd->prepare('SELECT title, username, contenu,sources, id
                      FROM article JOIN users ON article.autor_id = users.id
                      WHERE id_article = ?');
$req->execute(array($_GET['article']));
$donnees = $req->fetch();
$autorName = $donnees['username'];
$id = $donnees['id'];

$article = $_GET['article'];



//Récuperation des likes
$likes = $bdd->prepare('SELECT id_likes FROM likes WHERE id_article = ?');
$likes->execute(array($article));
$likes = $likes->rowCount();


//Récuperation des dislikes
$dislikes = $bdd->prepare('SELECT id_dislike FROM dislike WHERE id_article = ?');
$dislikes->execute(array($article));
$dislikes = $dislikes->rowCount();

session_start();


$scoreFiable = 0;


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
    $scoreFiable = 0;
}
else{
    $scoreFiable = round((($nbLike) / ($total)) * 100) . "%";
}


$reponse->closeCursor();



?>

<div class = "article back">
    <h1>
        <u><?php echo htmlspecialchars($donnees['title']); ?></u>
    </h1>

    <h4> De : <?php echo $autorName?> (Score de fiabilité : <?php echo $scoreFiable?>)</h4>


    <p>
    <?php
    echo nl2br(htmlspecialchars($donnees['contenu']));
    ?>
    </p>
    <p>
    sources : 
    <?php
    echo nl2br(htmlspecialchars($donnees['sources']));
    ?>
    </p>
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
            $sql = 'SELECT * FROM tagLink WHERE articleId = '. $article . ' AND tagId =' . $i;
            $reponse = $bdd->query($sql);
            if($data = $reponse ->fetch()){
              echo $array[$i];
            }

          }
          $reponse->closeCursor();
          ?>
</div>

<!-- Systeme de like et dislike -->

<p>Nombre de like : <?= $likes ?></p>
<a href="php/aime.php?t=2&id=<?= $article; ?>"><img src="../images/icons/like.svg" alt="like" style="width: 2%; height: 2%;"></a>
<br>
<p>Nombre de dislike : <?= $dislikes ?></p>
<a href="php/aime.php?t=3&id=<?= $article; ?>"><img src="../images/icons/dislike.svg" alt="like" style="width: 2%; height: 2%;"></a>






<?php
$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
?>

<fieldset>
    <legend>Ajouter une source</legend>
    <form name="frmContact" method="post" action="sources.php?article=<?php echo $article;?>">
        
        <p>
        <label for="commentaire">Entrer une source</label>
        <textarea name="source" id="source"></textarea>
        </p>
        <p>&nbsp;</p>
        <p>
        <input type="submit" name="submit" id="Submit" value="Ajouter">
        </p>
    </form>
</fieldset>

<h2>Commentaires</h2>

<fieldset>
    <legend>Ajouter un commentaire</legend>
    <form name="frmContact" method="post" action="envoi_commentaire.php?article=<?php echo $article;?>">
        
        <p>
        <label for="commentaire">Entrer un commentaire</label>
        <textarea name="commentaire" id="commentaire"></textarea>
        </p>
        <p>&nbsp;</p>
        <p>
        <input type="submit" name="submit" id="Submit" value="Ajouter">
        </p>
    </form>
</fieldset>


<!-- // Récupération des commentaires -->
<?php
$req = $bdd->prepare("SELECT username, commentaire
FROM users JOIN commentaires ON users.id = commentaires.id_auteur_commentaire
WHERE id_article = ?");

$req->execute(array($_GET['article']));

while ($donnees = $req->fetch())
{
?>
<div style="border: 6px solid #1C6EA4; margin: 10px 50px 20px;">
    <p> de <strong><?php echo htmlspecialchars($donnees['username']); ?></strong></p>
    <p><?php echo nl2br(htmlspecialchars($donnees['commentaire'])); ?></p>
</div>

<?php
} // Fin de la boucle des commentaires
$req->closeCursor();
?>
</body>
<?php include('include/footer.php'); ?>

</html>
