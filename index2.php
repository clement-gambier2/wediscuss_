<?php include('include/nav.php'); ?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/css/home/home.css">
    <link rel="stylesheet" href="/css/home/enveloppe.css">
    <link rel="stylesheet" href="/css/home/search_bar.css">
    <link rel="stylesheet" href="/css/hover.css">
    <title>Wediscus</title>
</head>

<body>

<div class="container-body">

    <!-- Enveloppe -->

    <div id = "topBox" class="box">
        <a href="deposer_article/form.php">
            <div class="letter-image">
                <div class="animated-mail">
                    <div class="back-fold"></div>
                    <div class="letter">
                        <div class="letter-border"></div>
                        <div class="letter-title"> Déposer une info</div>

                        <div class="letter-stamp">
                            <div class="letter-stamp-inner"></div>
                        </div>
                    </div>
                    <div class="top-fold"></div>
                    <div class="body"></div>
                    <div class="left-fold"></div>
                </div>
                <div class="shadow"></div>
            </div>
        </a>

    </div>


    <!-- Voir les infos  -->
    <div class="box">
        <div class="button ">
            <a href="articles/afficher_articles.php" class="hvr-bounce-in square_btn ">Voir les articles</a>
        </div>
    </div>

    <!-- Search bar -->

    <div class="box">
        <form name="form1" method="POST" action="search.php">
            <input type="text" placeholder = "Chercher" name="search" aria-label = "Search" required class="searchTerm">
            <input type="submit" value = "Chercher" name ="submit" class="searchButton">
        </form>
        <img src="images/ressources/rechercher.svg" alt="girl searching" class="hvr-grow">
    </div>

</div>



</body>
<?php include('include/footer.php'); ?>

</html>
