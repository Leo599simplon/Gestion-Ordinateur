<?php
// initialiser la session
session_start();
 
// verifier si l'utilisateur est déjà log
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header('location: src/pages/welcome.php');
    exit;
}
 
// inclure bdd
require_once "src/include/config.php";
 
// variables définies en mode chaine de caractères vide
$email = $password = "";
$email_err = $password_err = "";
 
// traitement du formulaire
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // verifier si le nom est vide
    if(empty(trim($_POST["email"]))){
        $email_err = "Veuillez entrer votre email.";
    } else{
        $email = trim($_POST["email"]);
    }
    
    // verifier si le champs mot de passe est vide
    if(empty(trim($_POST["password"]))){
        $password_err = "Veuillez entrer votre mot de passe.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validation
    if(empty($email_err) && empty($password_err)){
        // preparation requête SQL
        $sql = "SELECT id, email, password FROM Administrateur WHERE email = :email";
        
        if($stmt = $pdo->prepare($sql)){
            // lier les variables à la requête
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            
            // paramètres
            $param_email = trim($_POST["email"]);
            
            // execution
            if($stmt->execute()){
                // si le nom existe, verifie le mot de passe
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $id = $row["id"];
                        $email = $row["email"];
                        $hashed_password = $row["password"];
                        if(password_verify($password, $hashed_password)){
                            // password lé bon : nouvelle session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;                            
                            
                            // Redirect user to welcome page
                            header('Location: src/pages/welcome.php');
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "Mot de passe invalide";
                        }
                    }
                } else{
                    // Display an error message if email doesn't exist
                    $email_err = "Pas de compte avec cet utilisateur";
                }
            } else{
                // error_log(date('l jS \of F Y h:i:s A') . ": erreur lors de la connexion\r\n", 3, 'log.txt');
            }

            // fermeture requête
            unset($stmt);
        }
    }
    
    // fermeture connection
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Page de connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="src/style/style.css">

</head>

<body>

    <div class="container-fluid d-flex flex-column align-items-center justify-content-center mt-3">
        <h1>Gestion d'attribution d'ordinateurs </h1>
    </div>

    <div class="container-fluid d-flex align-items-center justify-content-center">
        <img class="rounded-circle w-25" src="src/ressources/bot_icon.gif" alt="" />
    </div>
    </div>


    <div class="d-flex flex-column align-items-center container-fluid" id="loginDiv">
        <h2 class="pb-5">Connexion Administrateur</h2>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group mb-3 <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label class="form-label">Email</label>
                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group mb-3 <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group mb-3 pt-3">
                <button type="submit" class="btn btn-primary" value="Login">Connexion</button>
            </div>
            </div>
        </form>
    </div>
</body>

</html>