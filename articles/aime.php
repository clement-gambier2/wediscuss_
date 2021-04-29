<?php
    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=wediscus_;charset=utf8', 'makaque', '9^0h6Yfg');
    }
    catch(Exception $e)
    {
            die('Erreur : '.$e->getMessage());
    }
    session_start();
    //Si les valeurs ne sont pas nulles
    if(isset($_GET['t'],$_GET['id']) && !empty($_GET['t']) && !empty($_GET['id'])){
        //id_article
        $getid = (int) $_GET['id'];

        $membre = $_SESSION['id'];

        //Like = 1 Dislike = 2
        $gett = (int) $_GET['t'];

        $check = $bdd->prepare('SELECT id_article FROM article WHERE id_article = ?');
        $check->execute(array($getid));

        $count = $check->rowCount();
        if($count == 1){
            //si il a like 
            if($gett == 2){
                $check_like = $bdd->prepare('SELECT id_likes FROM likes WHERE id_article = ? AND id_membre = ?');
                $check_like->execute(array($getid,$membre));

                //Si il a déjà un dislike ca lui enlève
                $del = $bdd->prepare('DELETE FROM dislike WHERE id_article = ? AND id_membre = ?');
                $del->execute(array($getid,$membre));

                //Si l'utilisateur a dejà mit un like
                if($check_like->rowCount() == 1){
                    $del = $bdd->prepare('DELETE FROM likes WHERE id_article = ? AND id_membre = ?');
                    $del->execute(array($getid,$membre));
                }
                //Si il n'en a pas mit
                else{
                    $ins = $bdd->prepare('INSERT INTO likes (id_article,id_membre) VALUES (?, ?)');
                    $ins->execute(array($getid, $membre));
                }
                
            }
            //si il a dislike
            elseif($gett == 3){
                $check_dislike = $bdd->prepare('SELECT id_dislike FROM dislike WHERE id_article = ? AND id_membre = ?');
                $check_dislike->execute(array($getid,$membre));


                //Si il a déjà un like ca lui enlève
                $del = $bdd->prepare('DELETE FROM likes WHERE id_article = ? AND id_membre = ?');
                $del->execute(array($getid,$membre));


                //Si l'utilisateur a déjà mit un dislike
                if($check_dislike->rowCount() == 1){
                    $del = $bdd->prepare('DELETE FROM dislike WHERE id_article = ? AND id_membre = ?');
                    $del->execute(array($getid,$membre));
                }
                //Si il n'en a pas mit
                else{
                    $ins = $bdd->prepare('INSERT INTO dislike (id_article,id_membre) VALUES (?, ?)');
                    $ins->execute(array($getid, $membre));
                }

            }
                    
        }
        
    }
    header('Location: https://wediscuss.fr/articles/commentaires.php?article='.$getid);
    
?>