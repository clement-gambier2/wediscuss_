<?php
include('../include/nav.php');
include('config.php');

// Initialize the session
session_start();
/* Attempt to connect to MySQL database */
try
{
  $bdd = new PDO('mysql:host=localhost;dbname=wediscus_;charset=utf8', 'makaque', '9^0h6Yfg', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
  $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}
catch (PDOException $e)
{
        die('Erreur : ' . $e->getMessage());
}

// Check connection
if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}


// get the post records
$titre = addslashes($_POST['titre']);
$contenu = addslashes($_POST['contenu']);
$sources = addslashes($_POST['sources']);
$tag = $_POST['radio-tag'];
$id = $_SESSION['id'];  







// database insert SQL code
$sql ="INSERT INTO article (autor_id, title, contenu, sources) VALUES ('".$id."', '".$titre."', '".$contenu."', '".$sources."')";
$reponse = $bdd->query($sql);

$sql = "SELECT id_article FROM article WHERE autor_id = '" .$id."' ORDER BY id_article DESC";
$reponseId = $bdd->query($sql);
if($data = $reponseId->fetch()){
    $id_article = $data['id_article'];
}

$sql2 = "INSERT INTO tagLink (articleId, tagId) VALUES ('".$id_article."', '".$tag."')";
$reponse2 = $bdd->query($sql2);

echo "Article envoyé !";

?>
