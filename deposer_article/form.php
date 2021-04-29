<?php include('../include/nav.php'); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="../css/tagButton.css">
	<link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/hover.css">
    <link rel="stylesheet" href="../css/deposer.css">

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Déposer une information</title>
</head>
  
<body >
<section style="padding-top: 1%;">
        <form name="frmContact" method="post" action="envoi.php">
            <h2>Déposer une information</h2>

            <p>
                <label for="titre">Titre </label>
                <input type="text" name="titre" id="titre" required>
            </p>


            <p>
                <p>Contenu</p>
                <textarea name="contenu" id="contenu" required rows="20" cols="50"></textarea>
            </p>

            <p>
                <label for="sources">Entrez vos sources</label>
                <textarea name="sources" id="sources"></textarea>
            </p>
            <div class="tag-depoArticle">

                <select name="radio-tag" id="radioTags">
                <option type="radio" id="radioInfo" name="radio-tag" value="1">
                <label for="radioInfo">Informatique</label>


                <option type="radio" id="radioMath" name="radio-tag" value="2">
                <label for="radioMath">Mathématiques</label>

                <option type="radio" id="radioSciences" name="radio-tag" value="3">
                <label for="radioSciences">Sciences</label>

                <option type="radio" id="radioCulture"name="radio-tag" value="4">
                <label for="radioCulture">Culture</label>

                <option type="radio" id="radioDroit" name="radio-tag" value="5">
                <label for="radioDroit">Droit</label>


                <option type="radio" id="radioActu" name="radio-tag" value="6">
                <label for="radioActu">Actualité</label>

                <option type="radio" id="radioNewTech" name="radio-tag" value="7">
                <label for="radioNewTech">Nouvelles technologie</label>

                <option type="radio" id="radioAutre" name="radio-tag" value="8">
                <label for="radioAutre">Autre</label>
              </select>
            </div>
                
            <div class="button ">
                <input type="submit" name="Submit" class="hvr-bounce-in square_btn " value="Submit">
            </div>
        </form>
        <img src="../images/ressources/deposer.svg" alt="image_deposer_info" class="hvr-grow">
</section>

</body>
<?php include('../include/footer.php'); ?>

</html>
