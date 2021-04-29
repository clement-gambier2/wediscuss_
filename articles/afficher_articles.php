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
    ?>
    <!DOCTYPE html>
    <html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
        <link rel="stylesheet" href="/css/home/search_bar.css">
        <link rel="stylesheet" href="/css/profil.css">

        <style>
            .box1{
                border: 6px solid rgb(104,104, 246); 
                margin: 10px 50px 20px; 
                border-radius: 30px;
            }
        </style>
    </head>
    <body>
        <div class="body-container">
            <div class ="line">
                <div class = "searchBarCenter">
    <form name="form1" method="POST" action="../search.php">
            <input type="text" placeholder = "Rechercher" name="search" aria-label = "Search" required class="searchTerm">
            <input type="submit" value = "Chercher" name ="submit" class="searchButton">
    </form>
    </div>

    </div>
    <div class="line">
    <?php
    $sql = "SELECT title, username, contenu,id_article
        FROM article JOIN users ON article.autor_id = users.id ORDER BY id_article DESC";
    $reponse = $bdd->query($sql);
    while($data = $reponse->fetch()){

        //Compte les commentaires de chaque article
        $req = $bdd->prepare('SELECT id_commentaire FROM commentaires WHERE id_article = ?');
        $req->execute(array($data["id_article"]));
        $req = $req->rowCount();

        ?>
        <div class="box1" >
            <p style = "text-align:center;"><?php echo htmlspecialchars($data["title"]); ?></p>
            <p style = "text-align:center;">de : <?php echo htmlspecialchars($data["username"]); ?></p>
            <p style = "text-align:center;">Nombre de commentaire : <?php echo $req ?></p>
            <p style = "text-align:center;"><em>
                <a href="commentaires.php?article=<?php echo $data["id_article"]; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-zoom-in" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#6868f6" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <circle cx="10" cy="10" r="7" />
                        <line x1="7" y1="10" x2="13" y2="10" />
                        <line x1="10" y1="7" x2="10" y2="13" />
                        <line x1="21" y1="21" x2="15" y2="15" />
                    </svg>
                </a></em>
            </p>
        </div>
    
<?php
    }
      $reponse->closeCursor();
?>
        </div>
    </div>
</body>

<?php include('../include/footer.php'); ?>

</html>
