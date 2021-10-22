<?php include('../include/nav.php'); ?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="utf-8" />
    <title>wediscuss</title>
    <link href="style.css" rel="stylesheet" />
    <link href="../css/tagLook.css" rel="stylesheet" />
    <link href="../css/commentaire.css" rel="stylesheet" />

</head>

<body>

<p><a href="afficher_articles.php"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-back-up" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#6868f6" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M9 13l-4 -4l4 -4m-4 4h11a4 4 0 0 1 0 8h-1" />
        </svg></a>
</p>


<?php
// Connexion à la base de données
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=clement8_;charset=utf8', 'clement_bd', 'F~ih43i5');
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
        <?php

        $source = $donnees['sources'];

        $test_source = substr($source,0,5);

        if($test_source == 'https'){
            echo "<a href='$source'>$source</a>";
        }
        else{
            echo $source;
        }
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
<section id="avis">
    <div>
        <a href="aime.php?t=2&id=<?= $article; ?>">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-thumb-up" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#6868f6" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M7 11v8a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-7a1 1 0 0 1 1 -1h3a4 4 0 0 0 4 -4v-1a2 2 0 0 1 4 0v5h3a2 2 0 0 1 2 2l-1 5a2 3 0 0 1 -2 2h-7a3 3 0 0 1 -3 -3" />
            </svg>
        </a>
        <p id="aime">Nombre de like : <?= $likes ?></p>
    </div>
    <div>
        <a href="aime.php?t=3&id=<?= $article; ?>">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-thumb-down" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#6868f6" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M7 13v-8a1 1 0 0 0 -1 -1h-2a1 1 0 0 0 -1 1v7a1 1 0 0 0 1 1h3a4 4 0 0 1 4 4v1a2 2 0 0 0 4 0v-5h3a2 2 0 0 0 2 -2l-1 -5a2 3 0 0 0 -2 -2h-7a3 3 0 0 0 -3 3" />
            </svg>
        </a>
        <p>Nombre de dislike : <?= $dislikes ?></p>
    </div>
</section>


<?php
$req->closeCursor(); // Important : on libère le curseur pour la prochaine requête
?>

<div id="ajout">
    <section class="box-secondaire">
        <div class="title">
            <h3>Ajouter une source</h3>
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <line x1="10" y1="14" x2="21" y2="3" />
                <path d="M21 3l-6.5 18a0.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a0.55 .55 0 0 1 0 -1l18 -6.5" />
            </svg>
        </div>
        <form name="frmContact" method="post" action="sources.php?article=<?php echo $article;?>">
            <p>Entrer une source</p>
            <textarea name="source" id="source"></textarea>
            <input type="submit" name="submit" id="Submit" value="Ajouter">
        </form>
    </section>




    <section class="box-secondaire" id="comm">
        <div class="title">
            <h3>Ajouter un commentaire</h3>
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-writing" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M20 17v-12c0 -1.121 -.879 -2 -2 -2s-2 .879 -2 2v12l2 2l2 -2z" />
                <path d="M16 7h4" />
                <path d="M18 19h-13a2 2 0 1 1 0 -4h4a2 2 0 1 0 0 -4h-3" />
            </svg>
        </div>
        <form name="frmContact" method="post" action="envoi_commentaire.php?article=<?php echo $article;?>">
            <label for="commentaire">Entrer un commentaire</label>
            <textarea name="commentaire"></textarea>
            <input type="submit" name="submit" id="Submit" value="Ajouter">
        </form>
    </section>
</div>


<h2>Commentaires</h2>
<!-- // Récupération des commentaires -->
<?php
$req = $bdd->prepare("SELECT username, commentaire
FROM users JOIN commentaires ON users.id = commentaires.id_auteur_commentaire
WHERE id_article = ?");

$req->execute(array($_GET['article']));

$num_commentaire = $bdd->prepare('SELECT id_commentaire FROM commentaires WHERE id_article = ?');
$num_commentaire->execute(array($article));
$num_commentaire = $num_commentaire->rowCount();

while ($donnees = $req->fetch()){
    if($num_commentaire % 2 == 0){
        ?>
        <section id="gauche">
            <div id="commentaire1">
                <p> de <strong><?php echo htmlspecialchars($donnees['username']); ?></strong></p>
                <p><?php echo nl2br(htmlspecialchars($donnees['commentaire'])); ?></p>
            </div>
        </section>
        <?php
    }
    else{
        ?>
        <section id="droite">
            <div id="commentaire2">
                <p> de <strong><?php echo htmlspecialchars($donnees['username']); ?></strong></p>
                <p><?php echo nl2br(htmlspecialchars($donnees['commentaire'])); ?></p>
            </div>
        </section>

        <?php
    }

    ?>




    <?php
    $num_commentaire = $num_commentaire - 1;
} // Fin de la boucle des commentaires
$req->closeCursor();
?>
</body>
<?php include('../include/footer.php'); ?>

</html>
