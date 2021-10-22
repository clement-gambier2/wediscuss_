<?php include('include/nav.php'); ?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Search</title>
        <link rel="stylesheet" href="/css/home/search_bar.css">
        <link rel="stylesheet" href="/css/profil.css">
    </head>
    <body>
    <div class="body-container">
        <div class ="line">  

          <form name="form1" method="POST" action="../search.php">
          <input type="text" placeholder = "Search" name="search" aria-label = "Search" required class="searchTerm">
          <input type="submit" value = "Chercher" name ="submit" class="searchButton">
    </form>
    </div>
    </div>
    <?php
        

        //Connection à la base de donnée
        define('DB_SERVER', 'localhost');
        define('DB_USERNAME', 'clement_bd');
        define('DB_PASSWORD', 'F~ih43i5');
        define('DB_NAME', 'clement8_');

        session_start();
        $con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if(isset($_POST['submit'])){
            $search = mysqli_real_escape_string($con,$_POST['search']);


            $sql = "SELECT title, username, id_article
            FROM article JOIN users ON article.autor_id = users.id
            WHERE title LIKE '%$search%' OR contenu LIKE '%$search%' OR username LIKE '%$search%' ";
            
            $result = mysqli_query($con,$sql);
            $queryResult = mysqli_num_rows($result);


            if($queryResult > 0){
                while($row = mysqli_fetch_assoc($result)) {

                    ?>

                <div class="line">

                    <div class="box1" style="border: 6px solid rgb(104,104, 246); margin: 10px 50px 20px;">
                        <p style = "text-align:center;">Titre : <?php echo htmlspecialchars($row["title"]); ?></p>
                        <p style = "text-align:center;">de : <?php echo htmlspecialchars($row["username"]); ?></p>
                        <p style = "text-align:center;"><em><a href="/articles/commentaires.php?article=<?php echo $row["id_article"]; ?>">Voir l'info</a></em></p>
                    </div>
                    </div>       

                    <?php
                }
            }
            else{
                echo "no result ...";
                ?>
                <embed src="images/singe.mp4" allowfullscreen="true" width="1280" height="720">
                <?php
            }
        }
    ?>
        
    </body>
    <?php include('include/footer.php'); ?>

</html>