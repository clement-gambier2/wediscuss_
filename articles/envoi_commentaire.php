<?php include('../include/nav.php'); ?>
<?php
// database connection code
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'makaque');
define('DB_PASSWORD', '9^0h6Yfg');
define('DB_NAME', 'wediscus_');

session_start();
/* Attempt to connect to MySQL database */
$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}


// get the post records
$commentaire = addslashes($_POST['commentaire']);
$auteur = $_SESSION['id'];


//Récupération de l'id_article 
$id_article = $_GET['article'];

// database insert SQL code
$sql = "INSERT INTO commentaires (`id_auteur_commentaire`,`commentaire`,`id_article`) 
        VALUES('$auteur','$commentaire','$id_article')";
        
// insert in database
$rs = mysqli_query($con, $sql);


header('Location: https://wediscuss.fr/articles/commentaires.php?article='.$id_article);
?>
