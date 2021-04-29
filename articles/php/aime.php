<?php
    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=wediscus_;charset=utf8', 'makaque', '9^0h6Yfg');
    }
    catch(Exception $e)
    {
            die('Erreur : '.$e->getMessage());
    }
    echo "patate";
    //Si les valeurs ne sont pas nulles
    if(isset($_GET['t'],$_GET['id']) AND !empty($_GET['t']) AND !empty($_GET['id'])){
        $getid = (int) $_GET['id'];

        //Like = 1 Dislike = 2
        $gett = (int) $_GET['t'];


        $check = $bdd->prepare('SELECT id_article FROM article WHERE id_article = ?');
        $check->execute(array($getid));

        $count = $check->rowCount();
        if($count == 1){
            if($gett == 1){
                $ins = $bdd->prepare('INSERT INTO likes (id_article) VALUES (?)');
                $ins->execute(array($getid));
            }
            elseif($gett == 2){
                $ins = $bdd->prepare('INSERT INTO dislike (id_article) VALUES (?)');
                $ins->execute(array($getid));
            }
            header('Location : https://wediscuss.fr/articles/commentaires.php?article='.$getid);
            
        }
        else{
            exit("Erreur . <a href='https://wediscuss.fr/articles/afficher_articles.php'>accueil</a>");
        }
    }
    else{

        exit("Erreur . <a href='https://wediscuss.fr/articles/afficher_articles.php'>accueil</a>");
    }
?>