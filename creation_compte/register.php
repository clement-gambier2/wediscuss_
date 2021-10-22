<?php
// Include le fichier de connexion
require_once "config.php";
 
// Definition des variables 
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Est ce que le username est valide
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare la requete
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Inclus les parametres
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Installe les paramtres
            $param_username = trim($_POST["username"]);
            
            // Tentative d'execution de la requete
            if(mysqli_stmt_execute($stmt)){
                
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Fermeture de la session
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validation du mot de passe
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Valide la confirmation de mot de passe
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Regarde si il peut y avoir des erreurs et envoi a la base de donnée
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Parametre
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Variables
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Tentative d'execution de la requete
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
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
    <title>Creation de compte</title>
    <link rel="stylesheet" href="../css/creation_compte/register.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/hover.css">


        <!-- <script src="https://www.google.com/recaptcha/api.js"></script> -->

</head>
<body>
    <div class="body-container">
        <div class = "container">
            <h2>Créer un compte</h2>
            <p>Veuillez remplir ce formulaire afin de créer un compte.</p>
            <form id ="registerForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Nom d'utilisateur</label>
                    <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>    
                <div class="form-group">
                    <label>Mot de passe</label>
                    <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Confirmation de mot de passe</label>
                    <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                </div>
                
                <div class="form-group">
                    <button class="g-recaptcha" 
                        data-sitekey="6LfJXKkaAAAAAO7mLT0qUP12JRLFQDZdTHdeC7dG" 
                        data-callback='onSubmit' 
                        data-action='submit'>Créer le compte
                    </button>  
                    <input type="reset" class="btn btn-secondary ml-2" value="Réinitialiser">
                </div>
                <p>Vous avez déjà un compte ? <a style="color: white;" href="login.php">Connectez vous ici</a>.</p>
            
            </form>
        </div>
        <img src="../images/ressources/register.svg" alt="" class="hvr-grow"> 
    </div> 
    <script>
   function onSubmit(token) {
     document.getElementById("registerForm").submit();
   }
    </script>

</body>
<?php include('../include/footer.php'); ?>

</html>