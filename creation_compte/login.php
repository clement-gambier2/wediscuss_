<?php
// lance la session
session_start();
 
//Regarde si l'utilisateur est connecté
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: ../index2.php");
    exit;
}
 
// Include le fichier de connexion
require_once "config.php";
 
// Definition des variables 
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Check des conditions pour la connexion
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Regarde si le username n'est pas vide
    if(empty(trim($_POST["username"]))){
        $username_err = "Veuillez entrer votre nom d'utilisateur.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Regarde si le mot de passe n'est pas vide
    if(empty(trim($_POST["password"]))){
        $password_err = "Veuillez rentrer votre mot de passe.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Valide la connexion
    if(empty($username_err) && empty($password_err)){
        // Preparation de la requete
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            //Installation des variables
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // mise en place des parametres
            $param_username = $username;
            
            // Tente une execution
            if(mysqli_stmt_execute($stmt)){
                // stocke le resultat
                mysqli_stmt_store_result($stmt);
                
                // Si le username existe alors on check le mot de passe
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Si le mot de passe est bon on lance la session
                            session_start();
                            
                            // Stocke les données
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirection
                            header("location: ../index2.php");
                        } else{
                            //Si echec de ma connexion 
                            $login_err = "Nom d'utilisateur ou mot de passe invalide";
                        }
                    }
                } else{
                     //Si echec de ma connexion
                    $login_err = "Nom d'utilisateur ou mot de passe invalide";
                }
            } else{
                echo "Euh y a un problème. Repassez plus tard ;)";
            }

            // Fermeture de la session
            mysqli_stmt_close($stmt);
        }
    }
    
    // fermeture de la connexion
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="../css/hover.css">
    <link rel="stylesheet" href="../css/creation_compte/login.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- <script src="https://www.google.com/recaptcha/api.js"></script> -->



</head>
<body>
<div class = "body-container">

    <div class="container">
        <h2>Se connecter</h2>
        <p>Veuillez rentrez vos informations</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form id ='loginForm' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Nom d'utilisateur</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
            <button data-action='submit'>Se connecter</button>            
            </div>
            <p>Vous n'avez pas de compte ? <a style="color: white;" href="register.php">Créer un compte</a>.</p>
            
        </form>
    </div>
    <div>
        <img src="../images/ressources/login.svg" alt="" class="hvr-grow"> 
    </div>

</div>


    <script>
   function onSubmit(token) {
     document.getElementById("loginForm").submit();
   }
    </script>

</body>
<?php include('../include/footer.php'); ?>

</html>