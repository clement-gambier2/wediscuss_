<?php
include('include/nav.php');

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

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$id = $_SESSION['id'];

$username = addslashes($_POST['username']);
$bio = addslashes($_POST['bio']);

$lastUsername = "";

$sql = 'SELECT username FROM users WHERE id = ' . $_SESSION['id'];
$reponse = $bdd->query($sql);
if($data = $reponse->fetch()){
  $lastUsername = $data['username'];
}
$reponse->closeCursor();

$sql = "SELECT COUNT(id) AS nbId, username FROM users WHERE username = '$username'";
$reponse = $bdd->query($sql);
if($data = $reponse->fetch()){


    if($data['nbId'] == 1 && $username == $data['username']){
        $sql2 = "UPDATE users SET bio= '$bio', username = '$username' WHERE id= " . $id;


        $reponse2 = $bdd->prepare($sql2);
        
        $reponse2 -> execute();
        header("location: /profil.php");  
    } 

    else if ($data['nbId'] == 0 && $username != $data['username']){
    $sql2 = "UPDATE users SET bio= '$bio', username = '$username' WHERE id= " . $id;


    $reponse2 = $bdd->prepare($sql2);
    
    $reponse2 -> execute();
    header("location: /profil.php");
  }
  

}



// echo a message to say the UPDATE succeeded
$reponse->closeCursor();
$reponse2->closeCursor();


$bdd = null;

?>
