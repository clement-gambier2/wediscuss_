<?php include('../include/nav.php'); ?>
<?php
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
    // recupere les nouvelles sources
    $new_sources = addslashes($_POST['source']);



//Récupération de l'id_article 
$id_article = $_GET['article'];


//Va chercher l'ancienne source 
$sql = "SELECT sources FROM article WHERE id_article = $id_article";
$reponse = $bdd->query($sql);
$old_sources;
if($data = $reponse->fetch()){
    $old_sources = $data['sources'];
  }
$reponse->closeCursor();

$new_sources = $old_sources . "    " . $new_sources;

 // Modification des sources
$sql = "UPDATE article SET sources= '$new_sources' WHERE id_article = '$id_article'";
        
$result = $bdd->query($sql);



$result->closeCursor();

header('Location: https://wediscuss.fr/articles/commentaires.php?article='.$id_article);

?>